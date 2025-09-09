<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    /**
     * Menampilkan daftar semua pelanggan.
     */
    public function index()
    {
        $pelanggans = User::where('role', 'pengguna')->latest()->paginate(10);
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    /**
     * Menampilkan formulir untuk menambah pelanggan baru.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Menyimpan pelanggan baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'required|string|unique:users,nomor_hp',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // 2. Buat user baru di database
        User::create([
            'nama' => $request->nama,
            'nomor_hp' => $request->nomor_hp,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'role' => 'pengguna' // Otomatis set role sebagai 'pengguna'
        ]);

        // 3. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit data pelanggan.
     */
    public function edit(User $pelanggan)
    {
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Memproses update data pelanggan dari form edit.
     */
    public function update(Request $request, User $pelanggan)
    {
        // 1. Validasi data input
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_hp' => [
                'required',
                'string',
                Rule::unique('users')->ignore($pelanggan->id),
            ],
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // 2. Siapkan data untuk diupdate
        $dataToUpdate = [
            'nama' => $request->nama,
            'nomor_hp' => $request->nomor_hp,
            'alamat' => $request->alamat,
        ];

        // 3. Cek jika admin mengisi password baru
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        // 4. Update data di database
        $pelanggan->update($dataToUpdate);

        // 5. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus data pelanggan dari database.
     */
    public function destroy(User $pelanggan)
    {
        // Pastikan tidak menghapus user dengan role selain 'pengguna' untuk keamanan
        if ($pelanggan->role !== 'pengguna') {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }

        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil dihapus.');
    }

    /**
     * Method show tidak digunakan saat ini.
     */
    public function show(User $pelanggan)
    {
        // Arahkan ke halaman edit saja
        return redirect()->route('admin.pelanggan.edit', $pelanggan->id);
    }
}

