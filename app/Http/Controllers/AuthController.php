<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman formulir registrasi.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses data dari formulir registrasi.
     */
    public function register(Request $request)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'required|string|unique:users,nomor_hp',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // 2. Jika validasi berhasil, buat user baru
        $user = User::create([
            'nama' => $request->nama,
            'nomor_hp' => $request->nomor_hp,
            'password' => Hash::make($request->password),
            // Kolom 'role' akan otomatis terisi 'pengguna'
        ]);

        // 3. Setelah user berhasil dibuat, langsung loginkan user tersebut
        Auth::login($user);

        // 4. Arahkan (redirect) ke halaman dashboard
        return redirect()->route('dashboard');
    }

    /**
     * Menampilkan halaman formulir login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses data dari formulir login.
     */
    public function login(Request $request)
    {
        // 1. Validasi data yang masuk
        $credentials = $request->validate([
            'nomor_hp' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Coba lakukan proses otentikasi (login)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // CUKUP ARAHKAN KE ROUTE 'dashboard'
            // Biarkan route di web.php yang menentukan tujuan akhir berdasarkan role.
            return redirect()->intended(route('dashboard'));
        }

        // 3. Jika otentikasi gagal
        return back()->withErrors([
            'nomor_hp' => 'Nomor HP atau Password yang Anda masukkan salah.',
        ])->onlyInput('nomor_hp');
    }

    /**
     * Memproses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
