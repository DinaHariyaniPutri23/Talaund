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

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/super-admin', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard.super_admin');

    Route::get('/dashboard/super-admin/data-master', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'index'])->name('dashboard.super_admin.data_master');
    Route::post('/dashboard/super-admin/data-master/pelanggan', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'storePelanggan'])->name('super_admin.pelanggan.store');
    Route::put('/dashboard/super-admin/data-master/pelanggan/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'updatePelanggan'])->name('super_admin.pelanggan.update');
    Route::delete('/dashboard/super-admin/data-master/pelanggan/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'destroyPelanggan'])->name('super_admin.pelanggan.destroy');

    Route::post('/dashboard/super-admin/data-master/layanan', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'storeLayanan'])->name('super_admin.layanan.store');
    Route::put('/dashboard/super-admin/data-master/layanan/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'updateLayanan'])->name('super_admin.layanan.update');
    Route::delete('/dashboard/super-admin/data-master/layanan/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'destroyLayanan'])->name('super_admin.layanan.destroy');

    Route::post('/dashboard/super-admin/data-master/pencucian', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'storePencucian'])->name('super_admin.pencucian.store');
    Route::put('/dashboard/super-admin/data-master/pencucian/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'updatePencucian'])->name('super_admin.pencucian.update');
    Route::delete('/dashboard/super-admin/data-master/pencucian/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'destroyPencucian'])->name('super_admin.pencucian.destroy');

    Route::post('/dashboard/super-admin/data-master/pengiriman', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'storePengiriman'])->name('super_admin.pengiriman.store');
    Route::put('/dashboard/super-admin/data-master/pengiriman/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'updatePengiriman'])->name('super_admin.pengiriman.update');
    Route::delete('/dashboard/super-admin/data-master/pengiriman/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'destroyPengiriman'])->name('super_admin.pengiriman.destroy');

    Route::post('/dashboard/super-admin/data-master/item', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'storeItem'])->name('super_admin.item.store');
    Route::put('/dashboard/super-admin/data-master/item/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'updateItem'])->name('super_admin.item.update');
    Route::delete('/dashboard/super-admin/data-master/item/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'destroyItem'])->name('super_admin.item.destroy');

    Route::post('/dashboard/super-admin/data-master/promo', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'storePromo'])->name('super_admin.promo.store');
    Route::put('/dashboard/super-admin/data-master/promo/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'updatePromo'])->name('super_admin.promo.update');
    Route::delete('/dashboard/super-admin/data-master/promo/{id}', [App\Http\Controllers\SuperAdmin\DataMasterController::class, 'destroyPromo'])->name('super_admin.promo.destroy');

    Route::get('/dashboard/super-admin/manajemen-user', [App\Http\Controllers\SuperAdmin\ManajemenUserController::class, 'index'])->name('dashboard.super_admin.manajemen_user');
    Route::post('/dashboard/super-admin/manajemen-user', [App\Http\Controllers\SuperAdmin\ManajemenUserController::class, 'store'])->name('super_admin.manajemen_user.store');
    Route::put('/dashboard/super-admin/manajemen-user/{id}', [App\Http\Controllers\SuperAdmin\ManajemenUserController::class, 'update'])->name('super_admin.manajemen_user.update');
    Route::delete('/dashboard/super-admin/manajemen-user/{id}', [App\Http\Controllers\SuperAdmin\ManajemenUserController::class, 'destroy'])->name('super_admin.manajemen_user.destroy');

    Route::get('/dashboard/super-admin/transaksi', [App\Http\Controllers\SuperAdmin\TransaksiController::class, 'index'])->name('dashboard.super_admin.transaksi');
    Route::get('/dashboard/super-admin/riwayat', [App\Http\Controllers\SuperAdmin\RiwayatController::class, 'index'])->name('dashboard.super_admin.riwayat');

    Route::get('/dashboard/super-admin/kendali', function () {
        return view('super_admin.kendali');
    })->name('dashboard.super_admin.kendali');

    Route::get('/dashboard/super-admin/konfigurasi', function () {
        return view('super_admin.konfigurasi');
    })->name('dashboard.super_admin.konfigurasi');

    Route::get('/dashboard/kasir', [App\Http\Controllers\Kasir\DashboardController::class, 'index'])->name('dashboard.kasir');

    Route::get('/dashboard/kasir/pelanggan', [App\Http\Controllers\PelangganController::class, 'index'])->name('dashboard.kasir.pelanggan');
    Route::post('/dashboard/kasir/pelanggan', [App\Http\Controllers\PelangganController::class, 'store'])->name('pelanggan.store');
    Route::put('/dashboard/kasir/pelanggan/{id}', [App\Http\Controllers\PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/dashboard/kasir/pelanggan/{id}', [App\Http\Controllers\PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    Route::get('/dashboard/kasir/transaksi', [App\Http\Controllers\Kasir\TransaksiController::class, 'create'])->name('dashboard.kasir.transaksi');
    Route::post('/dashboard/kasir/transaksi/store', [App\Http\Controllers\Kasir\TransaksiController::class, 'store'])->name('dashboard.kasir.transaksi.store');
    Route::get('/dashboard/kasir/transaksi/struk/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'struk'])->name('dashboard.kasir.struk');
    Route::post('/dashboard/kasir/transaksi/{id}/lunasi', [App\Http\Controllers\Kasir\TransaksiController::class, 'lunasi'])->name('dashboard.kasir.transaksi.lunasi');

    Route::get('/dashboard/kasir/riwayat', [App\Http\Controllers\Kasir\RiwayatController::class, 'index'])->name('dashboard.kasir.riwayat');

    Route::get('/dashboard/pemilik', function () {
        return view('pemilik.dashboard');
    })->name('dashboard.pemilik');

    Route::get('/dashboard/pemilik/transaksi', function () {
        return view('pemilik.transaksi');
    })->name('dashboard.pemilik.transaksi');

    Route::get('/dashboard/pemilik/laporan', function () {
        return view('pemilik.laporan');
    })->name('dashboard.pemilik.laporan');
});
