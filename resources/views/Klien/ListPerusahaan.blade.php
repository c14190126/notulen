@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Daftar Klien</h4>
                    </div>
                </div>
                <hr style="height: 10px;">
                <div class="iq-card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table table-striped table-borderless">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:10%;"">No.</th>
                                        <th>Nama Perusahaan</th>
                                        <th>Nama Klien</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($list_perusahaan as $perusahaan)
                                @isset($perusahaan->deleted)
                                @else
                                <tr>
                                        <td>{{ $perusahaan->id }}</td>
                                        <td>{{ $perusahaan->nama_perusahaan }}</td>
                                        <td>{{ $perusahaan->klien->nama_klien }}</td>
                                        <td>
                                            @can('superadmin')
                                            <form action="{{ url('/perusahaan/'.$perusahaan->id) }}" method="POST" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            <form action="{{ url('/perusahaan-edit/'.$perusahaan->id) }}" method="POST" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button class="btn btn-success">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endisset

                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>