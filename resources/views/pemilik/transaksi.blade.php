@extends('layouts.dashboard')

@section('title', 'Monitoring Transaksi')
@section('header_title', 'Monitoring Transaksi')
@section('header_subtitle', 'Pantau seluruh nota dan progres cucian yang sedang dikerjakan oleh kasir.')

@section('content')
<div class="space-y-6 pb-10">

    <!-- Content Card -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden mt-2">
        
        <!-- Toolbar (Search & Filters) -->
        <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Cari Nota atau Pelanggan...">
                </div>
                <select class="block w-full sm:w-40 pl-3 pr-10 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none">
                    <option value="">Status Bayar</option>
                    <option value="lunas">Lunas</option>
                    <option value="pending">Belum Bayar</option>
                </select>
            </div>
            
            <button class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl font-medium text-sm transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter Detail
            </button>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold">No Nota</th>
                        <th class="py-4 px-6 font-semibold">Nama Pelanggan</th>
                        <th class="py-4 px-6 font-semibold">Tanggal</th>
                        <th class="py-4 px-6 font-semibold">Layanan</th>
                        <th class="py-4 px-6 font-semibold text-right">Total Harga</th>
                        <th class="py-4 px-6 font-semibold text-center">Status Bayar</th>
                        <th class="py-4 px-6 font-semibold w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 font-bold text-blue-600">INV-090</td>
                        <td class="py-4 px-6 font-medium text-gray-800">Budi Santoso</td>
                        <td class="py-4 px-6 whitespace-nowrap">15 Mei 2026</td>
                        <td class="py-4 px-6">Kiloan Reguler</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-right">Rp 45.000</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">Lunas</span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail Nota" onclick="alert('Membuka detail nota INV-090 tanpa opsi Edit.')"><svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 font-bold text-blue-600">INV-091</td>
                        <td class="py-4 px-6 font-medium text-gray-800">Siti Aminah</td>
                        <td class="py-4 px-6 whitespace-nowrap">15 Mei 2026</td>
                        <td class="py-4 px-6">Satuan - Bed Cover</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-right">Rp 120.000</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Belum Bayar</span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail Nota" onclick="alert('Membuka detail nota INV-091 tanpa opsi Edit.')"><svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 font-bold text-blue-600">INV-092</td>
                        <td class="py-4 px-6 font-medium text-gray-800">Dedi Kusuma</td>
                        <td class="py-4 px-6 whitespace-nowrap">14 Mei 2026</td>
                        <td class="py-4 px-6">Kiloan Express 1 Hari</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-right">Rp 75.000</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">Lunas</span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail Nota" onclick="alert('Membuka detail nota INV-092 tanpa opsi Edit.')"><svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 font-bold text-blue-600">INV-093</td>
                        <td class="py-4 px-6 font-medium text-gray-800">Rina Melati</td>
                        <td class="py-4 px-6 whitespace-nowrap">14 Mei 2026</td>
                        <td class="py-4 px-6">Satuan - Jas</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-right">Rp 40.000</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">Lunas</span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail Nota" onclick="alert('Membuka detail nota INV-093 tanpa opsi Edit.')"><svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan 1 hingga 4 dari 42 nota hari ini</p>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1 border border-gray-200 rounded-lg text-gray-400 cursor-not-allowed text-sm">Prev</button>
                <button class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium">1</button>
                <button class="px-3 py-1 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 text-sm">2</button>
                <button class="px-3 py-1 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 text-sm">3</button>
                <span class="px-2 text-gray-400">...</span>
                <button class="px-3 py-1 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 text-sm">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection
