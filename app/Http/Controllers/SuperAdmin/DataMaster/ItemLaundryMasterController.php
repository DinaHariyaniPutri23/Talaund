<?php

namespace App\Http\Controllers\SuperAdmin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\ItemLaundry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemLaundryMasterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_item' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah_item', true);
        }

        ItemLaundry::create([
            'nama_item' => $request->nama_item,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Item Laundry berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $item = ItemLaundry::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_item' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit_item', $item->id);
        }

        $item->update([
            'nama_item' => $request->nama_item,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Data Item Laundry berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $item = ItemLaundry::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item Laundry berhasil dihapus!');
    }
}
