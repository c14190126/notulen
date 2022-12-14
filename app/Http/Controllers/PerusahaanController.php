<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Http\Requests\StorePerusahaanRequest;
use App\Http\Requests\UpdatePerusahaanRequest;
use App\Models\detail_klien;
use Illuminate\Support\Facades\Auth;
use App\Models\klien;


class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('user')->check()) {
            return view('Klien.ListPerusahaan', [
                "title" => "Daftar Perusahaan",
                "list_perusahaan" => Perusahaan::all()
            ]);
        }
    }
    public function indexklien($id)
    {
        if(Auth::guard('user')->check()) {
            return view('Klien.ListKlienPerusahaan', [
                "title" => "Daftar Perusahaan",
                "list_perusahaan" => detail_klien::where('deleted', NULL)->where('perusahaan_id',$id)->get()
            ]);
        }
    }
    public function indexAdd()
    {
        if(Auth::guard('user')->check()) {
            return view('Klien.AddPerusahaan', [
                "title" => "Add Perusahaan",
                "list_klien" => klien::where('deleted', NULL)->get(),
                "list_perusahaan" => Perusahaan::where('deleted', NULL)->get()
            ]);
        }
    }
    public function indexAssign()
    {
        if(Auth::guard('user')->check()) {
            return view('Klien.AssignPerusahaan', [
                "title" => "Assign Perusahaan",
                "list_klien" => klien::where('deleted', NULL)->get(),
                "list_perusahaan" => Perusahaan::where('deleted', NULL)->get()
            ]);
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
     * @param  \App\Http\Requests\StorePerusahaanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerusahaanRequest $request)
    {
        $validatedData = $request->validate([
            'nama_perusahaan' => 'required|max:255',
        ]);
        
        Perusahaan::create($validatedData);

        $request->session()->flash('success','Penyimpanan Berhasil');
        return redirect('/add-perusahaan');
    }
    public function storedetail(StorePerusahaanRequest $request)
    {
        $validatedData = $request->validate([
            'perusahaan_id' => 'required|max:255',
            'klien_id' => 'required|max:255'
        ]);
        
        detail_klien::create($validatedData);

        $request->session()->flash('success','Penyimpanan Berhasil');
        return redirect('/add-perusahaan');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function show(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Perusahaan $perusahaan)
    {
        $perusahaans = Perusahaan::where('id', $perusahaan->id)->first();          

        return view('Klien.EditPerusahaan', [
            "title" => "Edit Perusahaan",
            "perusahaan" => $perusahaans,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePerusahaanRequest  $request
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerusahaanRequest $request, Perusahaan $perusahaan)
    {
        Perusahaan::where('id', $perusahaan->id)
                  ->update(['nama_perusahaan' => $request->nama_perusahaan,
                    ]);
        $request->session()->flash('success','Perusahaan Berhasil Diupdate');
        return redirect('/daftar-perusahaan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perusahaan $perusahaan)
    {
        Perusahaan::where('id', $perusahaan->id)
                  ->update(['deleted' => '1']);
        
        return redirect('/daftar-perusahaan')->with('success', 'Perusahaan Berhasil dihapus!');
    }
}
