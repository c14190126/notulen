<?php

namespace App\Http\Controllers;

use App\Models\notulen;
use App\Models\klien;
use App\Http\Requests\StorenotulenRequest;
use App\Http\Requests\UpdatenotulenRequest;
use App\Models\detail_klien;
use App\Models\NotesNotulen;
use App\Models\Perusahaan;
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
            // dd($list_notulen);
            // $last_edit = NotesNotulen::groupBy('notulen_id')->select(DB::raw('MAX(created_at) as max'), 'notulen_id', 'created_at')->get();

            // dd($last_edit);
            
            return view('ListNotulen', [
                "title" => "Daftar Notulen",
                "list_notulen" => notulen::latest()->whereIn('id', $user_akses)->orwhere('private', 0)->whereNull('tanda_tangan')->filter(request(['search', 'klien']))->paginate(10)->withQueryString(),
                "last_edit" => NotesNotulen::groupBy('notulen_id')->select(DB::raw('MAX(created_at) as max'),'notulen_id')->get()
            ]);
        }
        else{
            $klien_akses = detail_klien::where('detail_kliens.klien_id', Auth::guard('klien')->id())->get('detail_kliens.perusahaan_id');
            $list_notulen = DB::table('notulens as n')
                       ->join('detail_kliens as d', 'd.perusahaan_id', '=', 'n.id')
                       ->join('users as u','n.user_id','=','u.id')
                       ->join('perusahaans as p','p.id','=','d.perusahaan_id')
                       ->join('kliens as k','k.id','d.klien_id')
                       ->wherein('d.perusahaan_id',$klien_akses)
                       ->select('n.*','u.name','p.nama_perusahaan','k.nama_klien')->distinct()
                       ->get();
            // dd($list_notulen);
            return view('ListNotulen', [
                "title" => "Daftar Notulen",
                "list_notulen" => $list_notulen,
                "last_edit" => NotesNotulen::groupBy('notulen_id')->select(DB::raw('MAX(created_at) as max'),'notulen_id')->get()
            ]);
            // if($user != NULL) {
            // }
        }
       
    }
    public function indexacc()
    {
        if(Auth::guard('user')->check()) {
            $user_akses = user_akses::where('akses_user', Auth::id())->get('notulen_id');
            // dd($list_notulen);
            // $last_edit = NotesNotulen::groupBy('notulen_id')->select(DB::raw('MAX(created_at) as max'), 'notulen_id', 'created_at')->get();

            // dd($last_edit);
            
            return view('ListNotulenAcc', [
                "title" => "Daftar Notulen Acc",
                "list_notulen" => notulen::latest()->whereNotNull('tanda_tangan')->orwhere('private', 0)->whereIn('id', $user_akses)->filter(request(['search', 'klien']))->paginate(10)->withQueryString(),
                "last_edit" => NotesNotulen::groupBy('notulen_id')->select(DB::raw('MAX(created_at) as max'),'notulen_id')->get()
            ]);
        }
        else{
            $klien_akses = detail_klien::where('detail_kliens.klien_id', Auth::guard('klien')->id())->get('detail_kliens.perusahaan_id');
            return view('ListNotulenAcc', [
                "title" => "Daftar Notulen Acc",
                "list_notulen" => notulen::latest()->join('detail_kliens','detail_kliens.id','=','notulens.perusahaan_id')->whereIn('detail_kliens.perusahaan_id', $klien_akses)->whereNotNull('tanda_tangan')->filter(request(['search', 'klien']))->paginate(10)->withQueryString(),
                "last_edit" => NotesNotulen::groupBy('notulen_id')->select(DB::raw('MAX(created_at) as max'),'notulen_id')->get()

            ]);
        }
       
    }


    public function indexAdd()
    {
        return view('CreateNotulen', [
            "title" => "Create Notulen",
            "list_perusahaan" => detail_klien::where('deleted',Null)->get(),
        ]);
    }

    public function send_wa(Request $request)
    {
        $notulen = notulen::join('perusahaans as p', 'notulens.perusahaan_id', '=', 'p.id')->join('kliens as k', 'p.klien_id','k.id')->where('notulens.id', $request->id_notulen)->select('notulens.*', 'p.klien_id', 'k.nama_klien', 'k.email')->first();
        $tanggal = Carbon::createFromFormat('Y-m-d', $notulen->tanggal)->format('d F Y');
        $jam_mulai = Carbon::createFromFormat('H:i:s', $notulen->jam_mulai)->format('H:i');
        $jam_selesai = Carbon::createFromFormat('H:i:s', $notulen->jam_selesai)->format('H:i');
        $no_wa = substr($notulen->no_wa, 1);
        // dd($notulen->email);
        return redirect('https://api.whatsapp.com/send?phone=62'.$no_wa.'&text=Judul%20Meeting:%20'.$notulen->judul_meeting.'%0ANama%20Klien:%20'.$notulen->nama_klien.'%0ATanggal%20Meeting:%20'.$tanggal.'%0AJam%20Mulai:%20'.$jam_mulai.'%20WIB%0AJam%20Selesai:%20'.$jam_selesai.'%20WIB%0ALink%20Notulen:%20'.$request->link_edit.'%0A%0ADefault%20Login:%0AEmail:%20'.$notulen->email);
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
                'perusahaan_id' => 'required',
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
                'perusahaan_id' => 'required',
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
                    "catatan" => NotesNotulen::where('notulen_id', $id)->get(),
                    "count" => NotesNotulen::where('notulen_id', $id)->count(),
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
                        "catatan" => NotesNotulen::where('notulen_id', $id)->get(),
                        "count" => NotesNotulen::where('notulen_id', $id)->count(),
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
        else if (Auth::guard('klien')->check()) 
        {
            $akses_notulen = detail_klien::where('detail_kliens.perusahaan_id','=',$id)->where('detail_kliens.klien_id','=',Auth::guard('klien')->check())->get();
            // $klien_akses = notulen::where('notulens.id', $notulen->id)->join('perusahaans', 'perusahaans.id', '=', 'notulens.perusahaan_id')->where('perusahaans.klien_id', Auth::guard('klien')->id())->first();
            $notulen = notulen::join('detail_kliens', 'detail_kliens.id', '=', 'notulens.perusahaan_id')->where('notulens.id', $notulen->id)->select('detail_kliens.klien_id')->first();
            if ($akses_notulen != null){
            if ($notulen->klien_id ){
                return view('SingleNotulen.SingleNotulen', [
                    "title" => "Notulen",
                    "notulen" => notulen::where('id', $id)->first(),
                    "catatan" => NotesNotulen::where('notulen_id', $id)->get(),
                    "count" => NotesNotulen::where('notulen_id', $id)->count(),
                    "edited" => DB::table('users as u')
                                ->join('notulens as n', 'u.id', '=', 'n.edited_by')
                                ->where('n.id',$id)
                                ->select('u.name')
                                ->first()
                ]);      
            }
            else
            {
                abort(403);
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
}
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
            $klien_akses = detail_klien::where('detail_kliens.klien_id', Auth::guard('klien')->id())->get('detail_kliens.perusahaan_id');
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
        // dd($request);
        // dd($notulen->jumlah_revisi+1);
        if(Auth::guard('user')->check())
        {
            // if(is_null($request->catatan)) {
                notulen::where('id', $notulen->id)
                       ->update(['tanda_tangan' => $request->tanda_tangan,
                            'isi_notulen' => $request->isi_notulen,
                            'judul_meeting'=>$request->judul_meeting,
                             'edited_by' => Auth::id()
                    ]);
            // }
            // else {
            //     notulen::where('id', $notulen->id)
            //            ->update(['tanda_tangan' => $request->tanda_tangan,
            //                      'isi_notulen' => $request->isi_notulen,
            //                      'edited_by' => $request->edited_by,
            //                      'catatan'=>$request->catatan,
            //                     //  'jumlah_revisi' => $notulen->jumlah_revisi+1,
            //                     //  'tanggal_revisi' => Carbon::today()
            //                     ]);
            // }
            
        }
        elseif(Auth::guard('klien')->check())
        {
            if(is_null($request->_klien)) {
                notulen::where('id', $notulen->id)
                       ->update(['tanda_tangan' => $request->tanda_tangan,
                       'catatan_klien' => $request->catatan_klien,
                    //    'tanggal_revisi' => NULL,
                    ]);
                  }
                  else
                  {
                    notulen::where('id', $notulen->id)
                       ->update(['tanda_tangan' => $request->tanda_tangan,
                  ]);
                  }
         }
        return redirect('/')->with('success', 'Notulen telah diedit!');
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
