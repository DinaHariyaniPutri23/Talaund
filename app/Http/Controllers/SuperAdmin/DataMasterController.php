<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\Pencucian;
use App\Models\Pengiriman;
use App\Models\ItemLaundry;
use App\Models\Promo;
use App\Models\MSatuan;

class DataMasterController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pelanggan');
        $search = $request->query('search');
        
        // Data yang selalu di-load
        $allLayanans = Layanan::orderBy('id', 'asc')->get();
        $allPencucians = Pencucian::orderBy('id', 'asc')->get();
        $allSatuans = MSatuan::orderBy('id', 'asc')->get();
        
        $data = [
            'layanans_list' => $allLayanans,
            'pencucians_list' => $allPencucians,
            'satuans_list' => $allSatuans,
            'search' => $search,
        ];
        
        if ($tab == 'pelanggan') {
            $query = Pelanggan::query();
            if ($search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('no_telepon', 'like', "%{$search}%");
            }
            $data['pelanggans'] = $query->orderBy('id_pelanggan', 'asc')->paginate(10);
            
        } elseif ($tab == 'layanan') {
            $query = Layanan::query();
            if ($search) {
                $query->where('nama_layanan', 'like', "%{$search}%");
            }
            $data['layanans'] = $query->orderBy('id', 'asc')->paginate(10);
            
        } elseif ($tab == 'item') {
            $query = ItemLaundry::with('layanan', 'pencucian');
            if ($search) {
                $query->where('nama_item', 'like', "%{$search}%");
            }
            $data['items'] = $query->orderBy('id', 'asc')->paginate(10);
            
        } elseif ($tab == 'pencucian') {
            $query = Pencucian::query();
            if ($search) {
                $query->where('nama_pencucian', 'like', "%{$search}%");
            }
            $data['pencucians'] = $query->orderBy('id', 'asc')->paginate(10);
            
        } elseif ($tab == 'pengiriman') {
            $query = Pengiriman::query();
            if ($search) {
                $query->where('jenis_pengiriman', 'like', "%{$search}%");
            }
            $data['pengirimans'] = $query->orderBy('id', 'asc')->paginate(10);
            
        } elseif ($tab == 'promo') {
            $query = Promo::query();
            if ($search) {
                $query->where('kode_promo', 'like', "%{$search}%");
            }
            $data['promos'] = $query->orderBy('id', 'asc')->paginate(10);
            
        } elseif ($tab == 'satuan') {
            $query = MSatuan::query();
            if ($search) {
                $query->where('nama_satuan', 'like', "%{$search}%");
            }
            $data['satuans'] = $query->orderBy('id', 'asc')->paginate(10);
        }

        return view('super_admin.data_master', array_merge(['tab' => $tab], $data));
    }
}
