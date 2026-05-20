<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_layanan' => 'Express', 'harga_layanan' => 20000],
            ['nama_layanan' => 'Reguler', 'harga_layanan' => 0],
        ];

        foreach ($data as $layanan) {
            Layanan::firstOrCreate(
                ['nama_layanan' => $layanan['nama_layanan']],
                ['harga_layanan' => $layanan['harga_layanan']]
            );
        }
    }
}
