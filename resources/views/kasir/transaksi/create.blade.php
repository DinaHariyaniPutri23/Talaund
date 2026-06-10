@extends('layouts.dashboard')

@section('title', 'Entri Transaksi Baru')
@section('header_title', 'Transaksi')
@section('header_subtitle', 'Entri transaksi baru untuk pelanggan.')


@section('content')
<div class="space-y-6">
    <!-- SEKSI 1: DATA PELANGGAN -->
    <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 relative">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-bold text-gray-400 tracking-wider uppercase">Langkah 1: Data Pelanggan</h3>
            <span id="status-pelanggan" class="text-xs font-bold px-2.5 py-1 bg-blue-100 text-blue-700 rounded-lg transition-colors">Pelanggan Baru</span>
        </div>
        <div class="flex flex-col items-start gap-4">
            <div class="w-full relative z-20">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pelanggan (Ketik Nama / No. HP)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input id="pelanggan-search" type="text" autocomplete="off" class="block w-full pl-10 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Contoh: Dani atau 0897...">
                    <button id="btn-clear-search" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 hidden transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Dropdown Hasil Pencarian -->
                <div id="search-dropdown" class="absolute w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg shadow-gray-200/50 hidden max-h-60 overflow-y-auto divide-y divide-gray-50">
                    <!-- Data injeksi via JS -->
                </div>
            </div>
            
            <!-- Form Input Pelanggan -->
            <input type="hidden" id="input-id-pelanggan" value="">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Pelanggan <span class="text-red-500">*</span></label>
                    <input id="input-nama" type="text" class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Masukkan nama...">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">No. WhatsApp / HP <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input id="input-hp" type="text" inputmode="numeric" maxlength="12" class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-white text-sm focus:outline-none focus:ring-2 focus:border-blue-500 transition-all" placeholder="Contoh: 08123456789" data-error="false">
                        <div id="hp-error" class="text-xs text-red-500 mt-1 hidden">Nomor HP harus 11-12 angka (Contoh: 08123456789)</div>
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Alamat Lengkap</label>
                    <textarea id="input-alamat" rows="2" class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Masukkan alamat lengkap pelanggan..."></textarea>
                </div>
            </div>
            
            <div class="w-full flex justify-end">
                <button id="btn-clear-form" type="button" class="text-xs font-medium text-red-500 hover:text-red-700 underline underline-offset-2 transition-colors">
                    Bersihkan Form
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- SEKSI 2: DETAIL CUCIAN -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 md:p-8 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100">
            <h3 class="text-sm font-bold text-gray-400 tracking-wider uppercase mb-6">Langkah 2: Detail Cucian</h3>
            
            <div class="space-y-6">
                <!-- 1. Pilih Item -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">1. Pilih Item</label>
                    <div class="relative">
                        <select id="item-select" class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer">
                            <option value="" data-satuan="">-- Pilih Item --</option>
                            @foreach($items->unique('nama_item') as $item)
                                <option value="{{ $item->nama_item }}" data-satuan="{{ strtoupper($item->satuan) }}">
                                    {{ $item->nama_item }}
                                </option>
                            @endforeach
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
                            <option value="">-- Pilih Pencucian --</option>
                            @foreach($pencucians as $pencucian)
                                <option value="{{ $pencucian->id }}">{{ $pencucian->nama_pencucian }}</option>
                            @endforeach
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
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($layanans as $layanan)
                                <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                            @endforeach
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
                            <option value="">-- Pilih Pengiriman --</option>
                            @foreach($pengirimans as $pengiriman)
                                <option value="{{ $pengiriman->id }}">{{ $pengiriman->pilihan_pengiriman }}</option>
                            @endforeach
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
                        <input id="qty-input" type="number" class="block w-full sm:w-24 pl-4 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all text-center" value="1" min="1" step="0.1">
                        
                        <div class="relative w-full sm:w-32 flex items-center">
                            <span id="satuan-display" class="px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 w-full text-center">-</span>
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
            <h3 class="text-sm font-bold text-gray-400 tracking-wider uppercase mb-6">Langkah 3: Ringkasan Nota</h3>
            
            <div class="mb-4 pb-4 border-b border-gray-100">
                <p class="text-sm text-gray-500 mb-1">Pelanggan:</p>
                <p id="nama-pelanggan-display" class="font-bold text-gray-800 text-lg">-</p>
                <div class="flex flex-col gap-1.5 mt-2 text-sm text-gray-600">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 shrink-0 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span id="hp-pelanggan-display">-</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 shrink-0 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span id="alamat-pelanggan-display" class="line-clamp-2">-</span>
                    </div>
                </div>
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
                            <option value="0" data-potongan="0">Pilih Promo</option>
                            @foreach($promos as $promo)
                                <option value="{{ $promo->id }}" data-potongan="{{ $promo->potongan }}">{{ $promo->nama_promo }} (Potongan Rp {{ number_format($promo->potongan, 0, ',', '.') }})</option>
                            @endforeach
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
            <div class="mt-6 space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <button id="btn-bayar-tunai" class="py-3.5 bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-50 rounded-xl font-bold text-sm transition-all shadow-sm">
                        BAYAR TUNAI
                    </button>
                    <button id="btn-bayar-nanti" class="py-3.5 bg-orange-100 text-orange-600 hover:bg-orange-200 border-2 border-orange-200 rounded-xl font-bold text-sm transition-all shadow-sm">
                        BAYAR NANTI
                    </button>
                </div>
                <button id="btn-bayar-qris" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-600/30">
                    BAYAR QRIS (TUNDA)
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
        const searchDropdown = document.getElementById('search-dropdown');
        const btnClearSearch = document.getElementById('btn-clear-search');
        const btnClearForm = document.getElementById('btn-clear-form');
        
        const inputIdPelanggan = document.getElementById('input-id-pelanggan');
        const statusPelanggan = document.getElementById('status-pelanggan');
        const inputNama = document.getElementById('input-nama');
        const inputHp = document.getElementById('input-hp');
        const inputAlamat = document.getElementById('input-alamat');
        
        const namaPelangganDisplay = document.getElementById('nama-pelanggan-display');
        const hpPelangganDisplay = document.getElementById('hp-pelanggan-display');
        const alamatPelangganDisplay = document.getElementById('alamat-pelanggan-display');
        
        const itemSelect = document.getElementById('item-select');
        const pencucianSelect = document.getElementById('pencucian-select');
        const layananSelect = document.getElementById('layanan-select');
        const pengirimanSelect = document.getElementById('pengiriman-select');
        const qtyInput = document.getElementById('qty-input');
        const satuanDisplay = document.getElementById('satuan-display');
        const btnTambah = document.getElementById('btn-tambah');
        
        const masterItems = @json($items);
        
        const cartContainer = document.getElementById('cart-container');
        const emptyCartMsg = document.getElementById('empty-cart-msg');
        
        const subtotalDisplay = document.getElementById('subtotal-display');
        const promoSelect = document.getElementById('promo-select');
        const totalDisplay = document.getElementById('total-display');

        // Data pelanggan dari database
        @php
            $mappedPelanggan = $pelanggans->map(function($p) {
                return [
                    'id' => $p->id,
                    'nama' => $p->nama_lengkap,
                    'hp' => $p->no_telepon,
                    'alamat' => $p->alamat
                ];
            });
        @endphp
        const mockPelanggan = @json($mappedPelanggan);

        // Check if pelanggan_id parameter exists in URL
        const urlParams = new URLSearchParams(window.location.search);
        const pelangganIdParam = urlParams.get('pelanggan_id');
        
        // Define hpError here untuk digunakan di validateHP
        const hpError = document.getElementById('hp-error');
        
        if (pelangganIdParam) {
            const foundPelanggan = mockPelanggan.find(p => p.id == pelangganIdParam);
            if (foundPelanggan) {
                inputIdPelanggan.value = foundPelanggan.id;
                inputNama.value = foundPelanggan.nama;
                inputHp.value = foundPelanggan.hp;
                inputAlamat.value = foundPelanggan.alamat;
                
                statusPelanggan.innerText = 'Pelanggan Terdaftar';
                statusPelanggan.className = 'text-xs font-bold px-2.5 py-1 bg-green-100 text-green-700 rounded-lg transition-colors';
                
                namaPelangganDisplay.innerText = foundPelanggan.nama;
                hpPelangganDisplay.innerText = foundPelanggan.hp;
                alamatPelangganDisplay.innerText = foundPelanggan.alamat;
            }
        }

        // Fungsi mengubah status jika form diedit manual
        const checkEditStatus = () => {
            if(inputIdPelanggan.value !== '') {
                statusPelanggan.innerText = 'Edit Data Terdaftar';
                statusPelanggan.className = 'text-xs font-bold px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-lg transition-colors';
            }
        };

        // Validasi Nomor HP
        const validateHP = () => {
            const hpValue = inputHp.value.trim();
            const isValid = /^\d{11,12}$/.test(hpValue); // Hanya angka, 11-12 digit
            
            if (hpValue.length === 0) {
                // Kosong tidak error, cukup warning
                inputHp.classList.remove('border-red-500', 'focus:ring-red-500');
                inputHp.classList.add('border-gray-200', 'focus:ring-blue-500');
                hpError.classList.add('hidden');
                inputHp.dataset.error = 'false';
            } else if (!isValid) {
                // Error: tidak sesuai format
                inputHp.classList.remove('border-gray-200', 'focus:ring-blue-500');
                inputHp.classList.add('border-red-500', 'focus:ring-red-500');
                hpError.classList.remove('hidden');
                inputHp.dataset.error = 'true';
            } else {
                // Valid
                inputHp.classList.remove('border-red-500', 'focus:ring-red-500');
                inputHp.classList.add('border-gray-200', 'focus:ring-blue-500');
                hpError.classList.add('hidden');
                inputHp.dataset.error = 'false';
            }
        };

        // Update display nama
        inputNama.addEventListener('input', function() {
            namaPelangganDisplay.innerText = this.value.trim() !== '' ? this.value : '-';
            checkEditStatus();
        });

        // Hanya terima input angka, hapus karakter non-numerik
        inputHp.addEventListener('input', function() {
            // Hapus semua karakter yang bukan angka
            this.value = this.value.replace(/[^\d]/g, '');
            validateHP();
            checkEditStatus();
            // Update display HP
            hpPelangganDisplay.innerText = this.value.trim() !== '' ? this.value : '-';
        });

        // Update display nota
        inputAlamat.addEventListener('input', function() {
            alamatPelangganDisplay.innerText = this.value.trim() !== '' ? this.value : '-';
            checkEditStatus();
        });

        // Search Logic
        pelangganSearch.addEventListener('input', function() {
            const keyword = this.value.toLowerCase().trim();
            searchDropdown.innerHTML = ''; // Kosongkan dropdown

            if(keyword.length > 0) {
                btnClearSearch.classList.remove('hidden');
            } else {
                btnClearSearch.classList.add('hidden');
                searchDropdown.classList.add('hidden');
                return;
            }

            if(keyword.length >= 2) {
                // Filter cari multiple pelanggan (berdasarkan nama atau no HP yang mengandung keyword)
                const results = mockPelanggan.filter(p => 
                    (p.nama ? String(p.nama).toLowerCase().includes(keyword) : false) || 
                    (p.hp ? String(p.hp).includes(keyword) : false)
                );
                
                if(results.length > 0) {
                    results.forEach(p => {
                        const itemDiv = document.createElement('div');
                        itemDiv.className = 'px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors';
                        itemDiv.innerHTML = `
                            <p class="font-bold text-gray-800 text-sm">${p.nama}</p>
                            <div class="flex gap-2 text-xs text-gray-500 mt-1">
                                <span>📞 ${p.hp}</span>
                                <span class="truncate pl-2 border-l border-gray-300">📍 ${p.alamat}</span>
                            </div>
                        `;
                        
                        // Event ketika salah satu list diklik
                        itemDiv.addEventListener('click', function() {
                            // Isi otomatis form
                            inputIdPelanggan.value = p.id;
                            inputNama.value = p.nama;
                            inputHp.value = p.hp;
                            inputAlamat.value = p.alamat;
                            
                            // Validasi HP format
                            validateHP();
                            
                            // Ubah status badge
                            statusPelanggan.innerText = 'Pelanggan Terdaftar';
                            statusPelanggan.className = 'text-xs font-bold px-2.5 py-1 bg-green-100 text-green-700 rounded-lg transition-colors';
                            
                            // Update display nota
                            namaPelangganDisplay.innerText = p.nama;
                            hpPelangganDisplay.innerText = p.hp;
                            alamatPelangganDisplay.innerText = p.alamat;
                            
                            // Sembunyikan dropdown & bersihkan input search
                            searchDropdown.classList.add('hidden');
                            pelangganSearch.value = '';
                            btnClearSearch.classList.add('hidden');
                        });

                        searchDropdown.appendChild(itemDiv);
                    });
                    searchDropdown.classList.remove('hidden');
                } else {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.className = 'px-4 py-3 text-sm text-gray-500 italic text-center';
                    emptyDiv.innerText = 'Tidak ada pelanggan yang cocok.';
                    searchDropdown.appendChild(emptyDiv);
                    searchDropdown.classList.remove('hidden');
                }
            } else {
                searchDropdown.classList.add('hidden');
            }
        });

        const originalPencucianOptions = Array.from(pencucianSelect.options);
        const originalLayananOptions = Array.from(layananSelect.options);

        // Update dropdown pencucian, layanan, dan satuan saat item dipilih
        itemSelect.addEventListener('change', function() {
            const selectedNamaItem = this.value;
            const selectedOption = this.options[this.selectedIndex];
            const satuan = selectedOption.getAttribute('data-satuan') || '-';
            satuanDisplay.innerText = satuan;
            
            if (!selectedNamaItem) {
                // Restore all if empty
                pencucianSelect.innerHTML = '';
                originalPencucianOptions.forEach(opt => pencucianSelect.appendChild(opt.cloneNode(true)));
                layananSelect.innerHTML = '';
                originalLayananOptions.forEach(opt => layananSelect.appendChild(opt.cloneNode(true)));
                return;
            }

            // Filter masterItems based on selected item
            const availableItems = masterItems.filter(i => i.nama_item === selectedNamaItem);
            
            // Get unique available id_pencucian and id_layanan
            const availablePencucianIds = [...new Set(availableItems.map(i => String(i.id_pencucian)))];
            const availableLayananIds = [...new Set(availableItems.map(i => String(i.id_layanan)))];

            // Reset pencucianSelect
            pencucianSelect.innerHTML = '';
            originalPencucianOptions.forEach(opt => {
                if (opt.value === "" || availablePencucianIds.includes(opt.value)) {
                    pencucianSelect.appendChild(opt.cloneNode(true));
                }
            });

            // Reset layananSelect
            layananSelect.innerHTML = '';
            originalLayananOptions.forEach(opt => {
                if (opt.value === "" || availableLayananIds.includes(opt.value)) {
                    layananSelect.appendChild(opt.cloneNode(true));
                }
            });
            
            // Auto-select if only one valid option exists (besides empty)
            if(pencucianSelect.options.length === 2) pencucianSelect.selectedIndex = 1;
            if(layananSelect.options.length === 2) layananSelect.selectedIndex = 1;
        });

        // Hide dropdown saat klik di luar
        document.addEventListener('click', function(e) {
            if (!pelangganSearch.contains(e.target) && !searchDropdown.contains(e.target)) {
                searchDropdown.classList.add('hidden');
            }
        });

        // Tombol clear pencarian
        btnClearSearch.addEventListener('click', function() {
            pelangganSearch.value = '';
            searchDropdown.classList.add('hidden');
            this.classList.add('hidden');
            pelangganSearch.focus();
        });

        // Tombol bersihkan form
        btnClearForm.addEventListener('click', function() {
            inputIdPelanggan.value = '';
            inputNama.value = '';
            inputHp.value = '';
            inputAlamat.value = '';
            
            // Reset styling HP
            inputHp.classList.remove('border-red-500', 'focus:ring-red-500');
            inputHp.classList.add('border-gray-200', 'focus:ring-blue-500');
            hpError.classList.add('hidden');
            
            statusPelanggan.innerText = 'Pelanggan Baru';
            statusPelanggan.className = 'text-xs font-bold px-2.5 py-1 bg-blue-100 text-blue-700 rounded-lg transition-colors';
            
            namaPelangganDisplay.innerText = '-';
            hpPelangganDisplay.innerText = '-';
            alamatPelangganDisplay.innerText = '-';
        });

        // Format Currency
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        };

        // Add to Cart Logic
        btnTambah.addEventListener('click', function() {
            if (!itemSelect.value || !pencucianSelect.value || !layananSelect.value) {
                alert('Pilih Item, Jenis Pencucian, dan Jenis Layanan terlebih dahulu!');
                return;
            }

            const selectedNamaItem = itemSelect.value;
            const selectedPencucianId = pencucianSelect.value;
            const selectedLayananId = layananSelect.value;

            // Find matching item in masterItems
            const foundItem = masterItems.find(i => 
                i.nama_item === selectedNamaItem && 
                i.id_pencucian == selectedPencucianId && 
                i.id_layanan == selectedLayananId
            );

            if (!foundItem) {
                alert('Kombinasi layanan ini tidak tersedia untuk item terpilih! (Cek kembali harga master)');
                return;
            }

            const itemText = foundItem.nama_item;
            const pencucianText = pencucianSelect.options[pencucianSelect.selectedIndex].text;
            const layananText = layananSelect.options[layananSelect.selectedIndex].text;
            const basePrice = parseFloat(foundItem.harga);
            const satuan = foundItem.satuan.toUpperCase();
            
            const pengirimanText = pengirimanSelect.options[pengirimanSelect.selectedIndex].text;
            
            const qty = parseFloat(qtyInput.value) || 1;
            
            // Hitung total harga
            const unitPriceCalculated = basePrice;
            const itemPrice = unitPriceCalculated * qty;
            
            const itemId = Date.now().toString();

            // Masukkan ke array keranjang dengan struktur data mentah untuk dikirim ke backend
            cart.push({
                id: itemId, // Temporary id
                item_id: foundItem.id,
                pencucian_id: selectedPencucianId,
                layanan_id: selectedLayananId,
                // Label string hanya untuk UI
                name: `${itemText} (${pencucianText})`,
                layanan: layananText,
                pengiriman: pengirimanText,
                qty: `${qty} ${satuan}`,
                qty_num: qty,
                price: itemPrice,
                unitPrice: unitPriceCalculated,
                pencucianHarga: 0,
                layananHarga: 0
            });

            // Kosongkan seluruh Sesi 2 setelah item ditambah ke keranjang (kecuali pengiriman karena berlaku untuk 1 nota)
            itemSelect.value = "";
            pencucianSelect.value = "";
            layananSelect.value = "";
            qtyInput.value = 1;
            satuanDisplay.innerText = '-';

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
                            <p>Qty: <span class="font-medium text-gray-800">${item.qty} <span class="text-gray-400 font-normal">(x ${formatRupiah(item.unitPrice)})</span></span></p>
                            <p>Total Harga: <span class="font-bold text-blue-600">${formatRupiah(item.price)}</span></p>
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
            
            const selectedPromo = promoSelect.options[promoSelect.selectedIndex];
            let promoDiscount = parseFloat(selectedPromo.getAttribute('data-potongan')) || 0;
            
            let total = subtotal - promoDiscount;
            if(total < 0) total = 0; // Jangan sampai total minus

            totalDisplay.innerText = formatRupiah(total);
        }

        // Kalkulasi ulang otomatis jika promo berubah
        promoSelect.addEventListener('change', calculateTotals);
        
        // Panggil calculate awal
        calculateTotals();

        // TOMBOL BAYAR TUNAI (Proses Simpan Transaksi)
        const btnBayarTunai = document.getElementById('btn-bayar-tunai');
        const btnBayarNanti = document.getElementById('btn-bayar-nanti');

        btnBayarTunai.addEventListener('click', function() {
            prosesPembayaran('paid', this);
        });

        if (btnBayarNanti) {
            btnBayarNanti.addEventListener('click', function() {
                prosesPembayaran('unpaid', this);
            });
        }

        function prosesPembayaran(statusBayar, btnElement) {
            if (cart.length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }

            const pelanggan_id = inputIdPelanggan.value;
            const pelanggan_nama = inputNama.value.trim();
            const pelanggan_hp = inputHp.value.trim();
            const pelanggan_alamat = inputAlamat.value.trim();

            if (!pelanggan_nama) {
                alert('Silakan cari pelanggan atau masukkan nama pelanggan baru secara manual!');
                return;
            }

            // Validasi nomor HP
            if (!pelanggan_hp) {
                alert('Nomor HP harus diisi!');
                inputHp.focus();
                inputHp.classList.add('border-red-500');
                return;
            }

            if (!/^\d{11,12}$/.test(pelanggan_hp)) {
                alert('Nomor HP harus 11-12 angka tanpa karakter khusus (Contoh: 08123456789)');
                inputHp.focus();
                return;
            }

            const pengiriman_id = pengirimanSelect.value;
            if (!pengiriman_id) {
                alert('Silakan pilih jenis pengiriman terlebih dahulu (di Langkah 2)!');
                return;
            }

            const promo_id = promoSelect.value;

            // Ambil total harga terbaru
            let promoDiscount = parseFloat(promoSelect.options[promoSelect.selectedIndex].getAttribute('data-potongan')) || 0;
            let totalAkhir = subtotal - promoDiscount;
            if(totalAkhir < 0) totalAkhir = 0;

            // Loading state
            const originalText = btnElement.innerHTML;
            btnElement.disabled = true;
            btnElement.innerHTML = 'MEMPROSES...';

            fetch('{{ route("dashboard.kasir.transaksi.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    pelanggan_id: pelanggan_id,
                    pelanggan_nama: pelanggan_nama,
                    pelanggan_hp: pelanggan_hp,
                    pelanggan_alamat: pelanggan_alamat,
                    pengiriman_id: pengiriman_id,
                    promo_id: promo_id,
                    status_bayar: statusBayar,
                    total: totalAkhir,
                    cart: cart
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Redirect ke struk digital
                    window.location.href = data.redirect_url;
                } else {
                    alert('Gagal menyimpan transaksi: ' + data.message);
                    btnElement.disabled = false;
                    btnElement.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan pada server.');
                btnElement.disabled = false;
                btnElement.innerHTML = originalText;
            });
        }

        // TOMBOL BAYAR QRIS
        const btnBayarQris = document.getElementById('btn-bayar-qris');
        btnBayarQris.addEventListener('click', function() {
            alert('Fitur Pembayaran QRIS / Xendit sedang dalam proses integrasi.');
        });
    });
</script>
@endpush
@endsection
