<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index(){
        $pageTitle = 'Invoices';
        return view('payments.index',compact('pageTitle'));
    }

    public function paymentMethods(Request $request){
        $pageTitle = 'Payment Methods';
        $allPaymentMethods = PaymentMethods::where('user_id',auth()->user()->id)->get();
        if($request->isMethod('post')){
            if($request->rec_id>0){
                $paymentMethods = PaymentMethods::where('id',$request->rec_id)->where('user_id',auth()->user()->id)->first();
                if(empty($paymentMethods)){
                    return redirect()->back()->with('error','Invalid Request');
                }
            }else{
                $paymentMethods = new PaymentMethods();
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
        $record = PaymentMethods::find($request->updateid);
        $record->status = ($record->status) ? 0 : 1;
        $record->save();

        return redirect()->back()->with('success','Status Updated');
    }
}
