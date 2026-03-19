@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900">Estimasi Biaya Desain</h1>
        <p class="text-gray-500 mt-2">Ketahui perkiraan biaya desain arsitektur sebelum memulai proyek impian Anda.</p>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 text-sm">
            <div class="p-6 bg-indigo-50/50 rounded-xl border border-indigo-100 hover:shadow-md transition">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4 text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <h3 class="font-bold text-indigo-900 text-xl mb-2">Rumah Hunian</h3>
                <p class="text-indigo-700/80 leading-relaxed">Estimasi desain rumah tinggal umumnya lebih terjangkau. Fokus pada kenyamanan keluarga, sirkulasi udara/cahaya, dan zonasi privat vs publik.</p>
                <div class="mt-5 pt-4 border-t border-indigo-200/50">
                    <p class="font-bold text-indigo-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Rataan: Rp 100k - 250k / m²
                    </p>
                </div>
            </div>
            <div class="p-6 bg-emerald-50/50 rounded-xl border border-emerald-100 hover:shadow-md transition">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-4 text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="font-bold text-emerald-900 text-xl mb-2">Komersial / Ruang Usaha</h3>
                <p class="text-emerald-700/80 leading-relaxed">Fokus pada alur pengunjung (flow), efisiensi ruang komersil, utilitas kompleks, ME (Mechanical Electrical) & identitas branding (Facade).</p>
                <div class="mt-5 pt-4 border-t border-emerald-200/50">
                    <p class="font-bold text-emerald-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Rataan: Rp 200k - 500k / m²
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-10">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Kalkulator Cepat</h2>
                <p class="text-gray-500 text-sm mt-1">Gunakan slider atau input angka untuk melihat estimasi</p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-6 justify-center max-w-2xl mx-auto">
                <div class="w-full md:w-1/2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Jasa Arsitek / m²</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" id="calc-price" class="pl-10 block w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-3" value="150000" step="10000">
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Luas Bangunan (m²)</label>
                    <div class="relative rounded-md shadow-sm">
                        <input type="number" id="calc-area" class="block w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-3 pr-10" value="100" min="10">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">m²</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 max-w-xl mx-auto text-center bg-gray-900 rounded-2xl py-8 px-4 shadow-2xl relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-emerald-500 rounded-full blur-3xl"></div>
                </div>
                
                <p class="text-sm text-gray-400 font-medium tracking-wider uppercase relative z-10">Estimasi Total Biaya Desain</p>
                <div class="flex items-center justify-center mt-3 relative z-10">
                    <span class="text-2xl text-gray-400 font-medium mr-2">Rp</span>
                    <h3 class="text-5xl font-extrabold text-white tracking-tight" id="calc-total">15.000.000</h3>
                </div>
                <p class="text-xs text-gray-500 mt-4 relative z-10">*Harga ini hanya estimasi kasar dan tidak mengikat</p>
            </div>
            
            <div class="mt-8 text-center">
                <a href="{{ route('features.cari') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition">
                    Cari Arsitek Sekarang
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const priceInput = document.getElementById('calc-price');
        const areaInput = document.getElementById('calc-area');
        const totalOutput = document.getElementById('calc-total');

        function calculate() {
            const price = parseFloat(priceInput.value) || 0;
            const area = parseFloat(areaInput.value) || 0;
            const total = price * area;
            
            // Format number directly without currency symbol since we added "Rp" separately in HTML
            totalOutput.innerText = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(total);
        }

        priceInput.addEventListener('input', calculate);
        areaInput.addEventListener('input', calculate);
        
        // Initial calc
        calculate();
    });
</script>
@endsection