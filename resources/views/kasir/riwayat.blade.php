@extends('layouts.dashboard')

@section('title', 'Riwayat Transaksi')
@section('header_title', 'Riwayat Transaksi')
@section('header_subtitle', 'Kelola semua data transaksi dan piutang pelanggan.')

@push('styles')
<style>
    .search-box {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.02);
        margin-bottom: 25px;
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .input-group {
        flex: 1;
        min-width: 200px;
    }
    
    .input-field {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        color: #1b2559;
        outline: none;
        transition: border-color 0.3s;
    }
    
    .input-field:focus {
        border-color: #3b82f6;
    }
    
    .btn-search {
        background: #3b82f6;
        color: white;
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .btn-search:hover {
        background: #2563eb;
    }

    .table-card { 
        background: white; 
        border-radius: 20px; 
        padding: 0; 
        box-shadow: 0px 4px 10px rgba(0,0,0,0.02); 
        border: 1px solid rgba(0,0,0,0.02); 
        overflow-x: auto; 
    }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { padding: 20px 25px; color: #a3aed0; font-size: 13px; font-weight: 700; border-bottom: 1px solid #f4f7fe; text-transform: uppercase;}
    td { padding: 20px 25px; color: #2b3674; font-weight: 600; font-size: 14px; border-bottom: 1px solid #f4f7fe; }
    
    .status-pill { padding: 8px 20px; border-radius: 8px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; width: 120px; }
    .status-lunas { background: #e6f8ed; color: #10b981; }
    .status-belum { background: #fee2e2; color: #ef4444; }

    .btn-lunasi {
        background: #10b981;
        color: white;
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.3s;
    }

    .btn-lunasi:hover {
        background: #059669;
    }
    
    .btn-cetak {
        background: #f1f5f9;
        color: #475569;
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.3s;
        text-decoration: none;
    }
    
    .btn-cetak:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg" role="alert">
        <p class="font-bold">Sukses!</p>
        <p>{{ session('success') }}</p>
    </div>
@endif

<!-- Search & Filter Area -->
<form action="{{ route('dashboard.kasir.riwayat') }}" method="GET" class="search-box">
    <div class="input-group" style="flex: 2;">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama Pelanggan atau No Nota (misal: 10)..." class="input-field">
    </div>
    <div class="input-group">
        <select name="status" class="input-field">
            <option value="">Semua Status</option>
            <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>LUNAS</option>
            <option value="unpaid" {{ $status == 'unpaid' ? 'selected' : '' }}>BELUM LUNAS</option>
        </select>
    </div>
    <button type="submit" class="btn-search">
        <i class="fas fa-search mr-2"></i> Terapkan Filter
    </button>
    @if($search || $status)
    <a href="{{ route('dashboard.kasir.riwayat') }}" class="btn-cetak" style="padding: 12px 25px; margin-left: 10px;">Reset</a>
    @endif
</form>

<!-- Table Area -->
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>No. Nota</th>
                <th>Tanggal & Waktu</th>
                <th>Pelanggan</th>
                <th>Total (Rp)</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $t)
            <tr>
                <td style="font-weight: 700; color: #3b82f6;">INV-{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y - H:i') }}</td>
                <td>
                    <div style="font-weight: 700; color: #1b2559;">{{ $t->pelanggan->nama_lengkap ?? '-' }}</div>
                    <div style="font-size: 12px; color: #a3aed0;">{{ $t->pelanggan->no_telepon ?? '-' }}</div>
                </td>
                <td style="font-weight: 700; font-size: 16px;">{{ number_format($t->total_transaksi, 0, ',', '.') }}</td>
                <td style="text-align: center;">
                    @if(optional($t->pembayaran)->status_bayar == 'paid')
                        <span class="status-pill status-lunas">
                            <i class="fas fa-check-circle mr-2"></i> LUNAS
                        </span>
                    @else
                        <span class="status-pill status-belum">
                            <i class="fas fa-times-circle mr-2"></i> PIUTANG
                        </span>
                    @endif
                </td>
                <td style="text-align: center;">
                    <div style="display: flex; justify-content: center; gap: 8px;">
                        <a href="{{ route('dashboard.kasir.struk', $t->id) }}" class="btn-cetak" title="Lihat Struk">
                            <i class="fas fa-print"></i> Struk
                        </a>
                        
                        @if(optional($t->pembayaran)->status_bayar != 'paid')
                        <form action="{{ route('dashboard.kasir.transaksi.lunasi', $t->id) }}" method="POST" onsubmit="return confirm('Apakah pelanggan ini sudah membayar sebesar Rp {{ number_format($t->total_transaksi, 0, ',', '.') }}?');">
                            @csrf
                            <button type="submit" class="btn-lunasi" title="Tandai Sudah Bayar">
                                <i class="fas fa-money-bill-wave"></i> Lunasi
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #a3aed0; font-style: italic; padding: 60px;">
                    <i class="fas fa-search mb-3" style="font-size: 30px; opacity: 0.5;"></i><br>
                    Tidak ada transaksi yang sesuai dengan kriteria pencarian Anda.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $transaksis->withQueryString()->links() }}
</div>

@endsection
