@extends('layouts.landing')

@section('content')
<div class="relative min-h-screen bg-[#FAFAFA] overflow-x-hidden">
    {{-- Background blobs --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-gray-200/50 to-transparent blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-gradient-to-tl from-gray-200/50 to-transparent blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-3xl mx-auto px-6 py-14 pt-28">

        {{-- Header --}}
        <div class="mb-10">
            <p class="text-sm font-semibold text-gray-400 tracking-widest uppercase mb-2">Arsitek</p>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Pengaturan Profil</h1>
            <p class="mt-2 text-base text-gray-500 font-medium">Lengkapi profilmu agar mudah ditemukan oleh klien.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-100 px-5 py-4 text-emerald-700 font-semibold text-sm shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('architect.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Foto & Info Akun --}}
            <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <h2 class="text-base font-extrabold text-gray-900 mb-5">Foto & Info Akun</h2>

                {{-- Avatar --}}
                <div class="flex items-center gap-5 mb-6" x-data="{ preview: null }">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-white shadow-md bg-gray-200">
                            <img id="avatar-preview"
                                 src="{{ $profile->profile_image ? Storage::url($profile->profile_image) : asset('images/profiles/profile_placeholder.png') }}"
                                 class="w-full h-full object-cover" />
                        </div>
                    </div>
                    <div>
                        <input type="file" name="profile_image" id="profile_image" class="hidden" accept="image/*"
                               onchange="previewAvatar(this)" />
                        <button type="button" onclick="document.getElementById('profile_image').click()"
                                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Ganti Foto
                        </button>
                        <p class="mt-1 text-[11px] text-gray-400 font-medium">JPG, PNG, max 2MB</p>
                        @error('profile_image')<p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Email (read-only) --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Email Akun</label>
                    <div class="flex items-center gap-3 w-full bg-gray-100 border-0 rounded-2xl py-3 px-4 text-sm text-gray-500 font-medium">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                        {{ $user->email }}
                        <span class="ml-auto text-[10px] font-bold text-gray-400 bg-gray-200 rounded-full px-2 py-0.5">Tidak bisa diubah</span>
                    </div>
                </div>
            </div>

            {{-- Spesialisasi --}}
            <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <h2 class="text-base font-extrabold text-gray-900 mb-1">Spesialisasi</h2>
                <p class="text-sm text-gray-400 font-medium mb-5">Pilih satu atau lebih bidang keahlianmu.</p>

                <div class="flex flex-wrap gap-2">
                    @foreach($specializations as $spec)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="specializations[]" value="{{ $spec->id }}"
                                   {{ in_array($spec->id, $selectedSpecializations) ? 'checked' : '' }}
                                   class="hidden peer" />
                            <span class="inline-flex items-center px-4 py-2 rounded-full border border-gray-200 bg-gray-50 text-xs font-bold text-gray-600 transition
                                         peer-checked:bg-gray-900 peer-checked:text-white peer-checked:border-gray-900 hover:border-gray-400">
                                {{ $spec->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('specializations')<p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>@enderror
            </div>

            {{-- Detail Profil --}}
            <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <h2 class="text-base font-extrabold text-gray-900 mb-5">Detail Profil Publik</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="price_per_m2" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Harga per m² (Rp)</label>
                        <input type="number" name="price_per_m2" id="price_per_m2"
                               value="{{ old('price_per_m2', $profile->price_per_m2) }}"
                               placeholder="Contoh: 150000"
                               class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm" />
                    </div>

                    <div>
                        <label for="location" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Lokasi / Kota</label>
                        <input type="text" name="location" id="location"
                               value="{{ old('location', $profile->location) }}"
                               placeholder="Contoh: Jakarta Selatan"
                               class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm" />
                    </div>

                    <div>
                        <label for="style" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Gaya Desain</label>
                        <input type="text" name="style" id="style"
                               value="{{ old('style', $profile->style) }}"
                               placeholder="Contoh: Modern Tropis"
                               class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm" />
                    </div>

                    <div>
                        <label for="timeline" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Estimasi Timeline</label>
                        <input type="text" name="timeline" id="timeline"
                               value="{{ old('timeline', $profile->timeline) }}"
                               placeholder="Contoh: 1-3 Bulan"
                               class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm" />
                    </div>
                </div>
            </div>

            {{-- Save --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-2xl bg-gray-900 px-8 py-3.5 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] shadow-sm">
                    Simpan Perubahan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </div>
        </form>
        {{-- Portfolio Showcase --}}
        <div class="mt-6 rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-base font-extrabold text-gray-900">Portfolio Showcase</h2>
                    <p class="text-sm text-gray-400 font-medium mt-1">Portofolio yang ditampilkan di profil publikmu.</p>
                </div>
                <a href="{{ route('architect.portfolios.create') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-gray-900 px-4 py-2 text-xs font-bold text-white hover:bg-black transition active:scale-[0.97] shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah
                </a>
            </div>

            @if($portfolios->isEmpty())
                <div class="py-8 text-center">
                    <div class="w-14 h-14 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-3">
                        <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-400 font-medium">Belum ada portofolio. Tampilkan karya terbaikmu!</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($portfolios as $portfolio)
                    <div class="group rounded-2xl border border-gray-100 bg-gray-50/80 overflow-hidden hover:shadow-md transition">
                        <div class="h-32 bg-gray-200 overflow-hidden">
                            <img src="{{ Storage::url($portfolio->image) }}"
                                 alt="{{ $portfolio->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                 onerror="this.src='{{ asset('images/portofolios/portofolio_placeholder.png') }}'" />
                        </div>
                        <div class="p-4">
                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $portfolio->title }}</h4>
                            @if($portfolio->description)
                                <p class="text-xs text-gray-400 font-medium mt-1 line-clamp-1">{{ $portfolio->description }}</p>
                            @endif
                            <div class="flex items-center gap-2 mt-3">
                                <a href="{{ route('architect.portfolios.edit', $portfolio) }}"
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3 py-1.5 text-xs font-bold text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('architect.portfolios.destroy', $portfolio) }}" method="POST"
                                      onsubmit="return confirm('Hapus portofolio ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-red-100 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-500 hover:bg-red-100 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('architect.portfolios.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-900 transition">
                        Kelola semua portofolio →
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => { document.getElementById('avatar-preview').src = e.target.result; };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
