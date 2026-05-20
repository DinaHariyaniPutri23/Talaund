@extends('layouts.dashboard')

@section('title', 'Dashboard Kasir')
@section('header_title', 'Dashboard Kasir')
@section('header_subtitle', 'Ringkasan aktivitas dan transaksi laundry hari ini.')

@push('styles')
<style>
    /* SUMMARY CARDS */
    .summary-grid { 
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 24px; 
        margin-top: 15px; 
        margin-bottom: 40px; 
    }
    
    .summary-card { 
        background: white; 
        border-radius: 16px; 
        padding: 28px; 
        box-shadow: 0px 2px 8px rgba(0,0,0,0.04); 
        border: 1px solid #f0f2f5;
        display: flex; 
        align-items: center; 
        gap: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0px 12px 24px rgba(0,0,0,0.08);
    }
    
    .icon-box { 
        width: 75px; 
        height: 75px; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 28px;
        flex-shrink: 0;
    }
    
    .icon-box.green { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
        color: white;
    }
    
    .icon-box.red { 
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); 
        color: white;
    }
    
    .summary-info h3 { 
        font-size: 11px; 
        color: #a3aed0; 
        font-weight: 600; 
        text-transform: uppercase; 
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }
    
    .summary-info h2 { 
        font-size: 28px; 
        color: #10b981; 
        margin-bottom: 4px;
        font-weight: 700;
    }
    
    .summary-info h2.red-text { 
        color: #ef4444; 
    }
    
    .summary-info p { 
        font-size: 13px; 
        color: #a3aed0;
        line-height: 1.4;
    }

    /* TRANSAKSI TERBARU */
    .section-title { 
        font-size: 20px; 
        color: #1b2559; 
        margin-bottom: 8px; 
        font-weight: 700;
    }
    
    .section-subtitle { 
        font-size: 14px; 
        color: #a3aed0; 
        margin-bottom: 24px; 
    }
    
    .table-card { 
        background: white; 
        border-radius: 16px; 
        padding: 0; 
        box-shadow: 0px 2px 8px rgba(0,0,0,0.04); 
        border: 1px solid #f0f2f5;
        overflow: hidden; 
    }
    
    table { 
        width: 100%; 
        border-collapse: collapse;
    }
    
    th { 
        padding: 18px 20px; 
        color: #1b2559; 
        font-size: 13px; 
        font-weight: 700;
        background: #f9fafb;
        border-bottom: 2px solid #e5e7eb;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    tbody tr {
        border-bottom: 1px solid #f0f2f5;
        transition: background-color 0.2s ease;
    }
    
    tbody tr:hover {
        background-color: #f9fafb;
    }
    
    tbody tr:last-child {
        border-bottom: none;
    }
    
    td { 
        padding: 18px 20px; 
        color: #2b3674; 
        font-weight: 500; 
        font-size: 14px;
    }
    
    .status-pill { 
        padding: 6px 16px; 
        border-radius: 6px; 
        font-size: 12px; 
        font-weight: 600; 
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .status-lunas { 
        background: #ecfdf5; 
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    
    .status-belum { 
        background: #fef2f2; 
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    
    .action-wrapper {
        display: flex; 
        align-items: center; 
        justify-content: center; 
        gap: 12px;
    }
    
    .btn-lunasi {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    
    .btn-lunasi:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-lunasi:active {
        transform: translateY(0);
    }
    
    .total-amount {
        color: #10b981;
        font-weight: 700;
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        color: #a3aed0;
        font-style: italic;
        padding: 50px 20px;
    }
</style>
@endpush

@section('content')
    <h3 style="color: #1b2559; font-size: 18px; font-weight: 700; margin-bottom: 16px;">Status Pembayaran Hari Ini</h3>
    <div class="summary-grid">
        <a href="{{ route('dashboard.kasir.riwayat', ['status' => 'paid']) }}" style="text-decoration: none;">
            <div class="summary-card">
                <div class="icon-box green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="summary-info">
                    <h3>Total Lunas (Hari Ini)</h3>
                    <h2>Rp {{ number_format($totalLunas, 0, ',', '.') }}</h2>
                    <p>Uang yang sudah aman di tangan</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('dashboard.kasir.riwayat', ['status' => 'unpaid']) }}" style="text-decoration: none;">
            <div class="summary-card">
                <div class="icon-box red">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="summary-info">
                    <h3>Total Belum Lunas (Hari Ini)</h3>
                    <h2 class="red-text">Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}</h2>
                    <p>Klik untuk melihat daftar piutang</p>
                </div>
            </div>
        </a>
    </div>

    <div style="margin-top: 40px;">
        <div class="section-title">Transaksi Terbaru</div>
        <div class="section-subtitle">Daftar transaksi terbaru yang masuk hari ini.</div>
        
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>No. Nota</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiTerbaru as $t)
                    <tr>
                        <td><strong>INV-{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ $t->pelanggan->nama_lengkap ?? '-' }}</td>
                        <td class="total-amount">Rp {{ number_format($t->total_transaksi, 0, ',', '.') }}</td>
                        <td>
                            <div class="action-wrapper">
                                @if(optional($t->pembayaran)->status_bayar == 'paid')
                                    <span class="status-pill status-lunas">✓ Lunas</span>
                                @else
                                    <span class="status-pill status-belum">⚠ Belum Lunas</span>
                                    
                                    <form action="{{ route('dashboard.kasir.transaksi.lunasi', $t->id) }}" method="POST" onsubmit="return confirm('Lunasi tagihan ini?');" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn-lunasi">Lunasi</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">Belum ada data transaksi untuk ditampilkan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
