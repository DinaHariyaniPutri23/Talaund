<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;

try {
    $pembayaran = Pembayaran::where('status_bayar', 'unpaid')->latest()->first();
    if (!$pembayaran) {
        die("Tidak ada transaksi QRIS yang berstatus unpaid.");
    }
    
    $transaksi = Transaksi::find($pembayaran->transaksi_id);
    if (!$transaksi) {
        die("Transaksi tidak ditemukan.");
    }

    // Ekstrak external_id atau kita bisa pakai QR string if needed
    // Di controller, id nota lokal adalah: 'MILA-' . $transaksi->id . '-' . timestamp
    // Karena kita tidak menyimpan external_id secara langsung, tapi kita bisa mencarinya di Xendit!
    
    $secret_key = env('XENDIT_SECRET_KEY');
    
    // 1. Ambil detail QR dari Xendit pakai id_xendit
    $ch = curl_init('https://api.xendit.co/qr_codes/' . $pembayaran->id_xendit);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ':');
    $res = curl_exec($ch);
    curl_close($ch);
    
    $qrData = json_decode($res, true);
    
    if(!isset($qrData['external_id'])) {
        die("Gagal mengambil data QR dari Xendit: " . $res);
    }
    
    $external_id = $qrData['external_id'];
    $amount = $qrData['amount'];

    echo "Ditemukan Transaksi: " . $external_id . " dengan nominal Rp " . $amount . "<br>";
    echo "Melakukan simulasi pembayaran...<br>";
    
    // 2. Tembak API Simulasi Xendit
    $ch2 = curl_init('https://api.xendit.co/qr_codes/' . $external_id . '/payments/simulate');
    curl_setopt_array($ch2, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_USERPWD => $secret_key . ':',
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode(['amount' => $amount])
    ]);
    
    $simRes = curl_exec($ch2);
    $httpCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
    curl_close($ch2);
    
    echo "<b>Hasil Simulasi (HTTP $httpCode):</b><br>";
    echo "<pre>" . print_r(json_decode($simRes, true), true) . "</pre>";
    
    echo "<br><b>Selesai!</b> Cek database atau aplikasi kasirmu, statusnya harusnya sudah berubah jadi Paid (Lunas).";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
