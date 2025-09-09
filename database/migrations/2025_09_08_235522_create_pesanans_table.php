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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            // Menghubungkan pesanan dengan pelanggan (user).
            // onDelete('cascade') berarti jika user dihapus, pesanannya juga ikut terhapus.
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');

            // Kode unik untuk setiap transaksi/invoice
            $table->string('kode_invoice')->unique();

            // Status pesanan saat ini
            $table->enum('status', ['Baru', 'Proses', 'Selesai', 'Diambil'])->default('Baru');

            // Total harga dari semua layanan dalam pesanan ini
            $table->integer('total_harga')->default(0);

            // Berat total cucian (jika ada layanan kiloan), boleh kosong
            $table->float('berat')->nullable();

            // Waktu pesanan dibuat dan selesai
            $table->timestamp('tanggal_masuk')->useCurrent();
            $table->timestamp('tanggal_selesai')->nullable();

            // Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
};
