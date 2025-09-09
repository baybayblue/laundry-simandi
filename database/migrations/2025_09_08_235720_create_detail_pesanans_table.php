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
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke pesanan utamanya
            $table->foreignId('id_pesanan')->constrained('pesanans')->onDelete('cascade');

            // Menghubungkan ke layanan yang dipilih
            $table->foreignId('id_layanan')->constrained('layanans')->onDelete('cascade');

            // Jumlah/kuantitas dari layanan tersebut (misal: 5 kg, 2 pcs)
            $table->float('jumlah');

            // Subtotal harga (harga layanan * jumlah)
            $table->integer('subtotal');

            // Tidak perlu timestamps untuk tabel detail ini
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
