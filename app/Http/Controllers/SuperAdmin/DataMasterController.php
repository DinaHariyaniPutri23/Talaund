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
        
        $data = [];
        if ($tab == 'pelanggan') {
            $data['pelanggans'] = Pelanggan::orderBy('id_pelanggan', 'asc')->paginate(10);
        } elseif ($tab == 'layanan') {
            $data['layanans'] = Layanan::orderBy('id', 'asc')->paginate(10);
        } elseif ($tab == 'item') {
            $data['items'] = ItemLaundry::orderBy('id', 'asc')->paginate(10);
        } elseif ($tab == 'pencucian') {
            $data['pencucians'] = Pencucian::orderBy('id', 'asc')->paginate(10);
        } elseif ($tab == 'pengiriman') {
            $data['pengirimans'] = Pengiriman::orderBy('id', 'asc')->paginate(10);
        } elseif ($tab == 'promo') {
            $data['promos'] = Promo::orderBy('id', 'asc')->paginate(10);
        } elseif ($tab == 'satuan') {
            $data['satuans'] = MSatuan::orderBy('id', 'asc')->paginate(10);
        }

        return view('super_admin.data_master', array_merge(['tab' => $tab], $data));
    }
}
