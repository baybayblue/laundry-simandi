<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Menampilkan halaman riwayat pesanan.
     */
    public function index()
    {
        $userId = Auth::id();
        $pesanans = Pesanan::where('id_user', $userId)->latest()->paginate(10);
        return view('pengguna.pesanan.index', compact('pesanans'));
    }

    /**
     * Menampilkan halaman formulir untuk membuat pesanan baru.
     */
    public function create()
    {
        // Ambil semua data layanan untuk ditampilkan di dropdown
        $layanans = Layanan::orderBy('nama_layanan')->get();

        // Buat kode invoice unik otomatis
        $prefix = 'LNDRY-U-' . date('Ymd');
        $lastOrder = Pesanan::where('kode_invoice', 'like', $prefix . '%')->latest('id')->first();
        $counter = $lastOrder ? intval(substr($lastOrder->kode_invoice, -3)) + 1 : 1;
        $kode_invoice = $prefix . '-' . str_pad($counter, 3, '0', STR_PAD_LEFT);

        return view('pengguna.pesanan.create', compact('layanans', 'kode_invoice'));
    }

    /**
     * Menyimpan pesanan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'kode_invoice' => 'required|string|unique:pesanans,kode_invoice',
            'berat' => 'nullable|numeric|min:0',
            'layanans' => 'required|array|min:1',
            'layanans.*.id' => 'required|integer|exists:layanans,id',
            'layanans.*.jumlah' => 'required|numeric|min:0.1',
        ], [
            'layanans.required' => 'Anda harus memilih minimal satu layanan.',
        ]);

        // Gunakan transaction untuk memastikan semua data berhasil disimpan
        DB::beginTransaction();
        try {
            $totalHarga = 0;
            // Hitung total harga dari semua layanan yang dipilih
            foreach ($request->layanans as $item) {
                $layanan = Layanan::find($item['id']);
                $subtotal = $layanan->harga * $item['jumlah'];
                $totalHarga += $subtotal;
            }

            // Buat pesanan utama
            $pesanan = Pesanan::create([
                'id_user' => Auth::id(), // Ambil ID pengguna yang sedang login
                'kode_invoice' => $request->kode_invoice,
                'status' => 'Baru', // Status awal selalu 'Baru'
                'total_harga' => $totalHarga,
                'berat' => $request->berat,
                'tanggal_masuk' => now(),
            ]);

            // Simpan rincian layanan untuk pesanan ini
            foreach ($request->layanans as $item) {
                $layanan = Layanan::find($item['id']);
                $subtotal = $layanan->harga * $item['jumlah'];

                $pesanan->detailPesanans()->create([
                    'id_layanan' => $item['id'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit(); // Konfirmasi semua perubahan jika berhasil

            // Redirect ke halaman detail pesanan yang baru dibuat dengan pesan sukses
            return redirect()->route('pengguna.pesanan.show', $pesanan->id)
                             ->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika terjadi error
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show($id)
    {
        $userId = Auth::id();
        $pesanan = Pesanan::where('id', $id)->where('id_user', $userId)->firstOrFail();
        return view('pengguna.pesanan.show', compact('pesanan'));
    }
}

