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
            @auth
            @if(Str::length(Auth::guard('user')->user())>0)
            <li class="nav-item {{ ($title === "Create Notulen") ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/add-notulen') }}">Create Notulen</a>
            </li>
            @endif
            <li class="nav-item {{ ($title === "Daftar Notulen") ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/') }}">List Notulen</a>
            </li>
            @if(Str::length(Auth::guard('user')->user())>0)
            <li class="nav-item {{ ($title === "Add Klien") ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/add-klien') }}">Add Klien</a>
            </li>
            <li class="nav-item {{ ($title === "Daftar Klien") ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/daftar-klien') }}">Daftar Klien</a>
            </li>
            @can('superadmin')
            <li class="nav-item {{ ($title === "Add User") ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/add-user') }}">Add User</a>
            </li>
            <li class="nav-item {{ ($title === "Daftar User") ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/daftar-user') }}">Daftar User</a>
            </li>
            @endcan
            @endif
            <br>
            <form action="{{ url('/logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-lock"> Logout</i>
                </button>
            </form>
            @endauth
        </ul>
    </div>
</nav>

{{-- <script src="js/jquery.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.1.1.min.js">
<script src="{{ asset('/js/popper.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>