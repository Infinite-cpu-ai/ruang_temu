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

        {{-- Danger Zone --}}
        <div class="mt-6 rounded-[2rem] border border-red-100 bg-red-50/50 p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
            <h2 class="text-base font-extrabold text-red-700 mb-1">Nonaktifkan Akun</h2>
            <p class="text-sm text-red-500/80 font-medium mb-5">Aksi ini menyembunyikan profil dari pencarian dan menonaktifkan login. Tidak bisa dikembalikan tanpa bantuan Admin.</p>
            <form action="{{ route('architect.profile.deactivate') }}" method="POST"
                  onsubmit="return confirm('Apakah Anda sangat yakin ingin menonaktifkan akun ini?')">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-2xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-bold text-red-600 hover:bg-red-100 transition active:scale-[0.97]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    Nonaktifkan Akun
                </button>
            </form>
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
