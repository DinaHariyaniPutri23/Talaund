<?php

namespace App\Http\Controllers\SuperAdmin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Pencucian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PencucianMasterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pencucian' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah_pencucian', true);
        }

        Pencucian::create([
            'nama_pencucian' => $request->nama_pencucian,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Jenis Pencucian berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pencucian = Pencucian::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_pencucian' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit_pencucian', $pencucian->id);
        }

        $pencucian->update([
            'nama_pencucian' => $request->nama_pencucian,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Data Jenis Pencucian berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pencucian = Pencucian::findOrFail($id);
        $pencucian->delete();

        return redirect()->back()->with('success', 'Jenis Pencucian berhasil dihapus!');
    }
}
