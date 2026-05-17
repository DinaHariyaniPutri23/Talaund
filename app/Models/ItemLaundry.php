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
    ];
}
