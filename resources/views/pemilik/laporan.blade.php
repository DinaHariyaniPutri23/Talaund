@extends('layouts.dashboard')

@section('title', 'Laporan Keuangan')
@section('header_title', 'Laporan Keuangan')
@section('header_subtitle', 'Rekapitulasi pendapatan tunai, non-tunai, dan piutang')

@section('content')
<div class="space-y-6 pb-10">

    <!-- Filter & Export Action Bar -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 p-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        
        <!-- Date Filters -->
        <form action="{{ route('dashboard.pemilik.laporan') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <span class="text-sm font-medium text-gray-500 whitespace-nowrap">Dari:</span>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="block w-full sm:w-40 px-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all text-gray-600">
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <span class="text-sm font-medium text-gray-500 whitespace-nowrap">Sampai:</span>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="block w-full sm:w-40 px-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all text-gray-600">
            </div>
            <button type="submit" class="w-full sm:w-auto bg-blue-50 hover:bg-blue-100 text-blue-600 px-5 py-2 rounded-xl font-medium text-sm transition-all">
                Terapkan Filter
            </button>
        </form>

        <!-- Export Buttons -->
        <div class="flex items-center gap-3 w-full lg:w-auto mt-4 lg:mt-0">
            <form action="{{ route('dashboard.pemilik.laporan') }}" method="GET" class="inline">
                <input type="hidden" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                <input type="hidden" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
                <input type="hidden" name="export" value="pdf">
                <button type="submit" class="flex-1 lg:flex-none flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 px-5 py-2.5 rounded-xl font-medium text-sm transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Ekspor PDF
                </button>
            </form>
            <form action="{{ route('dashboard.pemilik.laporan') }}" method="GET" class="inline">
                <input type="hidden" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                <input type="hidden" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
                <input type="hidden" name="export" value="excel">
                <button type="submit" class="flex-1 lg:flex-none flex items-center justify-center gap-2 bg-green-50 hover:bg-green-100 text-green-600 px-5 py-2.5 rounded-xl font-medium text-sm transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Ekspor Excel
                </button>
            </form>
        </div>
    </div>

    <!-- Summary Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Metric 1: Total Cucian -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Cucian Masuk</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalCucian) }} <span class="text-sm font-normal text-gray-400">Nota</span></h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Metric 2: Total Tunai -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Tunai (Cash)</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalTunai, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Metric 3: Total Xendit -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total via Xendit</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalXendit, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Metric 4: Total Promo -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 z-0"></div>
            <div class="relative z-10 flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Potongan Promo</p>
                    <h3 class="text-2xl font-bold text-red-500">- Rp {{ number_format($totalPromo, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Detail Table Breakdown -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Rincian Pendapatan Harian</h3>
            <span class="text-sm font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Total Bersih: Rp {{ number_format($totalBersih, 0, ',', '.') }}</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold">Tanggal</th>
                        <th class="py-4 px-6 font-semibold text-center">Jml Nota</th>
                        <th class="py-4 px-6 font-semibold text-right">Tunai (Cash)</th>
                        <th class="py-4 px-6 font-semibold text-right">Xendit (Non-Tunai)</th>
                        <th class="py-4 px-6 font-semibold text-right text-red-500">Potongan Promo</th>
                        <th class="py-4 px-6 font-semibold text-right text-blue-600">Total Pemasukan Bersih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($rincianHarian as $rincian)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 font-medium text-gray-800">{{ $rincian['tanggal'] }}</td>
                        <td class="py-4 px-6 text-center">{{ number_format($rincian['jml_nota']) }}</td>
                        <td class="py-4 px-6 text-right">Rp {{ number_format($rincian['tunai'], 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-right">Rp {{ number_format($rincian['xendit'], 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-right text-red-500">- Rp {{ number_format($rincian['promo'], 0, ',', '.') }}</td>
                        <td class="py-4 px-6 font-bold text-gray-800 text-right">Rp {{ number_format($rincian['total_bersih'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400 italic">Belum ada data untuk periode ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
