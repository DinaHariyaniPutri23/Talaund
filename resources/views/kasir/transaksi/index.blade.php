@extends('layouts.dashboard')

@section('title', 'Monitoring Transaksi')
@section('header_title', 'Transaksi')
@section('header_subtitle', 'Monitoring transaksi kasir dan status pembayaran secara real-time.')

@section('content')
<div class="space-y-6">

    <!-- Summary Cards for Quick Audit -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Transaksi</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalTransaksi ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Lunas</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $transaksiLunas ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Belum Lunas</p>
                <h3 class="text-2xl font-bold text-amber-500">{{ $transaksiPending ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Transaksi Hari Ini</p>
                <h3 class="text-2xl font-bold text-purple-600">Rp {{ number_format($totalHariIni ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Content Card -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        
        <!-- Toolbar (Search & Filters) -->
        <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-60">
                    <form action="{{ route('dashboard.kasir.transaksi') }}" method="GET" class="w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Cari No Nota, Pelanggan..." onchange="this.form.submit()">
                    </form>
                </div>
                
                <div class="relative w-full sm:w-48">
                    <form action="{{ route('dashboard.kasir.transaksi') }}" method="GET" class="w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="date" name="date" value="{{ $date ?? '' }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all text-gray-600" onchange="this.form.submit()">
                    </form>
                </div>

                <form action="{{ route('dashboard.kasir.transaksi') }}" method="GET" class="w-full sm:w-40">
                    <select name="status" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all appearance-none cursor-pointer" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="unpaid" {{ $status == 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
                </form>
            </div>
            
            <a href="{{ route('dashboard.kasir.transaksi.create') }}" class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Transaksi
            </a>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16">No</th>
                        <th class="py-4 px-6 font-semibold">No Nota</th>
                        <th class="py-4 px-6 font-semibold">Tanggal</th>
                        <th class="py-4 px-6 font-semibold">Pelanggan</th>
                        <th class="py-4 px-6 font-semibold">Total Bayar</th>
                        <th class="py-4 px-6 font-semibold">Metode</th>
                        <th class="py-4 px-6 font-semibold">Status</th>
                        <th class="py-4 px-6 font-semibold w-36 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transaksis as $index => $t)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500">{{ $transaksis->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-bold text-gray-800">INV-{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6">{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y H:i') }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800">
                            {{ $t->pelanggan->nama_lengkap ?? '-' }}
                            <div class="text-xs text-gray-400 font-normal">Kasir: {{ $t->pengguna->nama ?? '-' }}</div>
                        </td>
                        <td class="py-4 px-6 font-medium text-gray-800">Rp {{ number_format($t->total_transaksi, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 uppercase">{{ $t->pembayaran->metode_bayar ?? 'TUNAI' }}</td>
                        <td class="py-4 px-6">
                            @if(optional($t->pembayaran)->status_bayar == 'paid')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">Lunas</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Belum Lunas</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <!-- Tombol View Struk (Selalu ada) -->
                                <a href="{{ route('dashboard.kasir.struk', $t->id) }}" class="p-2 text-gray-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Struk">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>

                                <!-- Tombol Edit Pembayaran -->
                                <button onclick="openEditPembayaran({{ $t->id }}, '{{ optional($t->pembayaran)->status_bayar }}', '{{ optional($t->pembayaran)->metode_bayar }}')" class="p-2 text-gray-400 hover:text-purple-500 hover:bg-purple-50 rounded-lg transition-colors" title="Edit Pembayaran">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                <!-- Tombol Edit Items (Hanya PENDING) -->
                                @if($t->status_transaksi === 'pending')
                                <a href="{{ url('/dashboard/kasir/transaksi/' . $t->id . '/edit-items') }}" class="p-2 text-gray-400 hover:text-green-500 hover:bg-green-50 rounded-lg transition-colors" title="Edit Items">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </a>
                                @endif

                                <!-- Tombol Void (PENDING & DIPROSES) -->
                                @if($t->status_transaksi !== 'selesai')
                                <button onclick="openVoidModal({{ $t->id }})" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Batalkan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-10 text-gray-400 italic">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>

<!-- Modal Edit Pembayaran -->
<div id="modalEditPembayaran" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Edit Pembayaran</h3>
        <form onsubmit="submitEditPembayaran(event)">
            <input type="hidden" id="pembayaran_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Pembayaran</label>
                <select id="status_bayar" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="paid">Lunas</option>
                    <option value="unpaid">Belum Lunas</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <select id="metode_bayar" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="tunai">TUNAI</option>
                    <option value="transfer">TRANSFER</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeEditPembayaran()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Void Transaksi -->
<div id="modalVoid" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Batalkan Transaksi</h3>
        <form onsubmit="submitVoid(event)">
            <input type="hidden" id="void_id">
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Pembatalan <span class="text-red-500">*</span></label>
                <select id="alasan_void" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent mb-3">
                    <option value="">-- Pilih Alasan --</option>
                    <option value="Salah input">Salah input</option>
                    <option value="Dobel transaksi">Dobel transaksi</option>
                    <option value="Pelanggan batal">Pelanggan batal</option>
                    <option value="Kesalahan kasir">Kesalahan kasir</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <textarea id="alasan_void_text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" rows="3" placeholder="Jelaskan alasan lebih detail..."></textarea>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-6 text-sm text-red-700">
                ⚠️ Transaksi akan dibatalkan dan tidak dapat dikembalikan!
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeVoidModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                    Tidak
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">
                    Batalkan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditPembayaran(id, status, metode) {
        document.getElementById('pembayaran_id').value = id;
        document.getElementById('status_bayar').value = status;
        document.getElementById('metode_bayar').value = metode || 'tunai';
        document.getElementById('modalEditPembayaran').classList.remove('hidden');
    }

    function closeEditPembayaran() {
        document.getElementById('modalEditPembayaran').classList.add('hidden');
    }

    function submitEditPembayaran(event) {
        event.preventDefault();
        const id = document.getElementById('pembayaran_id').value;
        const statusBayar = document.getElementById('status_bayar').value;
        const metodeBayar = document.getElementById('metode_bayar').value;

        fetch(`{{ url('/dashboard/kasir/transaksi') }}/${id}/update-pembayaran`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                status_bayar: statusBayar,
                metode_bayar: metodeBayar
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pembayaran berhasil diupdate!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }

    function openVoidModal(id) {
        document.getElementById('void_id').value = id;
        document.getElementById('alasan_void').value = '';
        document.getElementById('alasan_void_text').value = '';
        document.getElementById('modalVoid').classList.remove('hidden');
    }

    function closeVoidModal() {
        document.getElementById('modalVoid').classList.add('hidden');
    }

    function submitVoid(event) {
        event.preventDefault();
        const id = document.getElementById('void_id').value;
        const alasan = document.getElementById('alasan_void').value + ' - ' + document.getElementById('alasan_void_text').value;

        if (!alasan.trim()) {
            alert('Silakan pilih dan jelaskan alasan pembatalan!');
            return;
        }

        fetch(`{{ url('/dashboard/kasir/transaksi') }}/${id}/void`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                alasan_void: alasan
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Transaksi berhasil dibatalkan!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }

</script>
@endpush
@endsection
