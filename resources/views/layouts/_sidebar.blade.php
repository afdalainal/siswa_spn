<div id="sidebar" class='active'>
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <img src="{{asset('assets/logo.png')}}" alt="" srcset="">
        </div>
        <div class="sidebar-menu">
            <ul class="menu" style="position: relative; top: -50px;">
                <li class='sidebar-title'>Main Menu</li>

                @if(Auth::user()->role === 'superadmin')
                <li class="sidebar-item {{ request()->routeIs('dashboard.superadmin') ? 'active' : '' }}">
                    <a href="{{route('dashboard.superadmin')}}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li
                    class="sidebar-item  has-sub {{ request()->routeIs('siswa.index') || request()->routeIs('pengasuh.index')  || request()->routeIs('akunpeleton.index')  || request()->routeIs('tugaspeleton.index') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="user" width="20"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="{{route('pengasuh.index')}}">
                                <span>Data pengasuh</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('siswa.index')}}">
                                <span>Data siswa</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('akunpeleton.index')}}">
                                <span>Akun User Peleton</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('tugaspeleton.index')}}">
                                <span>Tugas Peleton</span>
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
                <li
                    class="sidebar-item {{ request()->routeIs('penilaianpengamatan.index') || request()->routeIs('penilaianpengamatan.show') || request()->routeIs('penilaianpengamatan.edit')  || request()->routeIs('penilaianpengamatan.grafik')   || request()->routeIs('penilaianpengamatan.harian') ? 'active' : '' }}">
                    <a href="{{route('penilaianpengamatan.index')}}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Penilaian Pengamatan</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->routeIs('penilaianharian.index') || request()->routeIs('penilaianharian.show') || request()->routeIs('penilaianharian.edit') || request()->routeIs('penilaianharian.grafik') ? 'active' : '' }}">
                    <a href="{{route('penilaianharian.index')}}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Penilaian Harian</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->routeIs('penilaianmingguan.index') || request()->routeIs('penilaianmingguan.show') || request()->routeIs('penilaianmingguan.edit') || request()->routeIs('penilaianmingguan.grafik') ? 'active' : '' }}">
                    <a href="{{route('penilaianmingguan.index')}}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Penilaian Mingguan</span>
                    </a>
                </li>
                @endif

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>