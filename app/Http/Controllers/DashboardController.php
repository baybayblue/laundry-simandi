<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan data statistik asli.
     */
    public function adminDashboard()
    {
        // Ambil tanggal hari ini
        $today = Carbon::today();

        // 1. Data untuk Info Box
        $pendapatanHariIni = Pesanan::whereDate('tanggal_masuk', $today)->sum('total_harga');
        $pesananHariIni = Pesanan::whereDate('tanggal_masuk', $today)->count();
        $pesananDiproses = Pesanan::where('status', 'Proses')->count();
        $totalPelanggan = User::where('role', 'pengguna')->count();

        // 2. Data untuk Daftar Pesanan Terbaru
        //    Ambil 5 pesanan terbaru, dan muat relasi 'user' untuk menampilkan nama
        $pesananTerbaru = Pesanan::with('user')->latest()->take(5)->get();


        // Kirim semua data yang diperlukan ke view
        return view('admin.dashboard', compact(
            'pendapatanHariIni',
            'pesananHariIni',
            'pesananDiproses',
            'totalPelanggan',
            'pesananTerbaru'
        ));
    }

    /**
     * Menampilkan dashboard pengguna.
     */
    public function penggunaDashboard()
    {
        return view('pengguna.dashboard');
    }
}
