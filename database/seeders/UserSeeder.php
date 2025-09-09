<?php

namespace Database\Seeders;

use App\Models\User; // <-- Jangan lupa import model User
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- Jangan lupa import Hash untuk enkripsi

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hapus data user yang ada sebelumnya agar tidak duplikat jika seeder dijalankan lagi
        // User::truncate(); // Opsional: baris ini akan mengosongkan tabel users setiap kali seeder dijalankan

        // Buat data Admin
        User::create([
            'nama' => 'Admin Laundry',
            'nomor_hp' => '081234567890', // Nomor HP untuk login admin
            'password' => Hash::make('password'), // Passwordnya adalah 'password'
            'role' => 'admin',
        ]);

        // Buat data Pengguna/Pelanggan
        User::create([
            'nama' => 'Budi Pelanggan',
            'nomor_hp' => '089876543210', // Nomor HP untuk login pengguna
            'password' => Hash::make('password'), // Passwordnya adalah 'password'
            'role' => 'pengguna',
        ]);

        // Kamu bisa menambahkan lebih banyak data pengguna di sini jika perlu
    }
}