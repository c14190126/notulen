@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Assign Perusahaan</h4>
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
                    <form action="{{ url('/assign-perusahaan') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label style="color: black; font-weight: bold;" for="perusahaan_id">Nama Perusahaan</label><br>
                                    <select class="test form-control @error('perusahaan_id') is-invalid @enderror" data-live-search="true" id="perusahaan_id" name="perusahaan_id" required>
                                        <option selected="" disabled="">
                                            -- Pilih Perusahaan --
                                        </option>
                                        @foreach ($list_perusahaan as $perusahaan)
                                            @if(old('perusahaan_id') == $perusahaan->id)
                                                <option value="{{ $perusahaan->id }}" selected>{{ $perusahaan->nama_perusahaan }}</option>
                                            @else
                                                <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama_perusahaan }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label style="color: black; font-weight: bold;" for="klien_id">Nama Klien</label><br>
                                    <select class="test form-control @error('klien_id') is-invalid @enderror" data-live-search="true" id="klien_id" name="klien_id" required>
                                        <option selected="" disabled="">
                                            -- Pilih Klien --
                                        </option>
                                        @foreach ($list_klien as $klien)
                                            @if(old('klien_id') == $klien->id)
                                                <option value="{{ $klien->id }}" selected>{{ $klien->nama_klien }}</option>
                                            @else
                                                <option value="{{ $klien->id }}">{{ $klien->nama_klien }}</option>
                                            @endif
                                            {{-- <option value="{{ $klien->id }}">{{ $klien->nama_klien }}</option> --}}
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn" style="background-color: #FECF5B; color: black;">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
     $(document).ready(function() {
                $('.test').select2();
            });
</script>
</html>