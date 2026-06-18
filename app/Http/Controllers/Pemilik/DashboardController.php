<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Total Omzet Bulan Ini
        $totalOmzetBulanIni = Transaksi::whereHas('pembayaran', function($q) {
            $q->where('status_bayar', 'paid');
        })->whereBetween('tanggal_transaksi', [$startOfMonth, Carbon::now()])
            ->sum('total_transaksi');

        // Total Omzet Bulan Lalu untuk perbandingan
        $totalOmzetBulanLalu = Transaksi::whereHas('pembayaran', function($q) {
            $q->where('status_bayar', 'paid');
        })->whereBetween('tanggal_transaksi', [$lastMonthStart, $lastMonthEnd])
            ->sum('total_transaksi');

        $percentageOmzet = $totalOmzetBulanLalu > 0 
            ? round(((($totalOmzetBulanIni - $totalOmzetBulanLalu) / $totalOmzetBulanLalu) * 100), 2)
            : 0;

        // Total Transaksi Bulan Ini
        $totalTransaksiBulanIni = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, Carbon::now()])
            ->count();

        $totalTransaksiBulanLalu = Transaksi::whereBetween('tanggal_transaksi', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $percentageTransaksi = $totalTransaksiBulanLalu > 0 
            ? round(((($totalTransaksiBulanIni - $totalTransaksiBulanLalu) / $totalTransaksiBulanLalu) * 100), 2)
            : 0;

        // Pelanggan Baru Bulan Ini
        $pelangganBaruBulanIni = Pelanggan::whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->count();

        $pelangganBaruBulanLalu = Pelanggan::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $percentagePelanggan = $pelangganBaruBulanLalu > 0 
            ? round(((($pelangganBaruBulanIni - $pelangganBaruBulanLalu) / $pelangganBaruBulanLalu) * 100), 2)
            : 0;

        // Piutang Berjalan (Belum Lunas)
        $piutangBerjalan = Transaksi::whereHas('pembayaran', function($q) {
            $q->where('status_bayar', '!=', 'paid');
        })->sum('total_transaksi');

        $totalBelumLunas = Transaksi::whereHas('pembayaran', function($q) {
            $q->where('status_bayar', '!=', 'paid');
        })->count();

        // Tren Pendapatan Berdasarkan Filter
        $filter = request('filter', 'harian');
        $trendData = [];

        if ($filter == 'tahunan') {
            for ($i = 4; $i >= 0; $i--) {
                $year = Carbon::now()->subYears($i)->year;
                $omzet = Transaksi::whereHas('pembayaran', function($q) {
                    $q->where('status_bayar', 'paid');
                })->whereYear('tanggal_transaksi', $year)
                  ->sum('total_transaksi');
                
                $trendData[] = [
                    'date' => (string)$year,
                    'omzet' => $omzet
                ];
            }
            $chartSubtitle = "Omzet 5 Tahun Terakhir";
        } elseif ($filter == 'bulanan') {
            for ($i = 1; $i <= 12; $i++) {
                $omzet = Transaksi::whereHas('pembayaran', function($q) {
                    $q->where('status_bayar', 'paid');
                })->whereYear('tanggal_transaksi', Carbon::now()->year)
                  ->whereMonth('tanggal_transaksi', $i)
                  ->sum('total_transaksi');
                
                $trendData[] = [
                    'date' => Carbon::create()->month($i)->translatedFormat('M'),
                    'omzet' => $omzet
                ];
            }
            $chartSubtitle = "Omzet Per Bulan (" . Carbon::now()->year . ")";
        } else {
            // Default harian (30 Hari)
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $omzet = Transaksi::whereHas('pembayaran', function($q) {
                    $q->where('status_bayar', 'paid');
                })->whereDate('tanggal_transaksi', $date)
                    ->sum('total_transaksi');
                
                $trendData[] = [
                    'date' => $date->format('d M'),
                    'omzet' => $omzet
                ];
            }
            $chartSubtitle = "Omzet Per Hari (30 Hari Terakhir)";
        }

        // Transaksi Terbaru Hari Ini
        $transaksiTerbaru = Transaksi::with(['pelanggan', 'pembayaran'])
            ->whereDate('tanggal_transaksi', $today)
            ->latest('tanggal_transaksi')
            ->take(5)
            ->get();

        return view('pemilik.dashboard', compact(
            'totalOmzetBulanIni',
            'percentageOmzet',
            'totalTransaksiBulanIni',
            'percentageTransaksi',
            'pelangganBaruBulanIni',
            'percentagePelanggan',
            'piutangBerjalan',
            'totalBelumLunas',
            'trendData',
            'chartSubtitle',
            'filter',
            'transaksiTerbaru'
        ));
    }
}
