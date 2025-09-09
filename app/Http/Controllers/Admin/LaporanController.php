<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan dengan filter tanggal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Tentukan tanggal awal dan akhir default (bulan ini)
        $tanggalAwal = $request->input('tanggal_awal', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->endOfMonth()->toDateString());

        // Ambil data pesanan dari database berdasarkan rentang tanggal yang dipilih
        // Kita juga memuat relasi 'user' untuk menampilkan nama pelanggan (eager loading)
        $pesanans = Pesanan::with('user')
                           ->whereBetween('tanggal_masuk', [$tanggalAwal, $tanggalAkhir])
                           ->latest()
                           ->get();

        // Hitung total pendapatan dari data yang sudah difilter
        $totalPendapatan = $pesanans->sum('total_harga');

        // Kirim semua data yang diperlukan ke view
        return view('admin.laporan.index', compact('pesanans', 'totalPendapatan', 'tanggalAwal', 'tanggalAkhir'));
    }

    /**
     * Menyiapkan halaman untuk dicetak.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cetak(Request $request)
    {
        // Logikanya sama dengan method index, hanya saja view-nya berbeda
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Jika tidak ada tanggal, fallback ke bulan ini
        if (!$tanggalAwal || !$tanggalAkhir) {
            $tanggalAwal = Carbon::now()->startOfMonth()->toDateString();
            $tanggalAkhir = Carbon::now()->endOfMonth()->toDateString();
        }
        
        $pesanans = Pesanan::with('user')
                           ->whereBetween('tanggal_masuk', [$tanggalAwal, $tanggalAkhir])
                           ->latest()
                           ->get();
                           
        $totalPendapatan = $pesanans->sum('total_harga');

        // Return view khusus untuk halaman cetak
        return view('admin.laporan.cetak', compact('pesanans', 'totalPendapatan', 'tanggalAwal', 'tanggalAkhir'));
    }
}
