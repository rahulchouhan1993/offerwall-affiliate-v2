<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Invoice;
use App\Models\Country;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
class PaymentsController extends Controller
{
    public function index(){
        $pageTitle = 'Invoices';
        $allInvoices = Invoice::where('status','!=',4)->where('status','!=',0)->where('user_id',auth()->user()->id)->get();
        return view('payments.index',compact('pageTitle','allInvoices'));
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
