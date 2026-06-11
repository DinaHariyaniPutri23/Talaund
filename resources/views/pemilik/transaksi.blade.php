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
                <form action="{{ route('dashboard.pemilik.transaksi') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Cari Nota atau Pelanggan..." onchange="this.form.submit()">
                    </div>
                    <select name="status" class="block w-full sm:w-40 pl-3 pr-10 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none" onchange="this.form.submit()">
                        <option value="">Status Bayar</option>
                        <option value="lunas" {{ ($status ?? '') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Belum Bayar</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold">No Nota</th>
                        <th class="py-4 px-6 font-semibold">Nama Pelanggan</th>
                        <th class="py-4 px-6 font-semibold">Tanggal</th>
                        <th class="py-4 px-6 font-semibold text-right">Total Harga</th>
                        <th class="py-4 px-6 font-semibold text-center">Status Bayar</th>
                        <th class="py-4 px-6 font-semibold w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transaksis as $t)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 font-bold text-blue-600">INV-{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800">{{ $t->pelanggan->nama_lengkap ?? '-' }}</td>
                        <td class="py-4 px-6 whitespace-nowrap">{{ $t->tanggal_transaksi->format('d M Y') }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-right">Rp {{ number_format($t->total_transaksi, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-center">
                            @if(optional($t->pembayaran)->status_bayar == 'paid')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">Lunas</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('dashboard.kasir.struk', $t->id) }}" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail Nota">
                                <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400 italic">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection
