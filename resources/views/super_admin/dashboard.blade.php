@extends('layouts.dashboard')

@section('title', 'Dashboard Sistem')
@section('header_title', 'DASHBOARD SISTEM')
@section('header_subtitle', '')

@section('content')
<div class="space-y-6">
    <!-- Top Stats Cards: 4 Columns -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Kas Kasir Hari Ini -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-green-50 flex items-center justify-center text-green-500 shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[0.8rem] font-bold text-gray-700 tracking-wider mb-1">KAS TUNAI HARI INI</p>
                <h3 class="text-2xl font-bold text-green-600">Rp {{ number_format($kasHariIni, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Card 2: Lunas -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[0.8rem] font-bold text-gray-700 tracking-wider mb-1">TRANSAKSI LUNAS</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $transaksiLunas }} Nota</h3>
            </div>
        </div>

        <!-- Card 3: Belum Lunas -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[0.8rem] font-bold text-gray-700 tracking-wider mb-1">BELUM LUNAS</p>
                <h3 class="text-2xl font-bold text-amber-500">{{ $transaksiPending }} Nota</h3>
            </div>
        </div>

        <!-- Card 4: Total Pelanggan -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-[0.8rem] font-bold text-gray-700 tracking-wider mb-1">TOTAL PELANGGAN</p>
                <h3 class="text-2xl font-bold text-purple-600">{{ $totalPelanggan }} Orang</h3>
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
                    @forelse($riwayatAktivitas as $riwayat)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-2 text-gray-800 font-medium">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ \Carbon\Carbon::parse($riwayat->tanggal_transaksi)->format('d/m/Y H:i') }}
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded bg-blue-100/70 text-blue-600 text-xs font-semibold tracking-wide">{{ $riwayat->pengguna->nama ?? 'Sistem' }}</span>
                        </td>
                        <td class="py-5 px-6 text-gray-700 font-medium">Transaksi Baru: INV-{{ str_pad($riwayat->id, 5, '0', STR_PAD_LEFT) }} (Rp {{ number_format($riwayat->total_transaksi, 0, ',', '.') }})</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-8 text-center text-gray-500 italic">Belum ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
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
