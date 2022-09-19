@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Daftar Notulen</h4>
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
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <form action="{{ url('/') }}">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search.." name="search">
                                        <button class="btn" style="background-color: #FECF5B; color: black;" type="submit">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-borderless">
                        <thead class="thead-dark">
                            <tr>
                                <th>Tanggal Meeting</th>
                                <th>Creator</th>
                                <th>Nama Klien</th>
                                <th>Judul Meeting</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($list_notulen as $notulen)
                            <tr>
                                <td>{{ $notulen->tanggal }}</td>
                                <td>{{ $notulen->user->name }}</td>
                                <td>{{ $notulen->klien->nama_klien }}</td>
                                <td>{{ $notulen->judul_meeting }}</td>
                                <td>
                                    <button class="btn btn-info" onclick="window.location.href='{{ url('/notulen/'.$notulen->id) }}'">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning" onclick="window.location.href='{{ url('/notulen/'.$notulen->id.'/edit') }}'">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <form action="{{ url('/notulen/'.$notulen->id) }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        {{-- <input type="hidden" name="id" value="{{ $notulen->id }}"/> --}}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $list_notulen->links() }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>