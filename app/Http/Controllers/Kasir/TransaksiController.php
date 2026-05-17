<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\ItemLaundry;
use App\Models\Layanan;
use App\Models\Pencucian;
use App\Models\Pengiriman;
use App\Models\Promo;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function create()
    {
        $data = [
            'pelanggans' => Pelanggan::orderBy('nama_lengkap', 'asc')->get(),
            'items' => ItemLaundry::orderBy('nama_item', 'asc')->get(),
            'layanans' => Layanan::orderBy('nama_layanan', 'asc')->get(),
            'pencucians' => Pencucian::orderBy('nama_pencucian', 'asc')->get(),
            'pengirimans' => Pengiriman::orderBy('id', 'asc')->get(),
            'promos' => Promo::orderBy('nama_promo', 'asc')->get()
        ];

        return view('kasir.transaksi', $data);
    }

    public function store(Request $request)
    {
        // Validasi input dasar
        $request->validate([
            'pelanggan_nama' => 'required|string|max:255',
            'pengiriman_id' => 'required|exists:jenis_pengiriman,id',
            'cart' => 'required|array|min:1',
            'total' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            // Logika Pintar Pelanggan: Cek atau Update atau Buat Baru
            $pelanggan_id = $request->pelanggan_id;
            
            if ($pelanggan_id) {
                // Update Pelanggan yang Ada (jika data berubah)
                $pelanggan = Pelanggan::find($pelanggan_id);
                if ($pelanggan) {
                    $pelanggan->update([
                        'nama_lengkap' => $request->pelanggan_nama,
                        'no_telepon' => $request->pelanggan_hp,
                        'alamat' => $request->pelanggan_alamat,
                    ]);
                } else {
                    throw new \Exception("Data pelanggan lama tidak ditemukan.");
                }
            } else {
                // Buat Pelanggan Baru
                $pelanggan = Pelanggan::create([
                    'nama_lengkap' => $request->pelanggan_nama,
                    'no_telepon' => $request->pelanggan_hp,
                    'alamat' => $request->pelanggan_alamat,
                ]);
                $pelanggan_id = $pelanggan->id;
            }

            // 1. Simpan Transaksi Utama
            $transaksi = Transaksi::create([
                'pelanggan_id' => $pelanggan_id,
                // Kita gunakan user id 1 (Kasir) jika auth belum siap, atau Auth::id()
                'user_id' => Auth::id() ?? 1, 
                'promo_id' => $request->promo_id > 0 ? $request->promo_id : null,
                'pengiriman_id' => $request->pengiriman_id,
                'tanggal_transaksi' => now(),
                'total_transaksi' => $request->total,
            ]);

            // 2. Simpan Detail Transaksi
            foreach ($request->cart as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'item_id' => $item['item_id'] ?? null,
                    'layanan_id' => $item['layanan_id'] ?? null,
                    'pencucian_id' => $item['pencucian_id'] ?? null,
                    'harga_unit' => $item['price'] ?? 0,
                    'total_berat' => $item['qty_num'] ?? 1,
                    'subtotal' => $item['price'] ?? 0,
                ]);
            }

            // 3. Simpan Data Pembayaran
            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'tanggal_bayar' => ($request->status_bayar == 'unpaid') ? null : now(),
                'metode_bayar' => 'tunai',
                'status_bayar' => $request->status_bayar ?? 'paid',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan!',
                'redirect_url' => route('dashboard.kasir.struk', $transaksi->id)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'pengguna', 'promo', 'pengiriman', 'detailTransaksi.itemLaundry', 'detailTransaksi.layanan', 'detailTransaksi.pencucian', 'pembayaran'])->findOrFail($id);
        
        return view('kasir.struk', compact('transaksi'));
    }

    public function lunasi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        if ($transaksi->pembayaran) {
            $transaksi->pembayaran->update([
                'status_bayar' => 'paid',
                'tanggal_bayar' => now()
            ]);
        }
        
        return redirect()->back()->with('success', 'Transaksi berhasil dilunasi!');
    }
}
