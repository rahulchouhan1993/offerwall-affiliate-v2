<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Tracking;
use Illuminate\Support\Facades\Http;

class PaymentsController extends Controller
{
    public function index(){
        $pageTitle = 'Invoices';
        $firstConversion = Tracking::where('user_id',auth()->user()->id)->where('status',2)->whereNotNull('conversion_id')->orderBy('id','asc')->first();
        if(empty($firstConversion)){
            $dateFrom = date('Y-m-d');
        }else{
            $dateFrom = date('Y-m-d',strtotime($firstConversion->created_at));
        }
        $dateTo = date('Y-m-d');
        $url = "https://api-makamobile.affise.com/3.0/payments?date_from={$dateFrom}&date_to={$dateTo}";
        $response = HTTP::withHeaders([
            'API-Key' => 'c69003e37c7842104a08d9ea982c23a0',
        ])->get($url);
        
        if ($response->successful()) {
            $alInvoices = $response->json();
            echo "<pre>"; print_r($alInvoices);die;
            $pagination = $allAffiliates['pagination'] ?? []; // Extract pagination data
            $currentPage = $pagination['page'] ?? 1; 
            $totalCount = $pagination['total_count'] ?? 0;
            $prevPage = $pagination['prev_page'] ?? null;
            $nextPage = $pagination['next_page'] ?? null;
        }
        return view('payments.index',compact('pageTitle'));
    }

    public function paymentMethods(){
        $pageTitle = 'Payment Methods';
        return view('payments.methods',compact('pageTitle'));
    }
}


