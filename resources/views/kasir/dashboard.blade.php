@extends('layouts.dashboard')

@section('title', 'Dashboard Kasir')
@section('header_title', 'Dashboard Kasir')
@section('header_subtitle', 'Ringkasan aktivitas dan transaksi laundry hari ini.')

@push('styles')
<style>
    /* SUMMARY CARDS */
    .summary-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px; margin-bottom: 40px; }
    .summary-card { background: white; border-radius: 20px; padding: 25px; box-shadow: 0px 4px 10px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.02); display: flex; align-items: center; gap: 20px; }
    .icon-box { width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    .icon-box.green { background: #e6f8ed; color: #10b981; }
    .icon-box.red { background: #fee2e2; color: #ef4444; }
    .summary-info h3 { font-size: 13px; color: #1b2559; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; }
    .summary-info h2 { font-size: 24px; color: #10b981; margin-bottom: 5px; }
    .summary-info h2.red-text { color: #ef4444; }
    .summary-info p { font-size: 13px; color: #a3aed0; }

    /* TRANSAKSI TERBARU */
    .section-title { font-size: 18px; color: #1b2559; margin-bottom: 5px; font-weight: 700; }
    .section-subtitle { font-size: 14px; color: #a3aed0; margin-bottom: 20px; }
    
    .table-card { background: white; border-radius: 20px; padding: 0; box-shadow: 0px 4px 10px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.02); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; text-align: center; }
    th { padding: 20px 15px; color: #1b2559; font-size: 13px; font-weight: 700; border-bottom: 1px solid #f4f7fe; }
    td { padding: 20px 15px; color: #2b3674; font-weight: 600; font-size: 14px; border-bottom: 1px solid #f4f7fe; }
    
    .status-pill { padding: 8px 20px; border-radius: 8px; font-size: 12px; font-weight: 600; display: inline-block; }
    .status-lunas { background: #e6f8ed; color: #10b981; }
    .status-belum { background: #fee2e2; color: #ef4444; }
</style>
@endpush

@section('content')
    <h3 style="color: #1b2559; font-size: 18px;">Status Pembayaran Hari Ini</h3>
    <div class="summary-grid">
        <a href="{{ route('dashboard.kasir.riwayat', ['status' => 'paid']) }}" style="text-decoration: none;">
            <div class="summary-card" style="transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0px 4px 10px rgba(0,0,0,0.02)';">
                <div class="icon-box green">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="summary-info">
                    <h3>TOTAL LUNAS (HARI INI)</h3>
                    <h2>Rp {{ number_format($totalLunas, 0, ',', '.') }}</h2>
                    <p>Uang yang sudah aman di tangan</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('dashboard.kasir.riwayat', ['status' => 'unpaid']) }}" style="text-decoration: none;">
            <div class="summary-card" style="transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0px 4px 10px rgba(0,0,0,0.02)';">
                <div class="icon-box red">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="summary-info">
                    <h3>TOTAL BELUM LUNAS (HARI INI)</h3>
                    <h2 class="red-text">Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}</h2>
                    <p>Klik untuk melihat daftar piutang</p>
                </div>
            </div>
        </a>
    </div>

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
                    <td>INV-{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $t->pelanggan->nama_lengkap ?? '-' }}</td>
                    <td style="color: #10b981;">Rp {{ number_format($t->total_transaksi, 0, ',', '.') }}</td>
                    <td>
                        <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                            @if(optional($t->pembayaran)->status_bayar == 'paid')
                                <span class="status-pill status-lunas">LUNAS</span>
                            @else
                                <span class="status-pill status-belum">BELUM LUNAS</span>
                                
                                <form action="{{ route('dashboard.kasir.transaksi.lunasi', $t->id) }}" method="POST" onsubmit="return confirm('Lunasi tagihan ini?');" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: bold;">
                                        LUNASI
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #a3aed0; font-style: italic; padding: 40px;">Belum ada data transaksi untuk ditampilkan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
