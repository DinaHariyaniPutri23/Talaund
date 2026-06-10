<?php

namespace Database\Seeders;

use App\Models\ItemLaundry;
use App\Models\Layanan;
use App\Models\Pencucian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemLaundrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get IDs
        $reguler = Layanan::where('nama_layanan', 'Reguler')->first()->id ?? null;
        $express = Layanan::where('nama_layanan', 'Express')->first()->id ?? null;
        
        $cuci = Pencucian::where('nama_pencucian', 'Cuci')->first()->id ?? null;
        $setrika = Pencucian::where('nama_pencucian', 'Setrika')->first()->id ?? null;
        $cuciSetrika = Pencucian::where('nama_pencucian', 'Cuci Setrika')->first()->id ?? null;

        // Clear existing data to avoid duplicates if names match
        // DB::table('item_laundry')->truncate(); // Optional, let's just updateOrCreate

        $data = [
            // 1. Pakaian
            ['nama_item' => 'Pakaian', 'id_layanan' => $reguler, 'id_pencucian' => $cuci, 'harga' => 6000, 'satuan' => 'kg'],
            ['nama_item' => 'Pakaian', 'id_layanan' => $express, 'id_pencucian' => $cuci, 'harga' => 10000, 'satuan' => 'kg'],
            ['nama_item' => 'Pakaian', 'id_layanan' => $reguler, 'id_pencucian' => $setrika, 'harga' => 6000, 'satuan' => 'kg'],
            ['nama_item' => 'Pakaian', 'id_layanan' => $express, 'id_pencucian' => $setrika, 'harga' => 10000, 'satuan' => 'kg'],
            ['nama_item' => 'Pakaian', 'id_layanan' => $reguler, 'id_pencucian' => $cuciSetrika, 'harga' => 8000, 'satuan' => 'kg'],
            ['nama_item' => 'Pakaian', 'id_layanan' => $express, 'id_pencucian' => $cuciSetrika, 'harga' => 12000, 'satuan' => 'kg'],
            
            // 2. Bed Cover Besar
            ['nama_item' => 'Bed Cover Besar', 'id_layanan' => $reguler, 'id_pencucian' => $cuci, 'harga' => 40000, 'satuan' => 'pcs'],
            ['nama_item' => 'Bed Cover Besar', 'id_layanan' => $express, 'id_pencucian' => $cuci, 'harga' => 60000, 'satuan' => 'pcs'],
            
            // 3. Bed Cover Kecil
            ['nama_item' => 'Bed Cover Kecil', 'id_layanan' => $reguler, 'id_pencucian' => $cuci, 'harga' => 30000, 'satuan' => 'pcs'],
            ['nama_item' => 'Bed Cover Kecil', 'id_layanan' => $express, 'id_pencucian' => $cuci, 'harga' => 45000, 'satuan' => 'pcs'],
            
            // 4. Sepatu
            ['nama_item' => 'Sepatu', 'id_layanan' => $reguler, 'id_pencucian' => $cuci, 'harga' => 15000, 'satuan' => 'pcs'],
            ['nama_item' => 'Sepatu', 'id_layanan' => $express, 'id_pencucian' => $cuci, 'harga' => 20000, 'satuan' => 'pcs'],
            
            // 5. Jas
            ['nama_item' => 'Jas', 'id_layanan' => $reguler, 'id_pencucian' => $cuci, 'harga' => 20000, 'satuan' => 'pcs'],
            ['nama_item' => 'Jas', 'id_layanan' => $express, 'id_pencucian' => $cuci, 'harga' => 30000, 'satuan' => 'pcs'],
            ['nama_item' => 'Jas', 'id_layanan' => $reguler, 'id_pencucian' => $cuciSetrika, 'harga' => 30000, 'satuan' => 'pcs'],
            ['nama_item' => 'Jas', 'id_layanan' => $express, 'id_pencucian' => $cuciSetrika, 'harga' => 40000, 'satuan' => 'pcs'],
        ];

        // Clean up table first to make sure there are no leftover old items like "Baju dan Celana"
        DB::table('item_laundry')->truncate();

        foreach ($data as $item) {
            ItemLaundry::create($item);
        }
    }
}