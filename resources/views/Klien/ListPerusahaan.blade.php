@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Daftar Perusahaan Klien</h4>
                    </div>
                </div>
                <hr style="height: 10px;">
                <div class="iq-card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="dtBasicExample" class="table table-striped table-borderless">
                                <thead class="thead-dark text-center">
                                    <tr>
                                        <th style="width:10%;"">No.</th>
                                        <th>Nama Perusahaan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php $i = 0 ?>
                                @foreach ($list_perusahaan as $perusahaan)
                                @isset($perusahaan->deleted)
                                @else
                                <tr>
                                    <?php $i++ ?>
                                        <td>{{ $i }}</td>
                                        <td>{{ $perusahaan->nama_perusahaan }}</td>
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
                                                <a href="{{ url('/daftar-klien-perusahaan/'.$perusahaan->id) }}" class="btn btn-primary">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
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