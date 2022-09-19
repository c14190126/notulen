<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('User.Register', [
            "title" => "Register"
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email:dns',
            'password' => 'required'
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::create($validatedData);
        
        $request->session()->flash('success','Berhasil Mendaftar');
        return redirect('/login');
    }
}
