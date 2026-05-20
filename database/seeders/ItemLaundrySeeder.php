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
            ['nama_item' => 'Baju', 'harga' => 7000],
            ['nama_item' => 'Celana', 'harga' => 8000],
            ['nama_item' => 'Bad Cover', 'harga' => 20000],
            ['nama_item' => 'Jas', 'harga' => 25000],
            ['nama_item' => 'Sepatu', 'harga' => 30000],
        ];

        foreach ($data as $item) {
            ItemLaundry::firstOrCreate(
                ['nama_item' => $item['nama_item']],
                ['harga' => $item['harga']]
            );
        }
    }
}
