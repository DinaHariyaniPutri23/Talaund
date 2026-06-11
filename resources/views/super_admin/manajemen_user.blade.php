@extends('layouts.dashboard')

@section('title', 'Manajemen User')
@section('header_title', 'Manajemen User')
@section('header_subtitle', 'Kelola hak akses dan data pengguna sistem Mila Laundry.')

@section('content')
<div class="space-y-6">

    <!-- Success Message -->
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

    <!-- Error Message -->
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
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="Cari pengguna...">
            </div>
            <button onclick="openModalTambah()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-sm hover:shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Pengguna
            </button>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50">
                    <tr class="text-gray-500">
                        <th class="py-4 px-6 font-semibold w-16 text-center border-x border-gray-200">No</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Nama Lengkap</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Email</th>
                        <th class="py-4 px-6 font-semibold text-center border-x border-gray-200">Peran</th>
                        <th class="py-4 px-6 font-semibold w-36 text-center border-x border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $index => $u)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-6 text-gray-500 text-center border-x border-gray-200">{{ $users->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-medium text-gray-800 text-center border-x border-gray-200">{{ $u->nama }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">{{ $u->email }}</td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">
                            @if($u->peran == 'super_admin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">Super Admin</span>
                            @elseif($u->peran == 'pemilik')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Pemilik</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Kasir</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center border-x border-gray-200">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openModalEdit({{ $u->id }}, '{{ $u->nama }}', '{{ $u->email }}', '{{ $u->peran }}')" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                <button onclick="openModalHapus({{ $u->id }}, '{{ $u->nama }}')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">Belum ada data pengguna yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">Menampilkan halaman {{ $users->currentPage() }} dari {{ $users->lastPage() }}</p>
            <div class="flex items-center gap-1">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH PENGGUNA -->
<div id="modalTambah" class="{{ session('error_modal_tambah') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Tambah Pengguna Baru</h3>
            <button type="button" onclick="closeModalTambah()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('super_admin.manajemen_user.store') }}" method="POST">
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Masukkan nama lengkap pengguna">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="nama@email.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi <span class="text-red-500">*</span></label>
                    <input type="password" name="kata_sandi" required minlength="6" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Minimal 6 karakter">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hak Akses / Peran <span class="text-red-500">*</span></label>
                    <select name="peran" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        <option value="" disabled selected>Pilih hak akses</option>
                        <option value="kasir" {{ old('peran') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="pemilik" {{ old('peran') == 'pemilik' ? 'selected' : '' }}>Pemilik / Owner</option>
                        <option value="super_admin" {{ old('peran') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambah()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PENGGUNA -->
<div id="modalEdit" class="{{ session('error_modal_edit') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-semibold text-gray-800 font-outfit">Edit Data Pengguna</h3>
            <button type="button" onclick="closeModalEdit()" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-lg p-1.5 transition-colors shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEdit" action="{{ session('error_modal_edit') ? route('super_admin.manajemen_user.update', session('error_modal_edit')) : '' }}" method="POST">
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_nama" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="edit_email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="password" name="kata_sandi" minlength="6" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Kosongkan jika tidak ingin mengubah sandi">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hak Akses / Peran <span class="text-red-500">*</span></label>
                    <select id="edit_peran" name="peran" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        <option value="kasir">Kasir</option>
                        <option value="pemilik">Pemilik / Owner</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModalEdit()" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS PENGGUNA -->
<div id="modalHapus" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden text-center p-8">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2 font-outfit">Konfirmasi Hapus</h3>
        <p class="text-gray-500 text-base mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus pengguna <br><span id="hapus_nama" class="font-bold text-gray-800 text-lg"></span>?<br><span class="text-sm text-red-400 mt-1 block">Tindakan ini tidak dapat dibatalkan.</span></p>
        
        <form id="formHapus" method="POST" class="flex justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModalHapus()" class="px-6 py-3 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl font-medium transition-colors w-1/2">Batal</button>
            <button type="submit" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium shadow-sm transition-colors w-1/2 flex justify-center items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<script>
    function openModalTambah() {
        document.getElementById('modalTambah').classList.remove('hidden');
        document.getElementById('modalTambah').classList.add('flex');
    }
    
    function closeModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
        document.getElementById('modalTambah').classList.remove('flex');
    }

    function openModalEdit(id, nama, email, peran) {
        document.getElementById('modalEdit').classList.remove('hidden');
        document.getElementById('modalEdit').classList.add('flex');
        
        // Update form action route dynamically
        document.getElementById('formEdit').action = `/dashboard/super-admin/manajemen-user/${id}`;
        
        // Populate inputs
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_peran').value = peran;
    }

    function closeModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
        document.getElementById('modalEdit').classList.remove('flex');
    }

    function openModalHapus(id, nama) {
        document.getElementById('modalHapus').classList.remove('hidden');
        document.getElementById('modalHapus').classList.add('flex');
        
        document.getElementById('hapus_nama').textContent = nama;
        document.getElementById('formHapus').action = `/dashboard/super-admin/manajemen-user/${id}`;
    }

    function closeModalHapus() {
        document.getElementById('modalHapus').classList.add('hidden');
        document.getElementById('modalHapus').classList.remove('flex');
    }
</script>
@endsection
