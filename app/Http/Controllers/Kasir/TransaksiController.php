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
    public function index(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'pengguna', 'pembayaran'])
            ->orderBy('tanggal_transaksi', 'desc');

        // Filter berdasarkan kasir (user) yang login
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        }

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('pelanggan', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%$search%");
            })->orWhere(DB::raw("CONCAT('INV-', LPAD(id, 5, '0'))"), 'like', "%$search%");
        }

        // Date filter
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('tanggal_transaksi', $request->date);
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $status = $request->status;
            $query->whereHas('pembayaran', function ($q) use ($status) {
                $q->where('status_bayar', $status);
            });
        }

        $transaksis = $query->paginate(15);

        // Summary cards data
        $baseQuery = Transaksi::where('user_id', Auth::id() ?? 1);
        $totalTransaksi = $baseQuery->count();
        $transaksiLunas = $baseQuery->whereHas('pembayaran', function ($q) {
            $q->where('status_bayar', 'paid');
        })->count();
        $transaksiPending = $baseQuery->whereHas('pembayaran', function ($q) {
            $q->where('status_bayar', 'unpaid');
        })->count();
        
        // Total transaksi hari ini
        $totalHariIni = $baseQuery->whereDate('tanggal_transaksi', today())
            ->whereHas('pembayaran', function ($q) {
                $q->where('status_bayar', 'paid');
            })
            ->sum('total_transaksi');

        return view('kasir.transaksi.index', [
            'transaksis' => $transaksis,
            'totalTransaksi' => $totalTransaksi,
            'transaksiLunas' => $transaksiLunas,
            'transaksiPending' => $transaksiPending,
            'totalHariIni' => $totalHariIni,
            'search' => $request->get('search'),
            'date' => $request->get('date'),
            'status' => $request->get('status')
        ]);
    }

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

        return view('kasir.transaksi.create', $data);
    }

    public function editItemsPage($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'detailTransaksi.itemLaundry', 'detailTransaksi.layanan', 'detailTransaksi.pencucian', 'pengiriman', 'pembayaran'])->findOrFail($id);

        if ($transaksi->status_transaksi !== 'pending') {
            return redirect()->route('dashboard.kasir.transaksi')->with('success', 'Item hanya bisa diedit untuk transaksi yang masih pending.');
        }

        $data = [
            'transaksi' => $transaksi,
            'items' => ItemLaundry::orderBy('nama_item', 'asc')->get(),
            'layanans' => Layanan::orderBy('nama_layanan', 'asc')->get(),
            'pencucians' => Pencucian::orderBy('nama_pencucian', 'asc')->get(),
            'pengirimans' => Pengiriman::orderBy('id', 'asc')->get(),
            'promos' => Promo::orderBy('nama_promo', 'asc')->get(),
        ];

        return view('kasir.transaksi.edit-items', $data);
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

    // Method untuk edit pembayaran (ubah status bayar dan metode)
    public function updatePembayaran(Request $request, $id)
    {
        $request->validate([
            'status_bayar' => 'required|in:paid,unpaid',
            'metode_bayar' => 'required|string'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        
        if ($transaksi->pembayaran) {
            $transaksi->pembayaran->update([
                'status_bayar' => $request->status_bayar,
                'metode_bayar' => $request->metode_bayar,
                'tanggal_bayar' => ($request->status_bayar == 'paid') ? now() : null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diupdate!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data pembayaran tidak ditemukan'
        ], 404);
    }

    // Method untuk void transaksi (batalkan dengan alasan)
    public function voidTransaksi(Request $request, $id)
    {
        $request->validate([
            'alasan_void' => 'required|string|max:500'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        // Hanya bisa void jika PENDING atau DIPROSES, tidak SELESAI
        if ($transaksi->status_transaksi === 'selesai') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa membatalkan transaksi yang sudah selesai!'
            ], 422);
        }

        $transaksi->update([
            'status_transaksi' => 'void',
            'alasan_void' => $request->alasan_void,
            'void_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibatalkan!'
        ]);
    }

    // Method untuk edit items (hanya untuk PENDING)
    public function editItems(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Hanya bisa edit items jika PENDING
        if ($transaksi->status_transaksi !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya bisa edit items untuk transaksi yang masih PENDING!'
            ], 422);
        }

        $request->validate([
            'cart' => 'required|array|min:1',
            'total' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            // Hapus detail transaksi lama
            DetailTransaksi::where('transaksi_id', $id)->delete();

            // Insert detail transaksi baru
            foreach ($request->cart as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $id,
                    'item_id' => $item['item_id'] ?? null,
                    'layanan_id' => $item['layanan_id'] ?? null,
                    'pencucian_id' => $item['pencucian_id'] ?? null,
                    'harga_unit' => $item['price'] ?? 0,
                    'total_berat' => $item['qty_num'] ?? 1,
                    'subtotal' => $item['price'] ?? 0,
                ]);
            }

            // Update total transaksi
            $transaksi->update(['total_transaksi' => $request->total]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Items berhasil diupdate!',
                'redirect_url' => route('dashboard.kasir.struk', $id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate items: ' . $e->getMessage()
            ], 500);
        }
    }
}
