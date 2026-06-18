<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiturKendali extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_fitur',
        'kode_fitur',
        'deskripsi',
        'status'
    ];
}
