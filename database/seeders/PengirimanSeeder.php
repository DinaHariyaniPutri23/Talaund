<?php

namespace Database\Seeders;

use App\Models\Pengiriman;
use Illuminate\Database\Seeder;

class PengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['pilihan_pengiriman' => 'Diambil'],
            ['pilihan_pengiriman' => 'Diantar'],
        ];

        foreach ($data as $pengiriman) {
            Pengiriman::firstOrCreate($pengiriman);
        }
    }
}
