<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    protected $fillable = [
        'id_pelanggan',
        'nama_lengkap',
        'no_telepon',
        'alamat'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_pelanggan)) {
                $latest = self::orderBy('id', 'desc')->first();
                $nextId = $latest ? intval(substr($latest->id_pelanggan, 4)) + 1 : 1;
                $model->id_pelanggan = 'PLG-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
