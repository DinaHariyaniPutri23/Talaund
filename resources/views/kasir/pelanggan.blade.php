@extends('layouts.dashboard')

@section('title', 'Kelola Pelanggan')
@section('header_title', 'Kelola Pelanggan')
@section('header_subtitle', 'Kelola data pelanggan laundry.')

@section('content')
    <div class="flex justify-between items-center mb-[20px] mt-[15px]">
        <div class="relative w-full max-w-[500px]">
            <svg class="absolute left-[15px] top-1/2 -translate-y-1/2 text-[#a3aed0] w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" class="w-full py-[12px] pr-[15px] pl-[45px] border border-[#e0e5f2] rounded-[10px] outline-none text-[#2b3674] font-sans bg-white focus:border-[#1a73e8]" placeholder="Cari berdasarkan nama atau nomor HP...">
        </div>
        <button class="btn-tambah py-[12px] px-[20px] bg-[#0056D2] hover:bg-[#0043a8] text-white border-none rounded-[10px] font-semibold cursor-pointer flex items-center gap-[8px] font-sans transition duration-300">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Pelanggan
        </button>
    </div>
    
    <div class="bg-white rounded-[20px] p-0 shadow-[0px_4px_10px_rgba(0,0,0,0.02)] border border-[rgba(0,0,0,0.02)] overflow-hidden mb-[20px]">
        <table class="w-full border-collapse text-center">
            <thead>
                <tr>
                    <th class="p-[20px_15px] text-[#1b2559] text-[13px] font-bold border border-[#f4f7fe] text-center">ID Pelanggan</th>
                    <th class="p-[20px_15px] text-[#1b2559] text-[13px] font-bold border border-[#f4f7fe] text-center">Nama Lengkap</th>
                    <th class="p-[20px_15px] text-[#1b2559] text-[13px] font-bold border border-[#f4f7fe] text-center">Nomor Telepon/WA</th>
                    <th class="p-[20px_15px] text-[#1b2559] text-[13px] font-bold border border-[#f4f7fe] text-center">Alamat Singkat</th>
                    <th class="p-[20px_15px] text-[#1b2559] text-[13px] font-bold border border-[#f4f7fe] text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelanggans as $pelanggan)
                <tr>
                    <td class="p-[20px_15px] text-[#2b3674] font-semibold text-[14px] border border-[#f4f7fe] text-center">{{ $pelanggan->id_pelanggan }}</td>
                    <td class="p-[20px_15px] text-[#2b3674] font-semibold text-[14px] border border-[#f4f7fe] text-center">{{ $pelanggan->nama_lengkap }}</td>
                    <td class="p-[20px_15px] text-[#2b3674] font-semibold text-[14px] border border-[#f4f7fe] text-center">{{ $pelanggan->no_telepon }}</td>
                    <td class="p-[20px_15px] text-[#2b3674] font-semibold text-[14px] border border-[#f4f7fe] text-center">{{ $pelanggan->alamat }}</td>
                    <td class="p-[20px_15px] text-[#2b3674] font-semibold text-[14px] border border-[#f4f7fe] text-center">
                        <div class="flex gap-[10px] justify-center">
                            <button type="button" class="btn-edit w-[35px] h-[35px] rounded-[8px] border border-[#e0e5f2] bg-white cursor-pointer flex items-center justify-center transition duration-200 text-[#0056D2] hover:bg-[#f4f7fe]" data-id="{{ $pelanggan->id }}" data-nama="{{ $pelanggan->nama_lengkap }}" data-telepon="{{ $pelanggan->no_telepon }}" data-alamat="{{ $pelanggan->alamat }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-[16px] h-[16px]"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST" class="form-delete inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete w-[35px] h-[35px] rounded-[8px] border border-[#e0e5f2] bg-white cursor-pointer flex items-center justify-center transition duration-200 text-[#ef4444] hover:bg-[#f4f7fe]">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-[16px] h-[16px]"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-[#a3aed0] italic p-[60px_20px] border border-[#f4f7fe]">
                        Belum ada data pelanggan untuk ditampilkan
                    </td>
                </tr>
                @for ($i = 0; $i < 9; $i++)
                <tr>
                    <td colspan="5" class="p-[24px] border border-[#f4f7fe]"></td>
                </tr>
                @endfor
                @endforelse
            </tbody>
        </table>
        
        <div class="flex justify-between items-center p-[20px] bg-white border-t border-[#f4f7fe] rounded-b-[20px]">
            <div class="text-[#2b3674] text-[13px] font-medium">Menampilkan {{ $pelanggans->count() }} data pelanggan</div>
            <div class="flex gap-[5px]">
                <button class="w-[35px] h-[35px] flex items-center justify-center rounded-[8px] border border-[#e0e5f2] bg-white cursor-pointer text-[#2b3674] font-semibold hover:bg-[#f4f7fe]"><svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                <button class="w-[35px] h-[35px] flex items-center justify-center rounded-[8px] border border-[#0056D2] bg-[#0056D2] text-white cursor-pointer font-semibold">1</button>
                <button class="w-[35px] h-[35px] flex items-center justify-center rounded-[8px] border border-[#e0e5f2] bg-white cursor-pointer text-[#2b3674] font-semibold hover:bg-[#f4f7fe]"><svg class="w-[16px] h-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pelanggan -->
    <div class="fixed inset-0 bg-[#0b1d51]/40 flex items-center justify-center z-[1000] opacity-0 invisible transition-all duration-300 {{ session('error_modal') ? '!opacity-100 !visible' : '' }}" id="modalTambah">
        <div class="bg-white w-full max-w-[500px] rounded-[16px] p-[30px] shadow-[0_20px_40px_rgba(0,0,0,0.1)] -translate-y-[50px] transition-all duration-500 ease-out {{ session('error_modal') ? '!translate-y-0' : '' }}" id="modalTambahContent">
            <div class="flex justify-between items-center mb-[25px]">
                <h2 class="text-[18px] text-[#1b2559] font-bold m-0">Tambah Pelanggan</h2>
                <button type="button" class="bg-none border-none cursor-pointer text-[#2b3674] w-[30px] h-[30px] flex items-center justify-center rounded-[8px] transition duration-200 hover:bg-[#f4f7fe] hover:text-[#ef4444]" id="closeModal">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-[20px] h-[20px]"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                <div class="mb-[20px]">
                    <label class="block text-[13px] font-semibold text-[#1b2559] mb-[8px]">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full p-[12px_15px] border border-[#e0e5f2] rounded-[8px] outline-none text-[#2b3674] font-sans text-[14px] transition duration-200 focus:border-[#0056D2] focus:ring-[3px] focus:ring-[#0056D2]/10" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="mb-[20px]">
                    <label class="block text-[13px] font-semibold text-[#1b2559] mb-[8px]">Nomor Telepon/WA</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="w-full p-[12px_15px] border border-[#e0e5f2] rounded-[8px] outline-none text-[#2b3674] font-sans text-[14px] transition duration-200 focus:border-[#0056D2] focus:ring-[3px] focus:ring-[#0056D2]/10" placeholder="Masukkan nomor telepon atau WhatsApp" required>
                </div>
                <div class="mb-[20px]">
                    <label class="block text-[13px] font-semibold text-[#1b2559] mb-[8px]">Alamat Singkat</label>
                    <input type="text" name="alamat" value="{{ old('alamat') }}" class="w-full p-[12px_15px] border border-[#e0e5f2] rounded-[8px] outline-none text-[#2b3674] font-sans text-[14px] transition duration-200 focus:border-[#0056D2] focus:ring-[3px] focus:ring-[#0056D2]/10" placeholder="Masukkan alamat singkat" required>
                </div>
                <div class="flex justify-end gap-[12px] mt-[30px]">
                    <button type="button" class="p-[10px_20px] bg-white border border-[#e0e5f2] text-[#2b3674] font-semibold rounded-[8px] cursor-pointer transition duration-200 hover:bg-[#f4f7fe]" id="btnBatal">Batal</button>
                    <button type="submit" class="p-[10px_20px] bg-[#0056D2] border-none text-white font-semibold rounded-[8px] cursor-pointer transition duration-200 hover:bg-[#0043a8]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pelanggan -->
    <div class="fixed inset-0 bg-[#0b1d51]/40 flex items-center justify-center z-[1000] opacity-0 invisible transition-all duration-300 {{ session('error_modal_edit') ? '!opacity-100 !visible' : '' }}" id="modalEdit">
        <div class="bg-white w-full max-w-[500px] rounded-[16px] p-[30px] shadow-[0_20px_40px_rgba(0,0,0,0.1)] -translate-y-[50px] transition-all duration-500 ease-out {{ session('error_modal_edit') ? '!translate-y-0' : '' }}" id="modalEditContent">
            <div class="flex justify-between items-center mb-[25px]">
                <h2 class="text-[18px] text-[#1b2559] font-bold m-0">Edit Pelanggan</h2>
                <button type="button" class="bg-none border-none cursor-pointer text-[#2b3674] w-[30px] h-[30px] flex items-center justify-center rounded-[8px] transition duration-200 hover:bg-[#f4f7fe] hover:text-[#ef4444]" id="closeModalEdit">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-[20px] h-[20px]"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ session('error_modal_edit') ? route('pelanggan.update', session('error_modal_edit')) : '#' }}" method="POST" id="formEdit">
                @csrf
                @method('PUT')
                <div class="mb-[20px]">
                    <label class="block text-[13px] font-semibold text-[#1b2559] mb-[8px]">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="edit_nama" value="{{ old('nama_lengkap') }}" class="w-full p-[12px_15px] border border-[#e0e5f2] rounded-[8px] outline-none text-[#2b3674] font-sans text-[14px] transition duration-200 focus:border-[#0056D2] focus:ring-[3px] focus:ring-[#0056D2]/10" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="mb-[20px]">
                    <label class="block text-[13px] font-semibold text-[#1b2559] mb-[8px]">Nomor Telepon/WA</label>
                    <input type="text" name="no_telepon" id="edit_telepon" value="{{ old('no_telepon') }}" class="w-full p-[12px_15px] border border-[#e0e5f2] rounded-[8px] outline-none text-[#2b3674] font-sans text-[14px] transition duration-200 focus:border-[#0056D2] focus:ring-[3px] focus:ring-[#0056D2]/10" placeholder="Masukkan nomor telepon atau WhatsApp" required>
                </div>
                <div class="mb-[20px]">
                    <label class="block text-[13px] font-semibold text-[#1b2559] mb-[8px]">Alamat Singkat</label>
                    <input type="text" name="alamat" id="edit_alamat" value="{{ old('alamat') }}" class="w-full p-[12px_15px] border border-[#e0e5f2] rounded-[8px] outline-none text-[#2b3674] font-sans text-[14px] transition duration-200 focus:border-[#0056D2] focus:ring-[3px] focus:ring-[#0056D2]/10" placeholder="Masukkan alamat singkat" required>
                </div>
                <div class="flex justify-end gap-[12px] mt-[30px]">
                    <button type="button" class="p-[10px_20px] bg-white border border-[#e0e5f2] text-[#2b3674] font-semibold rounded-[8px] cursor-pointer transition duration-200 hover:bg-[#f4f7fe]" id="btnBatalEdit">Batal</button>
                    <button type="submit" class="p-[10px_20px] bg-[#0056D2] border-none text-white font-semibold rounded-[8px] cursor-pointer transition duration-200 hover:bg-[#0043a8]">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Modal Tambah ---
        const btnTambah = document.querySelector('.btn-tambah');
        const modalTambah = document.getElementById('modalTambah');
        const modalTambahContent = document.getElementById('modalTambahContent');
        const btnCloseTambah = document.getElementById('closeModal');
        const btnBatalTambah = document.getElementById('btnBatal');
        
        btnTambah.addEventListener('click', function() {
            modalTambah.classList.add('!opacity-100', '!visible');
            modalTambahContent.classList.add('!translate-y-0');
        });
        
        const closeTambah = function() { 
            modalTambah.classList.remove('!opacity-100', '!visible');
            modalTambahContent.classList.remove('!translate-y-0');
        };
        btnCloseTambah.addEventListener('click', closeTambah);
        btnBatalTambah.addEventListener('click', closeTambah);
        modalTambah.addEventListener('click', function(e) { if (e.target === modalTambah) closeTambah(); });

        // --- Modal Edit ---
        const modalEdit = document.getElementById('modalEdit');
        const modalEditContent = document.getElementById('modalEditContent');
        const btnCloseEdit = document.getElementById('closeModalEdit');
        const btnBatalEdit = document.getElementById('btnBatalEdit');
        const formEdit = document.getElementById('formEdit');
        const editNama = document.getElementById('edit_nama');
        const editTelepon = document.getElementById('edit_telepon');
        const editAlamat = document.getElementById('edit_alamat');

        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const telepon = this.getAttribute('data-telepon');
                const alamat = this.getAttribute('data-alamat');

                editNama.value = nama;
                editTelepon.value = telepon;
                editAlamat.value = alamat;
                
                // Update form action URL dynamically
                formEdit.action = `/dashboard/kasir/pelanggan/${id}`;
                
                modalEdit.classList.add('!opacity-100', '!visible');
                modalEditContent.classList.add('!translate-y-0');
            });
        });

        const closeEdit = function() { 
            modalEdit.classList.remove('!opacity-100', '!visible');
            modalEditContent.classList.remove('!translate-y-0');
        };
        btnCloseEdit.addEventListener('click', closeEdit);
        btnBatalEdit.addEventListener('click', closeEdit);
        modalEdit.addEventListener('click', function(e) { if (e.target === modalEdit) closeEdit(); });

        // --- Delete Confirmation ---
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.form-delete');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data pelanggan yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#a3aed0',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Notifications
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0056D2',
                confirmButtonText: 'Oke',
                timer: 3000
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                html: '{!! implode("<br>", $errors->all()) !!}',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Tutup'
            });
        @endif
    });
</script>
@endpush
