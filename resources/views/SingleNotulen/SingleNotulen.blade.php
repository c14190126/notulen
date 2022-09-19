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
                        <button onclick="window.location.href='{{ url('/') }}'" type="button" class="btn btn-success">
                            Back
                        </button>
                        <br><br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Creator</label>
                                    <input readonly="readonly" type="text" class="form-control"  id="user_id" value="{{ $notulen->user->name }}"/>
                                </div>
                            </div>
                           
                        </div>
                        <div class="form-group">
                            <div class="row">
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
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
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
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Judul Meeting</label>
                                    <input readonly="readonly" type="text" class="form-control" id="judul_meeting" value="{{ $notulen->judul_meeting }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Isi Meeting</label>
                                     <p>{!! $notulen->isi_notulen !!}</p>
                            {{-- <input id="isi_notulen" type="text" value="{!! $notulen->isi_notulen !!}">
                            <trix-editor input="isi_notulen"></trix-editor> --}}
                                </div>
                            </div>
                        </div>
                        @isset($notulen->revisi_notulen)
                        <div class="form-group">
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
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Revisi Meeting</label>
                                    <p>{!! $notulen->revisi_notulen !!}</p>
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
                    <input hidden type="text" value="{{ url('/notulen/'.$notulen->id.'/edit') }}" id="link-edit">
                    <button onclick="copyLink()" class="btn" style="background-color: #FECF5B; color: black">Copy Link Edit</button>
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