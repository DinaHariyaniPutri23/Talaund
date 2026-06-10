<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLaundry extends Model
{
    protected $table = 'item_laundry';

    protected $fillable = [
        'nama_item',
        'harga',
        'satuan',
        'id_layanan',
        'id_pencucian',
    ];

    // Relasi dengan Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }

    // Relasi dengan Pencucian
    public function pencucian()
    {
        return $this->belongsTo(Pencucian::class, 'id_pencucian');
    }
}
