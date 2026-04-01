@extends('layouts.landing')

@section('content')
<div class="relative min-h-screen bg-[#FAFAFA] overflow-x-hidden">
    <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-gray-200/50 to-transparent blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-gradient-to-tl from-gray-200/50 to-transparent blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-2xl mx-auto px-6 py-14 pt-28">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('architect.portfolios.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-gray-400 hover:text-gray-900 transition mb-5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Portofolio
            </a>
            <p class="text-sm font-semibold text-gray-400 tracking-widest uppercase mb-2">Arsitek</p>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Tambah Portofolio</h1>
            <p class="mt-2 text-base text-gray-500 font-medium">Tampilkan karya terbaikmu kepada calon klien.</p>
        </div>

        <form action="{{ route('architect.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Informasi Proyek --}}
            <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <h2 class="text-base font-extrabold text-gray-900 mb-5">Informasi Proyek</h2>

                <div class="space-y-5">
                    <div>
                        <label for="title" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Judul Proyek</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               placeholder="Contoh: Villa Tropis Modern — Bali"
                               class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm" />
                        @error('title')<p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Deskripsi <span class="normal-case text-gray-400 font-normal tracking-normal">(opsional)</span>
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  placeholder="Ceritakan konsep, tantangan, dan hasil yang dicapai..."
                                  class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm resize-none">{{ old('description') }}</textarea>
                        @error('description')<p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Upload Gambar --}}
            <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <h2 class="text-base font-extrabold text-gray-900 mb-1">Gambar Portofolio</h2>
                <p class="text-sm text-gray-400 font-medium mb-5">Maks. 5MB · JPG, PNG, WEBP</p>

                {{-- Drop Zone --}}
                <div id="upload-zone"
                     onclick="document.getElementById('image-input').click()"
                     class="relative border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50/80 p-8 flex flex-col items-center justify-center gap-3 cursor-pointer hover:border-gray-900 hover:bg-gray-50 transition-all duration-200 text-center">

                    {{-- Preview --}}
                    <div id="preview-wrap" class="hidden w-full rounded-xl overflow-hidden mb-2">
                        <img id="preview-img" src="" alt="Preview" class="w-full h-52 object-cover rounded-xl" />
                    </div>

                    {{-- Placeholder --}}
                    <div id="upload-placeholder" class="flex flex-col items-center gap-3">
                        <div id="upload-icon" class="w-14 h-14 rounded-2xl bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p id="upload-label" class="text-sm font-bold text-gray-700">Klik untuk pilih gambar</p>
                            <p id="upload-sub" class="text-xs text-gray-400 mt-0.5">atau seret & lepas di sini</p>
                        </div>
                    </div>
                </div>

                <input type="file" name="image" id="image-input" class="hidden" accept="image/*" required
                       onchange="handleFileChange(this)" />
                @error('image')<p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>@enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('architect.portfolios.index') }}"
                   class="rounded-2xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-2xl bg-gray-900 px-6 py-3 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] shadow-sm">
                    Upload Portofolio
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function handleFileChange(input) {
    const file = input.files[0];
    if (!file) return;
    const zone = document.getElementById('upload-zone');
    const placeholder = document.getElementById('upload-placeholder');
    const previewWrap = document.getElementById('preview-wrap');
    const previewImg = document.getElementById('preview-img');
    const label = document.getElementById('upload-label');
    const sub = document.getElementById('upload-sub');

    const reader = new FileReader();
    reader.onload = (e) => {
        previewImg.src = e.target.result;
        previewWrap.classList.remove('hidden');
        placeholder.classList.add('hidden');
        zone.classList.add('border-gray-900', 'border-solid');
        zone.classList.remove('border-dashed');
        label.textContent = file.name;
        sub.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB · Klik untuk ganti';
    };
    reader.readAsDataURL(file);
}

const zone = document.getElementById('upload-zone');
zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.classList.add('border-gray-900'); });
zone.addEventListener('dragleave', () => { zone.classList.remove('border-gray-900'); });
zone.addEventListener('drop', (e) => {
    e.preventDefault();
    const input = document.getElementById('image-input');
    input.files = e.dataTransfer.files;
    handleFileChange(input);
});
</script>
@endsection