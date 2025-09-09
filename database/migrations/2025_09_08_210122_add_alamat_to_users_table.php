<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'alamat' dengan tipe TEXT
            // nullable() berarti kolom ini boleh kosong
            // after('nomor_hp') menempatkan kolom ini setelah kolom nomor_hp
            $table->text('alamat')->nullable()->after('nomor_hp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Logika untuk menghapus kolom jika migrasi di-rollback
            $table->dropColumn('alamat');
        });
    }
};