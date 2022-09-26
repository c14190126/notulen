<?php

namespace App\Http\Controllers;

use App\Models\NotesNotulen;
use App\Http\Requests\StoreNotesNotulenRequest;
use App\Http\Requests\UpdateNotesNotulenRequest;
use Illuminate\Support\Facades\Auth;

class NotesNotulenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreNotesNotulenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, StoreNotesNotulenRequest $request)
    {
        $validatedData = $request->validate([
            'tanggal_catatan' => 'required',
            'isi_catatan' => 'required'
        ]);
        $validatedData['user_id'] = Auth::guard('user')->id();
        $validatedData['notulen_id'] = $id;

        NotesNotulen::create($validatedData);

        $request->session()->flash('success','Penyimpanan Berhasil');
        return redirect('/notulen/'.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotesNotulen  $notesNotulen
     * @return \Illuminate\Http\Response
     */
    public function show(NotesNotulen $notesNotulen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotesNotulen  $notesNotulen
     * @return \Illuminate\Http\Response
     */
    public function edit(NotesNotulen $notesNotulen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotesNotulenRequest  $request
     * @param  \App\Models\NotesNotulen  $notesNotulen
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotesNotulenRequest $request, NotesNotulen $notesNotulen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotesNotulen  $notesNotulen
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotesNotulen $notesNotulen)
    {
        //
    }
}
