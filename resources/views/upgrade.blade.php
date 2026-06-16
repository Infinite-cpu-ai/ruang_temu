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
                <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                Premium
            </div>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight">
                Unlock Semua Fitur<br>
                <span class="text-gray-400">Ruang Temu</span>
            </h1>
            <p class="mt-4 text-base text-gray-500 font-medium max-w-xl mx-auto">
                Akses konsultasi langsung, chat privat dengan arsitek, dan fitur eksklusif lainnya.
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
                    <p class="mt-3 text-sm text-gray-400 font-medium">Akses dasar untuk mulai eksplorasi.</p>
                </div>

                <ul class="space-y-3 mb-8">
                    @foreach([
                        ['check', 'Tanya Arsitek (Quick Ask)'],
                        ['check', 'Lihat profil & portfolio arsitek'],
                        ['check', 'Follow arsitek favorit'],
                        ['cross', 'Chat langsung dengan arsitek'],
                        ['cross', 'Booking & konsultasi privat'],
                        ['cross', 'Beli paket desain'],
                        ['cross', 'Prioritas respons arsitek'],
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
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg> Paling Populer
                    </span>
                </div>

                <div class="mb-6 mt-2">
                    <h3 class="text-lg font-extrabold text-gray-900">Premium Plan</h3>
                    <div class="flex items-baseline gap-1 mt-2">
                        <span class="text-4xl font-extrabold text-gray-900">Rp 50.000</span>
                        <span class="text-sm text-gray-400 font-medium">/bulan</span>
                    </div>
                    <p class="mt-3 text-sm text-gray-400 font-medium">Akses penuh ke semua fitur eksklusif.</p>
                </div>

                <ul class="space-y-3 mb-8">
                    @foreach([
                        'Tanya Arsitek (Quick Ask)',
                        'Lihat profil & portfolio arsitek',
                        'Follow arsitek favorit',
                        'Chat langsung dengan arsitek',
                        'Booking & konsultasi privat',
                        'Beli paket desain',
                        'Prioritas respons arsitek',
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
                                    Upgrade ke Premium — Rp 50.000/bln
                                </button>
                            </form>
                        @else
                            <form action="{{ route('upgrade.process') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full rounded-2xl bg-gray-900 px-6 py-3.5 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] shadow-lg shadow-gray-900/20">
                                    Upgrade ke Premium — Rp 50.000/bln
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

        {{-- Features Detail --}}
        <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
            <h2 class="text-lg font-extrabold text-gray-900 mb-8 text-center">Apa yang kamu dapatkan?</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <h3 class="text-sm font-extrabold text-gray-900 mb-1">Chat Langsung</h3>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed">Bicara langsung dengan arsitek pilihanmu. Diskusikan ide, konsep, dan kebutuhan spesifik tanpa batasan.</p>
                </div>
                
                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <h3 class="text-sm font-extrabold text-gray-900 mb-1">Konsultasi Privat</h3>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed">Dapatkan konsultasi one-on-one yang lebih fokus dan personal untuk proyekmu.</p>
                </div>

                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    </div>
                    <h3 class="text-sm font-extrabold text-gray-900 mb-1">Paket Desain</h3>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed">Beli paket desain siap pakai — dari denah rumah hingga konsep interior lengkap.</p>
                </div>

                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-sm font-extrabold text-gray-900 mb-1">Prioritas Respons</h3>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed">Pertanyaanmu di Quick Ask akan ditandai prioritas dan mendapat respons lebih cepat.</p>
                </div>

                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="text-sm font-extrabold text-gray-900 mb-1">Booking Arsitek</h3>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed">Pilih langsung arsitek yang kamu suka dan lock waktu konsultasi khusus untukmu.</p>
                </div>

                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-5 hover:bg-gray-100/80 transition group">
                    <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white shrink-0 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-sm font-extrabold text-gray-900 mb-1">Riwayat Proyek</h3>
                    <p class="text-xs text-gray-400 font-medium leading-relaxed">Track semua proyek, pembayaran, dan status desain dalam satu dashboard.</p>
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
