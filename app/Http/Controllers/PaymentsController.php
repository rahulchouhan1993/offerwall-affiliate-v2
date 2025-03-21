<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index(){
        $pageTitle = 'Invoices';
        return view('payments.index',compact('pageTitle'));
    }
}
