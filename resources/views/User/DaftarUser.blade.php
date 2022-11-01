@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Daftar User</h4>
                    </div>
                </div>
                <hr style="height: 10px;">
                <div class="iq-card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table table-striped table-borderless">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:10%;">No.</th>
                                        <th>Nama User</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                @foreach ($daftar_user as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->is_super_admin == 0)
                                            <form action="{{ url('/user/'.$user->id) }}" method="POST" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            <form action="{{ url('/user-edit/'.$user->id) }}" method="POST" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button class="btn btn-success">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                       
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>