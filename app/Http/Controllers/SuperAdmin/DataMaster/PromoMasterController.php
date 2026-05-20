<?php

namespace App\Http\Controllers\SuperAdmin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromoMasterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_promo' => 'required|string|max:255',
            'potongan' => 'required|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
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
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->back()->with('success', 'Promo berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_promo' => 'required|string|max:255',
            'potongan' => 'required|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
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
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->back()->with('success', 'Data Promo berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->back()->with('success', 'Promo berhasil dihapus!');
    }
}
