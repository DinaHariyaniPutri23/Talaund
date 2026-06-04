<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MSatuan;

class MSatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MSatuan::create([
            'nama_satuan' => 'kg',
        ]);

        MSatuan::create([
            'nama_satuan' => 'pcs',
        ]);
    }
}
