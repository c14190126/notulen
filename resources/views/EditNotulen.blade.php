@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                {{-- <div class="iq-card-header d-flex justify-content-between"> --}}
                    <div class="iq-header-title">
                        <h4 class="card-title">Edit Notulen</h4>
                    </div>
                    @auth
                    @if(Str::length(Auth::guard('user')->user())>0)
                    <hr style="height: 10px;">
                    <div class="iq-card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form action="{{ url('/edit-notulen/'.$notulen->id) }}" method="post" enctype="multipart/form-data">
                            @method('put')
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
                                        <input readonly="readonly" type="text" class="form-control" id="name" value="{{ $notulen->user->name }}"/>
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
                            @isset($notulen->tanda_tangan)
                            <label for="text" style="color: black; font-weight: bold;">Isi Meeting</label>
                            <p>{!! $notulen->isi_notulen !!}</p>                                                                       
                                        @else
                                        <label for="text" style="color: black; font-weight: bold;">Isi Meeting</label>
                                        <input id="isi_notulen" type="hidden" name="isi_notulen" value="{{ old('isi_notulen', $notulen->isi_notulen) }}">
                                        <trix-editor id="isi_notulen" input="isi_notulen" value="{{ old('isi_notulen', $notulen->isi_notulen) }}"></trix-editor>
                            @endisset            
                            <div class="form-group">
                                @isset($notulen->catatan_klien)
                                <label for="text" style="color: black; font-weight: bold;">Catatan Klien</label>
                                <p>{!! $notulen->catatan_klien !!}</p>                                                                       
                                @endisset
                            </div>
                            @isset($notulen->edited_by)
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="text" style="color: black; font-weight: bold;">Edited By</label>
                                        <input class="form-control" readonly type="text" value="{{ $edited->name }}">
                                    </div>
                                </div>
                            </div>
                            @endisset
                            {{-- <div class="form-group">
                                <label for="text" style="color: black; font-weight: bold;">Revisi Meeting</label>
                                @if($notulen->jumlah_revisi<3)
                                <input id="edited_by" type="hidden" name="edited_by" value="{{ auth()->user()->id }}">
                                <input id="revisi_notulen" type="hidden" name="revisi_notulen" value="{{ old('revisi_notulen', $notulen->revisi_notulen) }}">
                                <trix-editor id="revisi" input="revisi_notulen" value="{{ old('revisi_notulen', $notulen->revisi_notulen) }}"></trix-editor>
                                @else
                                <p>{!! $notulen->revisi_notulen !!}</p>
                                @endif
                            </div> --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="text" style="color: black; font-weight: bold;">Tanda Tangan Klien</label>
                                    @isset($notulen->tanda_tangan)
                                    <br><img src="{{ $notulen->tanda_tangan }}" style="height: 70%"/>
                                    @else
                                        <div id="signature-pad" class="jay-signature-pad">
                                            <div class="jay-signature-pad--body">
                                                <canvas id="jay-signature-pad-2" width=300 height=200 style="margin: 0px; padding: 0px; border: none; height: 200px; width: 300px; touch-action: none; background-color: rgb(247, 248, 248);"></canvas>
                                            </div>
                                            <div class="signature-pad--footer txt-center">
                                                <div class="signature-pad--actions txt-center">
                                                    <div>
                                                        <button type="button" class="btn btn-danger" data-action="clear">Clear</button>
                                                        <button id="tombol" type="button" class="btn btn-success">Save</button>
                                                    </div><br/>
                                                </div>
                                            </div>
                                        </div>    
                                        @endisset
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="text" style="color: black; font-weight: bold;">Tanda Tangan Deus</label>
                                        <br><img src="{{ $notulen->tanda_tangan_deus }}" style="height: 70%"/>
                                    </div>
                                </div>
                            </div>
                                    
                            <div class="form-group" id="data_url">
                                <input type="hidden" class="form-control" style="width:30%;" name="tanda_tangan"  autofocus value="{{ old('tanda_tangan') }}"/>
                            </div>
                            {{-- <br><button type="submit" class="btn" style="background-color: #FECF5B; color: black;">Submit</button> --}}
                        </form>
                        <form action="{{ url('/notulen/'.$notulen->id.'/edit/add-catatan') }}" method="post">
                            @csrf
                            @isset($notulen->tanda_tangan)
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="text" style="color: black; font-weight: bold;">Tanggal Catatan</label>
                                        <input type="date" class="form-control" id="tanggal_catatan" name="tanggal_catatan" value="{{ date('Y-m-d') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="text" style="color: black; font-weight: bold;">Isi Catatan</label>
                                        <input id="isi_notulen" type="hidden" name="isi_notulen" value="{{ old('isi_notulen') }}">
                                        <trix-editor class="trix-content input="isi_notulen"></trix-editor>                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </div>
                            @endisset
                        </form>
                    </div>
                    @else
                    @isset($notulen->tanda_tangan) 
                        <div class="form-group">
                            <br>
                            <label style="font-size: 130px">Sudah Tidak Bisa Di Edit</label>
                        </div>
                        @else
                            <hr style="height: 10px;">
                            <div class="iq-card-body">
                                <form action="{{ url('/edit-notulen/'.$notulen->id) }}" method="post" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <button onclick="window.location.href='{{ url('/') }}'" type="button" class="btn btn-success">
                                        Back
                                    </button>
                                    <br><br>
                                    <div class="form-group">
                                        <label for="text" style="color: black; font-weight: bold;">Creator</label>
                                        <input readonly="readonly" type="text" class="form-control" style="width:30%;" id="name" value="{{ $notulen->user->name }}"/>
                                    </div>
                                    <div class="form-group">
                                        <label style="color: black; font-weight: bold;" for="cabang">Nama Klien</label><br>
                                        <input readonly="readonly" type="text" class="form-control" style="width:30%;" id="nama_klien" value="{{ $notulen->klien->nama_klien }}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" style="color: black; font-weight: bold;">Tanggal Meeting</label>
                                        <input readonly="readonly" type="date" class="form-control" style="width:30%;" id="tanggal" value="{{ $notulen->tanggal }}"/>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label for="text" style="color: black; font-weight: bold;">Jam Mulai</label>
                                                <input readonly="readonly" type="time" class="form-control" style="width:90%;" id="jam_mulai" value="{{ $notulen->jam_mulai }}"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="text" style="color: black; font-weight: bold;">Jam Selesai</label>
                                                <input readonly="readonly" type="time" class="form-control" style="width:90%;" id="jam_selesai" value="{{ $notulen->jam_selesai }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" style="color: black; font-weight: bold;">Judul Meeting</label>
                                        <input readonly="readonly" type="text" class="form-control" id="judul_meeting" style="width:30%;" value="{{ $notulen->judul_meeting }}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" style="color: black; font-weight: bold;">Isi Meeting</label>
                                        <p>{!! $notulen->isi_notulen !!}</p>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="terima" value="terima" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                          Terima
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="tolak" value="tolak">
                                        <label class="form-check-label" for="exampleRadios2">
                                          Tolak
                                        </label>
                                      </div>
                                      <div class="form-group" id="catatan">
                                        
                                    </div>
                                    {{-- <div class="form-group">
                                        @isset($notulen->revisi_notulen)
                                            <label for="text" style="color: black; font-weight: bold;">Edited By</label>
                                            <p>{!! $edited->name !!}</p>
                                        @endisset
                                    </div> --}}
                                    {{-- <div class="form-group">
                                        @isset($notulen->catatan_klien)
                                            <label for="text" style="color: black; font-weight: bold;">Catatan Klien</label>
                                            <p>{!! $notulen->catatan_klien !!}</p>
                                        @endisset
                                    </div> --}}
                                    <div class="form-group" id="">
                                        
                                    </div>
                                    <div class="form-group">
                                        <div class="row" id="tandatangan">
                                            <div class="col-sm-6">
                                                <label for="text" style="color: black; font-weight: bold;">Tanda Tangan Klien</label>
                                                <div id="signature-pad" class="jay-signature-pad">
                                                    <div class="jay-signature-pad--body">
                                                        <canvas id="jay-signature-pad-2" width=300 height=200 style="margin: 0px; padding: 0px; border: none; height: 200px; width: 300px; touch-action: none; background-color: rgb(247, 248, 248);"></canvas>
                                                        </div>
                                                    <div class="signature-pad--footer txt-center">
                                                        <div class="signature-pad--actions txt-center">
                                                            <div>
                                                                <button type="button" class="btn btn-danger" data-action="clear">Clear</button>
                                                                <button id="tombol" type="button" class="btn btn-success">Save</button>
                                                            </div><br/>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="text" style="color: black; font-weight: bold;">Tanda Tangan Deus</label>
                                                <br><img src="{{ $notulen->tanda_tangan_deus }}" style="height: 70%"/>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('.form-check').click(function () {
                                            if($('#tolak').is(':checked')==true){
                                                var status = $('#tolak').val()
                                                        $('#catatan').append('<label for="text" style="color: black; font-weight: bold;">Catatan</label>\
                                                        <input id="catatan_klien" type="hidden" name="catatan_klien" value="{{ old('catatan_klien') }}">\
                                                        <trix-editor input="catatan_klien"></trix-editor>')
                                            }   
                                            else{
                                                $('#catatan').html('');
                                            }           
                                            // $.ajax({
                                            //     url: "{{url('/get-revisi')}}",
                                            //     type: 'POST',
                                            //     data: {
                                            //             status:status,
                                            //             _token:'{{ csrf_token() }}'
                                            //     },
                                            //     dataType: 'json',
                                            //     success: function (result) {
                                            //         if(status=="terima") {
                                                        
                                            //         }
                            
                                            //         else {
                                            //             $('#data_url').html('<input type="hidden" class="form-control" style="width:30%;" name="tanda_tangan" required autofocus value="'+result.klien+'"/><button type="submit" class="btn" style="background-color: #FECF5B; color: black;">Submit</button>');
                                            //         }
                                            //     }
                                            // });
                                        });
                                    </script>
                                    <div class="form-group" id="data_url">
                                        <input type="hidden" class="form-control" style="width:30%;" name="tanda_tangan"  autofocus value="{{ old('tanda_tangan') }}"/>
                                    </div>
                                    {{-- <br><button type="submit" class="btn" style="background-color: #FECF5B; color: black;">Submit</button> --}}
                                </form>
                            </div>
                        @endisset
                        @endif
                    @endauth
                {{-- </div> --}}
            </div>
        </div>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
        <script>
            var wrapper = document.getElementById("signature-pad");
            var clearButton = wrapper.querySelector("[data-action=clear]");
            var changeColorButton = wrapper.querySelector("[data-action=change-color]");
            var canvas = wrapper.querySelector("canvas");
            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });
            // Adjust canvas coordinate space taking into account pixel ratio,
            // to make it look crisp on mobile devices.
            // This also causes canvas to be cleared.
            function resizeCanvas() {
                console.log(signaturePad);
                // When zoomed out to less than 100%, for some very strange reason,
                // some browsers report devicePixelRatio as less than 1
                // and only part of the canvas is cleared then.
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                // This part causes the canvas to be cleared
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                console.log(canvas.getContext("2d").scale(1, 1));
                // This library does not listen for canvas changes, so after the canvas is automatically
                // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
                // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
                // that the state of this library is consistent with visual state of the canvas, you
                // have to clear it manually.
                signaturePad.clear();
            }
            // On mobile devices it might make more sense to listen to orientation change,
            // rather than window resize events.
            window.onresize = resizeCanvas;
            resizeCanvas();
            function download(dataURL, filename) {
                var blob = dataURLToBlob(dataURL);
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.style = "display: none";
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            }
            // One could simply use Canvas#toBlob method instead, but it's just to show
            // that it can be done using result of SignaturePad#toDataURL.
            function dataURLToBlob(dataURL) {
                var parts = dataURL.split(';base64,');
                var contentType = parts[0].split(":")[1];
                var raw = window.atob(parts[1]);
                var rawLength = raw.length;
                var uInt8Array = new Uint8Array(rawLength);
                for (var i = 0; i < rawLength; ++i) {
                    uInt8Array[i] = raw.charCodeAt(i);
                }
                return new Blob([uInt8Array], { type: contentType });
            }
            clearButton.addEventListener("click", function (event) {
                signaturePad.clear();
            });
            // saveJPGButton.addEventListener("click", function (event) {
            //     if (signaturePad.isEmpty()) {
            //     alert("Please provide a signature first.");
            //     } else {
            //     var dataURL = signaturePad.toDataURL("image/jpeg");
            //     console.log(dataURL);
            //     // download(dataURL, "signature.jpg");
            //     }
            // });
        </script>

        <script>
            var wrapper = document.getElementById("signature-pad-2");
            var clearButton = wrapper.querySelector("[data-action=clear]");
            var changeColorButton = wrapper.querySelector("[data-action=change-color]");
            var canvas = wrapper.querySelector("canvas");
            var signaturePad2 = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });
            // Adjust canvas coordinate space taking into account pixel ratio,
            // to make it look crisp on mobile devices.
            // This also causes canvas to be cleared.
            function resizeCanvas() {
                console.log(signaturePad2);
                // When zoomed out to less than 100%, for some very strange reason,
                // some browsers report devicePixelRatio as less than 1
                // and only part of the canvas is cleared then.
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                // This part causes the canvas to be cleared
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                console.log(canvas.getContext("2d").scale(1, 1));
                // This library does not listen for canvas changes, so after the canvas is automatically
                // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
                // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
                // that the state of this library is consistent with visual state of the canvas, you
                // have to clear it manually.
                signaturePad2.clear();
            }
            // On mobile devices it might make more sense to listen to orientation change,
            // rather than window resize events.
            window.onresize = resizeCanvas;
            resizeCanvas();
            function download(dataURL, filename) {
                var blob = dataURLToBlob(dataURL);
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.style = "display: none";
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            }
            // One could simply use Canvas#toBlob method instead, but it's just to show
            // that it can be done using result of SignaturePad#toDataURL.
            function dataURLToBlob(dataURL) {
                var parts = dataURL.split(';base64,');
                var contentType = parts[0].split(":")[1];
                var raw = window.atob(parts[1]);
                var rawLength = raw.length;
                var uInt8Array = new Uint8Array(rawLength);
                for (var i = 0; i < rawLength; ++i) {
                    uInt8Array[i] = raw.charCodeAt(i);
                }
                return new Blob([uInt8Array], { type: contentType });
            }
            clearButton.addEventListener("click", function (event) {
                signaturePad2.clear();
            });
            // saveJPGButton.addEventListener("click", function (event) {
            //     if (signaturePad.isEmpty()) {
            //     alert("Please provide a signature first.");
            //     } else {
            //     var dataURL = signaturePad.toDataURL("image/jpeg");
            //     console.log(dataURL);
            //     // download(dataURL, "signature.jpg");
            //     }
            // });
        </script>
       

        <script>
            $('#tombol').click(function () {
                var tanda_tangan = signaturePad.toDataURL("image/jpeg");
                // var tanda_tangan_deus = signaturePad2.toDataURL("image/jpeg");
                $("#data_url").html('');
                // $("#data_url_2").html('');
                // console.log(tanda_tangan);
                // alert(tanda_tangan);
                $.ajax({
                    url: "{{url('/get-url')}}",
                    type: 'POST',
                    data: {
                            tanda_tangan:tanda_tangan,
                            // tanda_tangan_deus:tanda_tangan_deus,
                            _token:'{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        if(signaturePad.isEmpty()) {
                            $('#data_url').html('<input type="hidden" class="form-control" style="width:30%;" name="tanda_tangan" required autofocus value=""/><button type="submit" class="btn" style="background-color: #FECF5B; color: black;">Submit</button>');
                        }

                        else {
                            $('#data_url').html('<input type="hidden" class="form-control" style="width:30%;" name="tanda_tangan" required autofocus value="'+result.klien+'"/><button type="submit" class="btn" style="background-color: #FECF5B; color: black;">Submit</button>');
                        }
                    }
                });
            });
        </script>
        
        
</body>
</html>