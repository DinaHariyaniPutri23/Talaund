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
        
        $riwayatAktivitas = Transaksi::with('pengguna')
            ->latest('tanggal_transaksi')
            ->take(5)
            ->get();

        return view('super_admin.dashboard', compact('totalPelanggan', 'riwayatAktivitas'));
    }
}
