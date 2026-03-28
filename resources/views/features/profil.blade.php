@extends('layouts.landing')

@section('content')
@php
    $profile = $architect->architectProfile;
    $specialization = $profile?->specialization ?: 'Arsitektur & Interior';
    $style = $profile?->style ?: 'Modern Minimalist';
    $location = $profile?->location ?: 'Indonesia';
    $rating = (float) ($profile?->rating ?? 0);
    $pricePerM2 = (float) ($profile?->price_per_m2 ?? 0);
    $portfolio = is_array($profile?->portfolio_images) ? $profile->portfolio_images : [];
    $placeholderProfile = asset('images/profiles/profile_placeholder.png');
    $placeholderPortfolio = asset('images/portofolios/portofolio_placeholder.png');
    $profilePhotoUrl = filled(data_get($profile, 'profile_image'))
        ? data_get($profile, 'profile_image')
        : $placeholderProfile;
    $portfolioItems = collect($portfolio)->filter(fn ($url) => filled($url))->values();
@endphp

<section class="pt-10 pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center">
            <div class="flex items-center justify-center gap-10 pb-6">
                <div class="w-14 h-14 rounded-full border border-gray-200 bg-gray-50 overflow-hidden shrink-0" aria-hidden="true"></div>
                <div class="w-20 h-20 rounded-full border-2 border-gray-200 bg-white shadow-lg overflow-hidden shrink-0 ring-4 ring-gray-50">
                    <img
                        src="{{ $profilePhotoUrl }}"
                        alt="{{ $architect->name }}"
                        class="w-full h-full object-cover"
                    />
                </div>
                <div class="w-14 h-14 rounded-full border border-gray-200 bg-gray-50 overflow-hidden shrink-0" aria-hidden="true"></div>
            </div>

            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900">
                {{ $architect->name }}
            </h1>
            <p class="mt-4 text-xs sm:text-sm text-gray-300 max-w-2xl mx-auto">
                Portofolio, spesialisasi, harga per m2, dan rating arsitek.
            </p>

            <div class="mt-10 flex flex-col items-center gap-3">
                <a
                    href="{{ route('checkout.index', $architect->id) }}"
                    class="inline-flex items-center justify-center gap-3 rounded-full bg-black text-white px-12 py-3 text-sm font-medium shadow-sm hover:bg-gray-900 transition w-72 max-w-full"
                >
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-white/10">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2L11 13"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2l-7 20-4-9-9-4 20-7z"></path>
                        </svg>
                    </span>
                    Pesan Desain
                </a>

                <a
                    href="{{ route('chat.index', ['architect_id' => $architect->id]) }}"
                    class="inline-flex items-center justify-center gap-3 rounded-full bg-black text-white/90 px-10 py-2.5 text-[11px] font-medium shadow-sm hover:bg-gray-900 transition w-56 max-w-full"
                >
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-white/10">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12c0 4.418-4.03 8-9 8a9.9 9.9 0 01-4-.8L3 20l1.2-3A7.6 7.6 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </span>
                    Mulai Konsultasi
                </a>
            </div>
        </div>

        <div class="mt-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="rounded-2xl border border-gray-100 bg-white px-6 py-6 text-center shadow-sm">
                <div class="text-[11px] font-medium text-gray-400 tracking-wide">Harga per m²</div>
                <div class="mt-2 text-2xl font-extrabold text-gray-900">
                    Rp {{ number_format($pricePerM2, 0, ',', '.') }}
                </div>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white px-6 py-6 text-center shadow-sm">
                <div class="text-[11px] font-medium text-gray-400 tracking-wide">Spesialisasi</div>
                <div class="mt-2 text-xl font-extrabold text-gray-900">
                    {{ $specialization }}
                </div>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white px-6 py-6 text-center shadow-sm">
                <div class="text-[11px] font-medium text-gray-400 tracking-wide">Rating</div>
                <div class="mt-2 text-2xl font-extrabold text-gray-900">
                    {{ $rating > 0 ? number_format($rating, 1) : 'Baru' }}
                    @if($rating > 0)
                        <span class="text-base text-gray-300 font-semibold">/ 5.0</span>
                    @endif
                </div>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white px-6 py-6 text-center shadow-sm">
                <div class="text-[11px] font-medium text-gray-400 tracking-wide">Lokasi</div>
                <div class="mt-2 text-xl font-extrabold text-gray-900">
                    {{ $location }}
                </div>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900">Review</h2>
                        <p class="mt-2 text-sm text-gray-500">
                            Rating & review pengguna (dummy) untuk preview tampilan.
                        </p>
                    </div>
                    <div class="shrink-0 rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-[11px] font-semibold text-gray-700">
                        Dummy
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    @php
                        $dummyReviews = [
                            ['name' => 'Dimas', 'stars' => 5, 'text' => 'Komunikasi enak, hasil desain rapi dan detail.'],
                            ['name' => 'Nadia', 'stars' => 4, 'text' => 'Revisi cepat, layout ruang jadi lebih fungsional.'],
                            ['name' => 'Raka', 'stars' => 5, 'text' => 'Style sesuai brief, timeline tepat. Mantap.'],
                        ];
                    @endphp

                    @foreach($dummyReviews as $review)
                        <div class="rounded-2xl border border-gray-100 bg-gray-50/60 px-5 py-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="font-semibold text-gray-900 text-sm">{{ $review['name'] }}</div>
                                <div class="flex items-center gap-1 text-gray-900">
                                    @for($s = 1; $s <= 5; $s++)
                                        <svg class="w-4 h-4 {{ $s <= $review['stars'] ? 'text-gray-900' : 'text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.173c.969 0 1.371 1.24.588 1.81l-3.377 2.454a1 1 0 00-.364 1.118l1.286 3.967c.3.921-.755 1.688-1.54 1.118l-3.377-2.454a1 1 0 00-1.176 0l-3.377 2.454c-.784.57-1.838-.197-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2 9.394c-.783-.57-.38-1.81.588-1.81h4.173a1 1 0 00.95-.69l1.286-3.967z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">{{ $review['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-extrabold text-gray-900">Ringkasan</h2>
                <div class="mt-4 space-y-3 text-sm text-gray-600">
                    <div class="flex items-center justify-between">
                        <span>Spesialisasi</span>
                        <span class="font-semibold text-gray-900">{{ $specialization }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Gaya</span>
                        <span class="font-semibold text-gray-900">{{ $style }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Timeline</span>
                        <span class="font-semibold text-gray-900">7-14 hari</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Portofolio</h2>
                <p class="mt-2 text-sm text-gray-500">Beberapa karya terbaru untuk referensi.</p>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @if ($portfolioItems->isEmpty())
                    @foreach (range(1, 6) as $_)
                        <div class="aspect-[4/3] rounded-2xl border border-gray-100 bg-gray-50 overflow-hidden shadow-sm">
                            <img
                                src="{{ $placeholderPortfolio }}"
                                alt="Portofolio placeholder"
                                class="w-full h-full object-cover"
                            />
                        </div>
                    @endforeach
                @else
                    @foreach ($portfolioItems as $image)
                        <div class="aspect-[4/3] rounded-2xl border border-gray-100 bg-gray-50 overflow-hidden shadow-sm">
                            <img src="{{ $image }}" alt="Portofolio" class="w-full h-full object-cover" />
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
@endsection