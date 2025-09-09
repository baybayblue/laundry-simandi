<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    // Menonaktifkan timestamps (created_at, updated_at) untuk model ini
    public $timestamps = false;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'id_pesanan',
        'id_layanan',
        'jumlah',
        'subtotal',
    ];

    /**
     * Mendefinisikan hubungan "satu detail dimiliki oleh satu layanan".
     */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }

    /**
     * Mendefinisikan hubungan "satu detail dimiliki oleh satu pesanan".
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}
