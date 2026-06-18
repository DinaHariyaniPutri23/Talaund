@extends('layouts.dashboard')

@section('title', 'Konfigurasi Sistem')
@section('header_title', 'Konfigurasi Sistem')
@section('header_subtitle', 'Pusat pengaturan identitas laundry, payment gateway, dan perangkat keras.')

@section('content')
<div class="space-y-6 pb-10">

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-center justify-between shadow-sm mb-2">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-green-700 font-medium text-sm">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="text-green-700 hover:text-green-900 focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <form method="POST" action="{{ route('super_admin.konfigurasi.update') }}" enctype="multipart/form-data">
        @csrf
        <!-- Top Action Bar -->
        <div class="flex justify-end mb-6">
            <button type="submit" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Simpan Perubahan
            </button>
        </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- CARD: IDENTITAS TOKO -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Identitas Toko</h3>
            </div>
            
            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 focus:bg-white" rows="3">{{ $konfigurasi['alamat'] ?? 'Jl. Tanah Laut No. 123, Kelurahan Pelaihari, Kabupaten Tanah Laut, Kalimantan Selatan' }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" name="no_telepon" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 focus:bg-white" value="{{ $konfigurasi['no_telepon'] ?? '081234567890' }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo Toko (Opsional)</label>
                    <div class="flex items-center gap-4 mt-2">
                        <div class="w-16 h-16 rounded-xl border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center">
                            @if(isset($konfigurasi['logo_toko']))
                                <img src="{{ asset($konfigurasi['logo_toko']) }}" alt="Logo" class="w-10 h-10 object-contain">
                            @else
                                <img src="{{ asset('image/ic_log.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                            @endif
                        </div>
                        <input type="file" name="logo_toko" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Data ini akan ditarik ke dalam Struk Nota dan Laporan.</p>
                </div>
            </div>
        </div>

        <!-- CARD: PENGATURAN TAMBAHAN -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Pengaturan Tambahan</h3>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Footer Struk</label>
                    <textarea name="pesan_struk" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all bg-gray-50 focus:bg-white" rows="3" placeholder="Contoh: Barang yang tidak diambil lebih dari 1 bulan di luar tanggung jawab kami.">{{ $konfigurasi['pesan_struk'] ?? 'Terima kasih telah mempercayakan cucian Anda kepada kami.' }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Pesan ini akan otomatis dicetak di bagian paling bawah struk nota kasir.</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Buka</label>
                        <input type="time" name="jam_buka" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all bg-gray-50 focus:bg-white" value="{{ $konfigurasi['jam_buka'] ?? '08:00' }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Tutup</label>
                        <input type="time" name="jam_tutup" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all bg-gray-50 focus:bg-white" value="{{ $konfigurasi['jam_tutup'] ?? '21:00' }}">
                    </div>
                </div>
                <div class="pt-2">
                    <p class="text-xs text-gray-500 bg-orange-50 p-3 rounded-lg border border-orange-100">
                        <span class="font-semibold text-orange-700">Catatan Jam Operasional:</span> Jika diisi, jam operasional dapat digunakan sebagai peringatan atau validasi tambahan saat kasir membuat transaksi di luar jam buka.
                    </p>
                </div>
            </div>
        </div>

    </div>
    </form>
</div>

@endsection


