<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Total Lunas Hari Ini
        $totalLunas = Transaksi::whereHas('pembayaran', function($q) {
            $q->where('status_bayar', 'paid');
        })->whereDate('tanggal_transaksi', $today)->sum('total_transaksi');

        // Total Belum Lunas Hari Ini (Jika ada)
        $totalBelumLunas = Transaksi::whereHas('pembayaran', function($q) {
            $q->where('status_bayar', '!=', 'paid');
        })->whereDate('tanggal_transaksi', $today)->sum('total_transaksi');

        // Transaksi Terbaru Hari Ini
        $transaksiTerbaru = Transaksi::with(['pelanggan', 'pembayaran'])
            ->whereDate('tanggal_transaksi', $today)
            ->latest('tanggal_transaksi')
            ->take(10)
            ->get();

        return view('kasir.dashboard', compact('totalLunas', 'totalBelumLunas', 'transaksiTerbaru'));
    }
}
