<?php

namespace Database\Seeders;

use App\Models\Pencucian;
use Illuminate\Database\Seeder;

class PencucianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_pencucian' => 'Cuci', 'harga' => 2000],
            ['nama_pencucian' => 'Setrika', 'harga' => 2000],
            ['nama_pencucian' => 'Cuci Setrika', 'harga' => 4000],
        ];

        foreach ($data as $pencucian) {
            Pencucian::firstOrCreate(
                ['nama_pencucian' => $pencucian['nama_pencucian']],
                ['harga' => $pencucian['harga']]
            );
        }
    }
}
