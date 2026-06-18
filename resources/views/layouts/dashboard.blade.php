<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mila Laundry')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Keep Google Fonts from original dashboard.css indirectly or add them here -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS v3 via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        sidebarBg: '#011C45',
                        sidebarActive: '#0056D2',
                        mainBg: '#F4F7FB',
                        cardBg: '#FFFFFF',
                        textDark: '#1E293B',
                        textMuted: '#64748B',
                        borderColor: '#E2E8F0'
                    }
                }
            }
        }
    </script>
    
    <!-- We still keep dashboard.css for some parts not yet migrated, but we will override layout here -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    @stack('styles')
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* General resets that Tailwind doesn't strictly enforce if using arbitrary overrides */
        body { font-family: 'Inter', sans-serif; background-color: #F4F7FB; }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-mainBg text-textDark">

    <aside class="w-[260px] bg-sidebarBg text-white flex flex-col h-full shrink-0">
        <div class="pt-[35px] px-[25px] pb-0 mb-[20px] flex items-center gap-[15px]">
            <img src="{{ asset('image/ic_log.png') }}" alt="Logo" class="w-[75px] h-[75px] object-contain">
            <div class="flex flex-col justify-center">
                <strong class="font-outfit text-[1.3rem] leading-[1.1] tracking-[0.5px] mb-[4px]">MILA<br>LAUNDRY</strong>
                <span class="text-[0.9rem] text-blue-300 font-normal">{{ ucfirst(Auth::user()->peran) }}</span>
            </div>
        </div>

        <ul class="flex-1 px-[15px] py-[20px] list-none overflow-y-auto no-scrollbar">
            <li class="mb-[5px]">
                <a href="{{ route('dashboard.' . Auth::user()->peran) }}" class="flex items-center gap-[15px] py-[12px] px-[20px] text-white no-underline rounded-lg font-medium transition duration-300 {{ Request::routeIs('dashboard.' . Auth::user()->peran) ? 'bg-sidebarActive' : 'hover:bg-sidebarActive' }}">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
            </li>
            @if(Auth::user()->peran == 'kasir')

            <li class="mb-[5px]">
                <a href="{{ route('dashboard.kasir.transaksi') }}" class="flex items-center gap-[15px] py-[12px] px-[20px] text-white no-underline rounded-lg font-medium transition duration-300 {{ Request::routeIs('dashboard.kasir.transaksi*') ? 'bg-sidebarActive' : 'hover:bg-sidebarActive' }}">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Transaksi
                </a>
            </li>
            @endif
            @if(Auth::user()->peran == 'super_admin')
            <li class="mb-[5px]">
                <a href="{{ route('dashboard.super_admin.kendali') }}" class="flex items-center gap-[15px] py-[12px] px-[20px] text-white no-underline rounded-lg font-medium transition duration-300 {{ Request::routeIs('dashboard.super_admin.kendali') ? 'bg-sidebarActive' : 'hover:bg-sidebarActive' }}">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    Kendali
                </a>
            </li>
            <li class="mb-[5px]">
                <a href="{{ route('dashboard.super_admin.transaksi') }}" class="flex items-center gap-[15px] py-[12px] px-[20px] text-white no-underline rounded-lg font-medium transition duration-300 {{ Request::routeIs('dashboard.super_admin.transaksi') ? 'bg-sidebarActive' : 'hover:bg-sidebarActive' }}">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Transaksi
                </a>
            </li>
            <li class="mb-[5px]">
                <a href="{{ route('dashboard.super_admin.riwayat') }}" class="flex items-center gap-[15px] py-[12px] px-[20px] text-white no-underline rounded-lg font-medium transition duration-300 {{ Request::routeIs('dashboard.super_admin.riwayat') ? 'bg-sidebarActive' : 'hover:bg-sidebarActive' }}">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat
                </a>
            </li>
            <li class="mb-[5px]">
                <a href="{{ route('dashboard.super_admin.manajemen_user') }}" class="flex items-center gap-[15px] py-[12px] px-[20px] text-white no-underline rounded-lg font-medium transition duration-300 {{ Request::routeIs('dashboard.super_admin.manajemen_user') ? 'bg-sidebarActive' : 'hover:bg-sidebarActive' }}">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manajemen User
                </a>
            </li>
            <li class="mb-[5px]">
                @php
                    $isDataMasterActive = Request::routeIs('dashboard.super_admin.data_master');
                    $activeTab = request()->query('tab', 'pelanggan');
                @endphp
                <button onclick="document.getElementById('data-master-submenu').classList.toggle('hidden'); document.getElementById('data-master-chevron').classList.toggle('rotate-180')" class="w-full flex items-center justify-between py-[12px] px-[20px] text-white bg-transparent border-none cursor-pointer rounded-lg font-medium transition duration-300 hover:bg-sidebarActive {{ $isDataMasterActive ? 'bg-sidebarActive/30' : '' }}">
                    <div class="flex items-center gap-[15px]">
                        <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Data Master
                    </div>
                    <svg id="data-master-chevron" class="w-[16px] h-[16px] transition-transform duration-200 {{ $isDataMasterActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <ul id="data-master-submenu" class="{{ $isDataMasterActive ? '' : 'hidden' }} pl-[45px] pr-[15px] py-[5px] list-none">
                    <li class="mb-[5px]">
                        <a href="{{ route('dashboard.super_admin.data_master') }}?tab=pelanggan" class="block py-[8px] {{ $isDataMasterActive && $activeTab == 'pelanggan' ? 'text-white font-medium' : 'text-gray-400 hover:text-white' }} no-underline text-[0.9rem] transition duration-300">Data Pelanggan</a>
                    </li>
                    <li class="mb-[5px]">
                        <a href="{{ route('dashboard.super_admin.data_master') }}?tab=layanan" class="block py-[8px] {{ $isDataMasterActive && $activeTab == 'layanan' ? 'text-white font-medium' : 'text-gray-400 hover:text-white' }} no-underline text-[0.9rem] transition duration-300">Jenis Layanan</a>
                    </li>
                    <li class="mb-[5px]">
                        <a href="{{ route('dashboard.super_admin.data_master') }}?tab=pencucian" class="block py-[8px] {{ $isDataMasterActive && $activeTab == 'pencucian' ? 'text-white font-medium' : 'text-gray-400 hover:text-white' }} no-underline text-[0.9rem] transition duration-300">Jenis Pencucian</a>
                    </li>
                    <li class="mb-[5px]">
                        <a href="{{ route('dashboard.super_admin.data_master') }}?tab=pengiriman" class="block py-[8px] {{ $isDataMasterActive && $activeTab == 'pengiriman' ? 'text-white font-medium' : 'text-gray-400 hover:text-white' }} no-underline text-[0.9rem] transition duration-300">Jenis Pengiriman</a>
                    </li>
                    <li class="mb-[5px]">
                        <a href="{{ route('dashboard.super_admin.data_master') }}?tab=item" class="block py-[8px] {{ $isDataMasterActive && $activeTab == 'item' ? 'text-white font-medium' : 'text-gray-400 hover:text-white' }} no-underline text-[0.9rem] transition duration-300">Item Laundry</a>
                    </li>
                    <li class="mb-[5px]">
                        <a href="{{ route('dashboard.super_admin.data_master') }}?tab=satuan" class="block py-[8px] {{ $isDataMasterActive && $activeTab == 'satuan' ? 'text-white font-medium' : 'text-gray-400 hover:text-white' }} no-underline text-[0.9rem] transition duration-300">Satuan</a>
                    </li>
                    <li class="mb-[5px]">
                        <a href="{{ route('dashboard.super_admin.data_master') }}?tab=promo" class="block py-[8px] {{ $isDataMasterActive && $activeTab == 'promo' ? 'text-white font-medium' : 'text-gray-400 hover:text-white' }} no-underline text-[0.9rem] transition duration-300">Promo</a>
                    </li>
                </ul>
            </li>
            <li class="mb-[5px]">
                <a href="{{ route('dashboard.super_admin.konfigurasi') }}" class="flex items-center gap-[15px] py-[12px] px-[20px] text-white no-underline rounded-lg font-medium transition duration-300 {{ Request::routeIs('dashboard.super_admin.konfigurasi') ? 'bg-sidebarActive' : 'hover:bg-sidebarActive' }}">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Konfigurasi
                </a>
            </li>
            @endif
            @if(Auth::user()->peran == 'pemilik')
            <li class="mb-[5px]">
                <a href="{{ route('dashboard.pemilik.transaksi') }}" class="flex items-center gap-[15px] py-[12px] px-[20px] text-white no-underline rounded-lg font-medium transition duration-300 {{ Request::routeIs('dashboard.pemilik.transaksi') ? 'bg-sidebarActive' : 'hover:bg-sidebarActive' }}">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Transaksi
                </a>
            </li>
            <li class="mb-[5px]">
                <a href="{{ route('dashboard.pemilik.laporan') }}" class="flex items-center gap-[15px] py-[12px] px-[20px] text-white no-underline rounded-lg font-medium transition duration-300 {{ Request::routeIs('dashboard.pemilik.laporan') ? 'bg-sidebarActive' : 'hover:bg-sidebarActive' }}">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan
                </a>
            </li>
            @endif
        </ul>

        <div class="p-[20px]">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-[15px] bg-transparent border-none text-white text-[1rem] cursor-pointer font-sans py-[12px] px-[5px] hover:text-red-300 transition duration-300">
                    <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <!-- Topbar -->
        <header class="flex justify-between items-center py-[25px] px-[40px] bg-mainBg">
            <div>
                <h1 class="text-[1.5rem] font-bold mb-[5px]">@yield('header_title')</h1>
                <p class="text-textMuted text-[0.9rem]">@yield('header_subtitle')</p>
            </div>
            
            <div class="flex items-center gap-[20px]">
                @yield('topbar_actions')
                
                <div class="flex items-center gap-[10px] text-textDark font-medium text-[0.9rem] pl-[20px] border-l border-borderColor">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y') }}</span>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="px-[40px] pb-[40px]">
            @yield('content')
        </div>
    </main>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Keluar Aplikasi?',
                text: "Sesi Anda akan diakhiri dan Anda harus login kembali.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                heightAuto: false,
                customClass: {
                    popup: 'rounded-[20px] shadow-2xl border border-gray-100',
                    title: 'text-[1.4rem] font-bold text-gray-800 font-outfit mb-1',
                    htmlContainer: 'text-gray-500 text-[0.95rem] font-sans',
                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-semibold py-[10px] px-[24px] rounded-xl transition-all duration-300 shadow-lg shadow-red-500/30',
                    cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-[10px] px-[24px] rounded-xl transition-all duration-300 mr-3'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>
    @stack('scripts')
</body>
</html>
