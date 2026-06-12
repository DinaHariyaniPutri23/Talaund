<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\DataMasterController;
use App\Http\Controllers\SuperAdmin\DataMaster\ItemLaundryMasterController;
use App\Http\Controllers\SuperAdmin\DataMaster\LayananMasterController;
use App\Http\Controllers\SuperAdmin\DataMaster\PelangganMasterController;
use App\Http\Controllers\SuperAdmin\DataMaster\PencucianMasterController;
use App\Http\Controllers\SuperAdmin\DataMaster\PengirimanMasterController;
use App\Http\Controllers\SuperAdmin\DataMaster\PromoMasterController;
use App\Http\Controllers\SuperAdmin\DataMaster\SatuanMasterController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\ManajemenUserController;
use App\Http\Controllers\SuperAdmin\RiwayatController as SuperAdminRiwayatController;
use App\Http\Controllers\SuperAdmin\TransaksiController as SuperAdminTransaksiController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\Kasir\RiwayatController as KasirRiwayatController;
use App\Http\Controllers\Kasir\TransaksiController as KasirTransaksiController;
use App\Http\Controllers\PelangganController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/super-admin', [SuperAdminDashboardController::class, 'index'])->name('dashboard.super_admin');

    Route::get('/dashboard/super-admin/data-master', [DataMasterController::class, 'index'])->name('dashboard.super_admin.data_master');
    Route::post('/dashboard/super-admin/data-master/pelanggan', [PelangganMasterController::class, 'store'])->name('super_admin.pelanggan.store');
    Route::put('/dashboard/super-admin/data-master/pelanggan/{id}', [PelangganMasterController::class, 'update'])->name('super_admin.pelanggan.update');
    Route::delete('/dashboard/super-admin/data-master/pelanggan/{id}', [PelangganMasterController::class, 'destroy'])->name('super_admin.pelanggan.destroy');

    Route::post('/dashboard/super-admin/data-master/layanan', [LayananMasterController::class, 'store'])->name('super_admin.layanan.store');
    Route::put('/dashboard/super-admin/data-master/layanan/{id}', [LayananMasterController::class, 'update'])->name('super_admin.layanan.update');
    Route::delete('/dashboard/super-admin/data-master/layanan/{id}', [LayananMasterController::class, 'destroy'])->name('super_admin.layanan.destroy');

    Route::post('/dashboard/super-admin/data-master/pencucian', [PencucianMasterController::class, 'store'])->name('super_admin.pencucian.store');
    Route::put('/dashboard/super-admin/data-master/pencucian/{id}', [PencucianMasterController::class, 'update'])->name('super_admin.pencucian.update');
    Route::delete('/dashboard/super-admin/data-master/pencucian/{id}', [PencucianMasterController::class, 'destroy'])->name('super_admin.pencucian.destroy');

    Route::post('/dashboard/super-admin/data-master/pengiriman', [PengirimanMasterController::class, 'store'])->name('super_admin.pengiriman.store');
    Route::put('/dashboard/super-admin/data-master/pengiriman/{id}', [PengirimanMasterController::class, 'update'])->name('super_admin.pengiriman.update');
    Route::delete('/dashboard/super-admin/data-master/pengiriman/{id}', [PengirimanMasterController::class, 'destroy'])->name('super_admin.pengiriman.destroy');

    Route::post('/dashboard/super-admin/data-master/item', [ItemLaundryMasterController::class, 'store'])->name('super_admin.item.store');
    Route::put('/dashboard/super-admin/data-master/item/{id}', [ItemLaundryMasterController::class, 'update'])->name('super_admin.item.update');
    Route::delete('/dashboard/super-admin/data-master/item/{id}', [ItemLaundryMasterController::class, 'destroy'])->name('super_admin.item.destroy');

    Route::post('/dashboard/super-admin/data-master/promo', [PromoMasterController::class, 'store'])->name('super_admin.promo.store');
    Route::put('/dashboard/super-admin/data-master/promo/{id}', [PromoMasterController::class, 'update'])->name('super_admin.promo.update');
    Route::delete('/dashboard/super-admin/data-master/promo/{id}', [PromoMasterController::class, 'destroy'])->name('super_admin.promo.destroy');

    Route::post('/dashboard/super-admin/data-master/satuan', [SatuanMasterController::class, 'store'])->name('super_admin.satuan.store');
    Route::put('/dashboard/super-admin/data-master/satuan/{id}', [SatuanMasterController::class, 'update'])->name('super_admin.satuan.update');
    Route::delete('/dashboard/super-admin/data-master/satuan/{id}', [SatuanMasterController::class, 'destroy'])->name('super_admin.satuan.destroy');

    Route::get('/dashboard/super-admin/manajemen-user', [ManajemenUserController::class, 'index'])->name('dashboard.super_admin.manajemen_user');
    Route::post('/dashboard/super-admin/manajemen-user', [ManajemenUserController::class, 'store'])->name('super_admin.manajemen_user.store');
    Route::put('/dashboard/super-admin/manajemen-user/{id}', [ManajemenUserController::class, 'update'])->name('super_admin.manajemen_user.update');
    Route::delete('/dashboard/super-admin/manajemen-user/{id}', [ManajemenUserController::class, 'destroy'])->name('super_admin.manajemen_user.destroy');

    Route::get('/dashboard/super-admin/transaksi', [SuperAdminTransaksiController::class, 'index'])->name('dashboard.super_admin.transaksi');
    Route::get('/dashboard/super-admin/riwayat', [SuperAdminRiwayatController::class, 'index'])->name('dashboard.super_admin.riwayat');

    Route::get('/dashboard/super-admin/kendali', function () {
        return view('super_admin.kendali');
    })->name('dashboard.super_admin.kendali');

    Route::get('/dashboard/super-admin/konfigurasi', function () {
        return view('super_admin.konfigurasi');
    })->name('dashboard.super_admin.konfigurasi');

    Route::get('/dashboard/kasir', [KasirDashboardController::class, 'index'])->name('dashboard.kasir');

    Route::get('/dashboard/kasir/pelanggan', [PelangganController::class, 'index'])->name('dashboard.kasir.pelanggan');
    Route::post('/dashboard/kasir/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::put('/dashboard/kasir/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/dashboard/kasir/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    Route::get('/dashboard/kasir/transaksi', [KasirTransaksiController::class, 'index'])->name('dashboard.kasir.transaksi');
    Route::get('/dashboard/kasir/transaksi/create', [KasirTransaksiController::class, 'create'])->name('dashboard.kasir.transaksi.create');

    Route::post('/dashboard/kasir/transaksi/store', [KasirTransaksiController::class, 'store'])->name('dashboard.kasir.transaksi.store');
    
    // ==========================================
    // ROUTE BARU: API GENERATE DYNAMIC QRIS XENDIT
    // ==========================================
    Route::post('/dashboard/kasir/transaksi/qris', [KasirTransaksiController::class, 'buatQrisDinamis'])->name('dashboard.kasir.transaksi.qris');
    
    Route::get('/dashboard/kasir/transaksi/struk/{id}', [KasirTransaksiController::class, 'struk'])->name('dashboard.kasir.struk');
    Route::post('/dashboard/kasir/transaksi/{id}/lunasi', [KasirTransaksiController::class, 'lunasi'])->name('dashboard.kasir.transaksi.lunasi');
    Route::post('/dashboard/kasir/transaksi/{id}/update-pembayaran', [KasirTransaksiController::class, 'updatePembayaran'])->name('dashboard.kasir.transaksi.updatePembayaran');
    Route::post('/dashboard/kasir/transaksi/{id}/void', [KasirTransaksiController::class, 'voidTransaksi'])->name('dashboard.kasir.transaksi.void');


    Route::get('/dashboard/kasir/riwayat', [KasirRiwayatController::class, 'index'])->name('dashboard.kasir.riwayat');

    Route::get('/dashboard/pemilik', [App\Http\Controllers\Pemilik\DashboardController::class, 'index'])->name('dashboard.pemilik');

    Route::get('/dashboard/pemilik/transaksi', [App\Http\Controllers\Pemilik\TransaksiController::class, 'index'])->name('dashboard.pemilik.transaksi');

    Route::get('/dashboard/pemilik/laporan', [App\Http\Controllers\Pemilik\LaporanController::class, 'index'])->name('dashboard.pemilik.laporan');
});

// =========================================================================
// ROUTE WEBHOOK CALLBACK: Di luar middleware auth agar Xendit bisa akses bebas
// =========================================================================
Route::post('/api/callback-xendit', [KasirTransaksiController::class, 'handleCallback']);