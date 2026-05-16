@extends('layouts.dashboard')

@section('title', 'Riwayat Sistem (Audit Log)')
@section('header_title', 'Riwayat Sistem')
@section('header_subtitle', 'Pantau semua aktivitas dan jejak digital pengguna di dalam sistem.')

@section('content')
<div class="space-y-6">

    <!-- Filters & Search -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Cari keterangan atau aksi...">
                </div>
                <select class="block w-full sm:w-40 pl-3 pr-10 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none">
                    <option value="">Semua Aksi</option>
                    <option value="create">Tambah Data</option>
                    <option value="update">Ubah Data</option>
                    <option value="delete">Hapus Data</option>
                    <option value="login">Login / Auth</option>
                </select>
                <input type="date" class="block w-full sm:w-40 px-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all text-gray-600">
            </div>
            <button class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export PDF
            </button>
        </div>

        <!-- Audit Log Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16">No</th>
                        <th class="py-4 px-6 font-semibold">ID Pencatatan</th>
                        <th class="py-4 px-6 font-semibold">Waktu</th>
                        <th class="py-4 px-6 font-semibold">Pelaku (User)</th>
                        <th class="py-4 px-6 font-semibold">Aksi</th>
                        <th class="py-4 px-6 font-semibold">Keterangan Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500">1</td>
                        <td class="py-4 px-6 font-medium text-gray-800">LOG-00921</td>
                        <td class="py-4 px-6 whitespace-nowrap text-gray-500">15 Mei 2026 <span class="text-gray-400 text-xs ml-1">11:05:22</span></td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs">M</div>
                                <span class="font-medium text-gray-800">Mila Karmila <span class="text-xs text-gray-400 font-normal">(Super Admin)</span></span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Ubah Harga</span>
                        </td>
                        <td class="py-4 px-6 text-gray-600">Mengubah harga <b>Jenis Pencucian Kiloan</b> dari Rp 6.000 menjadi Rp 7.000 per Kg.</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500">2</td>
                        <td class="py-4 px-6 font-medium text-gray-800">LOG-00920</td>
                        <td class="py-4 px-6 whitespace-nowrap text-gray-500">15 Mei 2026 <span class="text-gray-400 text-xs ml-1">10:15:00</span></td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-xs">S</div>
                                <span class="font-medium text-gray-800">Siti Nurhaliza <span class="text-xs text-gray-400 font-normal">(Kasir)</span></span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">Buat Transaksi</span>
                        </td>
                        <td class="py-4 px-6 text-gray-600">Membuat nota baru <b>INV-002</b> untuk pelanggan Siti Aminah sejumlah Rp 120.000.</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500">3</td>
                        <td class="py-4 px-6 font-medium text-gray-800">LOG-00919</td>
                        <td class="py-4 px-6 whitespace-nowrap text-gray-500">14 Mei 2026 <span class="text-gray-400 text-xs ml-1">18:30:10</span></td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs">A</div>
                                <span class="font-medium text-gray-800">Agus Setiawan <span class="text-xs text-gray-400 font-normal">(Kasir)</span></span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">Hapus Data</span>
                        </td>
                        <td class="py-4 px-6 text-gray-600">Menghapus data pelanggan dengan ID <b>PLG-012</b> secara permanen.</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors group bg-red-50/30">
                        <td class="py-4 px-6 text-gray-500">4</td>
                        <td class="py-4 px-6 font-medium text-gray-800">LOG-00918</td>
                        <td class="py-4 px-6 whitespace-nowrap text-gray-500">14 Mei 2026 <span class="text-gray-400 text-xs ml-1">16:45:05</span></td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs">M</div>
                                <span class="font-medium text-gray-800">Mila Karmila <span class="text-xs text-gray-400 font-normal">(Super Admin)</span></span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">Hapus Transaksi</span>
                        </td>
                        <td class="py-4 px-6 text-red-600 font-medium">Membatalkan dan menghapus transaksi <b>INV-045</b> dengan alasan salah input.</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500">5</td>
                        <td class="py-4 px-6 font-medium text-gray-800">LOG-00917</td>
                        <td class="py-4 px-6 whitespace-nowrap text-gray-500">14 Mei 2026 <span class="text-gray-400 text-xs ml-1">08:00:15</span></td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs">M</div>
                                <span class="font-medium text-gray-800">Mila Karmila <span class="text-xs text-gray-400 font-normal">(Super Admin)</span></span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">Login</span>
                        </td>
                        <td class="py-4 px-6 text-gray-600">Berhasil masuk ke sistem dari perangkat Desktop (IP: 192.168.1.5).</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan 1 hingga 5 dari 921 riwayat</p>
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
