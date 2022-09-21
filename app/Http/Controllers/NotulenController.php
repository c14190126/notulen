<?php

namespace App\Http\Controllers;

use App\Models\notulen;
use App\Models\klien;
use App\Http\Requests\StorenotulenRequest;
use App\Http\Requests\UpdatenotulenRequest;
use App\Models\User;
use App\Models\user_akses;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
        if(Auth::guard('user')->check()) {
            $user_akses = user_akses::where('akses_user', Auth::id())->get('notulen_id');
            // $list_notulen = notulen::latest()->whereIn('id', $user_akses)->orwhere('private', 0)->get();
            // dd($list_notulen);

            return view('ListNotulen', [
                "title" => "Daftar Notulen",
                "list_notulen" => notulen::latest()->whereIn('id', $user_akses)->orwhere('private', 0)->filter(request(['search', 'klien']))->paginate(10)->withQueryString(),
            ]);
        }
        else{
            $klien_akses = notulen::where('klien_id', Auth::id())->get('klien_id');
            

            return view('ListNotulen', [
                "title" => "Daftar Notulen",
                "list_notulen" => notulen::latest()->whereIn('klien_id', $klien_akses)->filter(request(['search', 'klien']))->paginate(10)->withQueryString(),
            ]);
        }
       
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
        // dd($request);
        if($request->private == 'on') {
            $count_akses_user = count($request->input('akses_user'));
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

        if($request->private == 'on') {
            $notulen= notulen::where('judul_meeting', $request->judul_meeting)->where('tanda_tangan_deus', $request->tanda_tangan_deus)->first();
            for($i=0; $i < $count_akses_user; $i++ ) {
                $user_akses = user_akses::create([
                    'notulen_id' => $notulen->id,
                    'akses_user' => $request->akses_user[$i]
                ]);
            }
        }
        
        $request->session()->flash('success','Penyimpanan Berhasil');
        return redirect('/');
    }

    public function getURL(StorenotulenRequest $request)
    {
        $data['klien'] = $request->tanda_tangan;
        $data['deus'] = $request->tanda_tangan_deus;

        return response()->json($data);
    }
    
    public function getUser(StorenotulenRequest $request)
    {
        $data['user'] = User::all();

        return response()->json($data);
    }

    public function getRevisi(StorenotulenRequest $request)
    {
        $data['user'] = User::all();

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
        $notulen = notulen::where('id', $id)->first();
        if (Auth::guard('user')->check()) {
            if ($notulen->private == 0)
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
            else
            {
                $akses_notulen = user_akses::where('notulen_id', $id)->where('akses_user', Auth::id())->count();
                if ($akses_notulen != 0)
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
                else {
                    abort(403);
                }
            }
        }
        else
        {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\notulen  $notulen
     * @return \Illuminate\Http\Response
     */
    public function edit(notulen $notulen)
    {
        if (Auth::guard("user")->check())
        {
            if ($notulen->private == 0)
            {
                return view('EditNotulen', [
                    "title" => "Edit Notulen",
                    "notulen" => $notulen,
                    "edited" => DB::table('users as u')
                                ->join('notulens as n', 'u.id', '=', 'n.edited_by')
                                ->where('n.id',$notulen->id)
                                ->select('u.name')
                                ->first()
                ]);
            }
            else
            {
                $akses_notulen = user_akses::where('notulen_id', $notulen->id)->where('akses_user', Auth::id())->count();
                if ($akses_notulen != 0)
                {
                    return view('EditNotulen', [
                        "title" => "Edit Notulen",
                        "notulen" => $notulen,
                        "edited" => DB::table('users as u')
                                    ->join('notulens as n', 'u.id', '=', 'n.edited_by')
                                    ->where('n.id',$notulen->id)
                                    ->select('u.name')
                                    ->first()
                    ]);
                }
                else {
                    abort(403);
                }
            }
        }
        else
        {
            $klien_akses = notulen::where('id', $notulen->id)->where('klien_id', Auth::id())->first();
            // dd($klien_akses);
            if ($klien_akses != null){
                return view('EditNotulen', [
                    "title" => "Edit Notulen",
                    "notulen" => $notulen,
                    "edited" => DB::table('users as u')
                                ->join('notulens as n', 'u.id', '=', 'n.edited_by')
                                ->where('n.id',$notulen->id)
                                ->select('u.name')
                                ->first()
                ]);
            }
            else {
                abort(403);
            }
        }
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
        if(Auth::user())
        {
            // if(is_null($request->revisi_notulen)) {
            //     notulen::where('id', $notulen->id)
            //            ->update(['tanda_tangan' => $request->tanda_tangan,
            //            'revisi_notulen' => $request->revisi_notulen,
            //            'jumlah_revisi' => 0,
            //            'tanggal_revisi' => NULL,
            //            'edited_by' => NULL
            //         ]);
            // }
            // else {
                notulen::where('id', $notulen->id)
                       ->update(['tanda_tangan' => $request->tanda_tangan,
                                 'isi_notulen' => $request->isi_notulen,
                                 'edited_by' => $request->edited_by,
                                 'jumlah_revisi' => $notulen->jumlah_revisi+1,
                                 'tanggal_revisi' => Carbon::today()]);
            // }
            
        }
        else{
            notulen::where('id', $notulen->id)
                    ->update(['tanda_tangan' => $request->tanda_tangan
            ]);
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
        if (Auth::user()) {
            if($notulen->private == 'on')
            {
                notulen::destroy($notulen->id);
            }
            else
            {
                $akses_notulen = user_akses::where('notulen_id', $notulen->id)->where('akses_user', Auth::id())->count();
                if ($akses_notulen != 0)
                {
                    notulen::destroy($notulen->id);
                }
                else
                {
                    abort(403);
                }
            }
        }
        return redirect('/')->with('success', 'Notulen telah dihapus!');
    }
}
