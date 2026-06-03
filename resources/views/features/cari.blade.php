@extends('layouts.landing')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 min-h-screen" x-data="{ 
    budget: '{{ request('budget') }}' 
}">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 mb-4">Temukan Arsitek Ideal Anda</h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto">Saring berdasarkan budget, tipe proyek, lokasi, dan style desain untuk mewujudkan visi bangunan Anda.</p>
    </div>

    <!-- Filters Bar (Premium Glassmorphism style) -->
    <form method="GET" action="{{ route('features.cari') }}" class="bg-white/70 backdrop-blur-md p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50 mb-12 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            
            <!-- Lokasi -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Lokasi</label>
                <select name="location" class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-gray-700 focus:ring-2 focus:ring-black transition shadow-sm cursor-pointer appearance-none">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc }}" @selected(request('location') === $loc)>{{ $loc }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tipe Proyek -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tipe Proyek</label>
                <select name="project_type" class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-gray-700 focus:ring-2 focus:ring-black transition shadow-sm cursor-pointer appearance-none">
                    <option value="">Semua Tipe</option>
                    @foreach($projectTypes as $type)
                        <option value="{{ $type }}" @selected(request('project_type') === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Style -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Gaya Desain</label>
                <select name="style" class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-gray-700 focus:ring-2 focus:ring-black transition shadow-sm cursor-pointer appearance-none">
                    <option value="">Semua Gaya</option>
                    @foreach($styles as $s)
                        <option value="{{ $s }}" @selected(request('style') === $s)>{{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Budget -->
            <div class="lg:col-span-2 relative">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Anggaran Jasa (Per m²)</label>
                <div class="flex gap-2">
                    <select name="budget" x-model="budget" class="flex-1 bg-gray-50 border-0 rounded-2xl py-3 px-4 text-gray-700 focus:ring-2 focus:ring-black transition shadow-sm cursor-pointer appearance-none">
                        <option value="">Semua Harga</option>
                        <option value="under_100">&lt; Rp 100rb</option>
                        <option value="100_300">Rp 100rb - 300rb</option>
                        <option value="above_300">&gt; Rp 300rb</option>
                        <option value="custom">Tentukan Sendiri...</option>
                    </select>
                    
                    <button type="submit" class="bg-black text-white px-8 py-3 rounded-2xl font-semibold hover:bg-gray-800 transition shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span class="hidden md:inline">Cari</span>
                    </button>
                    
                    <a href="{{ route('features.cari') }}" class="bg-gray-200 text-gray-600 px-4 py-3 rounded-2xl font-semibold hover:bg-gray-300 transition flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </a>
                </div>
                
                <!-- Custom Budget Dropdown -->
                <div x-show="budget === 'custom'" x-collapse x-cloak class="absolute top-full left-0 right-0 mt-3 bg-white p-4 rounded-2xl shadow-xl border border-gray-100 z-50">
                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <label class="block text-[10px] text-gray-400 uppercase tracking-widest mb-1">Min (Rp)</label>
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full bg-gray-50 border-0 rounded-xl py-2 px-3 text-sm focus:ring-2 focus:ring-black">
                        </div>
                        <div class="text-gray-300 font-bold mt-4">-</div>
                        <div class="flex-1">
                            <label class="block text-[10px] text-gray-400 uppercase tracking-widest mb-1">Max (Rp)</label>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Bebas" class="w-full bg-gray-50 border-0 rounded-xl py-2 px-3 text-sm focus:ring-2 focus:ring-black">
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </form>

    <!-- Error state from redirect -->
    @if(session('error'))
        <div class="mb-8 bg-red-50 border border-red-100 rounded-2xl p-4 text-red-600 flex items-center justify-center font-medium shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- List Arsitek -->
    @php
        $portfolioPlaceholder = asset('images/portofolios/portofolio_placeholder.png');
    @endphp
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($architects as $architect)
            @php
                $id = data_get($architect, 'id');
                $name = data_get($architect, 'name', 'Arsitek');
                $profile = data_get($architect, 'architectProfile');
                $specialization = data_get($architect, 'architectProfile.specialization', 'Spesialisasi belum diisi');
                
                // Fallback for missing specialization from relations
                if (isset($architect->architectProfile->specializations) && $architect->architectProfile->specializations->count() > 0) {
                    $specialization = $architect->architectProfile->specializations->pluck('name')->join(', ');
                }
                
                $rating = (float) data_get($architect, 'reviews_avg_rating', data_get($architect, 'architectProfile.rating', 0));
                $pricePerM2 = (float) data_get($architect, 'architectProfile.price_per_m2', 0);
                $location = data_get($architect, 'architectProfile.location', '-');
                $style = data_get($architect, 'architectProfile.style', '-');
                $portfolio = data_get($architect, 'architectProfile.portfolio_images', []);
                $firstPortfolio = is_array($portfolio) && count($portfolio) > 0 ? $portfolio[0] : null;
                
                // Construct storage url if path exists
                $thumb = filled($firstPortfolio) ? (str_starts_with($firstPortfolio, 'http') ? $firstPortfolio : '/storage/'.$firstPortfolio) : $portfolioPlaceholder;
                $profileImg = $architect->profile_image_url;
            @endphp

            <div class="group relative bg-white rounded-[2rem] p-3 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-out flex flex-col">
                <!-- Profile Image Cover -->
                <div class="h-[280px] rounded-[1.5rem] bg-gray-100 overflow-hidden relative">
                    <img src="{{ $profileImg }}" alt="Profil {{ $name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out" />
                </div>

                <div class="pt-5 pb-3 px-2 flex-col flex-1 flex justify-between">
                    <div>
                        <!-- Head -->
                        <div class="flex items-center gap-2 mb-2">
                            <h3 class="text-xl font-extrabold text-gray-900 leading-tight">{{ $name }}</h3>
                            <!-- Verified Badge -->
                            <svg class="w-5 h-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
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
                        <a href="{{ route('features.profil', $id) }}" class="inline-flex items-center gap-1 bg-gray-100 text-gray-900 font-bold text-sm px-5 py-2.5 rounded-full hover:bg-gray-200 transition-colors">
                            Lihat <span class="text-gray-500 font-normal ml-0.5">+</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-24 h-24 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pencarian Tidak Ditemukan</h3>
                <p class="text-gray-500 max-w-md mx-auto">Kami tidak dapat menemukan arsitek yang cocok dengan saringan Anda. Coba ubah atau atur ulang opsi pencarian Anda.</p>
                <a href="{{ route('features.cari') }}" class="inline-block mt-6 px-6 py-2.5 rounded-full bg-gray-100 text-gray-800 font-semibold hover:bg-gray-200 transition">Atur Ulang Filter</a>
            </div>
        @endforelse
    </div>
</div>
@endsection