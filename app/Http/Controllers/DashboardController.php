<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Kita tidak butuh User atau Carbon lagi di sini untuk sementara
// use App\Models\User;
// use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin yang sederhana.
     */
    public function adminDashboard()
    {
        // Hanya menampilkan view, tidak perlu kirim data
        return view('admin.dashboard');
    }

    /**
     * Menampilkan dashboard pengguna yang sederhana.
     */
    public function penggunaDashboard()
    {
        // Hanya menampilkan view, tidak perlu kirim data
        return view('pengguna.dashboard');
    }
}