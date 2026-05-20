<?php

namespace App\Http\Controllers\SuperAdmin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganMasterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon' => 'required|numeric|unique:pelanggan,no_telepon',
            'alamat' => 'required|string',
        ], [
            'no_telepon.numeric' => 'Nomor Telepon/WA harus berupa angka.',
            'no_telepon.unique' => 'Nomor Telepon/WA sudah terdaftar.',
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
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon' => 'required|numeric|unique:pelanggan,no_telepon,' . $pelanggan->id,
            'alamat' => 'required|string',
        ], [
            'no_telepon.numeric' => 'Nomor Telepon/WA harus berupa angka.',
            'no_telepon.unique' => 'Nomor Telepon/WA sudah terdaftar.',
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
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus!');
    }
}
