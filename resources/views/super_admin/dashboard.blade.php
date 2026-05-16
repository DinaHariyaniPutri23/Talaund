@extends('layouts.dashboard')

@section('title', 'Dashboard Sistem')
@section('header_title', 'DASHBOARD SISTEM')
@section('header_subtitle', '')

@section('content')
<div class="space-y-6">
    <!-- Top Stats Cards: 3 Columns -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Status Xendit -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
            <div class="w-20 h-20 rounded-full bg-green-50 flex items-center justify-center text-green-500 shrink-0">
                <svg class="w-10 h-10 transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            </div>
            <div>
                <p class="text-[0.8rem] font-bold text-gray-700 tracking-wider mb-2">STATUS XENDIT</p>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <h3 class="text-lg font-bold text-green-500 uppercase tracking-wide">TERHUBUNG</h3>
                </div>
            </div>
        </div>

        <!-- Card 2: Status Printer -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
            <div class="w-20 h-20 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 shrink-0">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            </div>
            <div>
                <p class="text-[0.8rem] font-bold text-gray-700 tracking-wider mb-2">STATUS PRINTER</p>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <h3 class="text-lg font-bold text-green-500 uppercase tracking-wide">READY</h3>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Pelanggan -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
            <div class="w-20 h-20 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 shrink-0">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-[0.8rem] font-bold text-gray-700 tracking-wider mb-1">TOTAL PELANGGAN</p>
                <h3 class="text-3xl font-bold text-blue-600">150</h3>
                <p class="text-sm text-gray-500">Orang</p>
            </div>
        </div>
    </div>

    <!-- Bottom Section: 5 Riwayat Aktivitas -->
    <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            <h2 class="text-lg font-bold text-blue-900 tracking-wide uppercase">5 RIWAYAT AKTIVITAS TERBARU</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-800 font-bold border-b border-gray-100">
                        <th class="py-4 px-6 w-48">Waktu</th>
                        <th class="py-4 px-6 w-64">User</th>
                        <th class="py-4 px-6">Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/50">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-2 text-gray-800 font-medium">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                20:45
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded bg-blue-100/70 text-blue-600 text-xs font-semibold tracking-wide">System</span>
                        </td>
                        <td class="py-5 px-6 text-gray-700 font-medium">Webhook Xendit: #ML-099 Lunas</td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-2 text-gray-800 font-medium">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                20:30
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded bg-green-100/70 text-green-600 text-xs font-semibold tracking-wide">Admin Mila</span>
                        </td>
                        <td class="py-5 px-6 text-gray-700 font-medium">Mengubah Harga Layanan Satuan</td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-2 text-gray-800 font-medium">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                19:15
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded bg-purple-100/70 text-purple-600 text-xs font-semibold tracking-wide">Kasir Ahmad</span>
                        </td>
                        <td class="py-5 px-6 text-gray-700 font-medium">Menghapus Data Transaksi #088</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 flex justify-end border-t border-gray-100 pt-6">
            <a href="#" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg border border-blue-200 text-blue-600 text-sm font-semibold hover:bg-blue-50 transition-colors">
                Lihat Semua Riwayat
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>
</div>
@endsection
