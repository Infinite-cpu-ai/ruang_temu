@extends('layouts.landing')

@section('content')
<div class="relative min-h-screen bg-[#FAFAFA] overflow-x-hidden">
    <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-gray-200/50 to-transparent blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-gradient-to-tl from-gray-200/50 to-transparent blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-6 py-14 pt-28">

        {{-- Upgrade Required Banner --}}
        @if(session('upgrade_required'))
        <div class="mb-8 flex items-center gap-3 rounded-2xl bg-amber-50 border border-amber-200 px-5 py-4 text-amber-700 font-semibold text-sm shadow-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            {{ session('upgrade_required') }}
        </div>
        @endif

        {{-- Header --}}
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 rounded-full bg-gray-900 px-4 py-1.5 text-xs font-bold text-white mb-5">
                <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                Premium Arsitek
            </div>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight">
                Tingkatkan Karir Arsitekmu<br>
                <span class="text-gray-400">dengan Premium</span>
            </h1>
            <p class="mt-4 text-base text-gray-500 font-medium max-w-xl mx-auto">
                Dapatkan lebih banyak klien, terima konsultasi berbayar, dan bangun reputasimu sebagai arsitek terbaik di platform.
            </p>
        </div>

        {{-- Pricing Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-14">

            {{-- Free Plan --}}
            <div class="rounded-[2rem] border border-gray-200 bg-white/70 backdrop-blur-xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="mb-6">
                    <h3 class="text-lg font-extrabold text-gray-900">Free Plan</h3>
                    <div class="flex items-baseline gap-1 mt-2">
                        <span class="text-4xl font-extrabold text-gray-900">Rp 0</span>
                        <span class="text-sm text-gray-400 font-medium">/selamanya</span>
                    </div>
                    <p class="mt-3 text-sm text-gray-400 font-medium">Akses dasar untuk mulai tampil di platform.</p>
                </div>

                <ul class="space-y-3 mb-8">
                    @foreach([
                        ['check', 'Profil arsitek dasar'],
                        ['check', 'Jawab pertanyaan di Quick Ask'],
                        ['check', 'Terima proyek dari klien'],
                        ['cross', 'Profil prioritas di pencarian'],
                        ['cross', 'Portfolio showcase lengkap'],
                        ['cross', 'Set harga konsultasi sendiri'],
                        ['cross', 'Chat & video privat dengan klien'],
                        ['cross', 'Terima booking langsung'],
                        ['cross', 'Monetisasi via paket & konsultasi'],
                    ] as $item)
                    <li class="flex items-center gap-3 text-sm {{ $item[0] === 'check' ? 'text-gray-700' : 'text-gray-300' }}">
                        @if($item[0] === 'check')
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="w-4 h-4 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @endif
                        <span class="font-medium">{{ $item[1] }}</span>
                    </li>
                    @endforeach
                </ul>

                @if(auth()->check() && !auth()->user()->isPremium())
                    <div class="rounded-2xl bg-gray-100 px-6 py-3 text-center text-sm font-bold text-gray-400">
                        Plan kamu saat ini
                    </div>
                @endif
            </div>

            {{-- Premium Plan --}}
            <div class="relative rounded-[2rem] border-2 border-gray-900 bg-white/70 backdrop-blur-xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.08)]">
                {{-- Badge --}}
                <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-900 px-4 py-1.5 text-xs font-bold text-white shadow-lg">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg> Rekomendasi Arsitek
                    </span>
                </div>

                <div class="mb-6 mt-2">
                    <h3 class="text-lg font-extrabold text-gray-900">Premium Arsitek</h3>
                    <div class="flex items-baseline gap-1 mt-2">
                        <span class="text-4xl font-extrabold text-gray-900">Rp 50.000</span>
                        <span class="text-sm text-gray-400 font-medium">/bulan</span>
                    </div>
                    <p class="mt-3 text-sm text-gray-400 font-medium">Unlock semua fitur untuk memaksimalkan pendapatan dan klien.</p>
                </div>

                <ul class="space-y-3 mb-8">
                    @foreach([
                        'Profil arsitek dasar',
                        'Jawab pertanyaan di Quick Ask',
                        'Terima proyek dari klien',
                        'Profil prioritas di pencarian',
                        'Portfolio showcase lengkap',
                        'Set harga konsultasi sendiri',
                        'Chat & video privat dengan klien',
                        'Terima booking langsung',
                        'Monetisasi via paket & konsultasi',
                    ] as $item)
                    <li class="flex items-center gap-3 text-sm text-gray-700">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span class="font-medium">{{ $item }}</span>
                    </li>
                    @endforeach
                </ul>

                @auth
                    @if(auth()->user()->isPremium())
                        <div class="flex items-center justify-center gap-2 rounded-2xl bg-emerald-50 border border-emerald-200 px-6 py-3 text-sm font-bold text-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Kamu sudah Premium!
                        </div>

                        @if(auth()->user()->is_subscription_active)
                            <p class="mt-3 text-center text-xs text-gray-500 font-medium">Berlaku hingga {{ auth()->user()->premium_expires_at?->format('d M Y') }}.</p>
                            <form action="{{ route('upgrade.cancel') }}" method="POST" class="mt-2 text-center" onsubmit="return confirm('Apakah kamu yakin ingin membatalkan perpanjangan otomatis? Fitur Premium akan tetap aktif hingga periode ini berakhir.')">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 hover:underline transition">
                                    Batalkan Langganan
                                </button>
                            </form>
                        @else
                            <div class="mt-3 rounded-xl bg-orange-50 border border-orange-100 p-3 text-center">
                                <p class="flex items-center justify-center gap-1.5 text-xs text-orange-600 font-bold">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                    Langganan Telah Dibatalkan
                                </p>
                                <p class="text-[11px] text-gray-500 font-medium mt-1">Akan kembali ke Free Plan pada {{ auth()->user()->premium_expires_at?->format('d M Y') }}.</p>
                            </div>
                        @endif
                    @else
                        @if(!empty($midtransReady))
                            <form action="{{ route('upgrade.process') }}" method="POST" id="upgrade-form">
                                @csrf
                                <button type="submit" id="upgrade-btn"
                                        class="w-full rounded-2xl bg-gray-900 px-6 py-3.5 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] shadow-lg shadow-gray-900/20">
                                    Upgrade ke Premium Arsitek — Rp 50.000/bln
                                </button>
                            </form>
                        @else
                            <form action="{{ route('upgrade.process') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full rounded-2xl bg-gray-900 px-6 py-3.5 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] shadow-lg shadow-gray-900/20">
                                    Upgrade ke Premium Arsitek — Rp 50.000/bln
                                </button>
                            </form>
                        @endif
                        @error('payment')
                            <p class="mt-3 text-center text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                        <p class="mt-3 text-center text-[11px] text-gray-400 font-medium">Bisa dibatalkan kapan saja.</p>
                    @endif
                @else
                    <a href="{{ route('register') }}"
                       class="block w-full rounded-2xl bg-gray-900 px-6 py-3.5 text-center text-sm font-bold text-white hover:bg-black transition">
                        Daftar & Upgrade
                    </a>
                @endauth
            </div>
        </div>

        {{-- 6 Feature Benefits --}}
        <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
            <h2 class="text-lg font-extrabold text-gray-900 mb-2 text-center">Apa yang kamu dapatkan?</h2>
            <p class="text-sm text-gray-400 font-medium text-center mb-8">Semua fitur yang kamu butuhkan untuk sukses sebagai arsitek profesional.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                {{-- 1. Upgrade ke Premium Profile --}}
                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-sm font-extrabold text-gray-900">Premium Profile</h3>
                    </div>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed mb-3">Profilmu tampil lebih menonjol dan diprioritaskan dalam pencarian klien.</p>
                    <ul class="space-y-1.5">
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Profile lebih visible
                        </li>
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Bisa dipilih langsung oleh user
                        </li>
                    </ul>
                </div>

                {{-- 2. Portfolio Showcase --}}
                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-sm font-extrabold text-gray-900">Portfolio Showcase</h3>
                    </div>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed mb-3">Tampilkan karya terbaikmu untuk menarik klien potensial.</p>
                    <ul class="space-y-1.5">
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Upload foto proyek
                        </li>
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Before-after gallery
                        </li>
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Deskripsi konsep desain
                        </li>
                    </ul>
                </div>

                {{-- 3. Paid Consultation --}}
                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-sm font-extrabold text-gray-900">Paid Consultation</h3>
                    </div>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed mb-3">Tentukan tarif konsultasi dan atur ketersediaanmu sendiri.</p>
                    <ul class="space-y-1.5">
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Set harga per jam
                        </li>
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Atur availability jadwal
                        </li>
                    </ul>
                </div>

                {{-- 4. Terima Booking --}}
                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <h3 class="text-sm font-extrabold text-gray-900">Terima Booking</h3>
                    </div>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed mb-3">Klien bisa langsung memilih dan booking konsultasi denganmu.</p>
                    <ul class="space-y-1.5">
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Terima request masuk otomatis
                        </li>
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Accept / decline booking
                        </li>
                    </ul>
                </div>

                {{-- 5. Konsultasi Private --}}
                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <h3 class="text-sm font-extrabold text-gray-900">Konsultasi Private</h3>
                    </div>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed mb-3">Diskusi mendalam dengan klien via chat atau video call.</p>
                    <ul class="space-y-1.5">
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Chat & video privat
                        </li>
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Diskusi layout & konsep desain
                        </li>
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Rekomendasi material spesifik
                        </li>
                    </ul>
                </div>

                {{-- 6. Monetisasi --}}
                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <h3 class="text-sm font-extrabold text-gray-900">Monetisasi</h3>
                    </div>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed mb-3">Hasilkan pendapatan langsung dari keahlianmu di platform.</p>
                    <ul class="space-y-1.5">
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Income dari konsultasi
                        </li>
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Penjualan package desain
                        </li>
                        <li class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Exposure profile di platform
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Midtrans Snap Popup --}}
@if(!empty($snapToken))
<script src="{{ $snapScriptUrl }}" data-client-key="{{ $snapClientKey }}"></script>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = '{{ route("upgrade.finish") }}?order_id=' + result.order_id;
            },
            onPending: function (result) {
                window.location.href = '{{ route("upgrade.finish") }}?order_id=' + result.order_id;
            },
            onError: function (result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function () {
                // User closed the popup without completing payment
            }
        });
    });
</script>
@endif
@endsection
