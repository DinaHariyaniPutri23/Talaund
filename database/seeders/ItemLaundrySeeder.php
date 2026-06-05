<?php

namespace Database\Seeders;

use App\Models\ItemLaundry;
use Illuminate\Database\Seeder;

class ItemLaundrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_item' => 'Baju dan Celana',
                'harga' => 2000,
                'satuan' => 'kg',
            ],
            [
                'nama_item' => 'Bed Cover Kecil',
                'harga' => 30000,
                'satuan' => 'pcs',
            ],
             [
                'nama_item' => 'Bed Cover Besar',
                'harga' => 40000,
                'satuan' => 'pcs',
            ],
            [
                'nama_item' => 'Jas',
                'harga' => 30000,
                'satuan' => 'pcs',
            ],
            [
                'nama_item' => 'Sepatu',
                'harga' => 15000,
                'satuan' => 'pcs',
            ],
        ];

        foreach ($data as $item) {
            ItemLaundry::updateOrCreate(
                ['nama_item' => $item['nama_item']],
                [
                    'harga' => $item['harga'],
                    'satuan' => $item['satuan'],
                ]
            );
        }
    }
}