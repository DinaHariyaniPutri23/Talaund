@extends('layouts.dashboard')

@section('title', 'Pencatatan - Dashboard Pemilik')
@section('header_title', 'Laporan Pencatatan')
@section('header_subtitle', 'Ringkasan data transaksi laundry pada periode tertentu.')

@section('topbar_actions')
    <div class="flex gap-[15px]">
        <button class="flex items-center gap-[8px] px-[16px] py-[8px] text-[13px] font-semibold text-[#2b3674] bg-white border border-[#e0e5f2] rounded-[8px] cursor-pointer transition-all duration-200 hover:bg-[#f8fafc] hover:border-primaryBlue">
            <svg class="w-[14px] h-[14px] text-primaryBlue stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export PDF
        </button>
        <button class="flex items-center gap-[8px] px-[16px] py-[8px] text-[13px] font-semibold text-[#2b3674] bg-white border border-[#e0e5f2] rounded-[8px] cursor-pointer transition-all duration-200 hover:bg-[#f8fafc] hover:border-primaryBlue">
            <svg class="w-[14px] h-[14px] text-primaryBlue stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            Export Excel
        </button>
    </div>
@endsection

@section('content')

    <div class="bg-cardBg rounded-[20px] p-[25px] grid grid-cols-1 lg:grid-cols-[2fr_1fr_1fr] gap-[20px] mb-[30px] shadow-[0_4px_10px_rgba(0,0,0,0.02)] border border-[rgba(0,0,0,0.02)]">
        <div class="flex flex-col gap-[10px]">
            <label class="font-bold text-[#2b3674] text-[14px]">Range Tanggal</label>
            <div class="flex items-center gap-[10px]">
                <input type="date" class="w-full p-[12px] border border-[#e0e5f2] rounded-[12px] outline-none text-[#2b3674] font-sans bg-white focus:border-primaryBlue">
                <span class="text-[#2b3674] font-semibold">s/d</span>
                <input type="date" class="w-full p-[12px] border border-[#e0e5f2] rounded-[12px] outline-none text-[#2b3674] font-sans bg-white focus:border-primaryBlue">
            </div>
        </div>
        <div class="flex flex-col gap-[10px]">
            <label class="font-bold text-[#2b3674] text-[14px]">Status</label>
            <select class="w-full p-[12px] border border-[#e0e5f2] rounded-[12px] outline-none text-[#2b3674] font-sans bg-white focus:border-primaryBlue">
                <option value="">Semua</option>
                <option value="lunas">Lunas</option>
                <option value="belum">Belum Lunas</option>
            </select>
        </div>
        <div class="flex flex-col gap-[10px]">
            <label class="font-bold text-[#2b3674] text-[14px]">Cari</label>
            <input type="text" class="w-full p-[12px] border border-[#e0e5f2] rounded-[12px] outline-none text-[#2b3674] font-sans bg-white focus:border-primaryBlue" placeholder="Nama/Nota...">
        </div>
    </div>

    <div class="bg-cardBg rounded-[20px] p-[20px] shadow-[0_4px_10px_rgba(0,0,0,0.02)] border border-[rgba(0,0,0,0.02)] overflow-hidden">
        <table class="w-full border-collapse text-left">
            <thead>
                <tr>
                    <th class="p-[15px] text-[#2b3674] text-[13px] font-bold uppercase border-b border-[#f4f7fe]">No. Nota</th>
                    <th class="p-[15px] text-[#2b3674] text-[13px] font-bold uppercase border-b border-[#f4f7fe]">Tanggal</th>
                    <th class="p-[15px] text-[#2b3674] text-[13px] font-bold uppercase border-b border-[#f4f7fe]">Metode</th>
                    <th class="p-[15px] text-[#2b3674] text-[13px] font-bold uppercase border-b border-[#f4f7fe]">Total</th>
                    <th class="p-[15px] text-[#2b3674] text-[13px] font-bold uppercase border-b border-[#f4f7fe] text-center">Status</th>
                    <th class="p-[15px] text-[#2b3674] text-[13px] font-bold uppercase border-b border-[#f4f7fe] text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="text-center p-[50px] text-[#a3aed0] italic font-normal border-b border-[#f4f7fe]">Belum ada data transaksi untuk ditampilkan.</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
