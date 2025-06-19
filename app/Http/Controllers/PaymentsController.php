<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Invoice;
use App\Models\Country;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
class PaymentsController extends Controller
{
    public function index(){
        $pageTitle = 'Invoices';

        $allInvoices = Invoice::query();
        $allInvoices = $allInvoices
            ->where('status', '!=', 4)
            ->where('status','!=',0)
            ->where('user_id',auth()->user()->id)
            ->with('invoicedetails')
            ->orderBy('id', 'DESC')
            ->get(); // NOW you assign the result

        $allInvoices = $allInvoices->map(function ($invoice) {
            $total = 0; $totalConv = 0;
            foreach ($invoice->invoicedetails as $detail) {
                $priceWithVat = $detail->payout + ($detail->payout * $detail->vat / 100);
                $total += $priceWithVat;
                $totalConv+=$detail->conversion;
            }
            $invoice->total_price = round($total, 2);
            $invoice->total_conversion = $totalConv;
            return $invoice;
        });
        
        $cardData = DB::table('invoices')
        ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
        ->select(
            'invoices.status',
            DB::raw('COUNT(DISTINCT invoices.id) as total_invoices'),
            DB::raw('SUM(invoice_details.payout) as total_payout_with_vat'),
            DB::raw("GROUP_CONCAT(CONCAT(invoices.start_date, ' - ', invoices.end_date) SEPARATOR ', ') as date_ranges")
        )
        ->where('invoices.status', 2)
        ->where('invoices.user_id', auth()->user()->id)
        ->groupBy('invoices.status') 
        ->first();
       
        if(!empty($cardData->date_ranges)){
            $rangeArray = array_map('trim', explode(',', $cardData->date_ranges));
        }
        $query = DB::table('trackings')
        ->where('user_id', auth()->user()->id)
        ->whereNotNull('conversion_id')
        ->whereNotNull('click_id')
        ->whereIn('status', [1]);
        if(!empty($cardData->date_ranges)){
            foreach ($rangeArray as $range) {
                [$start, $end] = array_map('trim', explode(' - ', $range));
                $query->whereNotBetween('click_time', [$start, $end]);
            }
        }
        $totalPendingPayout = $query->sum('payout');

        return view('payments.index',compact('pageTitle','allInvoices','cardData','totalPendingPayout'));
    }

    public function paymentMethods(Request $request){
        $pageTitle = 'Payment Settings';
        $allPaymentMethods = PaymentMethod::where('user_id',auth()->user()->id)->get();
        return view('payments.methods',compact('pageTitle','allPaymentMethods'));
    }

    public function updateMethodStatus(Request $request){
        $record = PaymentMethod::find($request->updateid);
        $record->status = ($record->status) ? 0 : 1;
        $record->save();

        return redirect()->back()->with('success','Status Updated');
    }

    public function download($id)
    {   
        $invoiceDetails = Invoice::where('id',$id)->with('invoicedetails','user')->first();
        $html = view('invoices.show',compact('invoiceDetails'))->render();

        $mpdf = new Mpdf([
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/mpdf-temp')
        ]);
        $mpdf->WriteHTML($html);

        return response($mpdf->Output("Invoice_{$id}.pdf", 'I'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Invoice_.pdf"');
    }

    public function addMethod(Request $request, $id=null){
        $pageTitle = 'Add Method';
        $allCountries = Country::get();
        if($id>0){
            $paymentMethods = PaymentMethod::find($id);
        }else{
            $paymentMethods = new PaymentMethod();
        }
        if($request->isMethod('post')){
            $paymentMethods->user_id = auth()->user()->id; 
            $paymentMethods->payment_method = $request->method;
            $paymentMethods->account_name = $request->org_name ?? NULL;
            $paymentMethods->iban = $request->account_number ?? NULL;
            $paymentMethods->routing_number = $request->routing_number ?? NULL;
            $paymentMethods->account_type = $request->account_type ?? NULL;
            $paymentMethods->country = $request->country ?? NULL;
            $paymentMethods->city = $request->city ?? NULL;
            $paymentMethods->address = $request->address ?? NULL;
            $paymentMethods->post_code = $request->post_code ?? NULL;
            $paymentMethods->wallet_address = $request->wallet_address ?? NULL;
            $paymentMethods->paypal_email = $request->paypal_email ?? NULL;
            $paymentMethods->save();
            return redirect()->route('payment.methods')->with('success','Payment Method Updated Successfully.');
        }

        return view('payments.add-method',compact('pageTitle','id','paymentMethods','allCountries'));
    }
}
