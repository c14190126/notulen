@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Edit Draft Notulen</h4>
                    </div>
                </div>
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
                    <form action="{{ url('/edit-draft/'.$notulen->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="private">
                            <label class="custom-control-label" for="customSwitch1">Private</label>
                        </div>
                        <div class="form-group" id="hak_akses">
                            {{-- <label for="text" style="color: black; font-weight: bold;">User</label>
                            <div style="overflow-y: scroll; height: 50px;" id="isi">
                            </div> --}}
                        </div>
                        <script>
                            $('#customSwitch1').change(function () {
                                if ($('#customSwitch1').is(':checked') == true) {
                                    var customSwitch1 = true;
                                }
                                else {
                                    var customSwitch1 = false;    
                                }
                                // alert(customSwitch1);
                                $.ajax({
                                    url: "{{url('/get-user')}}",
                                    type: 'POST',
                                    data: {
                                        customSwitch1:customSwitch1,
                                        _token:'{{ csrf_token() }}'
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        if(customSwitch1 == false) {
                                            $('#hak_akses').html('');
                                        }
                                        else {
                                            $('#hak_akses').append('<label for="text" style="color: black; font-weight: bold;">User</label>\
                                                                    <div style="overflow-y: scroll; height: 100px; " id="isi">');
                                            $.each(result.user, function (key, value) {
                                                if(value.is_super_admin == 1) {
                                                    $('#isi').append('<div class="col-sm-4"><label><input type="checkbox" name="akses_user[]" value="'+value.id+'" checked onclick="return false;">'+value.name+'</label></div>');
                                                }
                                                else if (value.id == {{ auth()->user()->id }}) {
                                                    $('#isi').append('<div class="col-sm-4"><label><input type="checkbox" name="akses_user[]" value="'+value.id+'" checked onclick="return false;">'+value.name+'</label></div>');
                                                }
                                                else {
                                                    $('#isi').append('<div class="col-sm-4"><label><input type="checkbox" name="akses_user[]" value="'+value.id+'">'+value.name+'</label></div>');
                                                }
                                            })
                                            $('#hak_akses').append('</div>');
                                        }
                                    }
                                });
                            });
                        </script>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Creator</label>
                                    <input readonly="readonly" type="hidden" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required autofocus value="{{ auth()->user()->id }}"/>
                                    <input readonly="readonly" type="text" class="form-control"  id="name" value="{{ auth()->user()->name }}"/>
                                    @error('user_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label style="color: black; font-weight: bold;" for="cabang">Nama Klien</label><br>
                                    <input  type="text" class="form-control @error('nama_klien') is-invalid @enderror"  id="nama_klien" name="nama_klien" value="{{ $perusahaan->nama_perusahaan }}{{ ' - ' }}{{ $perusahaan->nama_klien}}" required autofocus readonly/>
                                    @error('nama_klien')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Tanggal Meeting</label>
                                    <input  type="date" class="form-control @error('tanggal') is-invalid @enderror"  id="tanggal" name="tanggal" value="{{ $notulen->tanggal }}" required autofocus/>
                                    {{-- <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" required autofocus value="{{ old('nama_pelanggan') }}"/> --}}
                                    @error('tanggal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label for="text" style="color: black; font-weight: bold;">Jam Mulai</label>
                                    <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" id="jam_mulai" name="jam_mulai" value="{{ $notulen->jam_mulai }}" required autofocus/>
                                    {{-- <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" required autofocus value="{{ old('nama_pelanggan') }}"/> --}}
                                    @error('jam_mulai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="text" style="color: black; font-weight: bold;">Jam Selesai</label>
                                    <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" id="jam_selesai" name="jam_selesai" value="{{ $notulen->jam_selesai }}" required autofocus/>
                                    {{-- <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" required autofocus value="{{ old('nama_pelanggan') }}"/> --}}
                                    @error('jam_selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="text" style="color: black; font-weight: bold;">Judul Meeting</label>
                                    <input type="text" class="form-control @error('judul_meeting') is-invalid @enderror" id="judul_meeting"  name="judul_meeting" required autofocus value="{{ $notulen->judul_meeting }}"/>
                                    @error('judul_meeting')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="text" style="color: black; font-weight: bold;">Isi Meeting</label>
                            <input id="isi_notulen" type="hidden" name="isi_notulen" value="{{ $notulen->isi_notulen }}">
                            <trix-editor input="isi_notulen"></trix-editor>
                        </div>
                        {{-- <div class="form-group">
                            <label for="text" style="color: black; font-weight: bold;">Tanda Tangan Klien</label>
                            <textarea id="signature64" name="signed" style="display: none"></textarea>
                        </div> --}}

                        <div class="form-group">
                            <div class="row">
                                {{-- <div class="col-sm-6">
                                    <label for="text" style="color: black; font-weight: bold;">Tanda Tangan Klien</label>
                                    <div id="signature-pad" class="jay-signature-pad" >
                                        <div class="jay-signature-pad--body">
                                            <canvas id="jay-signature-pad" width=300 height=200 style="margin: 0px; padding: 0px; border: none; height: 200px; width: 300px; touch-action: none; background-color: rgb(247, 248, 248);"></canvas>
                                        </div>
                                        <div class="signature-pad--footer txt-center">
                                            <div class="signature-pad--actions txt-center">
                                                <div>
                                                    <button type="button" class="btn btn-danger" data-action="clear">Clear</button>
                                                </div><br/>
                                            </div>
                                        </div>
                                    </div>    
                                </div> --}}
                                <div class="col-sm-6">
                                    <label for="text" style="color: black; font-weight: bold;">Tanda Tangan Deus</label>
                                    <div id="signature-pad-2" class="jay-signature-pad">
                                        <div class="jay-signature-pad--body">
                                            <canvas id="jay-signature-pad-2" width=300 height=200 style="margin: 0px; padding: 0px; border: none; height: 200px; width: 300px; touch-action: none; background-color: rgb(247, 248, 248); border:1 solid-black"></canvas>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-danger" data-action="clear">Clear</button>
                                        </div><br/>
                                    </div>
                                </div>
                            </div>
                            <button id="tombol" type="button" class="btn btn-success">Save</button>
                            <button type="submit" class="btn btn-success" name="action" value="draft">Save As Draft</button>
                        </div>

                        <div class="form-group" id="data_url">
                            {{-- <input type="text" class="form-control" style="width:30%;" name="tanda_tangan" required autofocus value="{{ old('tanda_tangan') }}"/> --}}
                        </div>
                        <div class="form-group" id="data_url_2">
                            <input type="hidden" class="form-control" style="width:30%;" name="tanda_tangan_deus" required autofocus value="{{ old('tanda_tangan_deus') }}"/>
                        </div>
                        {{-- <button type="submit" class="btn" style="background-color: #FECF5B; color: black;">Submit</button> --}}
                    </form>
                    
                </div>
            </div>
        </div>
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
            $('#clear').click(function(e) {
                e.preventDefault();
                sig.signature('clear');
                $("#signature64").val('');
            });
        </script> --}}

        <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>

            $(document).ready(function() {
                $('.test').select2();
            });
            // var wrapper = document.getElementById("signature-pad");
            // var clearButton = wrapper.querySelector("[data-action=clear]");
            // var changeColorButton = wrapper.querySelector("[data-action=change-color]");
            // var savePNGButton = wrapper.querySelector("[data-action=save-png]");
            // var saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
            // var saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
            // var canvas = wrapper.querySelector("canvas");
            // var signaturePad = new SignaturePad(canvas, {
            //     backgroundColor: 'rgb(255, 255, 255)'
            // });
            // // Adjust canvas coordinate space taking into account pixel ratio,
            // // to make it look crisp on mobile devices.
            // // This also causes canvas to be cleared.
            // function resizeCanvas() {
            //     console.log(signaturePad);
            //     // When zoomed out to less than 100%, for some very strange reason,
            //     // some browsers report devicePixelRatio as less than 1
            //     // and only part of the canvas is cleared then.
            //     var ratio =  Math.max(window.devicePixelRatio || 1, 1);
            //     // This part causes the canvas to be cleared
            //     canvas.width = canvas.offsetWidth * ratio;
            //     canvas.height = canvas.offsetHeight * ratio;
            //     canvas.getContext("2d").scale(ratio, ratio);
            //     console.log(canvas.getContext("2d").scale(1, 1));
            //     // This library does not listen for canvas changes, so after the canvas is automatically
            //     // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
            //     // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
            //     // that the state of this library is consistent with visual state of the canvas, you
            //     // have to clear it manually.
            //     signaturePad.clear();
            // }
            // // On mobile devices it might make more sense to listen to orientation change,
            // // rather than window resize events.
            // window.onresize = resizeCanvas;
            // resizeCanvas();
            // function download(dataURL, filename) {
            //     var blob = dataURLToBlob(dataURL);
            //     var url = window.URL.createObjectURL(blob);
            //     var a = document.createElement("a");
            //     a.style = "display: none";
            //     a.href = url;
            //     a.download = filename;
            //     document.body.appendChild(a);
            //     a.click();
            //     window.URL.revokeObjectURL(url);
            // }
            // // One could simply use Canvas#toBlob method instead, but it's just to show
            // // that it can be done using result of SignaturePad#toDataURL.
            // function dataURLToBlob(dataURL) {
            //     var parts = dataURL.split(';base64,');
            //     var contentType = parts[0].split(":")[1];
            //     var raw = window.atob(parts[1]);
            //     var rawLength = raw.length;
            //     var uInt8Array = new Uint8Array(rawLength);
            //     for (var i = 0; i < rawLength; ++i) {
            //         uInt8Array[i] = raw.charCodeAt(i);
            //     }
            //     return new Blob([uInt8Array], { type: contentType });
            // }
            // clearButton.addEventListener("click", function (event) {
            //     signaturePad.clear();
            // });
            // // saveJPGButton.addEventListener("click", function (event) {
            // //     if (signaturePad.isEmpty()) {
            // //     alert("Please provide a signature first.");
            // //     } else {
            // //     var dataURL = signaturePad.toDataURL("image/jpeg");
            // //     console.log(dataURL);
            // //     // download(dataURL, "signature.jpg");
            // //     }
            // // });
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
                if (signaturePad2.isEmpty()) {
                    alert("Pihak Deus harus mengisi tanda tangan!");
                }
                else {
                    var tanda_tangan_deus = signaturePad2.toDataURL("image/jpeg");
                }
                // var tanda_tangan = signaturePad.toDataURL("image/jpeg");
                // $("#data_url").html('');
                $("#data_url_2").html('');
                // console.log(tanda_tangan);
                // alert(tanda_tangan);
                $.ajax({
                    url: "{{url('/get-url')}}",
                    type: 'POST',
                    data: {
                            // tanda_tangan:tanda_tangan,
                            tanda_tangan_deus:tanda_tangan_deus,
                            _token:'{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        // alert('BERHASIL');
                        // if(signaturePad.isEmpty()) {
                        // }
                        // else {
                        //     $('#data_url').html('<input type="hidden" class="form-control" style="width:30%;" name="tanda_tangan" required autofocus value="'+result.klien+'"/>');
                        // }
                        if (signaturePad2.isEmpty()) {
                        }
                        else {
                            $('#data_url_2').html('<input type="hidden" class="form-control" style="width:30%;" name="tanda_tangan_deus" required autofocus value="'+result.deus+'"/><button type="submit" name="action" value="submit" class="btn" style="background-color: #FECF5B; color: black;">Submit</button>');
                        }
                    }
                });
            });
        </script>
        
</body>
</html>