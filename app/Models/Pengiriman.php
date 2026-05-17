<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'jenis_pengiriman';

    protected $fillable = [
        'pilihan_pengiriman',
    ];
}
