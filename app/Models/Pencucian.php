<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencucian extends Model
{
    protected $table = 'pencucian';

    protected $fillable = [
        'nama_pencucian',
        'harga',
    ];
}
