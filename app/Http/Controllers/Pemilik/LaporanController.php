<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfDay();

        // Total Cucian Masuk
        $totalCucian = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])->count();

        // Total Tunai
        $totalTunai = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->whereHas('pembayaran', function($q) {
                $q->where('metode_bayar', 'tunai');
            })->sum('total_transaksi');

        // Total Xendit (Non-Tunai)
        $totalXendit = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->whereHas('pembayaran', function($q) {
                $q->where('metode_bayar', '!=', 'tunai');
            })->sum('total_transaksi');

        // Total Potongan Promo (dari promo yang digunakan)
        $totalPromo = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->whereNotNull('promo_id')
            ->with('promo')
            ->get()
            ->sum(function($t) {
                return optional($t->promo)->potongan ?? 0;
            });

        // Total Bersih
        $totalBersih = $totalTunai + $totalXendit - $totalPromo;

        // Rincian Harian
        $rincianHarian = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dayEnd = $currentDate->copy()->endOfDay();
            
            $tunai = Transaksi::whereBetween('tanggal_transaksi', [$currentDate, $dayEnd])
                ->whereHas('pembayaran', function($q) {
                    $q->where('metode_bayar', 'tunai');
                })->sum('total_transaksi');
            
            $xendit = Transaksi::whereBetween('tanggal_transaksi', [$currentDate, $dayEnd])
                ->whereHas('pembayaran', function($q) {
                    $q->where('metode_bayar', '!=', 'tunai');
                })->sum('total_transaksi');
            
            $promo = Transaksi::whereBetween('tanggal_transaksi', [$currentDate, $dayEnd])
                ->whereNotNull('promo_id')
                ->with('promo')
                ->get()
                ->sum(function($t) {
                    return optional($t->promo)->potongan ?? 0;
                });
            
            $jumlahNota = Transaksi::whereBetween('tanggal_transaksi', [$currentDate, $dayEnd])->count();
            
            if ($jumlahNota > 0 || $tunai > 0 || $xendit > 0) {
                $rincianHarian[] = [
                    'tanggal' => $currentDate->format('d M Y'),
                    'jml_nota' => $jumlahNota,
                    'tunai' => $tunai,
                    'xendit' => $xendit,
                    'promo' => $promo,
                    'total_bersih' => $tunai + $xendit - $promo
                ];
            }
            
            $currentDate->addDay();
        }

        // Handle Export
        if ($request->input('export') === 'excel') {
            return $this->exportExcel($startDate, $endDate, $totalCucian, $totalTunai, $totalXendit, $totalPromo, $totalBersih, $rincianHarian);
        } elseif ($request->input('export') === 'pdf') {
            return $this->exportPDF($startDate, $endDate, $totalCucian, $totalTunai, $totalXendit, $totalPromo, $totalBersih, $rincianHarian);
        }

        return view('pemilik.laporan', compact(
            'totalCucian',
            'totalTunai',
            'totalXendit',
            'totalPromo',
            'totalBersih',
            'rincianHarian',
            'startDate',
            'endDate'
        ));
    }

    private function exportExcel($startDate, $endDate, $totalCucian, $totalTunai, $totalXendit, $totalPromo, $totalBersih, $rincianHarian)
    {
        $filename = 'Laporan_Keuangan_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        
        $output = "LAPORAN KEUANGAN & PERFORMA LAUNDRY\n";
        $output .= "Periode: " . $startDate->format('d M Y') . " - " . $endDate->format('d M Y') . "\n\n";
        
        $output .= "RINGKASAN\n";
        $output .= "Total Cucian Masuk," . $totalCucian . "\n";
        $output .= "Total Tunai (Cash),Rp " . number_format($totalTunai, 0, ',', '.') . "\n";
        $output .= "Total Xendit (Non-Tunai),Rp " . number_format($totalXendit, 0, ',', '.') . "\n";
        $output .= "Total Potongan Promo,-Rp " . number_format($totalPromo, 0, ',', '.') . "\n";
        $output .= "Total Bersih,Rp " . number_format($totalBersih, 0, ',', '.') . "\n\n";
        
        $output .= "RINCIAN HARIAN\n";
        $output .= "Tanggal,Jml Nota,Tunai (Cash),Xendit (Non-Tunai),Potongan Promo,Total Pemasukan Bersih\n";
        
        foreach ($rincianHarian as $rincian) {
            $output .= $rincian['tanggal'] . ",";
            $output .= $rincian['jml_nota'] . ",";
            $output .= "Rp " . number_format($rincian['tunai'], 0, ',', '.') . ",";
            $output .= "Rp " . number_format($rincian['xendit'], 0, ',', '.') . ",";
            $output .= "-Rp " . number_format($rincian['promo'], 0, ',', '.') . ",";
            $output .= "Rp " . number_format($rincian['total_bersih'], 0, ',', '.') . "\n";
        }
        
        return response($output, 200)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=' . $filename);
    }

    private function exportPDF($startDate, $endDate, $totalCucian, $totalTunai, $totalXendit, $totalPromo, $totalBersih, $rincianHarian)
    {
        $html = "
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { text-align: center; color: #333; }
                .summary { margin: 20px 0; }
                .summary-item { display: inline-block; margin-right: 30px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
                th { background-color: #f4f4f4; font-weight: bold; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .text-right { text-align: right; }
                .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
            </style>
        </head>
        <body>
            <h1>LAPORAN KEUANGAN & PERFORMA LAUNDRY</h1>
            <p style='text-align: center;'>Periode: " . $startDate->format('d M Y') . " - " . $endDate->format('d M Y') . "</p>
            
            <div class='summary'>
                <div class='summary-item'>
                    <strong>Total Cucian Masuk:</strong> " . number_format($totalCucian) . " Nota
                </div>
                <div class='summary-item'>
                    <strong>Total Tunai (Cash):</strong> Rp " . number_format($totalTunai, 0, ',', '.') . "
                </div>
            </div>
            
            <div class='summary'>
                <div class='summary-item'>
                    <strong>Total Xendit (Non-Tunai):</strong> Rp " . number_format($totalXendit, 0, ',', '.') . "
                </div>
                <div class='summary-item'>
                    <strong>Total Potongan Promo:</strong> -Rp " . number_format($totalPromo, 0, ',', '.') . "
                </div>
            </div>
            
            <div class='summary' style='background-color: #f0f0f0; padding: 10px;'>
                <strong style='font-size: 16px;'>Total Bersih: Rp " . number_format($totalBersih, 0, ',', '.') . "</strong>
            </div>
            
            <h3>Rincian Pendapatan Harian</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th class='text-right'>Jml Nota</th>
                        <th class='text-right'>Tunai (Cash)</th>
                        <th class='text-right'>Xendit (Non-Tunai)</th>
                        <th class='text-right'>Potongan Promo</th>
                        <th class='text-right'>Total Pemasukan Bersih</th>
                    </tr>
                </thead>
                <tbody>";
        
        foreach ($rincianHarian as $rincian) {
            $html .= "
                    <tr>
                        <td>" . $rincian['tanggal'] . "</td>
                        <td class='text-right'>" . number_format($rincian['jml_nota']) . "</td>
                        <td class='text-right'>Rp " . number_format($rincian['tunai'], 0, ',', '.') . "</td>
                        <td class='text-right'>Rp " . number_format($rincian['xendit'], 0, ',', '.') . "</td>
                        <td class='text-right'>-Rp " . number_format($rincian['promo'], 0, ',', '.') . "</td>
                        <td class='text-right'><strong>Rp " . number_format($rincian['total_bersih'], 0, ',', '.') . "</strong></td>
                    </tr>";
        }
        
        $html .= "
                </tbody>
            </table>
            
            <div class='footer'>
                <p>Laporan ini dihasilkan secara otomatis oleh sistem Talaund Laundry Management</p>
                <p>Tanggal Cetak: " . now()->format('d M Y H:i:s') . "</p>
            </div>
        </body>
        </html>";
        
        // Simple PDF generation by returning HTML that can be printed as PDF
        // In production, use barryvdh/laravel-dompdf package
        $filename = 'Laporan_Keuangan_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.html';
        
        return response($html, 200)
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=' . $filename);
    }
}
