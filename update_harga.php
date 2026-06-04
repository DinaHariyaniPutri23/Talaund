<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\ItemLaundry;
use App\Models\Pencucian;
use App\Models\Layanan;

echo "=== Update Harga Database ===\n\n";

// Update Pencucian (Jenis Cuci)
echo "--- Updating Pencucian ---\n";
$pencucians = [
    ['nama' => 'Cuci', 'harga' => 6000],
    ['nama' => 'Setrika', 'harga' => 6000],
    ['nama' => 'Cuci + Setrika', 'harga' => 8000],
];

foreach ($pencucians as $p) {
    $pencucian = Pencucian::where('nama_pencucian', $p['nama'])->first();
    if ($pencucian) {
        $pencucian->update(['harga' => $p['harga']]);
        echo "✓ {$p['nama']}: Rp " . number_format($p['harga'], 0, ',', '.') . "\n";
    } else {
        echo "✗ {$p['nama']}: Tidak ditemukan\n";
    }
}

// Update Layanan (Services)
echo "\n--- Updating Layanan ---\n";
$layanans = [
    ['nama' => 'Reguler', 'harga' => 0],
    ['nama' => 'Express', 'harga' => 4000],
];

foreach ($layanans as $l) {
    $layanan = Layanan::where('nama_layanan', $l['nama'])->first();
    if ($layanan) {
        $layanan->update(['harga_layanan' => $l['harga']]);
        echo "✓ {$l['nama']}: Rp " . number_format($l['harga'], 0, ',', '.') . "\n";
    } else {
        echo "✗ {$l['nama']}: Tidak ditemukan\n";
    }
}

// Update Item Laundry
echo "\n--- Updating Item Laundry ---\n";
$items = [
    ['nama' => 'Baju & Celana', 'harga' => 2000],
    ['nama' => 'Bed Cover Kecil', 'harga' => 30000],
    ['nama' => 'Bed Cover Besar', 'harga' => 40000],
    ['nama' => 'Sepatu', 'harga' => 15000],
    ['nama' => 'Jas', 'harga' => 30000],
];

foreach ($items as $item) {
    $itemObj = ItemLaundry::where('nama_item', $item['nama'])->first();
    if ($itemObj) {
        $itemObj->update(['harga' => $item['harga']]);
        echo "✓ {$item['nama']}: Rp " . number_format($item['harga'], 0, ',', '.') . "\n";
    } else {
        echo "✗ {$item['nama']}: Tidak ditemukan\n";
    }
}

echo "\n=== Update Complete ===\n";
