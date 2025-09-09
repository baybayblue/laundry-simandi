<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna yang sedang login.
     */
    public function show()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Memproses pembaruan data profil.
     */
    public function update(Request $request)
    {
        // Ambil ID user yang sedang login
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_hp' => [
                'required',
                'string',
                // Pastikan nomor_hp unik, TAPI abaikan untuk user ini sendiri
                Rule::unique('users')->ignore($userId),
            ],
            'alamat' => 'required|string',
            // Password bersifat opsional, hanya divalidasi jika diisi
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Siapkan data untuk diupdate
        $user->nama = $request->nama;
        $user->nomor_hp = $request->nomor_hp;
        $user->alamat = $request->alamat;

        // Cek jika pengguna mengisi password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan ke database
        $user->save();

        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile.show')
                         ->with('success', 'Profil Anda berhasil diperbarui.');
    }
}