@extends('layouts.dashboard')

@section('title', 'Konfigurasi Sistem')
@section('header_title', 'Konfigurasi Sistem')
@section('header_subtitle', 'Pusat pengaturan identitas laundry, payment gateway, dan perangkat keras.')

@section('content')
<div class="space-y-6 pb-10">

    <!-- Top Action Bar -->
    <div class="flex justify-end">
        <button class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow" onclick="alert('Semua konfigurasi berhasil disimpan!')">
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Laundry</label>
                    <input type="text" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 focus:bg-white" value="Mila Laundry">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 focus:bg-white" rows="3">Jl. Tanah Laut No. 123, Kelurahan Pelaihari, Kabupaten Tanah Laut, Kalimantan Selatan</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 focus:bg-white" value="081234567890">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo Toko (Opsional)</label>
                    <div class="flex items-center gap-4 mt-2">
                        <div class="w-16 h-16 rounded-xl border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center">
                            <img src="{{ asset('image/ic_log.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                        </div>
                        <input type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Data ini akan ditarik ke dalam Struk Nota dan Laporan.</p>
                </div>
            </div>
        </div>

        <!-- CARD: INTEGRASI XENDIT -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Integrasi Xendit</h3>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Secret Key</label>
                    <input type="password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-gray-50 focus:bg-white" value="xnd_production_xxxxxxxxxxxxxxxxxxxxxxxxxxx">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Public Key</label>
                    <input type="text" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-gray-50 focus:bg-white" value="xnd_public_production_xxxxxxxxxxxxxxxxxxxx">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Webhook Verification Token</label>
                    <input type="text" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-gray-50 focus:bg-white" value="wxv_xxxxxxxxxxxxxxxxxxxx">
                    <p class="text-xs text-gray-400 mt-2">Untuk memastikan sinyal "Lunas" beneran dari Xendit.</p>
                </div>
                <div class="pt-2">
                    <button class="w-full sm:w-auto flex items-center justify-center gap-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-5 py-2.5 rounded-xl font-medium text-sm transition-all" onclick="alert('Berhasil terhubung dengan server Xendit!')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Cek Koneksi Xendit
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- CARD: PENGATURAN PRINTER -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Pengaturan Perangkat Keras (Printer)</h3>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Koneksi Printer</label>
                <select id="koneksi_printer" onchange="toggleIpAddress()" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition-all bg-gray-50 focus:bg-white appearance-none">
                    <option value="usb">USB</option>
                    <option value="lan">LAN (Jaringan)</option>
                    <option value="bluetooth">Bluetooth</option>
                </select>
            </div>
            <div id="ip_address_wrapper" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">IP Address Printer</label>
                <input type="text" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition-all bg-gray-50 focus:bg-white" placeholder="Contoh: 192.168.1.100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran Kertas</label>
                <select class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition-all bg-gray-50 focus:bg-white appearance-none">
                    <option value="58mm">58mm (Kecil)</option>
                    <option value="80mm">80mm (Besar)</option>
                </select>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-400 max-w-lg">Pastikan printer sudah menyala dan terhubung dengan komputer ini sebelum melakukan pengetesan.</p>
            <button class="flex items-center gap-2 border border-gray-200 hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-xl font-medium text-sm transition-all" onclick="alert('Mencetak struk percobaan...')">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Test Print
            </button>
        </div>
    </div>

</div>

<script>
    // Simple script to toggle IP Address field visibility based on Printer Connection choice
    function toggleIpAddress() {
        const select = document.getElementById('koneksi_printer');
        const wrapper = document.getElementById('ip_address_wrapper');
        
        if (select.value === 'lan') {
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    }
    
    // Run once on load to ensure correct state
    document.addEventListener('DOMContentLoaded', function() {
        toggleIpAddress();
    });
</script>
@endsection
