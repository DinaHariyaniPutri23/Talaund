<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }} - MilaLaundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400&display=swap');
        
        body {
            background-color: #f3f4f6;
            font-family: 'Courier Prime', monospace;
            padding: 2rem 1rem;
        }

        .receipt-container {
            width: 100%;
            max-width: 380px; /* ~80mm thermal paper width */
            background-color: white;
            margin: 0 auto;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        /* Zig-zag border top and bottom to simulate torn paper */
        .receipt-container::before, .receipt-container::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            height: 8px;
            background-size: 16px 16px;
        }
        .receipt-container::before {
            top: -8px;
            background-image: radial-gradient(circle at 8px 0, transparent 8px, white 9px);
        }
        .receipt-container::after {
            bottom: -8px;
            background-image: radial-gradient(circle at 8px 16px, transparent 8px, white 9px);
        }

        .dashed-line {
            border-top: 1.5px dashed #000;
            margin: 0.75rem 0;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none !important;
            }
            .receipt-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                max-width: 100%;
            }
            .receipt-container::before, .receipt-container::after {
                display: none;
            }
        }
    </style>
</head>
<body class="text-black text-sm">

    <!-- Kontrol Aksi (Tidak Ikut Tercetak) -->
    <div class="max-w-[380px] mx-auto flex gap-3 mb-6 no-print">
        <a href="{{ route('dashboard.kasir.transaksi') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-center font-bold py-3 rounded-lg transition-colors text-sm">
            &laquo; KEMBALI
        </a>
        <button onclick="window.print()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center font-bold py-3 rounded-lg transition-colors text-sm flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            CETAK NOTA
        </button>
    </div>

    <!-- Kertas Struk -->
    <div class="receipt-container">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="font-bold text-xl mb-1">MILA LAUNDRY</h1>
            <p class="text-xs leading-relaxed">
                Jl. Raya Kebersihan No. 99<br>
                Telp: 0812-3456-7890<br>
                IG: @milalaundry
            </p>
        </div>

        <div class="dashed-line"></div>

        <!-- Info Transaksi -->
        <div class="text-xs mb-3 space-y-1">
            <div class="flex justify-between">
                <span>Nota:</span>
                <span class="font-bold">INV-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tgl:</span>
                <span>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir:</span>
                <span>{{ $transaksi->pengguna->nama ?? 'Kasir' }}</span>
            </div>
            <div class="flex justify-between mt-2">
                <span>Plgn:</span>
                <span class="font-bold uppercase text-right">{{ $transaksi->pelanggan->nama_lengkap }}</span>
            </div>
            <div class="flex justify-between">
                <span>No HP:</span>
                <span>{{ $transaksi->pelanggan->no_telepon }}</span>
            </div>
        </div>

        <div class="dashed-line"></div>

        <!-- Detail Item -->
        <div class="text-xs space-y-3">
            @foreach($transaksi->detailTransaksi as $detail)
            <div>
                <!-- Baris Nama Item -->
                <div class="font-bold uppercase">
                    {{ $detail->itemLaundry->nama_item ?? 'Item' }} 
                    @if($detail->pencucian)
                        ({{ $detail->pencucian->nama_pencucian }})
                    @endif
                </div>
                <!-- Baris Layanan -->
                @if($detail->layanan)
                <div class="pl-2">- LYN: {{ $detail->layanan->nama_layanan }}</div>
                @endif
                <!-- Baris Qty dan Subtotal -->
                <div class="flex justify-between pl-2 mt-1">
                    <span>
                        {{ number_format($detail->total_berat, 1) }} x {{ number_format($detail->harga_unit, 0, ',', '.') }}
                    </span>
                    <span>{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="dashed-line"></div>

        <!-- Ringkasan Total -->
        <div class="text-xs space-y-1">
            <div class="flex justify-between">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($transaksi->detailTransaksi->sum('subtotal'), 0, ',', '.') }}</span>
            </div>

            @if($transaksi->promo_id && $transaksi->promo)
            <div class="flex justify-between text-black">
                <span>Diskon ({{ $transaksi->promo->nama_promo }}):</span>
                <span>-Rp {{ number_format($transaksi->promo->potongan, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="flex justify-between">
                <span>Pengiriman:</span>
                <span class="uppercase">{{ $transaksi->pengiriman->pilihan_pengiriman ?? '-' }}</span>
            </div>
        </div>
        
        <div class="dashed-line"></div>

        <!-- Total Akhir & Status -->
        <div class="flex justify-between items-center my-3">
            <span class="font-bold text-sm">TOTAL:</span>
            <span class="font-bold text-lg">Rp {{ number_format($transaksi->total_transaksi, 0, ',', '.') }}</span>
        </div>

        <div class="text-center text-xs mt-1">
            @if(optional($transaksi->pembayaran)->status_bayar == 'paid')
                <span class="border border-black px-2 py-0.5 rounded uppercase font-bold tracking-widest">
                    {{ $transaksi->pembayaran->metode_bayar ?? 'TUNAI' }} - LUNAS
                </span>
            @else
                <span class="border border-black px-2 py-0.5 rounded uppercase font-bold tracking-widest bg-black text-white">
                    BELUM LUNAS
                </span>
            @endif
        </div>

        <div class="dashed-line"></div>

        <!-- Footer -->
        <div class="text-center text-xs mt-4 space-y-1">
            <p>Terima Kasih Atas Kepercayaan Anda!</p>
            <p>Barang yang tidak diambil > 1 bulan</p>
            <p>bukan tanggung jawab kami.</p>
            <p class="mt-3 opacity-60">* SIMPAN STRUK INI *</p>
        </div>
    </div>

</body>
</html>
