@extends('layouts.dashboard')

@section('title', 'Entri Transaksi Baru')
@section('header_title', 'Transaksi')
@section('header_subtitle', 'Entri transaksi baru untuk pelanggan.')


@section('content')
<div class="space-y-6">
    <!-- SEKSI 1: DATA PELANGGAN -->
    <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 relative">
        <h3 class="text-sm font-bold text-gray-400 tracking-wider uppercase mb-4">Seksi 1: Data Pelanggan</h3>
        <div class="flex flex-col sm:flex-row items-start gap-4">
            <div class="flex-1 w-full">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Nama/HP</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input id="pelanggan-search" type="text" class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Ketik Nama atau No. HP (min. 3 huruf/angka)...">
                </div>
                
                <!-- Hasil Pencarian Card -->
                <div id="pelanggan-card" class="mt-4 flex items-start gap-3 p-4 border border-blue-100 bg-blue-50/50 rounded-xl hidden transition-all">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg shrink-0" id="pelanggan-initial">
                        -
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800" id="pelanggan-nama">-</p>
                        <div class="flex items-center gap-2 text-xs text-gray-600 mt-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span id="pelanggan-hp">-</span>
                        </div>
                        <div class="flex items-start gap-2 text-xs text-gray-500 mt-1">
                            <svg class="w-3.5 h-3.5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span id="pelanggan-alamat" class="line-clamp-2">-</span>
                        </div>
                    </div>
                    <button id="btn-clear-pelanggan" class="text-gray-400 hover:text-red-500 p-1.5 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
            
            <div class="pt-7 w-full sm:w-auto">
                <button class="w-full sm:w-auto flex justify-center items-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-600 px-5 py-3 rounded-xl font-medium text-sm transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Pelanggan Baru
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- SEKSI 2: DETAIL CUCIAN -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 md:p-8 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100">
            <h3 class="text-sm font-bold text-gray-400 tracking-wider uppercase mb-6">Seksi 2: Detail Cucian</h3>
            
            <div class="space-y-6">
                <!-- 1. Pilih Item -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">1. Pilih Item</label>
                    <div class="relative">
                        <select id="item-select" class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer">
                            <option value="" data-price="0">-- Pilih Item --</option>
                            <option value="bedcover" data-price="25000">Bedcover</option>
                            <option value="baju" data-price="7000">Baju Kiloan</option>
                            <option value="celana" data-price="6000">Celana Kiloan</option>
                            <option value="sepatu" data-price="35000">Sepatu (Pasang)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                
                <!-- 2. Jenis Pencucian -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">2. Jenis Pencucian</label>
                    <div class="relative">
                        <select id="pencucian-select" class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer">
                            <option value="cuci_setrika" data-multiplier="1">Cuci + Setrika</option>
                            <option value="cuci" data-multiplier="0.8">Cuci Saja</option>
                            <option value="setrika" data-multiplier="0.7">Setrika Saja</option>
                            <option value="cuci_kering" data-multiplier="0.9">Cuci Kering</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                
                <!-- 3. Jenis Layanan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">3. Jenis Layanan</label>
                    <div class="relative">
                        <select id="layanan-select" class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer">
                            <option value="reguler" data-multiplier="1">Reguler</option>
                            <option value="express" data-multiplier="1.5">Express (1 Hari)</option>
                            <option value="kilat" data-multiplier="2">Kilat (6 Jam)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                
                <!-- 4. Jenis Pengiriman -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">4. Jenis Pengiriman</label>
                    <div class="relative">
                        <select id="pengiriman-select" class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer">
                            <option value="diambil">Diambil Sendiri</option>
                            <option value="diantar">Diantar Kurir</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                
                <!-- 5. Berat/Jumlah -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">5. Berat / Jumlah</label>
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
                            TAMBAH
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEKSI 3: RINGKASAN NOTA -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex flex-col">
            <h3 class="text-sm font-bold text-gray-400 tracking-wider uppercase mb-6">Seksi 3: Ringkasan Nota</h3>
            
            <div class="mb-4 pb-4 border-b border-gray-100">
                <p class="text-sm text-gray-500 mb-1">Pelanggan:</p>
                <p id="nama-pelanggan-display" class="font-bold text-gray-800 text-lg">-</p>
            </div>

            <!-- List of items -->
            <div id="cart-container" class="flex-1 overflow-y-auto no-scrollbar mb-6 min-h-[150px]">
                <div id="empty-cart-msg" class="text-center text-gray-400 text-sm mt-10 italic">
                    Belum ada item ditambahkan.
                </div>
                <!-- Items will be injected here via JS -->
            </div>

            <!-- Totals -->
            <div class="space-y-4 pt-4 border-t border-gray-100 border-dashed">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 font-medium">Subtotal:</span>
                    <span id="subtotal-display" class="text-sm font-bold text-gray-800">Rp 0</span>
                </div>
                
                <div class="flex items-center justify-between gap-3">
                    <span class="text-sm text-gray-500 font-medium w-1/3">Promo:</span>
                    <div class="relative w-2/3">
                        <select id="promo-select" class="block w-full pl-3 pr-8 py-2 border border-gray-200 rounded-lg leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer">
                            <option value="0">Pilih Promo</option>
                            <option value="10">Diskon 10%</option>
                            <option value="5000">Potongan Rp 5.000</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-200">
                    <span class="text-base font-black text-gray-800 tracking-wide">TOTAL:</span>
                    <span id="total-display" class="text-xl font-black text-blue-600">Rp 0</span>
                </div>
            </div>

            <!-- Payment Buttons -->
            <div class="grid grid-cols-2 gap-3 mt-6">
                <button class="py-3.5 bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-50 rounded-xl font-bold text-sm transition-all shadow-sm">
                    BAYAR TUNAI
                </button>
                <button class="py-3.5 bg-blue-600 hover:bg-blue-700 text-white border-2 border-blue-600 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-600/30">
                    BAYAR QRIS
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cart = [];
        let subtotal = 0;
        
        // DOM Elements
        const pelangganSearch = document.getElementById('pelanggan-search');
        const pelangganCard = document.getElementById('pelanggan-card');
        const pelangganInitial = document.getElementById('pelanggan-initial');
        const pelangganNama = document.getElementById('pelanggan-nama');
        const pelangganHp = document.getElementById('pelanggan-hp');
        const pelangganAlamat = document.getElementById('pelanggan-alamat');
        const btnClearPelanggan = document.getElementById('btn-clear-pelanggan');
        const namaPelangganDisplay = document.getElementById('nama-pelanggan-display');
        
        const itemSelect = document.getElementById('item-select');
        const pencucianSelect = document.getElementById('pencucian-select');
        const layananSelect = document.getElementById('layanan-select');
        const pengirimanSelect = document.getElementById('pengiriman-select');
        const qtyInput = document.getElementById('qty-input');
        const unitSelect = document.getElementById('unit-select');
        const btnTambah = document.getElementById('btn-tambah');
        
        const cartContainer = document.getElementById('cart-container');
        const emptyCartMsg = document.getElementById('empty-cart-msg');
        
        const subtotalDisplay = document.getElementById('subtotal-display');
        const promoSelect = document.getElementById('promo-select');
        const totalDisplay = document.getElementById('total-display');

        // Simulasi database pelanggan
        const mockPelanggan = [
            { nama: 'Ahmad Nazri', hp: '081234567890', alamat: 'Jl. Merdeka No. 45, Kebayoran Baru, Jakarta Selatan' },
            { nama: 'Budi Santoso', hp: '085712341234', alamat: 'Perum. Indah Makmur Blok B/12, Depok' },
            { nama: 'Siti Aminah', hp: '081999888777', alamat: 'Jl. Mawar Raya No. 3, Bekasi Barat' }
        ];

        // Search Logic
        pelangganSearch.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            if(keyword.length >= 3) {
                // Cari dari mock data
                const found = mockPelanggan.find(p => p.nama.toLowerCase().includes(keyword) || p.hp.includes(keyword));
                
                if(found) {
                    pelangganInitial.innerText = found.nama.charAt(0).toUpperCase();
                    pelangganNama.innerText = found.nama;
                    pelangganHp.innerText = found.hp;
                    pelangganAlamat.innerText = found.alamat;
                    
                    pelangganCard.classList.remove('hidden');
                    namaPelangganDisplay.innerText = found.nama; // Update kanan
                } else {
                    pelangganCard.classList.add('hidden');
                    namaPelangganDisplay.innerText = '-';
                }
            } else {
                pelangganCard.classList.add('hidden');
                namaPelangganDisplay.innerText = '-';
            }
        });

        btnClearPelanggan.addEventListener('click', function() {
            pelangganSearch.value = '';
            pelangganCard.classList.add('hidden');
            namaPelangganDisplay.innerText = '-';
            pelangganSearch.focus();
        });

        // Format Currency
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        };

        // Add to Cart Logic
        btnTambah.addEventListener('click', function() {
            if (!itemSelect.value) {
                alert('Pilih item terlebih dahulu!');
                return;
            }

            const itemOption = itemSelect.options[itemSelect.selectedIndex];
            const itemText = itemOption.text;
            const basePrice = parseFloat(itemOption.getAttribute('data-price'));

            const pencucianOption = pencucianSelect.options[pencucianSelect.selectedIndex];
            const pencucianText = pencucianOption.text;
            const pencucianMultiplier = parseFloat(pencucianOption.getAttribute('data-multiplier'));
            
            const layananOption = layananSelect.options[layananSelect.selectedIndex];
            const layananText = layananOption.text;
            const layananMultiplier = parseFloat(layananOption.getAttribute('data-multiplier'));
            
            const pengirimanText = pengirimanSelect.options[pengirimanSelect.selectedIndex].text;
            
            const qty = parseFloat(qtyInput.value) || 1;
            const unit = unitSelect.value;
            
            // Hitung harga per baris (Simulasi: Harga dasar * Pengali Jenis Cuci * Pengali Layanan * Qty)
            const itemPrice = basePrice * pencucianMultiplier * layananMultiplier * qty;
            
            const itemId = Date.now().toString();

            // Masukkan ke array keranjang
            cart.push({
                id: itemId,
                name: `${itemText} (${pencucianText})`,
                layanan: layananText,
                pengiriman: pengirimanText,
                qty: `${qty} ${unit}`,
                price: itemPrice
            });

            // Reset Form secukupnya agar bisa input barang baru dengan cepat
            itemSelect.value = "";
            qtyInput.value = 1;

            // Gambar ulang tampilan keranjang
            renderCart();
        });

        // Render UI Keranjang
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
                    subtotal += item.price;
                    
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
                            <p>Qty: <span class="font-medium text-gray-800">${item.qty}</span></p>
                            <p>Harga: <span class="font-bold text-blue-600">${formatRupiah(item.price)}</span></p>
                        </div>
                    `;
                    cartContainer.appendChild(itemDiv);
                });

                // Attach event listeners ke tombol hapus (X)
                document.querySelectorAll('.remove-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const idx = this.getAttribute('data-index');
                        cart.splice(idx, 1); // Hapus item dari array
                        renderCart(); // Gambar ulang
                    });
                });
            }
            
            // Hitung total akhir
            calculateTotals();
        }

        // Hitung Subtotal, Diskon, dan Total Akhir
        function calculateTotals() {
            subtotalDisplay.innerText = formatRupiah(subtotal);
            
            let promoVal = parseFloat(promoSelect.value) || 0;
            let promoDiscount = 0;

            if (promoVal === 10) {
                // Diskon 10%
                promoDiscount = subtotal * 0.10;
            } else if (promoVal > 10) {
                // Potongan Nominal
                promoDiscount = promoVal;
            }
            
            let total = subtotal - promoDiscount;
            if(total < 0) total = 0; // Jangan sampai total minus

            totalDisplay.innerText = formatRupiah(total);
        }

        // Kalkulasi ulang otomatis jika promo berubah
        promoSelect.addEventListener('change', calculateTotals);
        
        // Panggil calculate awal
        calculateTotals();
    });
</script>
@endpush
@endsection
