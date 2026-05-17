<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id',
        'item_id',
        'layanan_id',
        'pencucian_id',
        'harga_unit',
        'total_berat',
        'subtotal',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function itemLaundry()
    {
        return $this->belongsTo(ItemLaundry::class, 'item_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function pencucian()
    {
        return $this->belongsTo(Pencucian::class, 'pencucian_id');
    }
}
