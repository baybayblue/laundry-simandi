<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Laundry Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Aplikasi Laundry</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->nama ?? 'Pengguna' }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') || Request::is('admin/dashboard') || Request::is('pengguna/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- ====================================================== --}}
                {{-- MENU KHUSUS UNTUK ROLE ADMIN --}}
                {{-- ====================================================== --}}
                @if (Auth::user()->role == 'admin')
                    <li class="nav-header">NAVIGASI ADMIN</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pesanan.index') }}" class="nav-link {{ Request::is('admin/pesanan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Manajemen Pesanan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.layanan.index') }}" class="nav-link {{ Request::is('admin/layanan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tshirt"></i>
                            <p>Manajemen Layanan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pelanggan.index') }}" class="nav-link {{ Request::is('admin/pelanggan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manajemen Pelanggan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ Request::is('admin/laporan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Laporan</p>
                        </a>
                    </li>
                @endif


                {{-- ====================================================== --}}
                {{-- MENU KHUSUS UNTUK ROLE PENGGUNA (PELANGGAN) --}}
                {{-- ====================================================== --}}
                @if (Auth::user()->role == 'pengguna')
                    <li class="nav-header">MENU PELANGGAN</li>
                    <li class="nav-item">
                        <a href="{{ route('pengguna.pesanan.create') }}" class="nav-link {{ Request::is('pengguna/pesan-baru*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>Pesan Laundry Baru</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pengguna.pesanan.index') }}" class="nav-link {{ Request::is('pengguna/pesanan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Riwayat Pesanan</p>
                        </a>
                    </li>
                @endif


                {{-- ====================================================== --}}
                {{-- MENU AKUN (UNTUK SEMUA ROLE) --}}
                {{-- ====================================================== --}}
                <li class="nav-header">AKUN</li>
                <li class="nav-item">
                    <a href="{{ route('profile.show') }}" class="nav-link {{ Request::is('profile*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); confirmLogout(event);">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

