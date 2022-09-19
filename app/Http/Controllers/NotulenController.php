<?php

namespace App\Http\Controllers;

use App\Models\notulen;
use App\Models\klien;
use App\Http\Requests\StorenotulenRequest;
use App\Http\Requests\UpdatenotulenRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class NotulenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ListNotulen', [
            "title" => "Daftar Notulen",
            "list_notulen" => notulen::latest()->filter(request(['search', 'klien']))->paginate(10)->withQueryString(),

        ]);
    }

    public function indexAdd()
    {
        return view('CreateNotulen', [
            "title" => "Create Notulen",
            "list_klien" => klien::orderBy('nama_klien')->get(),

        ]);
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
     * @param  \App\Http\Requests\StorenotulenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorenotulenRequest $request)
    {
        if($request->private == 'on') {
            $validatedData = $request->validate([
                'user_id' => 'required',
                'klien_id' => 'required',
                'tanggal' => 'required',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'judul_meeting' => 'required|max:255|',
                'isi_notulen' => 'required',
                'tanda_tangan' => '',
                'private' => '',
                'tanda_tangan_deus' => 'required'
            ]);
            $validatedData['private']=1;
        }
        else
        {
            $validatedData = $request->validate([
                'user_id' => 'required',
                'klien_id' => 'required',
                'tanggal' => 'required',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'judul_meeting' => 'required|max:255|',
                'isi_notulen' => 'required',
                'tanda_tangan' => '',
                'private' => '',
                'tanda_tangan_deus' => 'required'
            ]);
        }

        notulen::create($validatedData);
        
        $request->session()->flash('success','Penyimpanan Berhasil');
        return redirect('/');
    }

    public function getURL(StorenotulenRequest $request)
    {
        $data['klien'] = $request->tanda_tangan;
        $data['deus'] = $request->tanda_tangan_deus;

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\notulen  $notulen
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('SingleNotulen.SingleNotulen', [
            "title" => "Notulen",
            "notulen" => notulen::where('id', $id)->first(),
            "edited" => DB::table('users as u')
                        ->join('notulens as n', 'u.id', '=', 'n.edited_by')
                        ->where('n.id',$id)
                        ->select('u.name')
                        ->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\notulen  $notulen
     * @return \Illuminate\Http\Response
     */
    public function edit(notulen $notulen)
    {
        // dd($notulen);
        return view('EditNotulen', [
            "title" => "Edit Notulen",
            "notulen" => $notulen,
            "list_klien" => klien::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatenotulenRequest  $request
     * @param  \App\Models\notulen  $notulen
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatenotulenRequest $request, notulen $notulen)
    {
        // dd($notulen->jumlah_revisi+1);
        if(is_null($request->revisi_notulen)) {
            notulen::where('id', $notulen->id)
                   ->update(['tanda_tangan' => $request->tanda_tangan,
                   'revisi_notulen' => $request->revisi_notulen,
                   'jumlah_revisi' => 0 ,

                ]);
        }
        else {
            notulen::where('id', $notulen->id)
                   ->update(['tanda_tangan' => $request->tanda_tangan,
                             'revisi_notulen' => $request->revisi_notulen,
                             'edited_by' => $request->edited_by,
                             'jumlah_revisi' => $notulen->jumlah_revisi+1 ,
                             'tanggal_revisi' => Carbon::today()]);
        }

        return redirect('/notulen/'.$notulen->id)->with('success', 'Notulen telah diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\notulen  $notulen
     * @return \Illuminate\Http\Response
     */
    public function destroy(notulen $notulen)
    {
        // dd($notulen->id);
        notulen::destroy($notulen->id);
        
        return redirect('/')->with('success', 'Notulen telah dihapus!');
    }
}
