@extends('layouts.dashboard')

@section('title', 'Manajemen Kendali Fitur')
@section('header_title', 'Manajemen Kendali Fitur')
@section('header_subtitle', 'Kelola status aktif/nonaktif dari setiap modul atau fitur di dalam sistem.')

@section('content')
<div class="space-y-6">

    <!-- Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-green-700 font-medium text-sm">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="text-green-700 hover:text-green-900 focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-red-700 font-medium text-sm">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="text-red-700 hover:text-red-900 focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif


    <!-- Content Card -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        
        <!-- Toolbar (Search & Add) -->
        <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="search-fitur" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Cari fitur...">
            </div>
            <button onclick="openModalTambah()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Fitur Baru
            </button>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600" id="fiturTable">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16">No</th>
                        <th class="py-4 px-6 font-semibold">Nama Fitur</th>
                        <th class="py-4 px-6 font-semibold">Deskripsi</th>
                        <th class="py-4 px-6 font-semibold text-center w-28">Status</th>
                        <th class="py-4 px-6 font-semibold w-36 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($fiturs as $index => $fitur)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800">
                            {{ $fitur->nama_fitur }}
                            <div class="text-xs text-gray-400 mt-1 font-mono">{{ $fitur->kode_fitur }}</div>
                        </td>
                        <td class="py-4 px-6 text-gray-600">{{ $fitur->deskripsi ?? '-' }}</td>
                        <td class="py-4 px-6 text-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer toggle-kendali" data-id="{{ $fitur->id }}" {{ $fitur->status == 'on' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                            </label>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openModalEdit({{ $fitur->id }}, '{{ addslashes($fitur->nama_fitur) }}', '{{ addslashes($fitur->deskripsi) }}')" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button onclick="deleteFitur({{ $fitur->id }})" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">Belum ada fitur terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH FITUR -->
<div id="modalTambahFitur" class="{{ session('error_modal_tambah') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Tambah Fitur Baru</h3>
            <button type="button" onclick="closeModalTambahFitur()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('super_admin.kendali.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                @if(session('error_modal_tambah') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Fitur <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_fitur" value="{{ old('nama_fitur') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Fitur (Tanpa Spasi) <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_fitur" value="{{ old('kode_fitur') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Contoh: modul_parfum">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambahFitur()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT FITUR -->
<div id="modalEditFitur" class="{{ session('error_modal_edit') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Edit Fitur</h3>
            <button type="button" onclick="closeModalEditFitur()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEditFitur" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                @if(session('error_modal_edit') && $errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-2 border border-red-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Fitur <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_nama_fitur" name="nama_fitur" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"></textarea>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalEditFitur()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS FITUR -->
<div id="modalHapusFitur" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full my-6">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 6H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v15a2 2 0 01-2 2z"></path></svg>
        </div>
        <h3 class="text-lg font-semibold text-center text-gray-800">Hapus Fitur?</h3>
        <p class="text-center text-gray-600 text-sm mt-2 px-6">Anda yakin ingin menghapus fitur ini? Data yang dihapus tidak dapat dipulihkan.</p>
        <form id="formHapusFitur" method="POST" class="mt-6">
            @csrf
            @method('DELETE')
            <div class="flex gap-3 px-6 py-4">
                <button type="button" onclick="closeModalHapusFitur()" class="px-6 py-3 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors w-1/2">Batal</button>
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition-colors w-1/2 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Search function
    document.getElementById('search-fitur').addEventListener('keyup', function() {
        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll('#fiturTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });

    // Toggle Kendali
    document.querySelectorAll('.toggle-kendali').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const value = this.checked ? 'on' : 'off';
            
            fetch("{{ route('super_admin.kendali.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id, value: value })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Status diubah menjadi ' + value.toUpperCase(),
                        confirmButtonColor: '#0056D2',
                        confirmButtonText: 'Oke',
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan!',
                        text: data.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Tutup'
                    });
                    this.checked = !this.checked; // revert
                }
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan jaringan.',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Tutup'
                });
                this.checked = !this.checked; // revert
            });
        });
    });

    function openModalTambah() {
        document.getElementById('modalTambahFitur').classList.remove('hidden');
        document.getElementById('modalTambahFitur').classList.add('flex');
    }

    function closeModalTambahFitur() {
        document.getElementById('modalTambahFitur').classList.add('hidden');
        document.getElementById('modalTambahFitur').classList.remove('flex');
    }

    function openModalEdit(id, nama, deskripsi) {
        document.getElementById('modalEditFitur').classList.remove('hidden');
        document.getElementById('modalEditFitur').classList.add('flex');
        
        document.getElementById('formEditFitur').action = `/dashboard/super-admin/kendali/${id}`;
        document.getElementById('edit_nama_fitur').value = nama;
        document.getElementById('edit_deskripsi').value = deskripsi;
    }

    function closeModalEditFitur() {
        document.getElementById('modalEditFitur').classList.add('hidden');
        document.getElementById('modalEditFitur').classList.remove('flex');
    }

    function deleteFitur(id) {
        document.getElementById('modalHapusFitur').classList.remove('hidden');
        document.getElementById('modalHapusFitur').classList.add('flex');
        
        document.getElementById('formHapusFitur').action = `/dashboard/super-admin/kendali/${id}`;
    }

    function closeModalHapusFitur() {
        document.getElementById('modalHapusFitur').classList.add('hidden');
        document.getElementById('modalHapusFitur').classList.remove('flex');
    }

</script>
@endpush
