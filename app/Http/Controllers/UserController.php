<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller

{
    public function indexadd()
    {
        return view('User.AddUser', [
            "title" => "Add Klien"
        ]);
    }
    public function store(Request $request)
    {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users|email:dns',
                'password' => 'required',
                'is_admin' => '',
                'is_super_admin' => ''
            ]);
            $validatedData['is_admin']=1;
            $validatedData['is_super_admin']=0;
        
        $validatedData['password'] = Hash::make($request->password);

        User::create($validatedData);

        $request->session()->flash('success','Berhasil Mendaftar');
        return redirect('/add-user');
    }
    public function change_password()
    {
        return view('User.Changepassword', [
            "title" => "Change Password"
        ]);
    }
    public function update_password(Request $request)
    {
        $email = $request->session()->pull('key', 'default');
        $validatedData = $request->validate([
            'password' => 'required'
        ]);
        $password=$validatedData['password'] = Hash::make($request->password);
        User::where('email', $email)
        ->update(['password' => $password,
        

     ]);
        
        $request->session()->flash('success','Berhasil Mengganti Password');
        return redirect('/login');
    }
}
