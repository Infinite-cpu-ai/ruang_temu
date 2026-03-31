@extends('layouts.landing')

@section('content')

<div class="max-w-3xl mx-auto py-16 px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="text-center mb-14">
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900">Estimasi Biaya</h1>
        <p class="text-gray-400 text-sm mt-3 max-w-md mx-auto">
            Perkiraan biaya jasa desain arsitektur sebelum kamu memulai proyek.
        </p>
    </div>

    {{-- Tipe Proyek --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-12">

        <div class="type-card">
            <div class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-600 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-1">Rumah Hunian</h3>
            <p class="text-gray-400 text-sm leading-relaxed mb-4">
                Fokus pada kenyamanan keluarga, sirkulasi udara dan cahaya, serta zonasi privat dan publik.
            </p>
            <div class="pt-4 border-t border-gray-100">
                <p class="text-sm font-semibold text-gray-700">Rp 100.000 – 250.000 / m²</p>
            </div>
        </div>

        <div class="type-card">
            <div class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-600 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-1">Komersial / Ruang Usaha</h3>
            <p class="text-gray-400 text-sm leading-relaxed mb-4">
                Fokus pada alur pengunjung, efisiensi ruang, utilitas ME, dan identitas branding pada fasad.
            </p>
            <div class="pt-4 border-t border-gray-100">
                <p class="text-sm font-semibold text-gray-700">Rp 200.000 – 500.000 / m²</p>
            </div>
        </div>

    </div>

    {{-- Kalkulator --}}
    <div class="border border-gray-100 rounded-2xl p-8" style="box-shadow: 0px 4px 10px rgba(0,0,0,0.06);">

        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Kalkulator Cepat</h2>
            <p class="text-gray-400 text-sm mt-1">Masukkan angka untuk melihat estimasi biaya</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 max-w-xl mx-auto">

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    Harga Jasa / m²
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm pointer-events-none">Rp</span>
                    <input type="number" id="calc-price"
                        class="calc-input pl-10"
                        value="150000" step="10000">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    Luas Bangunan
                </label>
                <div class="relative">
                    <input type="number" id="calc-area"
                        class="calc-input pr-12"
                        value="100" min="10">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-400 text-sm pointer-events-none">m²</span>
                </div>
            </div>

        </div>

        {{-- Result --}}
        <div class="mt-8 max-w-xl mx-auto text-center bg-gray-900 rounded-2xl py-8 px-6 relative overflow-hidden">
            {{-- subtle glow --}}
            <div class="absolute inset-0 pointer-events-none opacity-10">
                <div class="absolute -top-8 -right-8 w-36 h-36 bg-white rounded-full blur-3xl"></div>
                <div class="absolute -bottom-8 -left-8 w-36 h-36 bg-white rounded-full blur-3xl"></div>
            </div>

            <p class="text-xs text-gray-500 font-medium tracking-widest uppercase relative z-10">Estimasi Total</p>
            <div class="flex items-baseline justify-center mt-3 gap-2 relative z-10">
                <span class="text-xl text-gray-400 font-medium">Rp</span>
                <h3 class="text-5xl font-extrabold text-white tracking-tight" id="calc-total">15.000.000</h3>
            </div>
            <p class="text-xs text-gray-600 mt-4 relative z-10">*Estimasi kasar, tidak mengikat</p>
        </div>

        {{-- CTA --}}
        <div class="mt-8 text-center">
            <a id="cta-cari-arsitek" href="{{ route('features.cari') }}"
               class="inline-flex items-center justify-center gap-3 rounded-full bg-black text-white px-10 py-3 text-sm font-medium shadow-sm hover:bg-gray-900 transition"
            >
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-white/10">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2L11 13"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                </span>
                Cari Arsitek Sekarang
            </a>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const priceInput = document.getElementById('calc-price');
        const areaInput  = document.getElementById('calc-area');
        const totalEl    = document.getElementById('calc-total');
        const ctaBtn     = document.getElementById('cta-cari-arsitek');
        const baseUrl    = "{{ route('features.cari') }}";

        function calculate() {
            const price = parseFloat(priceInput.value) || 0;
            const area  = parseFloat(areaInput.value)  || 0;
            totalEl.textContent = new Intl.NumberFormat('id-ID').format(price * area);
            
            if(price > 0) {
                ctaBtn.href = `${baseUrl}?budget=custom&max_price=${price}`;
            } else {
                ctaBtn.href = baseUrl;
            }
        }

        priceInput.addEventListener('input', calculate);
        areaInput.addEventListener('input', calculate);
        calculate();
    });
</script>
@endsection