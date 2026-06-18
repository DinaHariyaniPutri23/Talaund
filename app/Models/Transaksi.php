<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'pelanggan_id',
        'user_id',
        'promo_id',
        'pengiriman_id',
        'tanggal_transaksi',
        'total_transaksi',
        'status_transaksi',
        'alasan_void',
        'void_at',
        'snap_token',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'void_at' => 'datetime',
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'transaksi_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'promo_id');
    }

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'pengiriman_id');
    }
}
