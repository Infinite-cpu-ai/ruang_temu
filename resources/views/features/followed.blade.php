@extends('layouts.landing')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <div class="mb-10">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Arsitek Saya</h1>
        <p class="mt-2 text-sm text-gray-400">Daftar arsitek yang kamu ikuti.</p>
    </div>

    {{-- State 1: Guest --}}
    @if($isGuest)
        <div class="rounded-2xl border border-gray-100 bg-white p-12 text-center shadow-sm">
            <div class="mx-auto mb-6 w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Kamu belum login</h2>
            <p class="text-sm text-gray-500 mb-8 max-w-md mx-auto">
                Kamu harus login atau register terlebih dahulu untuk melihat arsitek yang kamu ikuti.
            </p>
            <div class="flex justify-center gap-3">
                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center justify-center rounded-full bg-black text-white px-8 py-3 text-sm font-medium hover:bg-gray-900 transition"
                >
                    Login
                </a>
                <a
                    href="{{ route('register') }}"
                    class="inline-flex items-center justify-center rounded-full border border-gray-200 bg-white text-gray-900 px-8 py-3 text-sm font-medium hover:bg-gray-50 transition"
                >
                    Register
                </a>
            </div>
        </div>

    {{-- State 2: Logged in but no followed architects --}}
    @elseif($architects->isEmpty())
        <div class="rounded-2xl border border-gray-100 bg-white p-12 text-center shadow-sm">
            <div class="mx-auto mb-6 w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Belum ada arsitek yang diikuti</h2>
            <p class="text-sm text-gray-500 mb-8 max-w-md mx-auto">
                Kamu belum mengikuti arsitek manapun. Cari arsitek yang sesuai kebutuhanmu dan mulai ikuti mereka.
            </p>
            <a
                href="{{ route('features.cari') }}"
                class="inline-flex items-center justify-center gap-3 rounded-full bg-black text-white px-8 py-3 text-sm font-medium hover:bg-gray-900 transition"
            >
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-white/10">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                Cari Arsitek
            </a>
        </div>

    {{-- State 3: Has followed architects --}}
    @else
        @php
            $portfolioPlaceholder = asset('images/portofolios/portofolio_placeholder.png');
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($architects as $architect)
                @php
                    $profile = $architect->architectProfile;
                    $specialization = data_get($profile, 'specialization', 'Spesialisasi belum diisi');
                    $rating = (float) ($architect->reviews_avg_rating ?? data_get($profile, 'rating', 0));
                    $pricePerM2 = (float) data_get($profile, 'price_per_m2', 0);
                    $location = data_get($profile, 'location', '-');
                    $style = data_get($profile, 'style', '-');
                    $portfolio = data_get($profile, 'portfolio_images', []);
                    $firstPortfolio = is_array($portfolio) && count($portfolio) > 0 ? $portfolio[0] : null;
                    $thumb = filled($firstPortfolio) ? $firstPortfolio : $portfolioPlaceholder;
                @endphp

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="h-48 bg-gray-100 overflow-hidden">
                        <img src="{{ $thumb }}" alt="Portofolio {{ $architect->name }}" class="w-full h-full object-cover" />
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-extrabold text-gray-900 mb-1">{{ $architect->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4">
                            <span class="font-semibold text-gray-900">Spesialisasi:</span> {{ $specialization }}
                        </p>

                        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-600 mb-4">
                            <span class="rounded-full border border-gray-200 px-3 py-1 bg-white">{{ $location }}</span>
                            <span class="rounded-full border border-gray-200 px-3 py-1 bg-white">{{ $style }}</span>
                        </div>

                        <div class="flex justify-between items-center text-sm text-gray-500 mb-6">
                            <span class="flex items-center gap-1 font-semibold text-gray-900">
                                <span class="text-gray-900">★</span>
                                <span class="text-gray-700">{{ number_format($rating, 1) }} <span class="text-gray-300 font-semibold">/ 5.0</span></span>
                            </span>
                            <span class="font-semibold text-gray-900">
                                Rp {{ number_format($pricePerM2, 0, ',', '.') }} <span class="text-gray-400 font-medium">/ m²</span>
                            </span>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('features.profil', $architect->id) }}" class="flex-1 text-center rounded-full bg-black text-white font-medium py-2.5 text-sm hover:bg-gray-900 transition">
                                Lihat Profil
                            </a>
                            <form action="{{ route('features.unfollow', $architect->id) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                <button type="submit" class="rounded-full border border-gray-200 text-gray-600 font-medium py-2.5 px-4 text-sm hover:bg-gray-50 hover:text-red-600 hover:border-red-200 transition" title="Berhenti mengikuti">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
