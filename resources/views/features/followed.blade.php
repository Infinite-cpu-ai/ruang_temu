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

                <div class="group relative bg-white rounded-[2rem] p-3 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-out flex flex-col">
                    <!-- Profile Image Cover -->
                    <div class="h-[280px] rounded-[1.5rem] bg-gray-100 overflow-hidden relative">
                        <img src="{{ $architect->profile_image_url }}" alt="Profil {{ $architect->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out" />
                    </div>

                    <div class="pt-5 pb-3 px-2 flex-col flex-1 flex justify-between">
                        <div>
                            <!-- Head -->
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-xl font-extrabold text-gray-900 leading-tight">{{ $architect->name }}</h3>
                                    <!-- Verified Badge -->
                                    <svg class="w-5 h-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                
                                <!-- Unfollow Action (only in followed page) -->
                                <form action="{{ route('features.unfollow', $architect->id) }}" method="POST" class="flex-shrink-0 relative z-10">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition p-1" title="Berhenti mengikuti">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Specialization -->
                            <p class="text-[13px] font-medium text-gray-500 leading-relaxed line-clamp-2">
                                {{ $specialization }}
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="mt-6 flex items-center justify-between">
                            <!-- Stats -->
                            <div class="flex items-center gap-4 text-[13px] font-bold text-gray-700">
                                <!-- Rating -->
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span>{{ number_format($rating, 1) }}</span>
                                </div>
                                <!-- Portfolio Count -->
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>{{ is_array($portfolio) ? count($portfolio) : 0 }}</span>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <a href="{{ route('features.profil', $architect->id) }}" class="inline-flex items-center gap-1 bg-gray-100 text-gray-900 font-bold text-sm px-5 py-2.5 rounded-full hover:bg-gray-200 transition-colors">
                                Lihat <span class="text-gray-500 font-normal ml-0.5">+</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
