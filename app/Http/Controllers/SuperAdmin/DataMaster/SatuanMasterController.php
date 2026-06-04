<?php

namespace App\Http\Controllers\SuperAdmin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\MSatuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SatuanMasterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_satuan' => 'required|string|max:255|unique:msatuan,nama_satuan',
        ], [
            'nama_satuan.required' => 'Nama Satuan harus diisi.',
            'nama_satuan.unique' => 'Nama Satuan sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah_satuan', true);
        }

        MSatuan::create([
            'nama_satuan' => $request->nama_satuan,
        ]);

        return redirect()->back()->with('success', 'Satuan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $satuan = MSatuan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_satuan' => 'required|string|max:255|unique:msatuan,nama_satuan,' . $id,
        ], [
            'nama_satuan.required' => 'Nama Satuan harus diisi.',
            'nama_satuan.unique' => 'Nama Satuan sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit_satuan', $satuan->id);
        }

        $satuan->update([
            'nama_satuan' => $request->nama_satuan,
        ]);

        return redirect()->back()->with('success', 'Data Satuan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $satuan = MSatuan::findOrFail($id);
        $satuan->delete();

        return redirect()->back()->with('success', 'Satuan berhasil dihapus!');
    }
}
