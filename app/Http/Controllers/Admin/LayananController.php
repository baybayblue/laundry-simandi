<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LayananController extends Controller
{
    /**
     * Menampilkan daftar semua layanan.
     */
    public function index()
    {
        $layanans = Layanan::latest()->paginate(10);
        return view('admin.layanan.index', compact('layanans'));
    }

    /**
     * Menampilkan formulir untuk membuat layanan baru.
     */
    public function create()
    {
        return view('admin.layanan.create');
    }

    /**
     * Menyimpan layanan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_layanan' => 'required|string|max:255|unique:layanans,nama_layanan',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'durasi' => 'required|string|max:50',
        ]);

        // Buat data baru
        Layanan::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit layanan.
     */
    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    /**
     * Memperbarui data layanan di database.
     */
    public function update(Request $request, Layanan $layanan)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_layanan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('layanans')->ignore($layanan->id),
            ],
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'durasi' => 'required|string|max:50',
        ]);

        // Update data
        $layanan->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Data layanan berhasil diperbarui.');
    }

    /**
     * Menghapus data layanan dari database.
     */
    public function destroy(Layanan $layanan)
    {
        // Hapus data
        $layanan->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Data layanan berhasil dihapus.');
    }
}
