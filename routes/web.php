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
    Route::get('/dashboard/super-admin', function () {
        return view('super_admin.dashboard');
    })->name('dashboard.super_admin');

    Route::get('/dashboard/super-admin/data-master', function () {
        return view('super_admin.data_master');
    })->name('dashboard.super_admin.data_master');

    Route::get('/dashboard/super-admin/manajemen-user', function () {
        return view('super_admin.manajemen_user');
    })->name('dashboard.super_admin.manajemen_user');

    Route::get('/dashboard/super-admin/transaksi', function () {
        return view('super_admin.transaksi');
    })->name('dashboard.super_admin.transaksi');

    Route::get('/dashboard/super-admin/riwayat', function () {
        return view('super_admin.riwayat');
    })->name('dashboard.super_admin.riwayat');

    Route::get('/dashboard/super-admin/kendali', function () {
        return view('super_admin.kendali');
    })->name('dashboard.super_admin.kendali');

    Route::get('/dashboard/super-admin/konfigurasi', function () {
        return view('super_admin.konfigurasi');
    })->name('dashboard.super_admin.konfigurasi');

    Route::get('/dashboard/kasir', function () {
        return view('kasir.dashboard');
    })->name('dashboard.kasir');

    Route::get('/dashboard/kasir/pelanggan', [App\Http\Controllers\PelangganController::class, 'index'])->name('dashboard.kasir.pelanggan');
    Route::post('/dashboard/kasir/pelanggan', [App\Http\Controllers\PelangganController::class, 'store'])->name('pelanggan.store');
    Route::put('/dashboard/kasir/pelanggan/{id}', [App\Http\Controllers\PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/dashboard/kasir/pelanggan/{id}', [App\Http\Controllers\PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    Route::get('/dashboard/kasir/transaksi', function () {
        return view('kasir.transaksi');
    })->name('dashboard.kasir.transaksi');

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
