@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between"> 
                    <div class="iq-header-title">
                        <h4 class="card-title">Daftar Draft Notulen</h4>
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
                    {{-- <div class="form-group">
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
                    </div> --}}
                    <table class="table table-striped table-borderless" id="dtBasicExample">
                        <thead class="thead-dark">
                            <tr>
                                <th>Tanggal Meeting</th>
                                <th>Nama Klien</th>
                                <th>Judul Meeting</th>
                                <th>Creator</th>
                                {{-- <th>Last Edited At</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        @if(Str::length(Auth::guard('klien')->user())>0)
                        @foreach ($list_notulen as $notulen)
                            <tr>
                                <td>{{ date('d-m-Y',strtotime($notulen->tanggal ))}}</td>
                                <td>{{ $notulen->nama_perusahaan . " - " . $notulen->nama_klien }}</td>
                                <td>{{ $notulen->judul_meeting }}</td>
                                <td>{{ $notulen->name }}</td>
                                <td>
                                    <button class="btn btn-info" onclick="window.location.href='{{ url('/notulen/'.$notulen->id) }}'">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning" onclick="window.location.href='{{ url('/notulen/'.$notulen->id.'/edit') }}'">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    @if(Str::length(Auth::guard('user')->user())>0)
                                    <form action="{{ url('/notulen/'.$notulen->id) }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        {{-- <input type="hidden" name="id" value="{{ $notulen->id }}"/> --}}
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @elseif(Str::length(Auth::guard('user')->user())>0)
                        @foreach ($list_notulen as $notulen)
                        <tr>
                            <td>{{ date('d-m-Y',strtotime($notulen->tanggal )) }}</td>
                            <td>{{ $notulen->perusahaan->klien->nama_klien . " - " . $notulen->perusahaan->Perusahaan->nama_perusahaan }}</td>
                                <td>{{ $notulen->judul_meeting }}</td>
                                <td>{{ $notulen->user->name }}</td>
                            <td>
                                <button class="btn btn-info" onclick="window.location.href='{{ url('/notulen/'.$notulen->id) }}'">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-warning" onclick="window.location.href='{{ url('/notulen/'.$notulen->id.'/edit') }}'">
                                    <i class="fa fa-edit"></i>
                                </button>
                                @if(Str::length(Auth::guard('user')->user())>0)
                                <form action="{{ url('/notulen/'.$notulen->id) }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {{-- <input type="hidden" name="id" value="{{ $notulen->id }}"/> --}}
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                        @endif
                    </table>
                   
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script>
    $(document).ready(function () {
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });
</script>
</html>