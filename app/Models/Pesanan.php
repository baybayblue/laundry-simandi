<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'id_user',
        'kode_invoice',
        'status',
        'total_harga',
        'berat',
        'tanggal_masuk',
        'tanggal_selesai',
    ];

    /**
     * Mendefinisikan hubungan "satu pesanan dimiliki oleh satu user".
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Mendefinisikan hubungan "satu pesanan memiliki banyak detail".
     */
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }
}
