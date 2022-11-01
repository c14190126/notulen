<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
    public function changePassword()
    {
        return view('User.ChangePassword', [
            "title" => "Change Password"
        ]);
    }
    public function updatePassword($id, Request $request)
    {
      $credentials = $request->validate([
            'password' => 'required',
            'email' => 'required'
        ]);
        if(Auth::guard('user')->attempt($credentials)) {
            $validatedData = $request->validate([
                'password_baru' => 'required'
            ]);
            $validatedData['password_baru'] = Hash::make($request->password_baru);

            User::where('id', $id)->update(['password' => $validatedData['password_baru']]);
    
            $request->session()->flash('success','Password Berhasil Diganti');

            Auth::logout();

            $request->session()->invalidate();
            
            $request->session()->regenerateToken();

            return redirect('/login');
        }
        else
        {
            $request->session()->flash('fail','Password Tidak Berhasil Diganti');
            return redirect('/change-password');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\klien  $klien
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $users = User::where('id', $user->id)->first();          

        return view('User.EditUser', [
            "title" => "Edit Klien",
            "user" => $users         
        ]);
    }

    public function update(Request $request, User $user)
    {
        if($request->password === null)
        {
            User::where('id', $user->id)
            ->update(['name' => $request->name,
            'email' => $request->email,
     ]); 
        }
        else
        {
            $password = Hash::make($request->password);
            {
                User::where('id', $user->id)
                ->update(['name' => $request->name,
                'email' => $request->email,
                'password'=>$password
         ]); 
            }
           }
           return redirect('/daftar-user');
  
        }

    public function destroy(user $user)
    {
        User::destroy($user->id);
        
        return redirect('/daftar-user')->with('success', 'User Berhasil dihapus!');
    }
}
