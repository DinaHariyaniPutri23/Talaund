@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="max-w-[1200px] mx-auto px-[2rem] w-full">
    <nav class="py-[1.5rem] flex justify-between items-center">
        <a href="/" class="font-outfit text-[1.8rem] font-bold text-primaryBlue tracking-[1px] no-underline transition duration-300 hover:text-primaryBlueHover">
            Mila<span class="text-accentBlue">Laundry</span>
        </a>
        <div class="hidden md:flex gap-[2rem] items-center">
            <a href="/" class="text-textGray font-medium no-underline transition duration-300 hover:text-primaryBlue">Beranda</a>
            <a href="#layanan" class="text-textGray font-medium no-underline transition duration-300 hover:text-primaryBlue">Layanan</a>
            <a href="#kontak" class="text-textGray font-medium no-underline transition duration-300 hover:text-primaryBlue">Kontak</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard/' . Auth::user()->peran) }}" class="inline-block py-[12px] px-[28px] rounded-[8px] font-outfit font-semibold cursor-pointer transition duration-300 text-center bg-transparent text-primaryBlue border-2 border-primaryBlue hover:bg-primaryBlue hover:text-white">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="inline-block py-[12px] px-[28px] rounded-[8px] font-outfit font-semibold cursor-pointer transition duration-300 text-center bg-primaryBlue text-white shadow-[0_4px_6px_rgba(26,54,93,0.2)] hover:bg-primaryBlueHover hover:-translate-y-[2px] hover:shadow-[0_6px_12px_rgba(26,54,93,0.3)]">Masuk</a>
                @endauth
            @endif
        </div>
    </nav>
</div>

<header class="flex-1 flex items-center justify-center text-center py-[6rem] px-[2rem] relative z-10 animate-[fadeIn_1s_ease-out]">
    <div class="max-w-[850px] mx-auto">
        <h1 class="text-[2.8rem] md:text-[3.8rem] mb-[1.5rem] leading-[1.15] text-primaryBlue font-bold font-outfit">
            Pakaian Bersih, Hidup Lebih Mudah dengan <span class="text-accentBlue">MilaLaundry.</span>
        </h1>
        <p class="text-[1.1rem] md:text-[1.25rem] text-textGray mb-[2.5rem] max-w-[700px] mx-auto">Kami memberikan perawatan terbaik untuk pakaian Anda dengan layanan cepat, bersih, dan wangi. Nikmati hari Anda, biarkan kami yang mengurus cucian.</p>
        <div class="flex flex-col md:flex-row gap-[1rem] justify-center">
            <a href="{{ route('login') }}" class="inline-block py-[16px] px-[32px] rounded-[8px] font-outfit font-semibold cursor-pointer transition duration-300 text-center bg-primaryBlue text-white shadow-[0_4px_6px_rgba(26,54,93,0.2)] hover:bg-primaryBlueHover hover:-translate-y-[2px] hover:shadow-[0_6px_12px_rgba(26,54,93,0.3)] text-[1.1rem]">Mulai Sekarang</a>
            <a href="#layanan" class="inline-block py-[16px] px-[32px] rounded-[8px] font-outfit font-semibold cursor-pointer transition duration-300 text-center bg-transparent text-primaryBlue border-2 border-primaryBlue hover:bg-primaryBlue hover:text-white text-[1.1rem]">Pelajari Lebih Lanjut</a>
        </div>
    </div>
</header>

<section id="layanan" class="py-[5rem] px-[2rem] max-w-[1200px] mx-auto w-full">
    <h2 class="text-center text-[2.5rem] mb-[3rem] text-primaryBlue font-bold font-outfit">Mengapa Memilih Kami?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-[2rem]">
        <div class="p-[2.5rem] text-center bg-white/85 backdrop-blur-[12px] border border-white/40 rounded-[16px] shadow-card transition duration-300 hover:-translate-y-[5px] hover:shadow-hover">
            <div class="text-[3rem] mb-[1.5rem] inline-block text-transparent bg-clip-text bg-gradient-to-br from-accentBlue to-primaryBlue">✨</div>
            <h3 class="text-[1.5rem] mb-[1rem] text-textDark font-bold font-outfit">Pasti Bersih & Wangi</h3>
            <p class="text-textGray text-[1rem]">Kami menggunakan detergen premium dan pewangi tahan lama untuk memastikan pakaian Anda selalu segar.</p>
        </div>
        <div class="p-[2.5rem] text-center bg-white/85 backdrop-blur-[12px] border border-white/40 rounded-[16px] shadow-card transition duration-300 hover:-translate-y-[5px] hover:shadow-hover">
            <div class="text-[3rem] mb-[1.5rem] inline-block text-transparent bg-clip-text bg-gradient-to-br from-accentBlue to-primaryBlue">⚡</div>
            <h3 class="text-[1.5rem] mb-[1rem] text-textDark font-bold font-outfit">Layanan Cepat Kilat</h3>
            <p class="text-textGray text-[1rem]">Butuh cepat? Kami menyediakan layanan cuci kilat selesai dalam hitungan jam tanpa mengurangi kualitas.</p>
        </div>
        <div class="p-[2.5rem] text-center bg-white/85 backdrop-blur-[12px] border border-white/40 rounded-[16px] shadow-card transition duration-300 hover:-translate-y-[5px] hover:shadow-hover">
            <div class="text-[3rem] mb-[1.5rem] inline-block text-transparent bg-clip-text bg-gradient-to-br from-accentBlue to-primaryBlue">🛡️</div>
            <h3 class="text-[1.5rem] mb-[1rem] text-textDark font-bold font-outfit">Garansi Perawatan</h3>
            <p class="text-textGray text-[1rem]">Pakaian Anda aman di tangan profesional. Kami memisahkan pakaian berdasarkan bahan dan warna.</p>
        </div>
    </div>
</section>

<footer class="py-[2rem] text-center border-t border-black/5 mt-auto bg-white text-textGray">
    <div class="max-w-[1200px] mx-auto px-[2rem]">
        <p>&copy; {{ date('Y') }} MilaLaundry. Semua Hak Cipta Dilindungi.</p>
    </div>
</footer>
@endsection
