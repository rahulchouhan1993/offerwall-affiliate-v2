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
            COUNT(CASE WHEN conversion_id IS NOT NULL THEN 1 END) as total_conversions,
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
                    $trackingStats->selectRaw("offer_id as element")->groupBy("offer_id");
                    break;
                default:
                    // Do nothing if groupBy is invalid
                    break;
            }
        }
        $allStatistics = $trackingStats->get();
        
        $graphData = [];
        if($allStatistics->isNotEmpty()){
            foreach($allStatistics as $k => $v){
                //special condition for offer grouped by
                if($requestedParams['groupBy']=='offer'){
                    $url = $advertiserDetails->affise_endpoint.'offer/'.$v->element;
                    $response = HTTP::withHeaders([
                        'API-Key' => $advertiserDetails->affise_api_key,
                    ])->get($url);
                    
                    if ($response->successful()) {
                        $offerDetails = $response->json();
                        $v->element = ucfirst($offerDetails['offer']['title']);
                    }
                }
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
        $allCountry = Tracking::where('user_id', auth()->id())->distinct()->pluck('country_code', 'country_name');    
        $allOffers = [];
        $allTrackings = Tracking::where('user_id',auth()->user()->id)->where('postback_sent',1)->groupBy('offer_id')->pluck('offer_id');
       
        $allOs = Tracking::where('user_id', auth()->id())->distinct()->pluck('device_os', 'device_os');   
        if(!empty($allTrackings)){
            foreach($allTrackings as $tracking){
                $url = $advertiserDetails->affise_endpoint.'offer/'.$tracking;
                $response = HTTP::withHeaders([
                    'API-Key' => $advertiserDetails->affise_api_key,
                ])->get($url);
                if ($response->successful()) {
                    $offerDetails = $response->json();
                    $allOffers[$tracking] = ucfirst($offerDetails['offer']['title']);
                }
            }
        }
        //filter section
        $trackingStats = Tracking::query();

        // Apply affiliate filter
        $trackingStats->whereNotNull('conversion_id');
        $trackingStats->where('user_id', auth()->user()->id);

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

        $allConversions = $trackingStats->paginate(100)->appends(request()->query());
        return view('reports.conversions',compact('allAffiliatesApp','pageTitle','allConversions','allCountry','allOffers','allOs','requestedParams','advertiserDetails'));
    }

    public function postbacks(Request $request){
        $pageTitle = 'Postbacks';
        $advertiserDetails = Setting::find(1);
        $allAffiliatesApp = App::where('affiliateId',auth()->user()->id)->get();
        $requestedParams = $request->all();
        
        $allTrackings = Tracking::where('user_id',auth()->user()->id)->where('postback_sent',1)->groupBy('offer_id')->pluck('offer_id'); 
        $allOffers = [];
        if(!empty($allTrackings)){
            foreach($allTrackings as $tracking){
                $url = $advertiserDetails->affise_endpoint.'offer/'.$tracking;
                $response = HTTP::withHeaders([
                    'API-Key' => $advertiserDetails->affise_api_key,
                ])->get($url);
                
                if ($response->successful()) {
                    $offerDetails = $response->json();
                    $allOffers[$tracking] = ucfirst($offerDetails['offer']['title']);
                }
            }
        }

        //filter section
        $trackingStats = Tracking::query();

        // Apply affiliate filter
        $trackingStats->whereNotNull('conversion_id');
        $trackingStats->where('user_id', auth()->user()->id);

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
            ->groupBy('country_code', 'country_name')
            ->pluck('country_name', 'country_code');
            foreach($allTrackings as $isoCode =>$countryName){
                $returnOptions.='<option value="'.$isoCode.'">'.$countryName.'</option>';
            }
        }elseif($filterBy=='devices'){
            $allTrackings = Tracking::groupBy('device_type')->pluck('device_type');
            if(!empty($allTrackings)){
                foreach($allTrackings as $tracking){
                    $returnOptions.='<option value="'.$tracking.'">'.ucfirst($tracking).'</option>';
                }
            }
        }elseif($filterBy=='os'){
            $allTrackings = Tracking::groupBy('device_os')->pluck('device_os');
            if(!empty($allTrackings)){
                foreach($allTrackings as $tracking){
                    $returnOptions.='<option value="'.$tracking.'">'.ucfirst($tracking).'</option>';
                }
            }
        }elseif($filterBy=='offer'){
            $allTrackings = Tracking::groupBy('offer_id')->pluck('offer_id');
            if(!empty($allTrackings)){
                foreach($allTrackings as $tracking){
                    $url = $advertiserDetails->affise_endpoint.'offer/'.$tracking;
                    $response = HTTP::withHeaders([
                        'API-Key' => $advertiserDetails->affise_api_key,
                    ])->get($url);
                    
                    if ($response->successful()) {
                        $offerDetails = $response->json();
                        $returnOptions.='<option value="'.$tracking.'">'.ucfirst($offerDetails['offer']['title']).'</option>';
                    }
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
                        $row['isp'],
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
                        $row['goal'],
                        $row['payout'],
                        $row['http_code'],
                        $row['error'],
                        $row['ceated_at'],
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
