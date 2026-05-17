<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Transaksi::with(['pelanggan', 'pengguna']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        // Ambil 50 aktivitas terbaru
        $riwayats = $query->latest('tanggal_transaksi')->paginate(50);

        return view('super_admin.riwayat', compact('riwayats', 'search'));
    }
}
