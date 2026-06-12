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
use App\Models\DetailTransaksi; // <-- Sudah Pasti Ada
use App\Models\Pembayaran;      // <-- Sudah Pasti Ada
use App\Models\MSatuan;
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
            'items' => ItemLaundry::with(['layanan', 'pencucian'])->orderBy('nama_item', 'asc')->get(),
            'layanans' => Layanan::orderBy('nama_layanan', 'asc')->get(),
            'pencucians' => Pencucian::orderBy('nama_pencucian', 'asc')->get(),
            'pengirimans' => Pengiriman::orderBy('id', 'asc')->get(),
            'promos' => Promo::orderBy('nama_promo', 'asc')->get(),
            'satuans' => MSatuan::orderBy('nama_satuan', 'asc')->get()
        ];

        return view('kasir.transaksi.create', $data);
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
                    'harga_unit' => $item['unitPrice'] ?? ($item['price'] ?? 0),
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

    // =========================================================================
    // INTEGRASI BARU: GENERATE DYNAMIC QRIS XENDIT VIA BACKEND (METODE cURL AMAN)
    // =========================================================================
    public function buatQrisDinamis(Request $request)
    {
        $request->validate([
            'pelanggan_nama' => 'required|string|max:255',
            'pengiriman_id' => 'required|exists:jenis_pengiriman,id',
            'cart' => 'required|array|min:1',
            'total' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            // Logika Pelanggan
            $pelanggan_id = $request->pelanggan_id;
            if (!$pelanggan_id) {
                $pelanggan = Pelanggan::create([
                    'nama_lengkap' => $request->pelanggan_nama,
                    'no_telepon' => $request->pelanggan_hp,
                    'alamat' => $request->pelanggan_alamat,
                ]);
                $pelanggan_id = $pelanggan->id;
            } else {
                $pelanggan = Pelanggan::find($pelanggan_id);
                if ($pelanggan) {
                    $pelanggan->update([
                        'nama_lengkap' => $request->pelanggan_nama,
                        'no_telepon' => $request->pelanggan_hp,
                        'alamat' => $request->pelanggan_alamat,
                    ]);
                }
            }

            // Simpan Transaksi Utama
            $transaksi = Transaksi::create([
                'pelanggan_id' => $pelanggan_id,
                'user_id' => Auth::id() ?? 1, 
                'promo_id' => $request->promo_id > 0 ? $request->promo_id : null,
                'pengiriman_id' => $request->pengiriman_id,
                'tanggal_transaksi' => now(),
                'total_transaksi' => $request->total,
            ]);

            // Simpan Detail Transaksi
            foreach ($request->cart as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'item_id' => $item['item_id'] ?? null,
                    'layanan_id' => $item['layanan_id'] ?? null,
                    'pencucian_id' => $item['pencucian_id'] ?? null,
                    'harga_unit' => $item['unitPrice'] ?? ($item['price'] ?? 0),
                    'total_berat' => $item['qty_num'] ?? 1,
                    'subtotal' => $item['price'] ?? 0,
                ]);
            }

            $id_nota_lokal = 'MILA-' . $transaksi->id . '-' . now()->timestamp;
            
            // Mengambil Secret Key langsung dari .env agar dinamis dan menghindari typo
            $secret_key = env('XENDIT_SECRET_KEY');

            // Kita tentukan callback url berdasarkan APP_URL dari .env secara paksa
            // Jangan pakai url() karena akan mengikuti browser user (misal laragon.test) yang ditolak Xendit
            $app_url = rtrim(env('APP_URL', 'http://localhost'), '/');
            $callback_url = $app_url . '/api/callback-xendit';
            
            // Konfigurasi Payload Xendit
            $payload = [
                'external_id' => $id_nota_lokal,
                'type' => 'DYNAMIC',
                'amount' => (int)$request->total,
            ];

            // Tambahkan callback_url ke payload hanya jika menggunakan domain asli / ngrok (bukan localhost)
            // Karena Xendit akan menolak request jika URL-nya localhost/127.0.0.1
            if (!str_contains($callback_url, 'localhost') && !str_contains($callback_url, '127.0.0.1')) {
                $payload['callback_url'] = $callback_url;
            }

            $ch = curl_init();
            
            \Illuminate\Support\Facades\Log::info('Xendit Payload:', $payload);
            \Illuminate\Support\Facades\Log::info('Xendit URL: ' . $callback_url);

            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://api.xendit.co/qr_codes',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_USERPWD => $secret_key . ':',
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_POSTFIELDS => json_encode($payload)
            ]);

            $responseXendit = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $responseData = json_decode($responseXendit, true);

            if ($httpCode !== 200 && $httpCode !== 201) {
                throw new \Exception($responseData['message'] ?? 'Respon Xendit API bermasalah.');
            }

            // Simpan Data Pembayaran awal (Status: unpaid)
            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'id_xendit' => $responseData['id'], 
                'tanggal_bayar' => null,
                'metode_bayar' => 'QRIS Cashless',
                'status_bayar' => 'unpaid',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'qr_data' => $responseData['qr_string']
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('QRIS Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses QRIS Xendit: ' . $e->getMessage()
            ], 500);
        }
    }

    // =========================================================================
    // INTEGRASI BARU: WEBHOOK CALLBACK PAID AUTOMATION
    // =========================================================================
    public function handleCallback(Request $request)
    {
        $id_qris_xendit = $request->id;
        $status_dari_xendit = $request->status;

        if ($status_dari_xendit == 'COMPLETED' || $status_dari_xendit == 'PAID') {
            $pembayaran = Pembayaran::where('id_xendit', $id_qris_xendit)->first();
            if ($pembayaran) {
                $pembayaran->update([
                    'status_bayar' => 'paid',
                    'tanggal_bayar' => now()
                ]);
            }
        }

        return response()->json(['status' => 'CALLBACK_ACCEPTED']);
    }
}