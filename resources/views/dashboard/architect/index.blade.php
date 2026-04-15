@extends('layouts.landing')

@section('content')
@php
    $statusLabels = ['pending' => 'Menunggu', 'in_progress' => 'Berjalan', 'completed' => 'Selesai'];
    $statusColors = ['pending' => 'text-amber-600 bg-amber-50 border-amber-200', 'in_progress' => 'text-blue-600 bg-blue-50 border-blue-200', 'completed' => 'text-emerald-600 bg-emerald-50 border-emerald-200'];
@endphp

<div class="relative min-h-screen bg-[#FAFAFA] overflow-x-hidden">
    <!-- Background blobs -->
    <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-gray-200/50 to-transparent blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-gradient-to-tl from-gray-200/50 to-transparent blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 py-14 pt-28">

        <!-- Header -->
        <div class="mb-12">
            <p class="text-sm font-semibold text-gray-400 tracking-widest uppercase mb-2">Dashboard Arsitek</p>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Halo, {{ auth()->user()->name }} 🏛️</h1>
            <p class="mt-2 text-base text-gray-500 font-medium">Kelola proyek, portofolio, dan bangun reputasimu sebagai arsitek terbaik.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-100 px-5 py-4 text-emerald-700 font-semibold text-sm shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Upgrade Banner (non-premium) --}}
        @if(!auth()->user()->isPremium())
        <div class="mb-8 rounded-[2rem] border border-gray-900/10 bg-gradient-to-r from-gray-900 to-gray-800 p-6 shadow-lg relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/5 blur-2xl"></div>
            <div class="relative flex items-center justify-between gap-4 flex-wrap">
                <div>
                    <h3 class="text-base font-extrabold text-white mb-1">Tingkatkan Karir Arsitekmu ke Premium 🏛️</h3>
                    <p class="text-sm text-gray-400 font-medium">Portfolio showcase, terima booking, konsultasi berbayar, dan monetisasi langsung dari platform.</p>
                </div>
                <a href="{{ route('upgrade.index') }}"
                   class="shrink-0 inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-2.5 text-sm font-bold text-gray-900 hover:bg-gray-100 transition active:scale-[0.97]">
                    Lihat Benefit →
                </a>
            </div>
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
            <div class="lg:col-span-2 relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)] overflow-hidden">
                <div class="text-xs font-semibold text-gray-400 tracking-wide mb-1">Total Pendapatan</div>
                <div class="text-2xl font-extrabold text-emerald-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="text-xs text-gray-400 mt-1">dari proyek selesai</div>
            </div>
            <div class="relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="text-3xl font-extrabold text-blue-600">{{ $activeProjects }}</div>
                <div class="mt-1 text-xs font-semibold text-gray-400 tracking-wide">Proyek Aktif</div>
            </div>
            <div class="relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="text-3xl font-extrabold text-gray-900">{{ $completedProjects }}</div>
                <div class="mt-1 text-xs font-semibold text-gray-400 tracking-wide">Selesai</div>
            </div>
            <div class="relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="text-3xl font-extrabold text-amber-500">{{ number_format($avgRating, 1) }}</div>
                <div class="mt-1 text-xs font-semibold text-gray-400 tracking-wide">Avg Rating</div>
            </div>
            <div class="relative rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="text-3xl font-extrabold text-gray-900">{{ $followersCount }}</div>
                <div class="mt-1 text-xs font-semibold text-gray-400 tracking-wide">Pengikut</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Recent Projects -->
            <div class="lg:col-span-2 rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-extrabold text-gray-900">Proyek Masuk</h2>
                    <a href="{{ route('architect.projects.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-900 transition">Lihat semua →</a>
                </div>

                @forelse($recentProjects as $project)
                    <div class="flex items-center justify-between py-3.5 border-b border-gray-100 last:border-0">
                        <div>
                            <div class="text-sm font-bold text-gray-900">{{ $project->property_type ?? 'Proyek #'.$project->id }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">Klien: {{ $project->client?->name ?? '-' }} · Rp {{ number_format($project->total_price, 0, ',', '.') }}</div>
                        </div>
                        @php
                            $st = $project->status ?? 'pending';
                            $color = $statusColors[$st] ?? 'text-gray-600 bg-gray-50 border-gray-200';
                            $label = $statusLabels[$st] ?? $st;
                        @endphp
                        <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-bold {{ $color }}">
                            {{ $label }}
                        </span>
                    </div>
                @empty
                    <div class="py-8 text-center text-sm text-gray-400 font-medium">
                        Belum ada proyek masuk. Lengkapi profil agar klien bisa menemukanmu!
                    </div>
                @endforelse
            </div>

            <!-- Quick Actions -->
            <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <h2 class="text-base font-extrabold text-gray-900 mb-5">Aksi Cepat</h2>
                <div class="flex flex-col gap-3">
                    {{-- Always accessible: Kelola Proyek --}}
                    <a href="{{ route('architect.projects.index') }}" class="flex items-center gap-3 rounded-2xl bg-gray-900 text-white px-4 py-3 text-sm font-bold hover:bg-black transition active:scale-[0.97]">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-white/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </span>
                        Kelola Proyek
                    </a>

                    {{-- Edit Profil Publik (Premium only) --}}
                    @if(auth()->user()->isPremium())
                    <a href="{{ route('architect.profile.edit') }}" class="flex items-center gap-3 rounded-2xl bg-white border border-gray-200 text-gray-900 px-4 py-3 text-sm font-bold hover:bg-gray-50 transition active:scale-[0.97]">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        Edit Profil Publik
                    </a>
                    @else
                    <a href="{{ route('upgrade.index') }}" class="flex items-center gap-3 rounded-2xl bg-gray-50 border border-gray-200 text-gray-400 px-4 py-3 text-sm font-bold hover:bg-gray-100 transition">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        Edit Profil Publik
                        <span class="ml-auto text-[10px] font-bold bg-gray-200 text-gray-500 rounded-full px-2 py-0.5">PREMIUM</span>
                    </a>
                    @endif

                    {{-- Always accessible: Ulasan Klien --}}
                    <a href="{{ route('architect.reviews.index') }}" class="flex items-center gap-3 rounded-2xl bg-white border border-gray-200 text-gray-900 px-4 py-3 text-sm font-bold hover:bg-gray-50 transition active:scale-[0.97]">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.173c.969 0 1.371 1.24.588 1.81l-3.377 2.454a1 1 0 00-.364 1.118l1.286 3.967c.3.921-.755 1.688-1.54 1.118l-3.377-2.454a1 1 0 00-1.176 0l-3.377 2.454c-.784.57-1.838-.197-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2 9.394c-.783-.57-.38-1.81.588-1.81h4.173a1 1 0 00.95-.69l1.286-3.967z"/></svg>
                        </span>
                        Ulasan Klien
                    </a>

                    {{-- Premium divider --}}
                    @if(!auth()->user()->isPremium())
                    <div class="flex items-center gap-2 mt-1 mb-0">
                        <div class="flex-1 border-t border-gray-200"></div>
                        <span class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">Premium</span>
                        <div class="flex-1 border-t border-gray-200"></div>
                    </div>
                    @endif

                    {{-- Portfolio Showcase --}}
                    @if(auth()->user()->isPremium())
                    <a href="{{ route('architect.portfolios.index') }}" class="flex items-center gap-3 rounded-2xl bg-white border border-gray-200 text-gray-900 px-4 py-3 text-sm font-bold hover:bg-gray-50 transition active:scale-[0.97]">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        Portfolio Showcase
                    </a>
                    @else
                    <a href="{{ route('upgrade.index') }}" class="flex items-center gap-3 rounded-2xl bg-gray-50 border border-gray-200 text-gray-400 px-4 py-3 text-sm font-bold hover:bg-gray-100 transition">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        Portfolio Showcase
                        <span class="ml-auto text-[10px] font-bold bg-gray-200 text-gray-500 rounded-full px-2 py-0.5">PREMIUM</span>
                    </a>
                    @endif

                    {{-- Kotak Masuk (Chat / Konsultasi Private) --}}
                    @if(auth()->user()->isPremium())
                    <a href="{{ route('chat.index') }}" class="flex items-center gap-3 rounded-2xl bg-white border border-gray-200 text-gray-900 px-4 py-3 text-sm font-bold hover:bg-gray-50 transition active:scale-[0.97]">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.9 9.9 0 01-4-.8L3 20l1.2-3A7.6 7.6 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </span>
                        Konsultasi Private
                    </a>
                    @else
                    <a href="{{ route('upgrade.index') }}" class="flex items-center gap-3 rounded-2xl bg-gray-50 border border-gray-200 text-gray-400 px-4 py-3 text-sm font-bold hover:bg-gray-100 transition">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        Konsultasi Private
                        <span class="ml-auto text-[10px] font-bold bg-gray-200 text-gray-500 rounded-full px-2 py-0.5">PREMIUM</span>
                    </a>
                    @endif

                    {{-- Terima Booking --}}
                    @if(auth()->user()->isPremium())
                    <a href="{{ route('architect.projects.index') }}" class="flex items-center gap-3 rounded-2xl bg-white border border-gray-200 text-gray-900 px-4 py-3 text-sm font-bold hover:bg-gray-50 transition active:scale-[0.97]">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        Terima Booking
                    </a>
                    @else
                    <a href="{{ route('upgrade.index') }}" class="flex items-center gap-3 rounded-2xl bg-gray-50 border border-gray-200 text-gray-400 px-4 py-3 text-sm font-bold hover:bg-gray-100 transition">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        Terima Booking
                        <span class="ml-auto text-[10px] font-bold bg-gray-200 text-gray-500 rounded-full px-2 py-0.5">PREMIUM</span>
                    </a>
                    @endif

                    {{-- Monetisasi --}}
                    @if(auth()->user()->isPremium())
                    <a href="{{ route('architect.projects.index') }}" class="flex items-center gap-3 rounded-2xl bg-white border border-gray-200 text-gray-900 px-4 py-3 text-sm font-bold hover:bg-gray-50 transition active:scale-[0.97]">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        Monetisasi
                    </a>
                    @else
                    <a href="{{ route('upgrade.index') }}" class="flex items-center gap-3 rounded-2xl bg-gray-50 border border-gray-200 text-gray-400 px-4 py-3 text-sm font-bold hover:bg-gray-100 transition">
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        Monetisasi
                        <span class="ml-auto text-[10px] font-bold bg-gray-200 text-gray-500 rounded-full px-2 py-0.5">PREMIUM</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
