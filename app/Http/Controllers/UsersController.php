<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        if($request->isMethod('POST')){
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            
            $user = User::where('email', $credentials['email'])->where('role','affiliate')->first();
            if ($user && $user->status == 0) {
                return redirect()->back()->with('error', 'Your account is inactive. Please contact support.');
            }
            if($user){
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect()->route('dashboard.index');
                }
            }
            
            return redirect()->back()->with('error', 'The provided credentials do not match our records.');
        }
       
        return view('users.login');
    }

    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
