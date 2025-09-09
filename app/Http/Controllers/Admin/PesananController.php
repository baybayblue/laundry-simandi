<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan.
     */
    public function index()
    {
        // Eager load data 'user' untuk menghindari N+1 query problem
        $pesanans = Pesanan::with('user')->latest()->paginate(10);
        return view('admin.pesanan.index', compact('pesanans'));
    }

    /**
     * Menampilkan formulir untuk membuat pesanan baru.
     */
    public function create()
    {
        $pelanggans = User::where('role', 'pengguna')->orderBy('nama', 'asc')->get();
        $layanans = Layanan::orderBy('nama_layanan', 'asc')->get();
        // Generate kode invoice unik: LNDRY-TAHUNBULANTANGGAL-ANGKAACAK
        $kode_invoice = 'LNDRY-' . date('Ymd') . '-' . mt_rand(1000, 9999);

        return view('admin.pesanan.create', compact('pelanggans', 'layanans', 'kode_invoice'));
    }

    /**
     * Menyimpan pesanan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_invoice' => 'required|string|unique:pesanans,kode_invoice',
            'id_user' => 'required|exists:users,id',
            'berat' => 'nullable|numeric|min:0',
            'layanans' => 'required|array|min:1',
            'layanans.*.id' => 'required|exists:layanans,id',
            'layanans.*.jumlah' => 'required|numeric|min:1',
        ]);

        // Gunakan Database Transaction untuk memastikan semua data tersimpan atau tidak sama sekali
        DB::beginTransaction();
        try {
            $pesanan = Pesanan::create([
                'id_user' => $request->id_user,
                'kode_invoice' => $request->kode_invoice,
                'berat' => $request->berat,
                'status' => 'Baru',
                'total_harga' => 0, // Harga awal 0, akan di-update
            ]);

            $total_harga = 0;

            foreach ($request->layanans as $item) {
                $layanan = Layanan::find($item['id']);
                $subtotal = $layanan->harga * $item['jumlah'];

                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id,
                    'id_layanan' => $layanan->id,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal,
                ]);

                $total_harga += $subtotal;
            }

            // Update total_harga di tabel pesanan utama
            $pesanan->update(['total_harga' => $total_harga]);

            DB::commit(); // Simpan semua perubahan jika berhasil

            return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan baru berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika ada error
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail spesifik dari sebuah pesanan.
     */
    public function show(Pesanan $pesanan)
    {
        // Eager load semua relasi yang dibutuhkan
        $pesanan->load('user', 'detailPesanans.layanan');
        return view('admin.pesanan.show', compact('pesanan'));
    }

    /**
     * Menampilkan formulir untuk mengedit pesanan (biasanya untuk ubah status).
     */
    public function edit(Pesanan $pesanan)
    {
        $statuses = ['Baru', 'Proses', 'Selesai', 'Diambil'];
        return view('admin.pesanan.edit', compact('pesanan', 'statuses'));
    }

    /**
     * Memproses update data pesanan.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:Baru,Proses,Selesai,Diambil',
        ]);

        $dataToUpdate = [
            'status' => $request->status,
        ];

        // Jika status diubah menjadi 'Selesai' dan tanggal selesai masih kosong, catat waktunya
        if ($request->status == 'Selesai' && is_null($pesanan->tanggal_selesai)) {
            $dataToUpdate['tanggal_selesai'] = now();
        }

        $pesanan->update($dataToUpdate);

        return redirect()->route('admin.pesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Menghapus pesanan dari database.
     */
    public function destroy(Pesanan $pesanan)
    {
        // Karena kita sudah mengatur 'onDelete(cascade)' di migrasi,
        // detail pesanan akan otomatis terhapus saat pesanan utamanya dihapus.
        $pesanan->delete();
        
        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}

