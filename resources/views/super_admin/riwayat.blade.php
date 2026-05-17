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
                    <form action="{{ route('dashboard.super_admin.riwayat') }}" method="GET" class="w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Cari ID atau Keterangan..." onchange="this.form.submit()">
                    </form>
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
                    @forelse($riwayats as $index => $r)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500">{{ $riwayats->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800">LOG-{{ str_pad($r->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6 whitespace-nowrap text-gray-500">
                            {{ \Carbon\Carbon::parse($r->created_at)->format('d M Y') }}
                            <span class="text-gray-400 text-xs ml-1">{{ \Carbon\Carbon::parse($r->created_at)->format('H:i:s') }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                @php
                                    $nama = $r->pengguna->nama ?? 'Sistem';
                                    $inisial = strtoupper(substr($nama, 0, 1));
                                @endphp
                                <div class="w-6 h-6 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-xs">{{ $inisial }}</div>
                                <span class="font-medium text-gray-800">{{ $nama }} <span class="text-xs text-gray-400 font-normal">(Kasir)</span></span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">Buat Transaksi</span>
                        </td>
                        <td class="py-4 px-6 text-gray-600">
                            Membuat nota baru <b>INV-{{ str_pad($r->id, 5, '0', STR_PAD_LEFT) }}</b> untuk pelanggan {{ $r->pelanggan->nama_lengkap ?? '-' }} sejumlah Rp {{ number_format($r->total_transaksi, 0, ',', '.') }}.
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400 italic">Belum ada riwayat aktivitas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $riwayats->links() }}
        </div>
    </div>
</div>
@endsection
