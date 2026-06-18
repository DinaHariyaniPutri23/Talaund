<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konfigurasi;
use Illuminate\Support\Facades\Storage;

class KonfigurasiController extends Controller
{
    public function index()
    {
        $konfigurasi = Konfigurasi::pluck('value', 'key')->toArray();
        return view('super_admin.konfigurasi', compact('konfigurasi'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', 'logo_toko']);

        foreach ($inputs as $key => $value) {
            Konfigurasi::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        if ($request->hasFile('logo_toko')) {
            $file = $request->file('logo_toko');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store in public/image directory to easily use asset()
            $file->move(public_path('image'), $filename);
            
            Konfigurasi::updateOrCreate(
                ['key' => 'logo_toko'],
                ['value' => 'image/' . $filename]
            );
        }

        return redirect()->back()->with('success', 'Konfigurasi berhasil disimpan!');
    }
}
