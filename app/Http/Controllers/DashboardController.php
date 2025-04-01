<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\App;
use App\Models\Tracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{

    public function index(){
        $pageTitle = 'Dashboard';
        $activeApps = App::where('affiliateId',auth()->user()->id)->where('status',1)->count();
        $totalRevenue = Tracking::where('user_id',auth()->user()->id)->where('status',1)->sum('revenue');
        $totalPayouts = Tracking::where('user_id',auth()->user()->id)->where('status',1)->sum('payout');
        $loggesInUser = auth()->user()->id;
        return view('dashboard.index',compact('pageTitle','activeApps','totalRevenue','totalPayouts','loggesInUser'));
    }

    public function setting(Request $request){
        $pageTitle = 'Settings';
        $user = User::find(Auth::user()->id);
        if($request->isMethod('post')){
            $validatedData = $request->validate([
                'name'             => 'required|string|max:255',
                'last_name'        => 'required|string|max:255',
                'email'            => 'required|email|max:255|unique:users,email,' . Auth::id(),
                'oldpassword'      => 'nullable|required_with:newpassword|current_password', // Validate old password
                'newpassword'      => 'nullable|min:8|confirmed', // Ensures newpassword matches confirmpassword
            ]);
           
            // Update basic details
            $user->name = $validatedData['name'];
            $user->last_name = $validatedData['last_name'];
            $user->email = $validatedData['email'];

            // Update the password if provided
            if (!empty($validatedData['newpassword'])) {
                $user->password = Hash::make($validatedData['newpassword']);
            }
            $user->save();
            return redirect()->route('dashboard.setting')->with('success', 'Profile updated successfully!');

        }
        return view('dashboard.setting',compact('user','pageTitle'));
    }
}
