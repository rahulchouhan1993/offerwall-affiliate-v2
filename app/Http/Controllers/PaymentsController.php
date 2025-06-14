<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Invoice;
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
        $pageTitle = 'Payment Methods';
        $allPaymentMethods = PaymentMethod::where('user_id',auth()->user()->id)->get();
        if($request->isMethod('post')){
            if($request->rec_id>0){
                $paymentMethods = PaymentMethod::where('id',$request->rec_id)->where('user_id',auth()->user()->id)->first();
                if(empty($paymentMethods)){
                    return redirect()->back()->with('error','Invalid Request');
                }
            }else{
                $paymentMethods = new PaymentMethod();
            }
            $paymentMethods->user_id = auth()->user()->id; 
            $paymentMethods->payment_method = $request->methods;
            $paymentMethods->account_name = $request->account_name;
            $paymentMethods->iban = $request->iban;
            $paymentMethods->routing_number = $request->routing_number;
            $paymentMethods->swift = $request->swift;
            $paymentMethods->save();
            if($request->rec_id>0){
                return redirect()->back()->with('success','Payment Method Updated Successfully.');
            }else{
                return redirect()->back()->with('success','Payment Method Added Successfully.');
            }
        }
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
}
