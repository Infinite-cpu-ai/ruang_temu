@extends('layouts.landing')

@section('content')
@php
    $profile = $architect->architectProfile;
    $specialization = $profile?->specialization ?: 'Arsitektur & Interior';
    $style = $profile?->style ?: 'Modern Minimalist';
    $location = $profile?->location ?: 'Indonesia';
    $rating = (float) ($ratingAverage ?? $profile?->rating ?? 0);
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

                @auth
                    @if(auth()->user()->role === 'user')
                        @if($isFollowing)
                            <form action="{{ route('features.unfollow', $architect->id) }}" method="POST" class="w-56 max-w-full">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-3 rounded-full bg-gray-200 text-gray-900 px-10 py-2.5 text-[11px] font-medium shadow-sm hover:bg-gray-300 transition">
                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-gray-900/10">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                    </span>
                                    Sudah Diikuti
                                </button>
                            </form>
                        @else
                            <form action="{{ route('features.follow', $architect->id) }}" method="POST" class="w-56 max-w-full">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-3 rounded-full bg-white text-black px-10 py-2.5 text-[11px] font-medium shadow-sm border border-gray-200 hover:bg-gray-50 transition">
                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-black/10">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </span>
                                    Ikuti
                                </button>
                            </form>
                        @endif
                    @endif
                @endauth
            </div>
        </div>

        <div class="mt-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
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
                    {{ number_format($rating, 1) }}
                    <span class="text-base text-gray-300 font-semibold">/ 5.0</span>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white px-6 py-6 text-center shadow-sm">
                <div class="text-[11px] font-medium text-gray-400 tracking-wide">Lokasi</div>
                <div class="mt-2 text-xl font-extrabold text-gray-900">
                    {{ $location }}
                </div>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white px-6 py-6 text-center shadow-sm">
                <div class="text-[11px] font-medium text-gray-400 tracking-wide">Pengikut</div>
                <div class="mt-2 text-2xl font-extrabold text-gray-900">
                    {{ $followersCount }}
                    <span class="text-base text-gray-300 font-semibold">pengguna</span>
                </div>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900">Review</h2>
                        <p class="mt-2 text-sm text-gray-500">
                            Review asli dari client untuk arsitek ini.
                        </p>
                    </div>
                    <div class="shrink-0 rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-[11px] font-semibold text-gray-700">
                        {{ $reviews->count() }} review
                    </div>
                </div>

                @if (session('success'))
                    <div class="mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mt-6 space-y-4">
                    @forelse($reviews as $review)
                        <div class="rounded-2xl border border-gray-100 bg-gray-50/60 px-5 py-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="font-semibold text-gray-900 text-sm">{{ $review->client?->name ?? 'Client' }}</div>
                                <div class="flex items-center gap-1 text-gray-900">
                                    @for($s = 1; $s <= 5; $s++)
                                        <svg class="w-4 h-4 {{ $s <= $review->rating ? 'text-gray-900' : 'text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.173c.969 0 1.371 1.24.588 1.81l-3.377 2.454a1 1 0 00-.364 1.118l1.286 3.967c.3.921-.755 1.688-1.54 1.118l-3.377-2.454a1 1 0 00-1.176 0l-3.377 2.454c-.784.57-1.838-.197-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2 9.394c-.783-.57-.38-1.81.588-1.81h4.173a1 1 0 00.95-.69l1.286-3.967z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">{{ $review->comment }}</p>

                            @auth
                                @if(auth()->user()->role === 'user' && $review->client_id === auth()->id())
                                    <form action="{{ route('features.reviews.update', ['architect' => $architect->id, 'review' => $review->id]) }}" method="POST" class="mt-4 space-y-3 border-t border-gray-200 pt-4">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="project_id" value="{{ $review->project_id }}">

                                        <div>
                                            <label for="rating-edit-{{ $review->id }}" class="block text-xs font-semibold text-gray-600">Edit Rating</label>
                                            <select id="rating-edit-{{ $review->id }}" name="rating" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                                                @for ($r = 1; $r <= 5; $r++)
                                                    <option value="{{ $r }}" @selected(old('rating', $review->rating) == $r)>{{ $r }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div>
                                            <label for="comment-edit-{{ $review->id }}" class="block text-xs font-semibold text-gray-600">Edit Komentar</label>
                                            <textarea id="comment-edit-{{ $review->id }}" name="comment" rows="3" class="mt-1 w-full rounded-lg border-gray-300 text-sm">{{ old('comment', $review->comment) }}</textarea>
                                        </div>

                                        <button type="submit" class="rounded-full bg-gray-900 px-4 py-2 text-xs font-semibold text-white hover:bg-gray-800 transition">
                                            Simpan Perubahan
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-200 p-6 text-sm text-gray-500">
                            Belum ada review untuk arsitek ini.
                        </div>
                    @endforelse
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
                        <span class="font-semibold text-gray-900">{{ data_get($profile, 'timeline', '7-14 hari') }}</span>
                    </div>
                </div>

                @auth
                    @if(auth()->user()->role === 'user')
                        <div class="mt-6 border-t border-gray-100 pt-6">
                            <h3 class="text-base font-bold text-gray-900">Tulis Review</h3>
                            @if($eligibleProjects->isEmpty())
                                <p class="mt-2 text-sm text-gray-500">
                                    Kamu belum punya proyek yang statusnya sudah selesai dan sudah dibayar dengan arsitek ini.
                                </p>
                            @else
                                <form action="{{ route('features.reviews.store', $architect->id) }}" method="POST" class="mt-3 space-y-3">
                                    @csrf
                                    <div>
                                        <label for="project_id" class="block text-xs font-semibold text-gray-600">Pilih Proyek Selesai</label>
                                        <select id="project_id" name="project_id" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                                            @foreach($eligibleProjects as $project)
                                                <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>
                                                    #{{ $project->id }} - {{ $project->property_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="rating" class="block text-xs font-semibold text-gray-600">Rating</label>
                                        <select id="rating" name="rating" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                                            @for ($r = 5; $r >= 1; $r--)
                                                <option value="{{ $r }}" @selected(old('rating', 5) == $r)>{{ $r }}</option>
                                            @endfor
                                        </select>
                                        @error('rating')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="comment" class="block text-xs font-semibold text-gray-600">Komentar</label>
                                        <textarea id="comment" name="comment" rows="3" class="mt-1 w-full rounded-lg border-gray-300 text-sm">{{ old('comment') }}</textarea>
                                        @error('comment')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="submit" class="w-full rounded-full bg-black text-white py-2.5 text-sm font-semibold hover:bg-gray-900 transition">
                                        Tambah Review
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                @else
                    <div class="mt-6 border-t border-gray-100 pt-6">
                        <p class="text-sm text-gray-500">
                            Login sebagai client untuk menambahkan review.
                        </p>
                    </div>
                @endauth
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