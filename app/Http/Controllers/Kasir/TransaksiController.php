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
use App\Models\MSatuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            $query->where(function($q) use ($search) {
                $q->whereHas('pelanggan', function ($q2) use ($search) {
                    $q2->where('nama_lengkap', 'like', "%$search%");
                })->orWhereRaw("CONCAT('INV-', LPAD(id, 5, '0')) LIKE ?", ["%{$search}%"]);
            });
        }

        // Date filter
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        
        if ($start_date) {
            $query->whereDate('tanggal_transaksi', '>=', $start_date);
        }

        if ($end_date) {
            $query->whereDate('tanggal_transaksi', '<=', $end_date);
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $status = $request->status;
            if ($status === 'lunas') {
                $query->whereHas('pembayaran', function($q) {
                    $q->where('status_bayar', 'paid');
                });
            } elseif ($status === 'pending') {
                $query->whereHas('pembayaran', function($q) {
                    $q->where('status_bayar', '!=', 'paid');
                });
            }
        }

        $transaksis = $query->paginate(15);

        // Summary cards data
        $userId = Auth::id() ?? 1;
        $totalTransaksi = Transaksi::where('user_id', $userId)->count();
        
        $transaksiLunas = Transaksi::where('user_id', $userId)->whereHas('pembayaran', function ($q) {
            $q->where('status_bayar', 'paid');
        })->count();
        
        $transaksiPending = Transaksi::where('user_id', $userId)->whereHas('pembayaran', function ($q) {
            $q->where('status_bayar', '!=', 'paid');
        })->count();
        
        // Total transaksi hari ini
        $startOfDay = now()->startOfDay()->utc();
        $endOfDay = now()->endOfDay()->utc();
        $totalHariIni = Transaksi::where('user_id', $userId)
            ->whereBetween('tanggal_transaksi', [$startOfDay, $endOfDay])
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
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $request->get('status')
        ]);
    }

    public function create()
    {
        $data = [
            'pelanggans' => Pelanggan::orderBy('nama_lengkap', 'asc')->get(),
            'items' => ItemLaundry::with(['layanan', 'pencucian', 'mSatuan'])->orderBy('nama_item', 'asc')->get(),
            'layanans' => Layanan::orderBy('nama_layanan', 'asc')->get(),
            'pencucians' => Pencucian::orderBy('nama_pencucian', 'asc')->get(),
            'pengirimans' => Pengiriman::orderBy('id', 'asc')->get(),
            'promos' => Promo::orderBy('nama_promo', 'asc')->get(),
            'satuans' => MSatuan::orderBy('nama_satuan', 'asc')->get(),
            'kendali' => \App\Models\FiturKendali::pluck('status', 'kode_fitur')->toArray(),
            'fitur_tambahan' => \App\Models\FiturKendali::whereNotIn('kode_fitur', ['modul_promo', 'modal_jenis_pengiriman'])
                                ->where('status', 'on')
                                ->get()
        ];

        return view('kasir.transaksi.create', $data);
    }

    // =========================================================================
    // TRANSAKSI MANUAL (CASH / BAYAR NANTI)
    // =========================================================================
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
            $pelanggan_id = $request->pelanggan_id;
            
            if ($pelanggan_id) {
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
                // Cek apakah nomor HP sudah ada di database untuk mencegah duplicate entry error
                $existingPelanggan = Pelanggan::where('no_telepon', $request->pelanggan_hp)->first();
                if ($existingPelanggan) {
                    $pelanggan_id = $existingPelanggan->id;
                    $existingPelanggan->update([
                        'nama_lengkap' => $request->pelanggan_nama,
                        'alamat' => $request->pelanggan_alamat,
                    ]);
                } else {
                    $pelanggan = Pelanggan::create([
                        'nama_lengkap' => $request->pelanggan_nama,
                        'no_telepon' => $request->pelanggan_hp,
                        'alamat' => $request->pelanggan_alamat,
                    ]);
                    $pelanggan_id = $pelanggan->id;
                }
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
        $konfigurasi = \App\Models\Konfigurasi::pluck('value', 'key')->toArray();
        
        $logoBase64 = null;
        if (isset($konfigurasi['logo_toko']) && file_exists(public_path($konfigurasi['logo_toko']))) {
            $type = pathinfo(public_path($konfigurasi['logo_toko']), PATHINFO_EXTENSION);
            $data = file_get_contents(public_path($konfigurasi['logo_toko']));
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        
        return view('kasir.struk', compact('transaksi', 'konfigurasi', 'logoBase64'));
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



    public function updatePembayaran(Request $request, $id)
    {
        $request->validate([
            'status_bayar' => 'required|in:paid,unpaid'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        if ($transaksi->pembayaran) {
            $transaksi->pembayaran->update([
                'status_bayar' => $request->status_bayar,
                'tanggal_bayar' => ($request->status_bayar == 'paid') ? now() : null
            ]);
        }

        session()->flash('success', 'Status pembayaran berhasil diupdate!');

        return response()->json([
            'success' => true,
            'message' => 'Status pembayaran berhasil diupdate!'
        ]);
    }

    // =========================================================================
    // INTEGRASI BARU: GENERATE INVOICE XENDIT VIA BACKEND
    // =========================================================================
    // =========================================================================
    // INTEGRASI BARU: GENERATE INVOICE XENDIT VIA BACKEND
    // =========================================================================
    public function buatInvoiceXendit(Request $request)
    {
        $request->validate([
            'pelanggan_nama' => 'required|string|max:255',
            'pengiriman_id'  => 'required|exists:jenis_pengiriman,id',
            'cart'           => 'required|array|min:1',
            'total'          => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat ID Invoice unik untuk dikirim ke Xendit (Tidak perlu disimpan ke DB)
            $external_id = 'MILA-' . time() . '-' . rand(100, 999);
            $total_pembayaran = (int)$request->total;

            // 2. Request ke API Xendit Invoices
            $response = Http::withBasicAuth(env('XENDIT_SECRET_KEY'), '')
                ->post('https://api.xendit.co/v2/invoices', [
                    'external_id' => $external_id,
                    'amount'      => $total_pembayaran,
                    'description' => 'Pembayaran Laundry - ' . $request->pelanggan_nama,
                    'customer'    => [
                        'given_names'   => $request->pelanggan_nama,
                        'mobile_number' => $request->pelanggan_hp,
                    ],
                    'customer_notification_preference' => [
                        'invoice_created' => ['whatsapp', 'sms']
                    ],
                    'currency' => 'IDR'
                ]);

            // 3. Cek Respons API
            if ($response->successful()) {
                $responseData = $response->json();
                $invoice_url = $responseData['invoice_url'];

                // 4. Proses Simpan Data Pelanggan
                $pelanggan_id = $request->pelanggan_id;
                if (!$pelanggan_id) {
                    $existingPelanggan = Pelanggan::where('no_telepon', $request->pelanggan_hp)->first();
                    if ($existingPelanggan) {
                        $pelanggan_id = $existingPelanggan->id;
                        $existingPelanggan->update([
                            'nama_lengkap' => $request->pelanggan_nama,
                            'alamat'       => $request->pelanggan_alamat,
                        ]);
                    } else {
                        $pelanggan = Pelanggan::create([
                            'nama_lengkap' => $request->pelanggan_nama,
                            'no_telepon'   => $request->pelanggan_hp,
                            'alamat'       => $request->pelanggan_alamat,
                        ]);
                        $pelanggan_id = $pelanggan->id;
                    }
                } else {
                    Pelanggan::where('id', $pelanggan_id)->update([
                        'nama_lengkap' => $request->pelanggan_nama,
                        'no_telepon'   => $request->pelanggan_hp,
                        'alamat'       => $request->pelanggan_alamat,
                    ]);
                }

                // 5. Simpan Data Transaksi Utama (Simpan URL ke snap_token)
                $transaksi = Transaksi::create([
                    'pelanggan_id'      => $pelanggan_id,
                    'user_id'           => Auth::id() ?? 1, 
                    'promo_id'          => $request->promo_id > 0 ? $request->promo_id : null,
                    'pengiriman_id'     => $request->pengiriman_id,
                    'tanggal_transaksi' => now(),
                    'total_transaksi'   => $total_pembayaran,
                    'snap_token'        => $invoice_url, // Menyimpan link Xendit ke sini
                ]);

                // 6. Simpan Detail Item Keranjang
                foreach ($request->cart as $item) {
                    DetailTransaksi::create([
                        'transaksi_id'  => $transaksi->id,
                        'item_id'       => $item['item_id'] ?? null,
                        'layanan_id'    => $item['layanan_id'] ?? null,
                        'pencucian_id'  => $item['pencucian_id'] ?? null,
                        'harga_unit'    => $item['unitPrice'] ?? ($item['price'] ?? 0),
                        'total_berat'   => $item['qty_num'] ?? 1,
                        'subtotal'      => $item['price'] ?? 0,
                    ]);
                }

                // 7. Simpan Riwayat Pembayaran (Status Pending & id_xendit)
                Pembayaran::create([
                    'transaksi_id'  => $transaksi->id,
                    'id_xendit'     => $responseData['id'], // Kunci referensi callback nantinya
                    'metode_bayar'  => 'Xendit Invoice',
                    'status_bayar'  => 'pending', 
                ]);

                DB::commit();

                // 8. Kirim link Invoice ke frontend untuk dibuka di tab baru
                return response()->json([
                    'success' => true,
                    'invoice_url' => $invoice_url
                ]);

            } else {
                DB::rollBack();
                Log::error('Xendit Request Gagal: ' . $response->body());
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat link Xendit: ' . $response->json('message', 'Terjadi kesalahan pada server Xendit.')
                ], 500);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Controller Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sistem gagal memproses transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    // =========================================================================
    // INTEGRASI BARU: WEBHOOK CALLBACK PAID AUTOMATION
    // =========================================================================
    public function handleCallback(Request $request)
    {
        try {
            // 1. Catat semua data yang masuk dari Xendit ke file log Laravel
            // Bisa dicek di file storage/logs/laravel.log jika terjadi error
            Log::info('Webhook Xendit Masuk:', $request->all());

            // 2. Amankan webhook (Komentar baris if di bawah jika error 401 saat testing)
            $xenditXCallbackToken = env('XENDIT_WEBHOOK_TOKEN'); 
            if ($xenditXCallbackToken && $request->header('x-callback-token') !== $xenditXCallbackToken) {
                Log::warning('Token Callback Xendit Tidak Valid!');
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // 3. Ambil data dari payload INVOICE
            $id_invoice_xendit = $request->id;
            $status = $request->status;

            // Jika yang masuk bukan invoice (misal salah pasang URL di dashboard), abaikan agar tidak error 500
            if (!$id_invoice_xendit) {
                Log::warning('Bukan payload Invoice. Mengabaikan request.');
                return response()->json(['status' => 'IGNORED']);
            }

            // 4. Cari data pembayaran di database kita
            $pembayaran = Pembayaran::where('id_xendit', $id_invoice_xendit)->first();

            if ($pembayaran) {
                if ($status === 'PAID' || $status === 'SETTLED') {
                    $pembayaran->update([
                        'status_bayar' => 'paid',
                        'tanggal_bayar' => now()
                    ]);
                    Log::info("Pembayaran dengan ID Xendit {$id_invoice_xendit} BERHASIL LUNAS.");
                    
                } else if ($status === 'EXPIRED') {
                    $pembayaran->update([
                        'status_bayar' => 'failed/expired'
                    ]);
                    Log::info("Pembayaran dengan ID Xendit {$id_invoice_xendit} KEDALUWARSA.");
                }
            } else {
                Log::error("Pembayaran dengan ID Xendit {$id_invoice_xendit} TIDAK DITEMUKAN di database.");
            }

            return response()->json(['status' => 'CALLBACK_ACCEPTED']);

        } catch (\Exception $e) {
            // Jika ada kode yang error, catat di log dan kembalikan response 500
            Log::error('Error pada Callback Xendit: ' . $e->getMessage());
            return response()->json(['status' => 'ERROR', 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // FITUR AUTO-REFRESH (AJAX POLLING) UNTUK HALAMAN MONITORING
    // =========================================================================
    public function checkStatus(Request $request)
    {
        try {
            $ids = $request->ids; 
            
            // Cek apakah data yang dikirim kosong atau bukan array
            if (empty($ids) || !is_array($ids)) {
                return response()->json([]);
            }

            // Gunakan path model secara eksplisit untuk mencegah error "Class not found"
            $pembayarans = \App\Models\Pembayaran::whereIn('transaksi_id', $ids)
                ->get(['transaksi_id', 'status_bayar']);
            
            return response()->json($pembayarans);

        } catch (\Exception $e) {
            // Catat error aslinya ke log Laravel agar mudah dilacak
            \Illuminate\Support\Facades\Log::error('Error Check Status: ' . $e->getMessage());
            
            // Kembalikan array kosong agar JavaScript tidak crash
            return response()->json([]); 
        }
    }
}