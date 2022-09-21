<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller

{
    public function indexadd()
    {
        if(auth()->check() && auth()->user()->is_super_admin)
        {
        return view('User.AddUser', [
            "title" => "Add Klien"
        ]);
    }
    else
    {
        abort(403);
    }
    }
    
    public function indexdaftar()
    {
        if(auth()->check() && auth()->user()->is_super_admin)
        {
            return view('User.DaftarUser', [
                "title" => "Daftar User",
                "daftar_user" => User::all()
            ]);
        }
        else
        {
            abort(403);
        }
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

    public function destroy(user $user)
    {
        User::destroy($user->id);
        
        return redirect('/daftar-user')->with('success', 'User Berhasil dihapus!');
    }
}
