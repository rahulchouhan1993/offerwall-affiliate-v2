<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;

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

    public function resetPassword(Request $request){
        if($request->isMethod('post')){
            $validateUser = User::where('email',$request->email)->where('role','affiliate')->first();
            if(empty($validateUser)){
                return redirect()->back()->with('error', 'We cannot find any account associated with that email, please make sure you that you are entring correct email.');
            }
            $randomPassword = $this->generatePassword();
            $validateUser->password = Hash::make($randomPassword);
            $details = [
                'name' => $validateUser->name,
                'password' => $randomPassword,
            ];
            Mail::to($validateUser->email)->send(new ResetPassword($details));
            $validateUser->save();
            return redirect()->back()->with('success', 'We have sent a new password on the provided email.');
        }
        return view('users.reset-password');
    }

    function generatePassword($length = 12) {
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()-_=+<>?';
        
        $allCharacters = $upper . $lower . $numbers . $symbols;
        
        // Ensure at least one character from each category
        $password = $upper[rand(0, strlen($upper) - 1)] .
                    $lower[rand(0, strlen($lower) - 1)] .
                    $numbers[rand(0, strlen($numbers) - 1)] .
                    $symbols[rand(0, strlen($symbols) - 1)];
        
        // Fill the remaining length with random characters
        for ($i = 4; $i < $length; $i++) {
            $password .= $allCharacters[rand(0, strlen($allCharacters) - 1)];
        }
        
        return str_shuffle($password); // Shuffle to make it random
    }
}
