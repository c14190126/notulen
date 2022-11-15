@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Edit Perusahaan</h4>
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
                    <form action="{{ url('/edit-perusahaan/'.$perusahaan->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label style="color: black; font-weight: bold;" for="add-perusahaan">Nama Perusahaan</label>
                                    <input type="text" class="form-control"  id="nama_perusahaan" name="nama_perusahaan" value="{{ $perusahaan->nama_perusahaan }}" required autofocus/>
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
</html>