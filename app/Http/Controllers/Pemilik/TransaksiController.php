<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Transaksi::with(['pelanggan', 'pengguna', 'pembayaran']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        if ($status) {
            if ($status === 'lunas') {
                $query->whereHas('pembayaran', function($q) {
                    $q->where('status_bayar', 'paid');
                });
            } elseif ($status === 'pending') {
                $query->whereHas('pembayaran', function($q) {
                    $q->where('status_bayar', '!=', 'paid');
                });
            }
        }

        if ($start_date) {
            $query->whereDate('tanggal_transaksi', '>=', $start_date);
        }

        if ($end_date) {
            $query->whereDate('tanggal_transaksi', '<=', $end_date);
        }

        $transaksis = $query->latest('tanggal_transaksi')->paginate(20);

        return view('pemilik.transaksi', compact('transaksis', 'search', 'status', 'start_date', 'end_date'));
    }
}
