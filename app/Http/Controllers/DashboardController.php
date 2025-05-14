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

    public function index(Request $request){
        $pageTitle = 'Dashboard';
        if(!isset($request->range)){
            return redirect()->route('dashboard.index',['range'=> date('m/d/Y', strtotime('-6 days')).' - '.date('m/d/Y')]);
        }
    
        // Filters
        $requestedParams = [];
        $completeDate = $request->input('range');
        $separateDate = explode('-', $completeDate);
        $requestedParams['strd'] = trim($separateDate[0]);
        $requestedParams['endd'] = trim($separateDate[1]);
        $startDate = date('Y-m-d 00:00:00', strtotime(trim($separateDate[0])));
        $endDate = date('Y-m-d 23::59:59', strtotime(trim($separateDate[1])));
        $affiliateId = auth()->user()->id;
    
        // App Statistics
        $activeApps = Tracking::where('status',1);
        if ($startDate) {
            $activeApps->whereDate('click_time', '>=', $startDate);
        }
        if ($endDate) {
            $activeApps->whereDate('click_time', '<=', $endDate);
        }
        if ($affiliateId) {
            $activeApps->where('user_id', $affiliateId);
        }
        $activeApps = $activeApps->distinct('user_id')->count();
    
        // Revenue Statistics
        $totalRevenue = Tracking::where('status',1);
        if ($startDate) {
            $totalRevenue->whereDate('click_time', '>=', $startDate);
        }
        if ($endDate) {
            $totalRevenue->whereDate('click_time', '<=', $endDate);
        }
        if ($affiliateId) {
            $totalRevenue->where('user_id', $affiliateId);
        }
        $totalRevenue = $totalRevenue->sum('revenue');
    
        // Payout Statistics
        $totalPayouts = Tracking::where('status',1);
        if ($startDate) {
            $totalPayouts->whereDate('click_time', '>=', $startDate);
        }
        if ($endDate) {
            $totalPayouts->whereDate('click_time', '<=', $endDate);
        }
        if ($affiliateId) {
            $totalPayouts->where('user_id', $affiliateId);
        }
        $totalPayouts = $totalPayouts->sum('payout');
        return view('dashboard.index', compact(
            'activeApps',
            'pageTitle',
            'totalRevenue',
            'totalPayouts',
            'requestedParams'
        ));
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
