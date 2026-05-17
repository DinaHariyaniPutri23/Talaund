<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Transaksi::with(['pelanggan', 'pembayaran']);

        // Filter berdasarkan status
        if ($status == 'paid') {
            $query->whereHas('pembayaran', function($q) {
                $q->where('status_bayar', 'paid');
            });
        } elseif ($status == 'unpaid') {
            $query->whereHas('pembayaran', function($q) {
                $q->where('status_bayar', 'unpaid');
            });
        }

        // Pencarian (berdasarkan nama pelanggan atau nomor nota)
        if ($search) {
            $query->where(function($q) use ($search) {
                // Cari dari nomor nota (id)
                $q->where('id', 'like', "%{$search}%")
                  // Atau cari dari nama pelanggan
                  ->orWhereHas('pelanggan', function($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        $transaksis = $query->latest('tanggal_transaksi')->paginate(20);

        return view('kasir.riwayat', compact('transaksis', 'search', 'status'));
    }
}
