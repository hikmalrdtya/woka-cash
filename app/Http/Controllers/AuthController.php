<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showlogin(){
        return view("auth.login");
    }

    public function Login(Request $request){
        $credentials = $request->validate([
            "email"=> 'required|email',
            'password'=> 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();  
            $user = Auth::user();

            if($user->role === 'admin'){
                return redirect()->route('admin.dashboard')->with('success','Anda berhasil login sebagai Admin');
            }
            elseif($user->role === 'finance'){
                return redirect()->route('finance.dashboard')->with('success','Anda berhasil login sebagai Finance');
            }
            elseif($user->role === 'staff'){
                return redirect()->route('staff.dashboard')->with('success','Anda berhasil login sebagai Staff');
            } else{
                Auth::logout();
                return redirect()->route('login')->with('error','Pengguna tidak di temukan');
            }
        }
    }
    public function Logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('login')->with('success','Anda Berhasil Logout');
    }
}