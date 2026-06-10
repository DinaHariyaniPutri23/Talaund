@php
    $tab = request()->query('tab', 'pelanggan');
    
    $tabNames = [
        'pelanggan' => 'Data Pelanggan',
        'layanan' => 'Jenis Layanan',
        'pencucian' => 'Jenis Pencucian',
        'pengiriman' => 'Jenis Pengiriman',
        'item' => 'Item Laundry',
        'promo' => 'Promo & Diskon',
        'satuan' => 'Satuan',
    ];

    $currentTabName = $tabNames[$tab] ?? 'Data Pelanggan';
@endphp
@extends('layouts.dashboard')

@section('title', 'Data Master - ' . $currentTabName)

@section('header_title')
    <div class="flex items-center gap-2">
        <span class="text-gray-400 font-medium text-[1.25rem]">Data Master</span>
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        <span class="text-textDark">{{ $currentTabName }}</span>
    </div>
@endsection

@section('header_subtitle', 'Kelola data ' . strtolower($currentTabName) . ' untuk sistem laundry Anda.')

@section('content')
<div class="space-y-6">

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-green-700 font-medium text-sm">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="text-green-700 hover:text-green-900 focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- Content Card -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        
        <!-- Toolbar (Search & Add) -->
        <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Cari data...">
            </div>
            
            @if($tab == 'pelanggan')
                <button onclick="openModalTambah()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data
                </button>
            @elseif($tab == 'layanan')
                <button onclick="openModalTambahLayanan()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data
                </button>
            @elseif($tab == 'item')
                <button onclick="openModalTambahItem()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data
                </button>
            @elseif($tab == 'promo')
                <button onclick="openModalTambahPromo()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data
                </button>
            @elseif($tab == 'pencucian')
                <button onclick="openModalTambahPencucian()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data
                </button>
            @elseif($tab == 'pengiriman')
                <button onclick="openModalTambahPengiriman()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data
                </button>
            @elseif($tab == 'satuan')
                <button onclick="openModalTambahSatuan()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data
                </button>
            @else
                <button class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data
                </button>
            @endif
        </div>

        @if($tab == 'pelanggan')
        <!-- Content: Pelanggan -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16 text-center border-x border-gray-200">No</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">ID Pelanggan</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Nama</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">No Telp</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Alamat</th>
                        <th class="py-4 px-6 font-semibold w-36 text-center border-x border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pelanggans as $index => $p)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500 text-center border-x border-gray-200">{{ $pelanggans->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-center border-x border-gray-200">{{ $p->id_pelanggan }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-center border-x border-gray-200">{{ $p->nama_lengkap }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">{{ $p->no_telepon }}</td>
                        <td class="py-4 px-6 truncate max-w-[200px] text-center border-x border-gray-200" title="{{ $p->alamat }}">{{ $p->alamat }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openModalEdit({{ $p->id }}, '{{ $p->nama_lengkap }}', '{{ $p->no_telepon }}', '{{ $p->alamat }}')" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                <button onclick="openModalHapus({{ $p->id }}, '{{ $p->nama_lengkap }}')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">Belum ada data pelanggan yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan halaman {{ $pelanggans->currentPage() }} dari {{ $pelanggans->lastPage() }}</p>
            <div class="flex items-center gap-1">
                {{ $pelanggans->appends(['tab' => 'pelanggan'])->links('pagination::tailwind') }}
            </div>
        </div>

        @elseif($tab == 'pencucian')
        <!-- Content: Pencucian -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16 text-center border-x border-gray-200">No</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">ID Pencucian</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Nama Pencucian</th>
                        <th class="py-4 px-6 font-semibold w-36 text-center border-x border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pencucians as $index => $p)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500 text-center border-x border-gray-200">{{ $pencucians->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-center border-x border-gray-200">CUC-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">{{ $p->nama_pencucian }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openModalEditPencucian({{ $p->id }}, '{{ $p->nama_pencucian }}')" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                <button onclick="openModalHapusPencucian({{ $p->id }}, '{{ $p->nama_pencucian }}')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">Belum ada data jenis pencucian yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan halaman {{ $pencucians->currentPage() }} dari {{ $pencucians->lastPage() }}</p>
            <div class="flex items-center gap-1">
                {{ $pencucians->appends(['tab' => 'pencucian'])->links('pagination::tailwind') }}
            </div>
        </div>

        @elseif($tab == 'layanan')
        <!-- Content: Layanan -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16 text-center border-x border-gray-200">No</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">ID Layanan</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Nama Layanan</th>
                        <th class="py-4 px-6 font-semibold w-36 text-center border-x border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($layanans as $index => $l)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500 text-center border-x border-gray-200">{{ $layanans->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-center border-x border-gray-200">LYN-{{ str_pad($l->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">{{ $l->nama_layanan }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openModalEditLayanan({{ $l->id }}, '{{ $l->nama_layanan }}')" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                <button onclick="openModalHapusLayanan({{ $l->id }}, '{{ $l->nama_layanan }}')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">Belum ada data jenis layanan yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan halaman {{ $layanans->currentPage() }} dari {{ $layanans->lastPage() }}</p>
            <div class="flex items-center gap-1">
                {{ $layanans->appends(['tab' => 'layanan'])->links('pagination::tailwind') }}
            </div>
        </div>

        @elseif($tab == 'item')
        <!-- Content: Item -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16 text-center border-x border-gray-200">No</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">ID Item</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Nama Item</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Harga</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Satuan</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Layanan</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Jenis Pencucian</th>
                        <th class="py-4 px-6 font-semibold w-36 text-center border-x border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $index => $i)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500 text-center border-x border-gray-200">{{ $items->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-center border-x border-gray-200">ITM-{{ str_pad($i->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">{{ $i->nama_item }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200 font-medium text-blue-600">Rp {{ number_format($i->harga, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200 font-medium text-gray-700">{{ strtoupper($i->satuan) }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">{{ $i->layanan?->nama_layanan ?? '-' }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">{{ $i->pencucian?->nama_pencucian ?? '-' }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openModalEditItem({{ $i->id }}, '{{ $i->nama_item }}', '{{ $i->harga }}', '{{ $i->satuan }}')" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                <button onclick="openModalHapusItem({{ $i->id }}, '{{ $i->nama_item }}')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-gray-500">Belum ada data item laundry yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan halaman {{ $items->currentPage() }} dari {{ $items->lastPage() }}</p>
            <div class="flex items-center gap-1">
                {{ $items->appends(['tab' => 'item'])->links('pagination::tailwind') }}
            </div>
        </div>

        @elseif($tab == 'pengiriman')
        <!-- Content: Pengiriman -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16 text-center border-x border-gray-200">No</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">ID Pengiriman</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Pilihan Pengiriman</th>
                        <th class="py-4 px-6 font-semibold w-36 text-center border-x border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pengirimans as $index => $p)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500 text-center border-x border-gray-200">{{ $pengirimans->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-center border-x border-gray-200">KRM-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">{{ $p->pilihan_pengiriman }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openModalEditPengiriman({{ $p->id }}, '{{ $p->pilihan_pengiriman }}')" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                <button onclick="openModalHapusPengiriman({{ $p->id }}, '{{ $p->pilihan_pengiriman }}')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">Belum ada data jenis pengiriman yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan halaman {{ $pengirimans->currentPage() }} dari {{ $pengirimans->lastPage() }}</p>
            <div class="flex items-center gap-1">
                {{ $pengirimans->appends(['tab' => 'pengiriman'])->links('pagination::tailwind') }}
            </div>
        </div>

        @elseif($tab == 'promo')
        <!-- Content: Promo -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16 text-center border-x border-gray-200">No</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">ID Promo</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Nama Promo</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Potongan</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Masa Berlaku</th>
                        <th class="py-4 px-6 font-semibold w-36 text-center border-x border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($promos as $index => $p)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500 text-center border-x border-gray-200">{{ $promos->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-center border-x border-gray-200">PRM-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">{{ $p->nama_promo }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200 font-medium text-blue-600">Rp {{ number_format($p->potongan, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">
                            @if($p->tanggal_mulai && $p->tanggal_selesai)
                                {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}
                            @else
                                <span class="text-gray-400 italic">Tanpa batas</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openModalEditPromo({{ $p->id }}, '{{ $p->nama_promo }}', '{{ $p->potongan }}', '{{ $p->tanggal_mulai }}', '{{ $p->tanggal_selesai }}')" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                <button onclick="openModalHapusPromo({{ $p->id }}, '{{ $p->nama_promo }}')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">Belum ada data promo yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan halaman {{ $promos->currentPage() }} dari {{ $promos->lastPage() }}</p>
            <div class="flex items-center gap-1">
                {{ $promos->appends(['tab' => 'promo'])->links('pagination::tailwind') }}
            </div>
        </div>

        @elseif($tab == 'satuan')
        <!-- Content: Satuan -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16 text-center border-x border-gray-200">No</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Nama Satuan</th>
                        <th class="py-4 px-6 font-semibold w-36 text-center border-x border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($satuans as $index => $s)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500 text-center border-x border-gray-200">{{ $satuans->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-center border-x border-gray-200">{{ $s->nama_satuan }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openModalEditSatuan({{ $s->id }}, '{{ $s->nama_satuan }}')" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                <button onclick="openModalHapusSatuan({{ $s->id }}, '{{ $s->nama_satuan }}')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-8 text-center text-gray-500">Belum ada data satuan yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan halaman {{ $satuans->currentPage() }} dari {{ $satuans->lastPage() }}</p>
            <div class="flex items-center gap-1">
                {{ $satuans->appends(['tab' => 'satuan'])->links('pagination::tailwind') }}
            </div>
        </div>
        @endif

    </div>
</div>

@if($tab == 'pelanggan')
<!-- MODAL TAMBAH PELANGGAN -->
<div id="modalTambah" class="{{ session('error_modal_tambah') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Tambah Pelanggan Baru</h3>
            <button type="button" onclick="closeModalTambah()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('super_admin.pelanggan.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                @if(session('error_modal_tambah') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Masukkan nama pelanggan">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="no_telepon" value="{{ old('no_telepon') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Contoh: 08123456789">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="alamat" required rows="3" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambah()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PELANGGAN -->
<div id="modalEdit" class="{{ session('error_modal_edit') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Edit Data Pelanggan</h3>
            <button type="button" onclick="closeModalEdit()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEdit" action="{{ session('error_modal_edit') ? route('super_admin.pelanggan.update', session('error_modal_edit')) : '' }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                @if(session('error_modal_edit') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="edit_no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea id="edit_alamat" name="alamat" required rows="3" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">{{ old('alamat') }}</textarea>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalEdit()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS PELANGGAN -->
<div id="modalHapus" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden text-center p-8">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2 font-outfit">Konfirmasi Hapus</h3>
        <p class="text-gray-500 text-base mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus data pelanggan <br><span id="hapus_nama_lengkap" class="font-bold text-gray-800 text-lg"></span>?<br><span class="text-sm text-red-400 mt-1 block">Tindakan ini tidak dapat dibatalkan.</span></p>
        
        <form id="formHapus" method="POST" class="flex justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModalHapus()" class="px-6 py-3 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors w-1/2">Batal</button>
            <button type="submit" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium shadow-sm transition-colors w-1/2 flex justify-center items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<script>
    function openModalTambah() {
        document.getElementById('modalTambah').classList.remove('hidden');
        document.getElementById('modalTambah').classList.add('flex');
    }
    
    function closeModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
        document.getElementById('modalTambah').classList.remove('flex');
    }

    function openModalEdit(id, nama, telp, alamat) {
        document.getElementById('modalEdit').classList.remove('hidden');
        document.getElementById('modalEdit').classList.add('flex');
        
        // Update form action route dynamically
        document.getElementById('formEdit').action = `/dashboard/super-admin/data-master/pelanggan/${id}`;
        
        // Populate inputs
        document.getElementById('edit_nama_lengkap').value = nama;
        document.getElementById('edit_no_telepon').value = telp;
        document.getElementById('edit_alamat').value = alamat;
    }

    function closeModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
        document.getElementById('modalEdit').classList.remove('flex');
    }

    function openModalHapus(id, nama) {
        document.getElementById('modalHapus').classList.remove('hidden');
        document.getElementById('modalHapus').classList.add('flex');
        
        document.getElementById('hapus_nama_lengkap').textContent = nama;
        document.getElementById('formHapus').action = `/dashboard/super-admin/data-master/pelanggan/${id}`;
    }

    function closeModalHapus() {
        document.getElementById('modalHapus').classList.add('hidden');
        document.getElementById('modalHapus').classList.remove('flex');
    }
</script>
@elseif($tab == 'layanan')
<!-- MODAL TAMBAH LAYANAN -->
<div id="modalTambahLayanan" class="{{ session('error_modal_tambah_layanan') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Tambah Jenis Layanan</h3>
            <button type="button" onclick="closeModalTambahLayanan()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('super_admin.layanan.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                @if(session('error_modal_tambah_layanan') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_layanan" value="{{ old('nama_layanan') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambahLayanan()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT LAYANAN -->
<div id="modalEditLayanan" class="{{ session('error_modal_edit_layanan') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Edit Jenis Layanan</h3>
            <button type="button" onclick="closeModalEditLayanan()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEditLayanan" action="{{ session('error_modal_edit_layanan') ? route('super_admin.layanan.update', session('error_modal_edit_layanan')) : '' }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                @if(session('error_modal_edit_layanan') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_nama_layanan" name="nama_layanan" value="{{ old('nama_layanan') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalEditLayanan()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS LAYANAN -->
<div id="modalHapusLayanan" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden text-center p-8">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2 font-outfit">Konfirmasi Hapus</h3>
        <p class="text-gray-500 text-base mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus layanan <br><span id="hapus_nama_layanan" class="font-bold text-gray-800 text-lg"></span>?<br><span class="text-sm text-red-400 mt-1 block">Tindakan ini tidak dapat dibatalkan.</span></p>
        
        <form id="formHapusLayanan" method="POST" class="flex justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModalHapusLayanan()" class="px-6 py-3 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors w-1/2">Batal</button>
            <button type="submit" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium shadow-sm transition-colors w-1/2 flex justify-center items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<script>
    function openModalTambahLayanan() {
        document.getElementById('modalTambahLayanan').classList.remove('hidden');
        document.getElementById('modalTambahLayanan').classList.add('flex');
    }
    
    function closeModalTambahLayanan() {
        document.getElementById('modalTambahLayanan').classList.add('hidden');
        document.getElementById('modalTambahLayanan').classList.remove('flex');
    }

    function openModalEditLayanan(id, nama) {
        document.getElementById('modalEditLayanan').classList.remove('hidden');
        document.getElementById('modalEditLayanan').classList.add('flex');
        
        document.getElementById('formEditLayanan').action = `/dashboard/super-admin/data-master/layanan/${id}`;
        
        document.getElementById('edit_nama_layanan').value = nama;
    }

    function closeModalEditLayanan() {
        document.getElementById('modalEditLayanan').classList.add('hidden');
        document.getElementById('modalEditLayanan').classList.remove('flex');
    }

    function openModalHapusLayanan(id, nama) {
        document.getElementById('modalHapusLayanan').classList.remove('hidden');
        document.getElementById('modalHapusLayanan').classList.add('flex');
        
        document.getElementById('hapus_nama_layanan').textContent = nama;
        document.getElementById('formHapusLayanan').action = `/dashboard/super-admin/data-master/layanan/${id}`;
    }

    function closeModalHapusLayanan() {
        document.getElementById('modalHapusLayanan').classList.add('hidden');
        document.getElementById('modalHapusLayanan').classList.remove('flex');
    }
</script>
@elseif($tab == 'pencucian')
<!-- MODAL TAMBAH PENCUCIAN -->
<div id="modalTambahPencucian" class="{{ session('error_modal_tambah_pencucian') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Tambah Jenis Pencucian</h3>
            <button type="button" onclick="closeModalTambahPencucian()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('super_admin.pencucian.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                @if(session('error_modal_tambah_pencucian') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pencucian <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pencucian" value="{{ old('nama_pencucian') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambahPencucian()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PENCUCIAN -->
<div id="modalEditPencucian" class="{{ session('error_modal_edit_pencucian') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Edit Jenis Pencucian</h3>
            <button type="button" onclick="closeModalEditPencucian()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEditPencucian" action="{{ session('error_modal_edit_pencucian') ? route('super_admin.pencucian.update', session('error_modal_edit_pencucian')) : '' }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                @if(session('error_modal_edit_pencucian') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pencucian <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_nama_pencucian" name="nama_pencucian" value="{{ old('nama_pencucian') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalEditPencucian()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS PENCUCIAN -->
<div id="modalHapusPencucian" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden text-center p-8">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2 font-outfit">Konfirmasi Hapus</h3>
        <p class="text-gray-500 text-base mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus pencucian <br><span id="hapus_nama_pencucian" class="font-bold text-gray-800 text-lg"></span>?<br><span class="text-sm text-red-400 mt-1 block">Tindakan ini tidak dapat dibatalkan.</span></p>
        
        <form id="formHapusPencucian" method="POST" class="flex justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModalHapusPencucian()" class="px-6 py-3 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors w-1/2">Batal</button>
            <button type="submit" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium shadow-sm transition-colors w-1/2 flex justify-center items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<script>
    function openModalTambahPencucian() {
        document.getElementById('modalTambahPencucian').classList.remove('hidden');
        document.getElementById('modalTambahPencucian').classList.add('flex');
    }
    
    function closeModalTambahPencucian() {
        document.getElementById('modalTambahPencucian').classList.add('hidden');
        document.getElementById('modalTambahPencucian').classList.remove('flex');
    }

    function openModalEditPencucian(id, nama) {
        document.getElementById('modalEditPencucian').classList.remove('hidden');
        document.getElementById('modalEditPencucian').classList.add('flex');
        
        document.getElementById('formEditPencucian').action = `/dashboard/super-admin/data-master/pencucian/${id}`;
        
        document.getElementById('edit_nama_pencucian').value = nama;
    }

    function closeModalEditPencucian() {
        document.getElementById('modalEditPencucian').classList.add('hidden');
        document.getElementById('modalEditPencucian').classList.remove('flex');
    }

    function openModalHapusPencucian(id, nama) {
        document.getElementById('modalHapusPencucian').classList.remove('hidden');
        document.getElementById('modalHapusPencucian').classList.add('flex');
        
        document.getElementById('hapus_nama_pencucian').textContent = nama;
        document.getElementById('formHapusPencucian').action = `/dashboard/super-admin/data-master/pencucian/${id}`;
    }

    function closeModalHapusPencucian() {
        document.getElementById('modalHapusPencucian').classList.add('hidden');
        document.getElementById('modalHapusPencucian').classList.remove('flex');
    }
</script>
@elseif($tab == 'pengiriman')
<!-- MODAL TAMBAH PENGIRIMAN -->
<div id="modalTambahPengiriman" class="{{ session('error_modal_tambah_pengiriman') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Tambah Jenis Pengiriman</h3>
            <button type="button" onclick="closeModalTambahPengiriman()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('super_admin.pengiriman.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                @if(session('error_modal_tambah_pengiriman') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilihan Pengiriman <span class="text-red-500">*</span></label>
                    <input type="text" name="pilihan_pengiriman" value="{{ old('pilihan_pengiriman') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambahPengiriman()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PENGIRIMAN -->
<div id="modalEditPengiriman" class="{{ session('error_modal_edit_pengiriman') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Edit Jenis Pengiriman</h3>
            <button type="button" onclick="closeModalEditPengiriman()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEditPengiriman" action="{{ session('error_modal_edit_pengiriman') ? route('super_admin.pengiriman.update', session('error_modal_edit_pengiriman')) : '' }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                @if(session('error_modal_edit_pengiriman') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilihan Pengiriman <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_pilihan_pengiriman" name="pilihan_pengiriman" value="{{ old('pilihan_pengiriman') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalEditPengiriman()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS PENGIRIMAN -->
<div id="modalHapusPengiriman" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden text-center p-8">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2 font-outfit">Konfirmasi Hapus</h3>
        <p class="text-gray-500 text-base mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus pengiriman <br><span id="hapus_pilihan_pengiriman" class="font-bold text-gray-800 text-lg"></span>?<br><span class="text-sm text-red-400 mt-1 block">Tindakan ini tidak dapat dibatalkan.</span></p>
        
        <form id="formHapusPengiriman" method="POST" class="flex justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModalHapusPengiriman()" class="px-6 py-3 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors w-1/2">Batal</button>
            <button type="submit" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium shadow-sm transition-colors w-1/2 flex justify-center items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<script>
    function openModalTambahPengiriman() {
        document.getElementById('modalTambahPengiriman').classList.remove('hidden');
        document.getElementById('modalTambahPengiriman').classList.add('flex');
    }
    
    function closeModalTambahPengiriman() {
        document.getElementById('modalTambahPengiriman').classList.add('hidden');
        document.getElementById('modalTambahPengiriman').classList.remove('flex');
    }

    function openModalEditPengiriman(id, pilihan) {
        document.getElementById('modalEditPengiriman').classList.remove('hidden');
        document.getElementById('modalEditPengiriman').classList.add('flex');
        
        document.getElementById('formEditPengiriman').action = `/dashboard/super-admin/data-master/pengiriman/${id}`;
        
        document.getElementById('edit_pilihan_pengiriman').value = pilihan;
    }

    function closeModalEditPengiriman() {
        document.getElementById('modalEditPengiriman').classList.add('hidden');
        document.getElementById('modalEditPengiriman').classList.remove('flex');
    }

    function openModalHapusPengiriman(id, pilihan) {
        document.getElementById('modalHapusPengiriman').classList.remove('hidden');
        document.getElementById('modalHapusPengiriman').classList.add('flex');
        
        document.getElementById('hapus_pilihan_pengiriman').textContent = pilihan;
        document.getElementById('formHapusPengiriman').action = `/dashboard/super-admin/data-master/pengiriman/${id}`;
    }

    function closeModalHapusPengiriman() {
        document.getElementById('modalHapusPengiriman').classList.add('hidden');
        document.getElementById('modalHapusPengiriman').classList.remove('flex');
    }
</script>
@elseif($tab == 'item')
<!-- MODAL TAMBAH ITEM -->
<div id="modalTambahItem" class="{{ session('error_modal_tambah_item') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Tambah Item Laundry</h3>
            <button type="button" onclick="closeModalTambahItem()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('super_admin.item.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                @if(session('error_modal_tambah_item') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_item" value="{{ old('nama_item') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                    <select name="id_layanan" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        <option value="">Pilih layanan (opsional)...</option>
                        @foreach($layanans_list as $layanan)
                            <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pencucian</label>
                    <select name="id_pencucian" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        <option value="">Pilih jenis pencucian (opsional)...</option>
                        @foreach($pencucians_list as $pencucian)
                            <option value="{{ $pencucian->id }}">{{ $pencucian->nama_pencucian }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="harga" value="{{ old('harga') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                    <p class="text-xs text-gray-400 mt-1">Biarkan 0 untuk item kiloan, isi harga untuk satuan (misal: Sepatu 35000).</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                    <select name="satuan" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        <option value="" disabled selected>Pilih satuan...</option>
                        <option value="pcs">PCS (Per Piece)</option>
                        <option value="kg">KG (Per Kilogram)</option>
                    </select>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambahItem()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT ITEM -->
<div id="modalEditItem" class="{{ session('error_modal_edit_item') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Edit Item Laundry</h3>
            <button type="button" onclick="closeModalEditItem()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEditItem" action="{{ session('error_modal_edit_item') ? route('super_admin.item.update', session('error_modal_edit_item')) : '' }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                @if(session('error_modal_edit_item') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_nama_item" name="nama_item" value="{{ old('nama_item') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                    <select id="edit_id_layanan" name="id_layanan" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        <option value="">Pilih layanan (opsional)...</option>
                        @foreach($layanans_list as $layanan)
                            <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pencucian</label>
                    <select id="edit_id_pencucian" name="id_pencucian" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        <option value="">Pilih jenis pencucian (opsional)...</option>
                        @foreach($pencucians_list as $pencucian)
                            <option value="{{ $pencucian->id }}">{{ $pencucian->nama_pencucian }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="edit_harga_item" name="harga" value="{{ old('harga') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                    <select id="edit_satuan_item" name="satuan" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        <option value="" disabled>Pilih satuan...</option>
                        <option value="pcs">PCS (Per Piece)</option>
                        <option value="kg">KG (Per Kilogram)</option>
                    </select>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalEditItem()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS ITEM -->
<div id="modalHapusItem" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden text-center p-8">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2 font-outfit">Konfirmasi Hapus</h3>
        <p class="text-gray-500 text-base mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus item <br><span id="hapus_nama_item" class="font-bold text-gray-800 text-lg"></span>?<br><span class="text-sm text-red-400 mt-1 block">Tindakan ini tidak dapat dibatalkan.</span></p>
        
        <form id="formHapusItem" method="POST" class="flex justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModalHapusItem()" class="px-6 py-3 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors w-1/2">Batal</button>
            <button type="submit" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium shadow-sm transition-colors w-1/2 flex justify-center items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<script>
    function openModalTambahItem() {
        document.getElementById('modalTambahItem').classList.remove('hidden');
        document.getElementById('modalTambahItem').classList.add('flex');
    }
    
    function closeModalTambahItem() {
        document.getElementById('modalTambahItem').classList.add('hidden');
        document.getElementById('modalTambahItem').classList.remove('flex');
    }

    function openModalEditItem(id, nama, harga, satuan) {
        document.getElementById('modalEditItem').classList.remove('hidden');
        document.getElementById('modalEditItem').classList.add('flex');
        
        document.getElementById('formEditItem').action = `/dashboard/super-admin/data-master/item/${id}`;
        
        document.getElementById('edit_nama_item').value = nama;
        document.getElementById('edit_harga_item').value = harga;
        document.getElementById('edit_satuan_item').value = satuan;
    }

    function closeModalEditItem() {
        document.getElementById('modalEditItem').classList.add('hidden');
        document.getElementById('modalEditItem').classList.remove('flex');
    }

    function openModalHapusItem(id, nama) {
        document.getElementById('modalHapusItem').classList.remove('hidden');
        document.getElementById('modalHapusItem').classList.add('flex');
        
        document.getElementById('hapus_nama_item').textContent = nama;
        document.getElementById('formHapusItem').action = `/dashboard/super-admin/data-master/item/${id}`;
    }

    function closeModalHapusItem() {
        document.getElementById('modalHapusItem').classList.add('hidden');
        document.getElementById('modalHapusItem').classList.remove('flex');
    }
</script>
@elseif($tab == 'promo')
<!-- MODAL TAMBAH PROMO -->
<div id="modalTambahPromo" class="{{ session('error_modal_tambah_promo') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Tambah Promo Baru</h3>
            <button type="button" onclick="closeModalTambahPromo()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('super_admin.promo.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                @if(session('error_modal_tambah_promo') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Promo <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_promo" value="{{ old('nama_promo') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Potongan Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="potongan" value="{{ old('potongan') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambahPromo()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PROMO -->
<div id="modalEditPromo" class="{{ session('error_modal_edit_promo') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Edit Promo</h3>
            <button type="button" onclick="closeModalEditPromo()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEditPromo" action="{{ session('error_modal_edit_promo') ? route('super_admin.promo.update', session('error_modal_edit_promo')) : '' }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                @if(session('error_modal_edit_promo') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Promo <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_nama_promo" name="nama_promo" value="{{ old('nama_promo') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Potongan Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="edit_potongan_promo" name="potongan" value="{{ old('potongan') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="date" id="edit_tanggal_mulai_promo" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="date" id="edit_tanggal_selesai_promo" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalEditPromo()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS PROMO -->
<div id="modalHapusPromo" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden text-center p-8">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2 font-outfit">Konfirmasi Hapus</h3>
        <p class="text-gray-500 text-base mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus promo <br><span id="hapus_nama_promo" class="font-bold text-gray-800 text-lg"></span>?<br><span class="text-sm text-red-400 mt-1 block">Tindakan ini tidak dapat dibatalkan.</span></p>
        
        <form id="formHapusPromo" method="POST" class="flex justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModalHapusPromo()" class="px-6 py-3 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors w-1/2">Batal</button>
            <button type="submit" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium shadow-sm transition-colors w-1/2 flex justify-center items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<script>
    function openModalTambahPromo() {
        document.getElementById('modalTambahPromo').classList.remove('hidden');
        document.getElementById('modalTambahPromo').classList.add('flex');
    }
    
    function closeModalTambahPromo() {
        document.getElementById('modalTambahPromo').classList.add('hidden');
        document.getElementById('modalTambahPromo').classList.remove('flex');
    }

    function openModalEditPromo(id, nama, potongan, mulai, selesai) {
        document.getElementById('modalEditPromo').classList.remove('hidden');
        document.getElementById('modalEditPromo').classList.add('flex');
        
        document.getElementById('formEditPromo').action = `/dashboard/super-admin/data-master/promo/${id}`;
        
        document.getElementById('edit_nama_promo').value = nama;
        document.getElementById('edit_potongan_promo').value = potongan;
        document.getElementById('edit_tanggal_mulai_promo').value = mulai;
        document.getElementById('edit_tanggal_selesai_promo').value = selesai;
    }

    function closeModalEditPromo() {
        document.getElementById('modalEditPromo').classList.add('hidden');
        document.getElementById('modalEditPromo').classList.remove('flex');
    }

    function openModalHapusPromo(id, nama) {
        document.getElementById('modalHapusPromo').classList.remove('hidden');
        document.getElementById('modalHapusPromo').classList.add('flex');
        
        document.getElementById('hapus_nama_promo').textContent = nama;
        document.getElementById('formHapusPromo').action = `/dashboard/super-admin/data-master/promo/${id}`;
    }

    function closeModalHapusPromo() {
        document.getElementById('modalHapusPromo').classList.add('hidden');
        document.getElementById('modalHapusPromo').classList.remove('flex');
    }
</script>
@elseif($tab == 'satuan')
<!-- MODAL TAMBAH SATUAN -->
<div id="modalTambahSatuan" class="{{ session('error_modal_tambah_satuan') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Tambah Satuan Baru</h3>
            <button type="button" onclick="closeModalTambahSatuan()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('super_admin.satuan.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                @if(session('error_modal_tambah_satuan') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Satuan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_satuan" value="{{ old('nama_satuan') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Contoh: kg, pcs, liter, dll">
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambahSatuan()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT SATUAN -->
<div id="modalEditSatuan" class="{{ session('error_modal_edit_satuan') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Edit Satuan</h3>
            <button type="button" onclick="closeModalEditSatuan()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEditSatuan" action="{{ session('error_modal_edit_satuan') ? route('super_admin.satuan.update', session('error_modal_edit_satuan')) : '' }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                @if(session('error_modal_edit_satuan') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Satuan <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_nama_satuan" name="nama_satuan" value="{{ old('nama_satuan') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalEditSatuan()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS SATUAN -->
<div id="modalHapusSatuan" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full my-6">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 6H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v15a2 2 0 01-2 2z"></path></svg>
        </div>
        <h3 class="text-lg font-semibold text-center text-gray-800">Hapus Satuan?</h3>
        <p class="text-center text-gray-600 text-sm mt-2 px-6">Anda yakin ingin menghapus satuan <strong id="hapus_nama_satuan"></strong>? Data yang dihapus tidak dapat dipulihkan.</p>
        <form id="formHapusSatuan" method="POST" class="mt-6">
            @csrf
            @method('DELETE')
            <div class="flex gap-3 px-6 py-4">
                <button type="button" onclick="closeModalHapusSatuan()" class="px-6 py-3 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors w-1/2">Batal</button>
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition-colors w-1/2 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalTambahSatuan() {
        document.getElementById('modalTambahSatuan').classList.remove('hidden');
        document.getElementById('modalTambahSatuan').classList.add('flex');
    }
    
    function closeModalTambahSatuan() {
        document.getElementById('modalTambahSatuan').classList.add('hidden');
        document.getElementById('modalTambahSatuan').classList.remove('flex');
    }

    function openModalEditSatuan(id, nama) {
        document.getElementById('modalEditSatuan').classList.remove('hidden');
        document.getElementById('modalEditSatuan').classList.add('flex');
        
        document.getElementById('formEditSatuan').action = `/dashboard/super-admin/data-master/satuan/${id}`;
        document.getElementById('edit_nama_satuan').value = nama;
    }

    function closeModalEditSatuan() {
        document.getElementById('modalEditSatuan').classList.add('hidden');
        document.getElementById('modalEditSatuan').classList.remove('flex');
    }

    function openModalHapusSatuan(id, nama) {
        document.getElementById('modalHapusSatuan').classList.remove('hidden');
        document.getElementById('modalHapusSatuan').classList.add('flex');
        
        document.getElementById('hapus_nama_satuan').textContent = nama;
        document.getElementById('formHapusSatuan').action = `/dashboard/super-admin/data-master/satuan/${id}`;
    }

    function closeModalHapusSatuan() {
        document.getElementById('modalHapusSatuan').classList.add('hidden');
        document.getElementById('modalHapusSatuan').classList.remove('flex');
    }
</script>
@endif

@endsection
