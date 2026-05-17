<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Transaksi::with(['pelanggan', 'pengguna', 'pembayaran']);

        // Jika ada pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                // Cari berdasarkan Invoice
                $q->where('id', 'like', "%{$search}%")
                  // Atau cari berdasarkan nama pelanggan
                  ->orWhereHas('pelanggan', function($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  // Atau cari berdasarkan nama kasir
                  ->orWhereHas('pengguna', function($q3) use ($search) {
                      $q3->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Urutkan dari yang terbaru, 20 data per halaman
        $transaksis = $query->latest('tanggal_transaksi')->paginate(20);

        return view('super_admin.transaksi', compact('transaksis', 'search'));
    }
}
