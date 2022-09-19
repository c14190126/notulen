<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('User.Login', [
            "title" => "Login"
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);
        
            // dd('berhasil login!');
            // if(Auth::attempt($credentials)) {
            //     if($credentials['password']=="password") {
            //         session(['key' => $credentials['email']]);
            //         return redirect('/change-password');
            //     }
            //     else{
            //         $request->session()->regenerate();
            //         return redirect()->intended('/');
            //     }

            if(Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/');

            }

        return back()->with('loginError', 'Login failed');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
