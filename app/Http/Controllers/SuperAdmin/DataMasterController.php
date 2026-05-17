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
use Illuminate\Support\Facades\Validator;

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
        }

        return view('super_admin.data_master', array_merge(['tab' => $tab], $data));
    }

    public function storePelanggan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon' => 'required|numeric|unique:pelanggan,no_telepon',
            'alamat' => 'required|string'
        ], [
            'no_telepon.numeric' => 'Nomor Telepon/WA harus berupa angka.',
            'no_telepon.unique' => 'Nomor Telepon/WA sudah terdaftar.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah', true);
        }

        Pelanggan::create([
            'nama_lengkap' => $request->nama_lengkap,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat
        ]);

        return redirect()->back()->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function updatePelanggan(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon' => 'required|numeric|unique:pelanggan,no_telepon,' . $pelanggan->id,
            'alamat' => 'required|string'
        ], [
            'no_telepon.numeric' => 'Nomor Telepon/WA harus berupa angka.',
            'no_telepon.unique' => 'Nomor Telepon/WA sudah terdaftar.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit', $pelanggan->id);
        }

        $pelanggan->update([
            'nama_lengkap' => $request->nama_lengkap,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat
        ]);

        return redirect()->back()->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroyPelanggan($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus!');
    }

    public function storeLayanan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255',
            'harga_layanan' => 'required|numeric|min:0'
        ], [
            'harga_layanan.numeric' => 'Harga Layanan harus berupa angka.',
            'harga_layanan.min' => 'Harga Layanan tidak boleh negatif.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah_layanan', true);
        }

        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'harga_layanan' => $request->harga_layanan
        ]);

        return redirect()->back()->with('success', 'Jenis Layanan berhasil ditambahkan!');
    }

    public function updateLayanan(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255',
            'harga_layanan' => 'required|numeric|min:0'
        ], [
            'harga_layanan.numeric' => 'Harga Layanan harus berupa angka.',
            'harga_layanan.min' => 'Harga Layanan tidak boleh negatif.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit_layanan', $layanan->id);
        }

        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'harga_layanan' => $request->harga_layanan
        ]);

        return redirect()->back()->with('success', 'Data Jenis Layanan berhasil diperbarui!');
    }

    public function destroyLayanan($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->back()->with('success', 'Jenis Layanan berhasil dihapus!');
    }

    public function storePencucian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pencucian' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0'
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah_pencucian', true);
        }

        Pencucian::create([
            'nama_pencucian' => $request->nama_pencucian,
            'harga' => $request->harga
        ]);

        return redirect()->back()->with('success', 'Jenis Pencucian berhasil ditambahkan!');
    }

    public function updatePencucian(Request $request, $id)
    {
        $pencucian = Pencucian::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_pencucian' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0'
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit_pencucian', $pencucian->id);
        }

        $pencucian->update([
            'nama_pencucian' => $request->nama_pencucian,
            'harga' => $request->harga
        ]);

        return redirect()->back()->with('success', 'Data Jenis Pencucian berhasil diperbarui!');
    }

    public function destroyPencucian($id)
    {
        $pencucian = Pencucian::findOrFail($id);
        $pencucian->delete();

        return redirect()->back()->with('success', 'Jenis Pencucian berhasil dihapus!');
    }

    public function storePengiriman(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pilihan_pengiriman' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah_pengiriman', true);
        }

        Pengiriman::create([
            'pilihan_pengiriman' => $request->pilihan_pengiriman
        ]);

        return redirect()->back()->with('success', 'Jenis Pengiriman berhasil ditambahkan!');
    }

    public function updatePengiriman(Request $request, $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'pilihan_pengiriman' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit_pengiriman', $pengiriman->id);
        }

        $pengiriman->update([
            'pilihan_pengiriman' => $request->pilihan_pengiriman
        ]);

        return redirect()->back()->with('success', 'Data Jenis Pengiriman berhasil diperbarui!');
    }

    public function destroyPengiriman($id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->delete();

        return redirect()->back()->with('success', 'Jenis Pengiriman berhasil dihapus!');
    }

    public function storeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_item' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0'
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah_item', true);
        }

        ItemLaundry::create([
            'nama_item' => $request->nama_item,
            'harga' => $request->harga
        ]);

        return redirect()->back()->with('success', 'Item Laundry berhasil ditambahkan!');
    }

    public function updateItem(Request $request, $id)
    {
        $item = ItemLaundry::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_item' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0'
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit_item', $item->id);
        }

        $item->update([
            'nama_item' => $request->nama_item,
            'harga' => $request->harga
        ]);

        return redirect()->back()->with('success', 'Data Item Laundry berhasil diperbarui!');
    }

    public function destroyItem($id)
    {
        $item = ItemLaundry::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item Laundry berhasil dihapus!');
    }

    public function storePromo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_promo' => 'required|string|max:255',
            'potongan' => 'required|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah_promo', true);
        }

        Promo::create([
            'nama_promo' => $request->nama_promo,
            'potongan' => $request->potongan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        return redirect()->back()->with('success', 'Promo berhasil ditambahkan!');
    }

    public function updatePromo(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_promo' => 'required|string|max:255',
            'potongan' => 'required|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit_promo', $promo->id);
        }

        $promo->update([
            'nama_promo' => $request->nama_promo,
            'potongan' => $request->potongan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        return redirect()->back()->with('success', 'Data Promo berhasil diperbarui!');
    }

    public function destroyPromo($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->back()->with('success', 'Promo berhasil dihapus!');
    }
}
