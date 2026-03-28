@extends('layouts.landing')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Cari Arsitek</h1>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('features.cari') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <select name="budget" class="border-gray-200 rounded-xl shadow-sm w-full bg-white text-gray-700 py-2.5 px-3 focus:ring-0 focus:border-gray-300">
                <option value="">Budget (Semua)</option>
                <option value="under_100" @selected(request('budget') === 'under_100')>&lt; Rp 100rb / m²</option>
                <option value="100_300" @selected(request('budget') === '100_300')>Rp 100rb - 300rb / m²</option>
                <option value="above_300" @selected(request('budget') === 'above_300')>&gt; Rp 300rb / m²</option>
            </select>

            <select name="project_type" class="border-gray-200 rounded-xl shadow-sm w-full bg-white text-gray-700 py-2.5 px-3 focus:ring-0 focus:border-gray-300">
                <option value="">Tipe Proyek (Semua)</option>
                <option value="Hunian" @selected(request('project_type') === 'Hunian')>Hunian</option>
                <option value="Komersial" @selected(request('project_type') === 'Komersial')>Restaurant / Komersial</option>
            </select>

            <select name="location" class="border-gray-200 rounded-xl shadow-sm w-full bg-white text-gray-700 py-2.5 px-3 focus:ring-0 focus:border-gray-300">
                <option value="">Lokasi (Semua)</option>
                @php
                    $locations = collect($architects)
                        ->map(fn ($a) => data_get($a, 'architectProfile.location'))
                        ->filter()
                        ->unique()
                        ->sort()
                        ->values();
                @endphp
                @foreach($locations as $loc)
                    <option value="{{ $loc }}" @selected(request('location') === $loc)>{{ $loc }}</option>
                @endforeach
            </select>

            <select name="style" class="border-gray-200 rounded-xl shadow-sm w-full bg-white text-gray-700 py-2.5 px-3 focus:ring-0 focus:border-gray-300">
                <option value="">Style (Semua)</option>
                @php
                    $styles = collect($architects)
                        ->map(fn ($a) => data_get($a, 'architectProfile.style'))
                        ->filter()
                        ->unique()
                        ->sort()
                        ->values();
                @endphp
                @foreach($styles as $s)
                    <option value="{{ $s }}" @selected(request('style') === $s)>{{ $s }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button class="flex-1 rounded-full bg-black text-white px-4 py-2.5 text-sm font-medium hover:bg-gray-900 transition">
                    Terapkan
                </button>
                <a href="{{ route('features.cari') }}" class="rounded-full border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <!-- List Arsitek -->
    @php
        $portfolioPlaceholder = asset('images/portofolios/portofolio_placeholder.png');
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($architects as $architect)
            @php
                $id = data_get($architect, 'id');
                $name = data_get($architect, 'name', 'Arsitek');
                $profile = data_get($architect, 'architectProfile');
                $specialization = data_get($architect, 'architectProfile.specialization', 'Spesialisasi belum diisi');
                $rating = (float) data_get($architect, 'reviews_avg_rating', data_get($architect, 'architectProfile.rating', 0));
                $pricePerM2 = (float) data_get($architect, 'architectProfile.price_per_m2', 0);
                $location = data_get($architect, 'architectProfile.location', '-');
                $style = data_get($architect, 'architectProfile.style', '-');
                $portfolio = data_get($architect, 'architectProfile.portfolio_images', []);
                $firstPortfolio = is_array($portfolio) && count($portfolio) > 0 ? $portfolio[0] : null;
                $thumb = filled($firstPortfolio) ? $firstPortfolio : $portfolioPlaceholder;
            @endphp

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                <div class="h-48 bg-gray-100 overflow-hidden">
                    <img src="{{ $thumb }}" alt="Portofolio {{ $name }}" class="w-full h-full object-cover" />
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-extrabold text-gray-900 mb-1">{{ $name }}</h3>
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

                    <a href="{{ route('features.profil', $id) }}" class="block w-full text-center rounded-full bg-black text-white font-medium py-2.5 hover:bg-gray-900 transition">
                        Lihat Profil
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-gray-100 bg-white p-10 text-center text-gray-500">
                Tidak ada arsitek yang cocok dengan filter kamu.
            </div>
        @endforelse
    </div>
</div>
@endsection