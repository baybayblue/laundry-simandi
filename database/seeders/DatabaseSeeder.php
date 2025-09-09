<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Panggil UserSeeder yang sudah kita buat
        $this->call([
            UserSeeder::class,
            // Kamu bisa menambahkan seeder lain di sini nanti, contoh: LayananSeeder::class
        ]);
    }
}