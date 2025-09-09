<?php

use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pengguna\PesananController as PenggunaPesananController;
use App\Http\Controllers\ProfileController; // <-- TAMBAHKAN INI
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ... (kode route lain tidak berubah) ...

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('pengguna.dashboard');
    })->name('dashboard');

    // GRUP RUTE KHUSUS ADMIN
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('/pelanggan', PelangganController::class);
        Route::resource('/layanan', LayananController::class);
        Route::resource('/pesanan', AdminPesananController::class);
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    });

    // GRUP RUTE KHUSUS PENGGUNA (PELANGGAN)
    Route::prefix('pengguna')->name('pengguna.')->middleware('role:pengguna')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'penggunaDashboard'])->name('dashboard');
        Route::get('/pesanan', [PenggunaPesananController::class, 'index'])->name('pesanan.index');
        Route::get('/pesanan/{id}', [PenggunaPesananController::class, 'show'])->name('pesanan.show');
        Route::get('/pesan-baru', [PenggunaPesananController::class, 'create'])->name('pesanan.create');
        Route::post('/pesan-baru', [PenggunaPesananController::class, 'store'])->name('pesanan.store');
    });

    // RUTE BERSAMA UNTUK PROFIL
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

