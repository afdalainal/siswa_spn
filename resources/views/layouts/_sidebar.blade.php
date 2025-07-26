<div id="sidebar" class='active'>
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/Insignia_of_the_Indonesian_National_Police.svg/640px-Insignia_of_the_Indonesian_National_Police.svg.png"
                alt="" srcset="">
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class='sidebar-title'>Main Menu</li>

                @if(Auth::user()->role === 'superadmin')
                <li class="sidebar-item {{ request()->routeIs('dashboard.superadmin') ? 'active' : '' }}">
                    <a href="{{route('dashboard.superadmin')}}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li
                    class="sidebar-item  has-sub {{ request()->routeIs('anggota.index') || request()->routeIs('regis.index') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="user" width="20"></i>
                        <span>Setting Penilaian</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="{{route('anggota.index')}}">
                                <span>List Anggota</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(Auth::user()->role === 'peleton')
                <li class="sidebar-item {{ request()->routeIs('dashboard.peleton') ? 'active' : '' }}">
                    <a href="{{route('dashboard.peleton')}}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endif

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>