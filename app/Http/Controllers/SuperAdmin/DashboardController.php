<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = Pelanggan::count();
        
        $kasHariIni = Transaksi::whereHas('pembayaran', function($q) {
            $q->where('status_bayar', 'paid');
        })->whereDate('tanggal_transaksi', now()->toDateString())->sum('total_transaksi');

        $transaksiLunas = Transaksi::whereHas('pembayaran', function ($q) {
            $q->where('status_bayar', 'paid');
        })->count();

        $transaksiPending = Transaksi::whereHas('pembayaran', function ($q) {
            $q->where('status_bayar', '!=', 'paid');
        })->count();

        $cucianBerjalan = Transaksi::whereIn('status_transaksi', ['pending', 'proses'])->count();
        
        $riwayatAktivitas = Transaksi::with('pengguna')
            ->latest('tanggal_transaksi')
            ->take(5)
            ->get();

        return view('super_admin.dashboard', compact('totalPelanggan', 'riwayatAktivitas', 'kasHariIni', 'cucianBerjalan', 'transaksiLunas', 'transaksiPending'));
    }
}
