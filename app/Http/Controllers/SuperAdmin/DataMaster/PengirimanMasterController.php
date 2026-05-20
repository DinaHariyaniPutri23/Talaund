<?php

namespace App\Http\Controllers\SuperAdmin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengirimanMasterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pilihan_pengiriman' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah_pengiriman', true);
        }

        Pengiriman::create([
            'pilihan_pengiriman' => $request->pilihan_pengiriman,
        ]);

        return redirect()->back()->with('success', 'Jenis Pengiriman berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'pilihan_pengiriman' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit_pengiriman', $pengiriman->id);
        }

        $pengiriman->update([
            'pilihan_pengiriman' => $request->pilihan_pengiriman,
        ]);

        return redirect()->back()->with('success', 'Data Jenis Pengiriman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->delete();

        return redirect()->back()->with('success', 'Jenis Pengiriman berhasil dihapus!');
    }
}
