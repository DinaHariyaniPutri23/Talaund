<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promo';

    protected $fillable = [
        'nama_promo',
        'potongan',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
}
