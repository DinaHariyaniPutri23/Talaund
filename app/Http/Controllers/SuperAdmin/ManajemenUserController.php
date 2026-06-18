<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManajemenUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Pengguna::query();
        
        if ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('peran', 'like', "%{$search}%");
        }
        
        $users = $query->orderBy('id', 'desc')->paginate(10);
        return view('super_admin.manajemen_user', compact('users', 'search'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'kata_sandi' => 'required|string|min:6',
            'peran' => 'required|in:super_admin,kasir,pemilik',
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'kata_sandi.min' => 'Kata sandi minimal 6 karakter.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_tambah', true);
        }

        Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'kata_sandi' => Hash::make($request->kata_sandi),
            'peran' => $request->peran,
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $pengguna->id,
            'kata_sandi' => 'nullable|string|min:6',
            'peran' => 'required|in:super_admin,kasir,pemilik',
        ], [
            'email.unique' => 'Email ini sudah terdaftar oleh pengguna lain.',
            'kata_sandi.min' => 'Kata sandi minimal 6 karakter.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_edit', $pengguna->id);
        }

        $dataUpdate = [
            'nama' => $request->nama,
            'email' => $request->email,
            'peran' => $request->peran,
        ];

        // Update password only if provided
        if (!empty($request->kata_sandi)) {
            $dataUpdate['kata_sandi'] = Hash::make($request->kata_sandi);
        }

        $pengguna->update($dataUpdate);

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        
        // Prevent deleting oneself
        if (auth()->id() == $pengguna->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $pengguna->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }
}
