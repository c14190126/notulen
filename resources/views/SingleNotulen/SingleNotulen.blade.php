@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Notulen</h4>
                    </div>
                </div>
                <hr style="height: 10px;">
                <div class="iq-card-body">
                    <form>
                        @csrf
                        @isset ($notulen->tanda_tangan)
                        <button onclick="window.location.href='{{ url('/list-notulen-acc') }}'" type="button" class="btn btn-success">
                            Back
                        </button>
                        @else
                        <button onclick="window.location.href='{{ url('/') }}'" type="button" class="btn btn-success">
                            Back
                        </button>
                        @endisset
                        <br><br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Creator</label>
                                    <input readonly="readonly" type="text" class="form-control"  id="user_id" value="{{ $notulen->user->name }}"/>
                                </div>
                                <div class="col-sm-4">
                                    <label style="color: black; font-weight: bold;" for="cabang">Nama Klien</label><br>
                                    <input readonly="readonly" type="text" class="form-control" id="nama_klien" value="{{ $notulen->klien->nama_klien }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Tanggal Meeting</label>
                                    <input readonly="readonly" type="date" class="form-control" id="tanggal" value="{{ $notulen->tanggal }}"/>
                                </div>
                                <div class="col-sm-2">
                                    <label for="text" style="color: black; font-weight: bold;">Jam Mulai</label>
                                    <input readonly="readonly" type="time" class="form-control" id="jam_mulai" value="{{ $notulen->jam_mulai }}"/>
                                </div>
                                <div class="col-sm-2">
                                    <label for="text" style="color: black; font-weight: bold;">Jam Selesai</label>
                                    <input readonly="readonly" type="time" class="form-control" id="jam_selesai" value="{{ $notulen->jam_selesai }}"/>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4" >
                                    <label for="text" style="color: black; font-weight: bold;">Judul Meeting</label>
                                    <input readonly="readonly" type="text" class="form-control" id="judul_meeting" value="{{ $notulen->judul_meeting }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="text" style="color: black; font-weight: bold;">Isi Meeting</label>
                                     <p>{!! $notulen->isi_notulen !!}</p>
                            {{-- <input id="isi_notulen" type="text" value="{!! $notulen->isi_notulen !!}">
                            <trix-editor input="isi_notulen"></trix-editor> --}}
                                </div>
                            </div>
                        </div>
                        @isset($notulen->catatan_klien)
                        {{-- <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Edited By</label>
                                    <input readonly="readonly" type="text" class="form-control" id="edited-by" value="{{ $edited->name}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Tanggal Revisi</label>
                                    <input readonly="readonly" type="text" class="form-control" id="tanggal_revisi" value="{{ date('d M Y', strtotime($notulen->tanggal_revisi)) }}"/>
                                </div>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="text" style="color: black; font-weight: bold;">Catatan Klien</label>
                                    <p>{!! $notulen->catatan_klien !!}</p>
                                    {{-- <input id="isi_notulen" type="text" value="{!! $notulen->isi_notulen !!}">
                                    <trix-editor input="isi_notulen"></trix-editor> --}}
                                </div>
                            </div>
                        </div>
                        @endisset


                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Tanda Tangan Klien</label><br>
                                    <img src="{{ $notulen->tanda_tangan }}" style="height: 200px"/>                                    
                                </div>
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Tanda Tangan Deus</label><br>
                                    <img src="{{ $notulen->tanda_tangan_deus }}" style="height: 200px"/>
                                </div>
                            </div>
                        </div>
                    </form>
                    @if ($count > 0)
                    <div>
                        <table class="table table-striped table-borderless">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Catatan</th>
                                    <th>Penulis</th>
                                </tr>
                            </thead>
                            @foreach ($catatan as $c)
                                <tr>
                                    <td>{{ $c->tanggal_catatan }}</td>
                                    <td>{{ $c->isi_catatan }}</td>
                                    <td>{{ $c->user->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                @if(Str::length(Auth::guard('user')->user())>0)
                                @empty($notulen->tanda_tangan)
                                <form action="{{  url('/send-wa')  }}" method="post">
                                    @csrf
                                    <input hidden type="text" name="link_edit" value="{{ url('/notulen/'.$notulen->id.'/edit') }}" id="link_edit">
                                    <input hidden type="text" name="id_notulen" value="{{ $notulen->id }}">
                                    <button type="submit" class="btn btn-success" style="width: 160px;"> Send WhatsApp</button>
                                </form>
                                @endempty
                                @endif
                            </div>
                            {{-- <div class="col-sm-2">
                                @if(Str::length(Auth::guard('user')->user())>0)
                                @empty($notulen->tanda_tangan)
                                <form action="{{  url('/send-email')  }}" method="post">
                                    @csrf
                                    <input hidden type="text" name="link_edit" value="{{ url('/notulen/'.$notulen->id.'/edit') }}" id="link_edit">
                                    <input hidden type="text" name="id_notulen" value="{{ $notulen->id }}">
                                    <button type="submit" class="btn btn-danger" style="width: 160px;"> Send Email</button>
                                </form>
                                @endempty
                                @endif
                            </div> --}}
                            @if(Str::length(Auth::guard('user')->user())>0)
                            @empty($notulen->tanda_tangan) 
                            <div class="col-sm-2">
                                <button onclick="copyLink()" class="btn" style="background-color: #FECF5B; color: black; width: 160px;">Copy Link Edit</button>
                            </div>
                            @endempty
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function copyLink() {
              /* Get the text field */
              var copyText = document.getElementById("link-edit");
            
              /* Select the text field */
              copyText.select();
              copyText.setSelectionRange(0, 99999); /* For mobile devices */
            
              /* Copy the text inside the text field */
              navigator.clipboard.writeText(copyText.value);
            }
        </script>
</body>
</html>