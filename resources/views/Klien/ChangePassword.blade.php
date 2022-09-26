@include('partials.main')
<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('partials.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Change Password</h4>
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
                    @elseif (session()->has('fail'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('fail') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form action="{{ url('/change-password/'.Auth::guard('klien')->id()) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="hidden" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required autofocus value="{{ Auth::guard('klien')->user()->email}}"/>
                                    @error('email')
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
                                    <label style="color: black; font-weight: bold;" for="add-klien">Password Lama</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autofocus/>
                                    @error('password')
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
                                    <label style="color: black; font-weight: bold;" for="add-klien">Password Baru</label>
                                    <input type="password" class="form-control @error('password_baru') is-invalid @enderror" id="password_baru" name="password_baru" required autofocus/>
                                    @error('password_baru')
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
                                    <input style="margin-left: 5px;" type="checkbox" onclick="myFunction()"> Show Password
                                </div>
                            </div>
                        </div>                        
                        <button onclick="window.location.href='{{ url('/') }}'" type="button" class="btn btn-danger">
                            Cancel
                        </button>
                        <button type="submit" class="btn" style="background-color: #FECF5B; color: black;">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
</body>
<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        var y = document.getElementById("password_baru");
        if (y.type === "password") {
            y.type = "text";
        } else {
            y.type = "password";
        }
    }
</script>
</html>