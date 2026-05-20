<?php

namespace App\Http\Controllers\SuperAdmin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LayananMasterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255',
            'harga_layanan' => 'required|numeric|min:0',
        ], [
            'harga_layanan.numeric' => 'Harga Layanan harus berupa angka.',
            'harga_layanan.min' => 'Harga Layanan tidak boleh negatif.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah_layanan', true);
        }

        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'harga_layanan' => $request->harga_layanan,
        ]);

        return redirect()->back()->with('success', 'Jenis Layanan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255',
            'harga_layanan' => 'required|numeric|min:0',
        ], [
            'harga_layanan.numeric' => 'Harga Layanan harus berupa angka.',
            'harga_layanan.min' => 'Harga Layanan tidak boleh negatif.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit_layanan', $layanan->id);
        }

        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'harga_layanan' => $request->harga_layanan,
        ]);

        return redirect()->back()->with('success', 'Data Jenis Layanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->back()->with('success', 'Jenis Layanan berhasil dihapus!');
    }
}
