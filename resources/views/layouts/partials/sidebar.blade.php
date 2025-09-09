<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Laundry Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Aplikasi Laundry</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{-- Placeholder untuk foto profil, bisa dikembangkan nanti --}}
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                {{-- Mengambil nama dari user yang sedang login --}}
                <a href="#" class="d-block">{{ Auth::user()->nama ?? 'Pengguna' }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
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
                        <a href="#" class="nav-link {{ Request::is('admin/laporan*') ? 'active' : '' }}">
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
                        <a href="#" class="nav-link {{ Request::is('pesan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>Pesan Laundry Baru</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ Request::is('riwayat*') ? 'active' : '' }}">
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
                    <a href="#" class="nav-link {{ Request::is('profile*') ? 'active' : '' }}">
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
        </div>
    </aside>