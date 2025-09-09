<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Import Auth

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Cek apakah role user yang sedang login ada di dalam daftar $roles yang diizinkan
        foreach ($roles as $role) {
            if (Auth::user()->role == $role) {
                // Jika cocok, izinkan akses ke halaman
                return $next($request);
            }
        }

        // Jika tidak ada role yang cocok, tolak akses
        abort(403, 'AKSES DITOLAK');
    }
}