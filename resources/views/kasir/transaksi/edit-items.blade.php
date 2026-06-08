@extends('layouts.dashboard')

@section('title', 'Edit Items Transaksi')
@section('header_title', 'Transaksi')
@section('header_subtitle', 'Tambah, hapus, atau ubah item untuk transaksi yang masih pending.')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Edit Items Transaksi</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">INV-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</h3>
                <p class="text-sm text-gray-500 mt-1">Pelanggan: <span class="font-medium text-gray-700">{{ $transaksi->pelanggan->nama_lengkap ?? '-' }}</span></p>
                <p class="text-sm text-gray-500">No. HP: <span class="font-medium text-gray-700">{{ $transaksi->pelanggan->no_telepon ?? '-' }}</span></p>
            </div>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Status: {{ strtoupper($transaksi->status_transaksi ?? 'pending') }}</span>
                <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">{{ optional($transaksi->tanggal_transaksi)->format('d M Y H:i') }}</span>
                <a href="{{ route('dashboard.kasir.struk', $transaksi->id) }}" target="_blank" class="px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors">Lihat Struk</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 md:p-8 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100">
            <h3 class="text-sm font-bold text-gray-400 tracking-wider uppercase mb-6">Langkah 1: Ubah / Tambah Item</h3>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">1. Pilih Item</label>
                    <div class="relative">
                        <select id="item-select" class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer">
                            <option value="" data-price="0" data-nama="">-- Pilih Item --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->harga }}" data-nama="{{ $item->nama_item }}">{{ $item->nama_item }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">2. Jenis Pencucian</label>
                    <div class="relative">
                        <select id="pencucian-select" class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer">
                            <option value="" data-harga="0">-- Pilih Pencucian --</option>
                            @foreach($pencucians as $pencucian)
                                <option value="{{ $pencucian->id }}" data-harga="{{ $pencucian->harga }}">{{ $pencucian->nama_pencucian }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">3. Jenis Layanan</label>
                    <div class="relative">
                        <select id="layanan-select" class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer">
                            <option value="" data-harga="0">-- Pilih Layanan --</option>
                            @foreach($layanans as $layanan)
                                <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga_layanan }}">{{ $layanan->nama_layanan }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">4. Berat / Jumlah</label>
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <input id="qty-input" type="number" class="block w-full sm:w-24 pl-4 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all text-center" value="1" min="1">

                        <div class="relative w-full sm:w-32">
                            <select id="unit-select" class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer">
                                <option value="pcs">Pcs</option>
                                <option value="kg">Kg</option>
                                <option value="pasang">Pasang</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <button id="btn-tambah" type="button" class="w-full sm:flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-bold text-sm transition-all shadow-sm mt-3 sm:mt-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            TAMBAH ITEM
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex flex-col">
            <h3 class="text-sm font-bold text-gray-400 tracking-wider uppercase mb-6">Langkah 2: Ringkasan Perubahan</h3>

            <div class="space-y-3 mb-4 pb-4 border-b border-gray-100 text-sm text-gray-600">
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Nama Pelanggan</span>
                    <span class="font-medium text-gray-800 text-right">{{ $transaksi->pelanggan->nama_lengkap ?? '-' }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Status Pembayaran</span>
                    <span class="font-medium text-gray-800 text-right">{{ optional($transaksi->pembayaran)->status_bayar === 'paid' ? 'Lunas' : 'Belum Lunas' }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Metode Bayar</span>
                    <span class="font-medium text-gray-800 text-right">{{ strtoupper(optional($transaksi->pembayaran)->metode_bayar ?? 'tunai') }}</span>
                </div>
            </div>

            <div id="cart-container" class="flex-1 overflow-y-auto no-scrollbar mb-6 min-h-[150px]">
                <div id="empty-cart-msg" class="text-center text-gray-400 text-sm mt-10 italic">
                    Belum ada item ditambahkan.
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-gray-100 border-dashed">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 font-medium">Subtotal:</span>
                    <span id="subtotal-display" class="text-sm font-bold text-gray-800">Rp 0</span>
                </div>
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-200">
                    <span class="text-base font-black text-gray-800 tracking-wide">TOTAL:</span>
                    <span id="total-display" class="text-xl font-black text-blue-600">Rp 0</span>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('dashboard.kasir.transaksi') }}" class="py-3.5 bg-white border-2 border-gray-300 text-gray-600 hover:bg-gray-50 rounded-xl font-bold text-sm transition-all shadow-sm text-center">
                        BATAL
                    </a>
                    <button id="btn-simpan" class="py-3.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-green-600/30">
                        SIMPAN PERUBAHAN
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $mappedCart = $transaksi->detailTransaksi->map(function ($detail) use ($transaksi) {
        $itemName = optional($detail->itemLaundry)->nama_item ?? 'Item';
        $pencucianName = optional($detail->pencucian)->nama_pencucian ?? '-';
        $layananName = optional($detail->layanan)->nama_layanan ?? '-';

        return [
            'id' => $detail->id,
            'item_id' => $detail->item_id,
            'pencucian_id' => $detail->pencucian_id,
            'layanan_id' => $detail->layanan_id,
            'name' => $itemName . ' (' . $pencucianName . ')',
            'layanan' => $layananName,
            'pengiriman' => optional($transaksi->pengiriman)->pilihan_pengiriman ?? '-',
            'qty' => $detail->total_berat . ' pcs',
            'qty_num' => $detail->total_berat,
            'price' => $detail->subtotal,
            'unitPrice' => $detail->harga_unit,
        ];
    })->values();
@endphp

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cart = @json($mappedCart);
        let subtotal = 0;

        const itemSelect = document.getElementById('item-select');
        const pencucianSelect = document.getElementById('pencucian-select');
        const layananSelect = document.getElementById('layanan-select');
        const qtyInput = document.getElementById('qty-input');
        const unitSelect = document.getElementById('unit-select');
        const btnTambah = document.getElementById('btn-tambah');
        const btnSimpan = document.getElementById('btn-simpan');
        const cartContainer = document.getElementById('cart-container');
        const emptyCartMsg = document.getElementById('empty-cart-msg');
        const subtotalDisplay = document.getElementById('subtotal-display');
        const totalDisplay = document.getElementById('total-display');

        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        };

        function renderCart() {
            cartContainer.innerHTML = '';

            if (cart.length === 0) {
                cartContainer.appendChild(emptyCartMsg);
                emptyCartMsg.style.display = 'block';
                subtotal = 0;
            } else {
                emptyCartMsg.style.display = 'none';
                subtotal = 0;

                cart.forEach((item, index) => {
                    subtotal += parseFloat(item.price) || 0;

                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'bg-blue-50/50 rounded-xl p-4 border border-blue-100 mb-3 relative group';
                    itemDiv.innerHTML = `
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-gray-800 text-sm mb-2">- ${item.name}</h4>
                            <button type="button" class="text-red-400 hover:text-red-600 transition-colors remove-btn" data-index="${index}" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="pl-3 text-xs text-gray-600 space-y-1.5 border-l-2 border-blue-200">
                            <p>Layanan: <span class="font-medium text-gray-800">${item.layanan}</span></p>
                            <p>Pengiriman: <span class="font-medium text-gray-800">${item.pengiriman}</span></p>
                            <p>Qty: <span class="font-medium text-gray-800">${item.qty} <span class="text-gray-400 font-normal">(x ${formatRupiah(item.unitPrice)})</span></span></p>
                            <p>Total Harga: <span class="font-bold text-blue-600">${formatRupiah(item.price)}</span></p>
                        </div>
                    `;
                    cartContainer.appendChild(itemDiv);
                });

                document.querySelectorAll('.remove-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const idx = this.getAttribute('data-index');
                        cart.splice(idx, 1);
                        renderCart();
                    });
                });
            }

            subtotalDisplay.innerText = formatRupiah(subtotal);
            totalDisplay.innerText = formatRupiah(subtotal);
        }

        btnTambah.addEventListener('click', function() {
            if (!itemSelect.value) {
                alert('Pilih item terlebih dahulu!');
                return;
            }

            const itemOption = itemSelect.options[itemSelect.selectedIndex];
            const itemText = itemOption.text;
            const basePrice = parseFloat(itemOption.getAttribute('data-price')) || 0;

            const pencucianOption = pencucianSelect.options[pencucianSelect.selectedIndex];
            const pencucianText = pencucianOption.text;
            const pencucianHarga = parseFloat(pencucianOption.getAttribute('data-harga')) || 0;

            const layananOption = layananSelect.options[layananSelect.selectedIndex];
            const layananText = layananOption.text;
            const layananHarga = parseFloat(layananOption.getAttribute('data-harga')) || 0;

            const qty = parseFloat(qtyInput.value) || 1;
            const unit = unitSelect.value;
            
            // Hitung total harga: (Harga Dasar + Cuci + Layanan) × Qty
            const unitPriceCalculated = basePrice + pencucianHarga + layananHarga;
            const itemPrice = unitPriceCalculated * qty;

            cart.push({
                id: Date.now().toString(),
                item_id: itemSelect.value,
                pencucian_id: pencucianSelect.value,
                layanan_id: layananSelect.value,
                name: `${itemText} (${pencucianText})`,
                layanan: layananText,
                pengiriman: '{{ optional($transaksi->pengiriman)->pilihan_pengiriman ?? '-' }}',
                qty: `${qty} ${unit}`,
                qty_num: qty,
                price: itemPrice,
                unitPrice: unitPriceCalculated
            });

            itemSelect.value = '';
            pencucianSelect.value = '';
            layananSelect.value = '';
            qtyInput.value = 1;
            unitSelect.value = 'pcs';
            renderCart();
        });

        btnSimpan.addEventListener('click', function() {
            if (cart.length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }

            const originalText = this.innerHTML;
            this.disabled = true;
            this.innerHTML = 'MEMPROSES...';

            fetch('{{ url('/dashboard/kasir/transaksi/' . $transaksi->id . '/edit-items') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart: cart,
                    total: subtotal
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect_url || '{{ route("dashboard.kasir.transaksi") }}';
                } else {
                    alert('Gagal mengupdate items: ' + data.message);
                    this.disabled = false;
                    this.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan pada server.');
                this.disabled = false;
                this.innerHTML = originalText;
            });
        });

        renderCart();
    });
</script>
@endpush
@endsection
