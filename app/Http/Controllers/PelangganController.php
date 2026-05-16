<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::orderBy('id_pelanggan', 'asc')->paginate(10);
        return view('kasir.pelanggan', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon' => 'required|string|unique:pelanggans,no_telepon|max:20',
            'alamat' => 'required|string'
        ], [
            'no_telepon.unique' => 'Nomor Telepon/WA sudah terdaftar di sistem.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', true);
        }

        Pelanggan::create([
            'nama_lengkap' => $request->nama_lengkap,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('dashboard.kasir.pelanggan')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20|unique:pelanggans,no_telepon,' . $pelanggan->id,
            'alamat' => 'required|string'
        ], [
            'no_telepon.unique' => 'Nomor Telepon/WA sudah terdaftar di sistem.'
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

        return redirect()->route('dashboard.kasir.pelanggan')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('dashboard.kasir.pelanggan')->with('success', 'Pelanggan berhasil dihapus!');
    }
}
