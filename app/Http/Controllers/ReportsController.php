<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Tracking;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\App;

class ReportsController extends Controller
{
    public function statistics(Request $request){
        $pageTitle = 'Statistics';
        $advertiserDetails = Setting::find(1);
        $allAffiliatesApp =  App::where('affiliateId',auth()->user()->id)->get();
        $trackingStats = Tracking::query();
        $requestedParams = $request->all();
        if(!isset($requestedParams['sort']) || !isset($requestedParams['order'])){
            return redirect()->route('report.statistics',['sort'=>'element','order'=>'asc']);
        }
        $requestedParams['groupBy'] = $requestedParams['groupBy'] ?? 'hour';
        $requestedParams['range'] = $requestedParams['range'] ?? date('m/d/Y', strtotime('-6 days')).' - '.date('m/d/Y');
        // Apply date range filter
        if (!empty($requestedParams['range'])) {
            $separateDate = explode('-', $requestedParams['range']);
            $requestedParams['strd'] = trim($separateDate[0]);
            $requestedParams['endd'] = trim($separateDate[1]);
            $startDate = date('Y-m-d 00:00:00', strtotime(trim($separateDate[0])));
            $endDate = date('Y-m-d 23:59:59', strtotime(trim($separateDate[1])));
            $trackingStats->whereBetween('click_time', [$startDate, $endDate]); 
        }

        // Apply affiliate filter
        $trackingStats->where('user_id', auth()->user()->id);

        // Apply app filter
        if (!empty($requestedParams['appid']) && $requestedParams['appid'] > 0) {
            $trackingStats->where('app_id', $requestedParams['appid']);
        }
    
        // Apply specific filter conditions
        if (!empty($requestedParams['filterBy']) && !empty($requestedParams['filterIn'])) {
            $filterColumnMap = [
                'os' => 'device_os',
                'country' => 'country_code',
                'offer' => 'offer_id',
                'devices' => 'device_type'
            ];
            
            foreach($requestedParams['filterIn'] as $filyKey => $filterAsIn){
                if (isset($filterColumnMap[$filyKey])) {
                    $trackingStats->where($filterColumnMap[$filyKey], $filterAsIn[0]);
                }
            }
        }

        $trackingStats->selectRaw("
            COUNT(*) as total_click,
            COUNT(CASE WHEN conversion_id IS NOT NULL AND status=1 THEN 1 END) as total_conversions,
            SUM(revenue) as total_revenue,
            SUM(payout) as total_payout
        ");

        // Apply conditional GROUP BY
        if (!empty($requestedParams['groupBy'])) {
            switch ($requestedParams['groupBy']) {
                case 'hour':
                    $trackingStats->selectRaw("HOUR(click_time) as element")->groupByRaw("HOUR(click_time)");
                    break;
                case 'day':
                    $trackingStats->selectRaw("DATE(click_time) as element")->groupByRaw("DATE(click_time)");
                    break;
                case 'month':
                    $trackingStats->selectRaw("DATE_FORMAT(click_time, '%Y-%m') as element")->groupByRaw("DATE_FORMAT(click_time, '%Y-%m')");
                    break;
                case 'country':
                    $trackingStats->selectRaw("country_name as element")->groupBy("country_name");
                    break;
                case 'browser':
                    $trackingStats->selectRaw("browser as element")->groupBy("browser");
                    break;
                case 'device':
                    $trackingStats->selectRaw("device_brand as element")->groupBy("device_brand");
                    break;
                case 'device_model':
                    $trackingStats->selectRaw("device_model as element")->groupBy("device_model");
                    break;
                case 'os':
                    $trackingStats->selectRaw("device_os as element")->groupBy("device_os");
                    break;
                case 'offer':
                    $trackingStats->selectRaw("offer_name as element")->groupBy("offer_name");
                    break;
                default:
                    // Do nothing if groupBy is invalid
                    break;
            }
        }
        $allStatistics = $trackingStats->get();
        $sortBy = $request->get('sort', 'element');
        $order = $request->get('order', 'asc');

        $allStatistics = $allStatistics->sortBy(function ($item) use ($sortBy) {
            switch ($sortBy) {
                case 'cvr':
                    return ($item->total_click > 0) ? ($item->total_conversions / $item->total_click) * 100 : 0;
                case 'epc':
                    return ($item->total_click > 0) ? ($item->total_payout / $item->total_click) : 0;
                default:
                    return $item->$sortBy ?? null;
            }
        }, SORT_REGULAR, $order === 'desc');

        $graphData = [];
        if($allStatistics->isNotEmpty()){
            foreach($allStatistics as $k => $v){
                $graphData[$v->element]['conversion'] = $v->total_conversions;
                $graphData[$v->element]['clicks'] = $v->total_click;
            }
        }
        
        return view('reports.statistics',compact('pageTitle','allStatistics','allAffiliatesApp','requestedParams','graphData'));
    }

    public function conversions(Request $request){
        $pageTitle = 'Conversions';
        $advertiserDetails = Setting::find(1);
        $allAffiliatesApp = App::where('affiliateId',auth()->user()->id)->get();
        $requestedParams = $request->all();
        if(!isset($requestedParams['sort']) || !isset($requestedParams['order'])){
            return redirect()->route('report.conversions',['sort'=>'click_time','order'=>'asc']);
        }
        $allCountry = Tracking::where('status',1)->where('user_id', auth()->id())->distinct()->pluck('country_code', 'country_name');    
        $allOffers = [];
        $allTrackings = Tracking::select('offer_id', 'offer_name')->whereIn('status',[1,2])->where('user_id',auth()->user()->id)->distinct()->pluck('offer_name', 'offer_id');

        $allOs = Tracking::where('status',1)->where('user_id', auth()->id())->distinct()->pluck('device_os', 'device_os');   
        if(!empty($allTrackings)){
            foreach ($allTrackings as $offerId => $offerName) {
                $allOffers[$offerId] = ucfirst($offerName);
            }
        }
        //filter section
        $trackingStats = Tracking::query();

        // Apply affiliate filter
        $trackingStats->whereNotNull('conversion_id');
        $trackingStats->where('user_id', auth()->user()->id)->whereIn('status',[1,2]);

        $requestedParams['range'] = $requestedParams['range'] ?? date('m/d/Y', strtotime('-6 days')).' - '.date('m/d/Y');
        // Apply date range filter
        if (!empty($requestedParams['range'])) {
            $separateDate = explode('-', $requestedParams['range']);
            $requestedParams['strd'] = trim($separateDate[0]);
            $requestedParams['endd'] = trim($separateDate[1]);
            $startDate = date('Y-m-d 00:00:00', strtotime(trim($separateDate[0])));
            $endDate = date('Y-m-d 23:59:59', strtotime(trim($separateDate[1])));
            $trackingStats->whereBetween('conversion_time', [$startDate, $endDate]); 
        }

        // Apply app filter
        if (!empty($requestedParams['appid']) && $requestedParams['appid'] > 0) {
            $trackingStats->where('app_id', $requestedParams['appid']);
        }

        // Apply country filter
        if (!empty($requestedParams['country'])) {
            $trackingStats->where('country_code', $requestedParams['country']);
        }

        // Apply offer filter
        if (!empty($requestedParams['offer']) && $requestedParams['offer'] > 0) {
            $trackingStats->where('offer_id', $requestedParams['offer']);
        }

        // Apply OS filter
        if (!empty($requestedParams['device_os'])) {
            $trackingStats->where('device_os', $requestedParams['device_os']);
        }

        // Apply OS filter
        if (!empty($requestedParams['goal'])) {
            $trackingStats->where('goal', $requestedParams['goal']);
        }

        // Apply sorting
        $sortColumn = $request->get('sort', 'click_time');
        $sortOrder = $request->get('order', 'asc');

        // Validate the sort column to prevent SQL injection
        $allowedSortColumns = ['click_time','conversion_time','status', 'offer_id', 'goal', 'payout', 'country_code','device_os','device_type'];
        if (in_array($sortColumn, $allowedSortColumns)) {
            $trackingStats->orderBy($sortColumn, $sortOrder);
        } else {
            $trackingStats->orderBy('click_time', 'asc');
        }

        $allConversions = $trackingStats->paginate(100)->appends(request()->query());
        return view('reports.conversions',compact('allAffiliatesApp','pageTitle','allConversions','allCountry','allOffers','allOs','requestedParams','advertiserDetails'));
    }

    public function postbacks(Request $request){
        $pageTitle = 'Postbacks';
        $advertiserDetails = Setting::find(1);
        $allAffiliatesApp = App::where('affiliateId',auth()->user()->id)->get();
        $requestedParams = $request->all();
        if(!isset($requestedParams['sort']) || !isset($requestedParams['order'])){
            return redirect()->route('report.postbacks',['sort'=>'offer_id','order'=>'asc']);
        }
        $allTrackings = Tracking::select('offer_id', 'offer_name')->where('status',1)->where('user_id',auth()->user()->id)->where('postback_sent',1)->distinct()->pluck('offer_name', 'offer_id');
        $allOffers = [];
        if(!empty($allTrackings)){
            foreach($allTrackings as $offerId => $offerName){
                $allOffers[$offerId] = ucfirst($offerName);
            }
        }

        //filter section
        $trackingStats = Tracking::query();

        // Apply affiliate filter
        $trackingStats->whereNotNull('conversion_id');
        $trackingStats->where('user_id', auth()->user()->id)->where('status',1);

        $requestedParams['range'] = $requestedParams['range'] ?? date('m/d/Y', strtotime('-6 days')).' - '.date('m/d/Y');
        // Apply date range filter
        if (!empty($requestedParams['range'])) {
            $separateDate = explode('-', $requestedParams['range']);
            $requestedParams['strd'] = trim($separateDate[0]);
            $requestedParams['endd'] = trim($separateDate[1]);
            $startDate = date('Y-m-d 00:00:00', strtotime(trim($separateDate[0])));
            $endDate = date('Y-m-d 23:59:59', strtotime(trim($separateDate[1])));
            $trackingStats->whereBetween('conversion_time', [$startDate, $endDate]); 
        }

        // Apply app filter
        if (!empty($requestedParams['appid']) && $requestedParams['appid'] > 0) {
            $trackingStats->where('app_id', $requestedParams['appid']);
        }

        // Apply offer filter
        if (!empty($requestedParams['offer']) && $requestedParams['offer'] > 0) {
            $trackingStats->where('offer_id', $requestedParams['offer']);
        }

        // Apply OS filter
        if (!empty($requestedParams['goal'])) {
            $trackingStats->where('goal', $requestedParams['goal']);
        }

        if (!empty($requestedParams['status'])) {
            $trackingStats->where('http_code', $requestedParams['status']);
        }

        // Apply sorting
        $sortColumn = $request->get('sort', 'offer_id');
        $sortOrder = $request->get('order', 'asc');

        // Validate the sort column to prevent SQL injection
        $allowedSortColumns = ['offer_id', 'status', 'goal', 'payout', 'updated_at'];
        if (in_array($sortColumn, $allowedSortColumns)) {
            $trackingStats->orderBy($sortColumn, $sortOrder);
        } else {
            $trackingStats->orderBy('offer_id', 'asc');
        }

        $allPostbacks = $trackingStats->paginate(100)->appends(request()->query());
        return view('reports.postbacks',compact('pageTitle','allPostbacks','allAffiliatesApp','requestedParams','allOffers','advertiserDetails'));
    }

    public function exported(){
        $pageTitle = 'Exported Reports';
        return view('reports.exported',compact('pageTitle'));
    }

    public function filterGroup($filterBy = null){
        $advertiserDetails = Setting::find(1);
        $returnOptions = '<option value="">Select</option>';
        if($filterBy=='country'){
            $allTrackings = Tracking::select('country_code', 'country_name')
            ->where('user_id',auth()->user()->id)
            ->groupBy('country_code', 'country_name')
            ->pluck('country_name', 'country_code');
            foreach($allTrackings as $isoCode =>$countryName){
                $returnOptions.='<option value="'.$isoCode.'">'.$countryName.'</option>';
            }
        }elseif($filterBy=='devices'){
            $allTrackings = Tracking::where('user_id',auth()->user()->id)->groupBy('device_type')->pluck('device_type');
            if(!empty($allTrackings)){
                foreach($allTrackings as $tracking){
                    $returnOptions.='<option value="'.$tracking.'">'.ucfirst($tracking).'</option>';
                }
            }
        }elseif($filterBy=='os'){
            $allTrackings = Tracking::where('user_id',auth()->user()->id)->groupBy('device_os')->pluck('device_os');
            if(!empty($allTrackings)){
                foreach($allTrackings as $tracking){
                    $returnOptions.='<option value="'.$tracking.'">'.ucfirst($tracking).'</option>';
                }
            }
        }elseif($filterBy=='offer'){
            $allTrackings = Tracking::select('offer_id', 'offer_name')->where('user_id',auth()->user()->id)->distinct()->pluck('offer_name', 'offer_id');
            if(!empty($allTrackings)){
                foreach($allTrackings as $offerId =>$offerName){
                    $returnOptions.='<option value="'.$offerId.'">'.ucfirst($offerName).'</option>';
                }
            }
        }
        
        echo $returnOptions;die;
    }

    public function exportReport(Request $request){
        $data = $request->input('exportData');
        $exportType = $request->input('exportType') ?? '';

        $filename = date('d M Y').' - '.rand()."-report.csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($data, $exportType) {
            $file = fopen('php://output', 'w');

            // Add CSV Heading
            fputcsv($file, $data['heading']);

            // Add Data Rows
            foreach ($data['data'] as $row) {
                if($exportType=='conversion'){
                    fputcsv($file, [
                        $row['click_id'], 
                        $row['conversion_id'], 
                        $row['click_time'], 
                        $row['created_at'], 
                        $row['status'], 
                        $row['offer_id'],
                        $row['goal'],
                        $row['payout'],
                        $row['country_name'],
                        $row['ip'],
                        $row['device_os'],
                        $row['device_type'],
                        // $row['isp'],
                        $row['ua']
                    ]);
                }elseif($exportType=='postback'){
                    fputcsv($file, [
                        $row['postback'], 
                        $row['conversion_id'], 
                        $row['offerName'], 
                        $row['goal'], 
                        $row['status'], 
                        $row['payout'],
                        $row['http_code'],
                        $row['error'],
                        $row['updated_at'],
                        $row['id']
                    ]);
                }else{
                    fputcsv($file, [
                        $row['element'], 
                        $row['clicks'], 
                        $row['conversions'], 
                        $row['cvr'], 
                        $row['epc'], 
                        $row['earnings']
                    ]);
                }
                
            }

            fclose($file);
        };
       

        return response()->stream($callback, 200, $headers);
    }
}
