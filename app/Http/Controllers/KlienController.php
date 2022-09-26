<?php

namespace App\Http\Controllers;

use App\Models\klien;
use App\Http\Requests\StoreklienRequest;
use App\Http\Requests\UpdateklienRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class KlienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexadd()
    {
        return view('Klien.AddKlien', [
            "title" => "Add Klien"
        ]);
    }
    public function indexdaftar()
    {
        return view('Klien.ListKlien', [
            "title" => "Daftar Klien",
            "list_klien" => klien::all()
        ]);
    }

    public function changePassword()
    {
        return view('Klien.ChangePassword', [
            "title" => "Change Password"
        ]);
    }
    
    public function updatePassword($id, Request $request)
    {
        $credentials = $request->validate([
            'password' => 'required',
            'email' => 'required'
        ]);
        if(Auth::guard('klien')->attempt($credentials)) {
            $validatedData = $request->validate([
                'password_baru' => 'required'
            ]);
            $validatedData['password_baru'] = Hash::make($request->password_baru);

            klien::where('id', $id)->update(['password' => $validatedData['password_baru']]);
    
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreklienRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreklienRequest $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'nama_klien' => 'required|max:255',
            'email' => 'required|max:255|unique:kliens|email:dns',
            'no_wa' => 'required|unique:kliens',
            'password'=>''
        ]);
        $validatedData['password'] = Hash::make($request->password);

        klien::create($validatedData);

        $request->session()->flash('success','Penyimpanan Berhasil');
        return redirect('/add-klien');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\klien  $klien
     * @return \Illuminate\Http\Response
     */
    public function show(klien $klien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\klien  $klien
     * @return \Illuminate\Http\Response
     */
    public function edit(klien $klien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateklienRequest  $request
     * @param  \App\Models\klien  $klien
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateklienRequest $request, klien $klien)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\klien  $klien
     * @return \Illuminate\Http\Response
     */
    public function destroy(klien $klien)
    {
        klien::destroy($klien->id);
        
        return redirect('/daftar-klien')->with('success', 'Klien Berhasil dihapus!');
    }
}
