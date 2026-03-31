@extends('layouts.landing')

@section('content')
<div class="relative min-h-screen bg-[#FAFAFA] overflow-x-hidden">
    <!-- Background blobs -->
    <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-gray-200/50 to-transparent blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-gradient-to-tl from-gray-200/50 to-transparent blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 py-14 pt-28">

        <!-- Header -->
        <div class="mb-12">
            <p class="text-sm font-semibold text-gray-400 tracking-widest uppercase mb-2">Admin Panel</p>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Platform Overview ⚙️</h1>
            <p class="mt-2 text-base text-gray-500 font-medium">Pantau seluruh aktivitas dan data platform RUANG TEMU.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-10">
            <div class="relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="text-3xl font-extrabold text-gray-900">{{ $totalUsers }}</div>
                <div class="mt-1 text-xs font-semibold text-gray-400 tracking-wide">Total Klien</div>
            </div>
            <div class="relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="text-3xl font-extrabold text-indigo-600">{{ $totalArchitects }}</div>
                <div class="mt-1 text-xs font-semibold text-gray-400 tracking-wide">Total Arsitek</div>
            </div>
            <div class="relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="text-3xl font-extrabold text-blue-600">{{ $totalProjects }}</div>
                <div class="mt-1 text-xs font-semibold text-gray-400 tracking-wide">Total Proyek</div>
            </div>
            <div class="relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="text-xl font-extrabold text-emerald-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="mt-1 text-xs font-semibold text-gray-400 tracking-wide">Total Revenue</div>
            </div>
            <div class="relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="text-3xl font-extrabold text-gray-900">{{ $totalReviews }}</div>
                <div class="mt-1 text-xs font-semibold text-gray-400 tracking-wide">Total Ulasan</div>
            </div>
            <div class="relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)] {{ $reportedReviews > 0 ? 'ring-2 ring-red-300' : '' }}">
                <div class="text-3xl font-extrabold {{ $reportedReviews > 0 ? 'text-red-600' : 'text-gray-400' }}">{{ $reportedReviews }}</div>
                <div class="mt-1 text-xs font-semibold text-gray-400 tracking-wide">Ulasan Dilaporkan</div>
            </div>
        </div>

        <!-- Management Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <a href="{{ route('admin.users.index') }}" class="group relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gray-900/5 rounded-bl-full"></div>
                <div class="mb-4 flex items-center justify-center w-12 h-12 rounded-2xl bg-gray-100 text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="text-base font-extrabold text-gray-900">Manajemen Pengguna</h3>
                <p class="mt-2 text-sm text-gray-500">Lihat dan kelola seluruh klien & arsitek terdaftar.</p>
                <span class="mt-4 inline-block text-sm font-bold text-gray-400 group-hover:text-gray-900 transition">Kelola →</span>
            </a>

            <a href="{{ route('admin.specializations.index') }}" class="group relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gray-900/5 rounded-bl-full"></div>
                <div class="mb-4 flex items-center justify-center w-12 h-12 rounded-2xl bg-gray-100 text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <h3 class="text-base font-extrabold text-gray-900">Master Spesialisasi</h3>
                <p class="mt-2 text-sm text-gray-500">Tambah, ubah, dan hapus kategori spesialisasi arsitek.</p>
                <span class="mt-4 inline-block text-sm font-bold text-gray-400 group-hover:text-gray-900 transition">Kelola →</span>
            </a>

            <a href="{{ route('admin.reviews.index') }}" class="group relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-shadow {{ $reportedReviews > 0 ? 'ring-2 ring-red-200' : '' }} overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gray-900/5 rounded-bl-full"></div>
                @if($reportedReviews > 0)
                    <span class="absolute top-4 right-6 inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-700">{{ $reportedReviews }} laporan</span>
                @endif
                <div class="mb-4 flex items-center justify-center w-12 h-12 rounded-2xl bg-gray-100 text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.173c.969 0 1.371 1.24.588 1.81l-3.377 2.454a1 1 0 00-.364 1.118l1.286 3.967c.3.921-.755 1.688-1.54 1.118l-3.377-2.454a1 1 0 00-1.176 0l-3.377 2.454c-.784.57-1.838-.197-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2 9.394c-.783-.57-.38-1.81.588-1.81h4.173a1 1 0 00.95-.69l1.286-3.967z"/></svg>
                </div>
                <h3 class="text-base font-extrabold text-gray-900">Manajemen Ulasan</h3>
                <p class="mt-2 text-sm text-gray-500">Cek dan moderasi ulasan yang masuk dari klien.</p>
                <span class="mt-4 inline-block text-sm font-bold text-gray-400 group-hover:text-gray-900 transition">Kelola →</span>
            </a>
        </div>

    </div>
</div>
@endsection
