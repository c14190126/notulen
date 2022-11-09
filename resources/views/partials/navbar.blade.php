<nav id="sidebar">
    <div class="custom-menu">
    <button type="button" id="sidebarCollapse" class="btn" style="background-color: #FECF5B">
        <i class="fa fa-bars"></i>
        <span class="sr-only">Toggle Menu</span>
    </button>
    </div>
    <div class="p-4 pt-5">
        <img src="{{ asset('/images/Logo-Deus.jpg') }}" width="200" height="100" style="object-fit: scale-down;">
        <br>
        <ul class="list-unstyled components mb-5">
            @if(Str::length(Auth::guard('user')->user())>0)
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#notulen" aria-expanded="false" aria-controls="notulen">
                <span class="menu-title">Notulen</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="notulen">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item {{ ($title === "Create Notulen") ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/add-notulen') }}">Create Notulen</a>
                        </li>
                        @endif
                        <li class="nav-item {{ ($title === "Daftar Notulen") ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/') }}">List Notulen</a>
                        </li>
                        <li class="nav-item {{ ($title === "Daftar Notulen Acc") ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/list-notulen-acc') }}">List Notulen Acc</a>
                        </li>
                    
                    </ul>
                </div>
            </li>
            @if(Str::length(Auth::guard('user')->user())>0)
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#klien" aria-expanded="false" aria-controls="klien">
                <span class="menu-title">Klien</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="klien">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item {{ ($title === "Add Klien") ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/add-klien') }}">Add Klien</a>
                    </li>
                    <li class="nav-item {{ ($title === "Daftar Klien") ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/daftar-klien') }}">Daftar Klien</a>
                    </li>
                    <li class="nav-item {{ ($title === "Add Perusahaan") ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/add-perusahaan') }}">Add Perusahaan</a>
                    </li>
                    <li class="nav-item {{ ($title === "Daftar Perusahaan") ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/daftar-perusahaan') }}">Daftar Perusahaan</a>
                    </li>
                    
                </ul>
                </div>
            </li>
            @can('superadmin')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#user" aria-expanded="false" aria-controls="user">
                <span class="menu-title">User</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="user">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item {{ ($title === "Add User") ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/add-user') }}">Add User</a>
                    </li>
                    <li class="nav-item {{ ($title === "Daftar User") ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/daftar-user') }}">Daftar User</a>
                    </li>
                </ul>
                </div>
            </li>
            @endcan
            @endif
            @if(Str::length(Auth::guard('klien')->user())>0)
            <li class="nav-item {{ ($title === "Change Password") ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/change-password') }}">Change Password</a>
            </li>
            @elseif(Str::length(Auth::guard('user')->user())>0)
            <li class="nav-item {{ ($title === "Change Password") ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/user-change-password') }}">Change Password</a>
            </li>
            @endif
            <br>
            <form action="{{ url('/logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-lock"> Logout</i>
                </button>
            </form>
        </ul>
    </div>
</nav>

{{-- <script src="js/jquery.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.1.1.min.js">
<script src="{{ asset('/js/popper.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>