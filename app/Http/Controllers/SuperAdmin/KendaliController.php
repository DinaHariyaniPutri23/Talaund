<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FiturKendali;

class KendaliController extends Controller
{
    public function index()
    {
        $fiturs = FiturKendali::all();
        return view('super_admin.kendali', compact('fiturs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fitur' => 'required|string|max:255',
            'kode_fitur' => 'required|string|max:255|unique:fitur_kendalis,kode_fitur',
            'deskripsi' => 'nullable|string'
        ]);

        FiturKendali::create([
            'nama_fitur' => $request->nama_fitur,
            'kode_fitur' => \Str::slug($request->kode_fitur, '_'),
            'deskripsi' => $request->deskripsi,
            'status' => 'off'
        ]);

        return redirect()->back()->with('success', 'Fitur baru berhasil ditambahkan!');
    }

    public function updateInfo(Request $request, $id)
    {
        $request->validate([
            'nama_fitur' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $fitur = FiturKendali::findOrFail($id);
        $fitur->update([
            'nama_fitur' => $request->nama_fitur,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Informasi fitur berhasil diperbarui!');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $value = $request->input('value'); // 'on' or 'off'

        $fitur = FiturKendali::findOrFail($id);
        $fitur->update(['status' => $value]);

        return response()->json([
            'success' => true,
            'message' => 'Status fitur berhasil diperbarui!'
        ]);
    }

    public function destroy($id)
    {
        $fitur = FiturKendali::findOrFail($id);
        
        // Cek fitur wajib (opsional jika ada fitur wajib)
        $wajib = ['modul_promo', 'modul_kurir'];
        if (in_array($fitur->kode_fitur, $wajib)) {
            return redirect()->back()->with('error', 'Fitur bawaan sistem tidak dapat dihapus!');
        }

        $fitur->delete();

        return redirect()->back()->with('success', 'Fitur berhasil dihapus!');
    }
}
