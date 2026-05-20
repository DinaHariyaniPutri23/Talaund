@extends('layouts.dashboard')

@section('title', 'Dashboard Pemilik')
@section('header_title', 'Dashboard')
@section('header_subtitle', 'Ringkasan performa laundry Anda hari ini.')

@section('content')
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-[20px] mb-[30px]">
        <div class="bg-cardBg rounded-[12px] p-[25px] flex items-start gap-[15px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-[rgba(0,0,0,0.04)] hover:shadow-[0_8px_16px_rgba(0,0,0,0.08)] transition-all">
            <div class="w-[55px] h-[55px] shrink-0 rounded-full flex items-center justify-center text-[1.5rem] font-bold bg-[#E6F8ED] text-[#10B981]">Rp</div>
            <div class="flex-1">
                <p class="text-textDark text-[0.85rem] font-semibold mb-[5px]">Total Omzet Bulan Ini</p>
                <h4 class="text-[1.6rem] font-bold mb-[8px] text-[#10B981]">Rp {{ number_format($totalOmzetBulanIni, 0, ',', '.') }}</h4>
                <p class="text-[0.8rem] text-textMuted">{{ $percentageOmzet >= 0 ? '+' : '' }}{{ $percentageOmzet }}% dari bulan lalu</p>
            </div>
        </div>

        <div class="bg-cardBg rounded-[12px] p-[25px] flex items-start gap-[15px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-[rgba(0,0,0,0.04)] hover:shadow-[0_8px_16px_rgba(0,0,0,0.08)] transition-all">
            <div class="w-[55px] h-[55px] shrink-0 rounded-full flex items-center justify-center text-[1.5rem] font-bold bg-[#EBF4FF] text-[#3B82F6]">
                <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="flex-1">
                <p class="text-textDark text-[0.85rem] font-semibold mb-[5px]">Total Transaksi</p>
                <h4 class="text-[1.6rem] font-bold mb-[8px] text-[#3B82F6]">{{ number_format($totalTransaksiBulanIni) }}</h4>
                <p class="text-[0.8rem] text-textMuted">{{ $percentageTransaksi >= 0 ? '+' : '' }}{{ $percentageTransaksi }}% dari bulan lalu</p>
            </div>
        </div>

        <div class="bg-cardBg rounded-[12px] p-[25px] flex items-start gap-[15px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-[rgba(0,0,0,0.04)] hover:shadow-[0_8px_16px_rgba(0,0,0,0.08)] transition-all">
            <div class="w-[55px] h-[55px] shrink-0 rounded-full flex items-center justify-center text-[1.5rem] font-bold bg-[#F3E8FF] text-[#8B5CF6]">
                <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div class="flex-1">
                <p class="text-textDark text-[0.85rem] font-semibold mb-[5px]">Jumlah Pelanggan Baru</p>
                <h4 class="text-[1.6rem] font-bold mb-[8px] text-[#8B5CF6]">{{ number_format($pelangganBaruBulanIni) }}</h4>
                <p class="text-[0.8rem] text-textMuted">{{ $percentagePelanggan >= 0 ? '+' : '' }}{{ $percentagePelanggan }}% dari bulan lalu</p>
            </div>
        </div>

        <div class="bg-cardBg rounded-[12px] p-[25px] flex items-start gap-[15px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-[rgba(0,0,0,0.04)] hover:shadow-[0_8px_16px_rgba(0,0,0,0.08)] transition-all">
            <div class="w-[55px] h-[55px] shrink-0 rounded-full flex items-center justify-center text-[1.5rem] font-bold bg-[#FEE2E2] text-[#EF4444]">
                <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
            <div class="flex-1">
                <p class="text-textDark text-[0.85rem] font-semibold mb-[5px]">Piutang Berjalan</p>
                <h4 class="text-[1.6rem] font-bold mb-[8px] text-[#EF4444]">Rp {{ number_format($piutangBerjalan, 0, ',', '.') }}</h4>
                <p class="text-[0.8rem] text-textMuted">{{ $totalBelumLunas }} Transaksi Belum Lunas</p>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-cardBg rounded-[12px] p-[25px] mb-[30px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-[rgba(0,0,0,0.04)]">
        <div class="flex justify-between items-start mb-[20px]">
            <div>
                <h3 class="text-[1.1rem] text-textDark mb-[5px] font-bold">Tren Pendapatan</h3>
                <p class="text-[0.85rem] text-textMuted">Omzet 30 Hari Terakhir</p>
            </div>
            <div>
                <select class="p-[8px_15px] rounded-[6px] border border-borderColor outline-none bg-cardBg font-sans text-[0.85rem]">
                    <option>30 Hari Terakhir</option>
                    <option>Bulan Ini</option>
                    <option>Tahun Ini</option>
                </select>
            </div>
        </div>
        <div class="h-[300px] w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-cardBg rounded-[12px] p-[25px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-[rgba(0,0,0,0.04)]">
        <div class="mb-[20px]">
            <h3 class="text-[1.1rem] font-bold">Transaksi Terbaru (5 Terakhir Hari Ini)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="text-left p-[15px] text-[0.85rem] text-textDark font-semibold bg-[#F8FAFC] border-b border-borderColor rounded-tl-[8px] rounded-bl-[8px]">No. Nota</th>
                        <th class="text-left p-[15px] text-[0.85rem] text-textDark font-semibold bg-[#F8FAFC] border-b border-borderColor">Pelanggan</th>
                        <th class="text-left p-[15px] text-[0.85rem] text-textDark font-semibold bg-[#F8FAFC] border-b border-borderColor">Total</th>
                        <th class="text-left p-[15px] text-[0.85rem] text-textDark font-semibold bg-[#F8FAFC] border-b border-borderColor">Status</th>
                        <th class="text-left p-[15px] text-[0.85rem] text-textDark font-semibold bg-[#F8FAFC] border-b border-borderColor rounded-tr-[8px] rounded-br-[8px]">Waktu Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiTerbaru as $t)
                    <tr>
                        <td class="text-left p-[15px] text-[0.85rem] text-textDark font-semibold border-b border-borderColor">INV-{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="text-left p-[15px] text-[0.85rem] text-textDark border-b border-borderColor">{{ $t->pelanggan->nama_lengkap ?? '-' }}</td>
                        <td class="text-left p-[15px] text-[0.85rem] font-semibold text-[#10B981] border-b border-borderColor">Rp {{ number_format($t->total_transaksi, 0, ',', '.') }}</td>
                        <td class="text-left p-[15px] text-[0.85rem] border-b border-borderColor">
                            @if(optional($t->pembayaran)->status_bayar == 'paid')
                                <span class="inline-block px-[10px] py-[4px] bg-[#E6F8ED] text-[#10B981] rounded-[6px] text-[0.75rem] font-semibold">Lunas</span>
                            @else
                                <span class="inline-block px-[10px] py-[4px] bg-[#FEE2E2] text-[#EF4444] rounded-[6px] text-[0.75rem] font-semibold">Belum Lunas</span>
                            @endif
                        </td>
                        <td class="text-left p-[15px] text-[0.85rem] text-textMuted border-b border-borderColor">{{ $t->tanggal_transaksi->format('H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-textMuted p-[30px] border-b border-borderColor">
                            Belum ada data transaksi hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Gradient for line chart
        let gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_map(fn($d) => $d['date'], $trendData)) !!},
                datasets: [{
                    label: 'Omzet',
                    data: {!! json_encode(array_map(fn($d) => $d['omzet'], $trendData)) !!},
                    borderColor: '#3B82F6',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#FFFFFF',
                    pointBorderColor: '#3B82F6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        titleFont: { family: 'Inter', size: 13 },
                        bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: 'Inter', size: 11 },
                            color: '#64748B'
                        }
                    },
                    y: {
                        grid: {
                            color: '#F1F5F9',
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: 'Inter', size: 11 },
                            color: '#64748B',
                            callback: function(value) {
                                if(value === 0) return 'Rp 0';
                                if(value >= 1000000) return 'Rp ' + (value/1000000) + ' jt';
                                if(value >= 1000) return 'Rp ' + (value/1000) + ' rb';
                                return 'Rp ' + value;
                            }
                        },
                        beginAtZero: true,
                        max: 1000000 // Set max to 1jt so the chart isn't just a flat line at the bottom of nothing
                    }
                }
            }
        });
    });
</script>
@endpush
