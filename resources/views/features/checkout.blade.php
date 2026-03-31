@extends('layouts.landing')

@section('content')
@php
    $defaultPrice = $defaultPricePerM2 ?? 150000;
    $midtransReady = $midtransReady ?? true;
    $profileImg = data_get($architect, 'profile_image') ? '/storage/'.data_get($architect, 'profile_image') : asset('images/profiles/profile_placeholder.png');
@endphp
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-3xl w-full">
        @if(isset($snapToken) && isset($project))
            {{-- Snap pembayaran --}}
            <div class="bg-white p-10 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] text-center">
                <div class="flex justify-center gap-4 mb-8">
                    <div class="w-16 h-16 rounded-full border border-gray-100 shadow-sm flex items-center justify-center bg-white text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Selesaikan Pembayaran</h1>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Klik tombol di bawah untuk membuka pop-up Midtrans dan menyelesaikan transaksi aman Anda.</p>
                
                <div class="inline-block bg-gray-50 border border-gray-100 rounded-2xl p-6 mb-8 text-left w-full max-w-md mx-auto">
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-1">Total Tagihan</p>
                    <p class="text-3xl font-extrabold text-gray-900">Rp {{ number_format($project->total_price, 0, ',', '.') }}</p>
                    <div class="mt-4 text-sm text-gray-600 space-y-2">
                        <div class="flex justify-between border-b pb-2"><span class="text-gray-400">ID Proyek</span><span class="font-medium text-gray-900">#{{ $project->id }}</span></div>
                        <div class="flex justify-between pt-1"><span class="text-gray-400">Arsitek</span><span class="font-medium text-gray-900">{{ $architect->name }}</span></div>
                    </div>
                </div>

                <div class="flex flex-col items-center gap-4">
                    <button id="midtrans-pay-button" class="w-full max-w-sm rounded-full bg-black text-white px-8 py-4 text-sm font-bold shadow-lg hover:shadow-xl hover:bg-gray-900 hover:-translate-y-1 transition duration-300 flex justify-center items-center gap-3">
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Bayar via Midtrans
                    </button>
                    <a href="{{ route('checkout.finish', $project) }}" class="text-sm font-medium text-gray-400 hover:text-gray-600 underline underline-offset-4 transition">
                        Batal atau muat ulang halaman
                    </a>
                </div>
            </div>

            <script src="{{ $snapScriptUrl }}" data-client-key="{{ $snapClientKey }}"></script>
            <script>
                (function () {
                    var token = @json($snapToken);
                    var finishUrl = @json(route('checkout.finish', $project));

                    function runSnap() {
                        if (typeof snap === 'undefined') {
                            alert('Midtrans Snap gagal dimuat. Periksa koneksi atau Client Key.');
                            return;
                        }
                        snap.pay(token, {
                            onSuccess: function () { window.location.href = finishUrl; },
                            onPending: function () { window.location.href = finishUrl; },
                            onError: function () { window.location.href = finishUrl; },
                            onClose: function () { /* user closed popup */ }
                        });
                    }

                    document.getElementById('midtrans-pay-button').addEventListener('click', runSnap);
                })();
            </script>
            
        @elseif(!empty($paymentSuccess))
            <div class="bg-white p-10 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] text-center text-gray-900">
                <div class="flex justify-center mb-8">
                    <div class="w-20 h-20 rounded-full bg-green-50 flex items-center justify-center shadow-sm border border-green-100">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
                
                <h1 class="text-4xl font-extrabold tracking-tight mb-3">Pesanan Sukses</h1>
                <p class="text-gray-500 max-w-md mx-auto mb-8">Selamat! Permintaan desain Anda telah berhasil dikonfirmasi dan dana telah diterima.</p>
                
                <div class="flex flex-col gap-3 mx-auto max-w-xs">
                    <a href="{{ route('client.projects.index') }}" class="w-full rounded-full bg-black text-white px-8 py-4 text-sm font-bold shadow-lg hover:bg-gray-900 transition flex items-center justify-center gap-2">
                        Lihat Proyek Saya
                    </a>
                    <a href="{{ route('home') }}" class="w-full rounded-full bg-gray-50 border border-gray-200 text-gray-700 px-8 py-4 text-sm font-bold hover:bg-gray-100 transition flex items-center justify-center gap-2">
                        Kembali ke Home
                    </a>
                </div>
            </div>
            
        @elseif(!empty($paymentPending))
            <div class="bg-white p-10 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] text-center text-gray-900">
                <div class="flex justify-center mb-8">
                    <div class="w-20 h-20 rounded-full bg-amber-50 flex items-center justify-center shadow-sm border border-amber-100">
                        <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight mb-3">Pesanan Pending</h1>
                <p class="text-gray-500 max-w-sm mx-auto mb-8">Kami masih menunggu penyelesaian pembayaran Anda. Silakan selesaikan pembayaran dan kembali periksa laman ini.</p>
                
                <div class="flex flex-col gap-3 mx-auto max-w-xs">
                    <a href="{{ route('checkout.finish', $project) }}" class="w-full rounded-full bg-black text-white px-8 py-4 text-sm font-bold shadow-lg hover:bg-gray-900 transition flex items-center justify-center gap-2">
                        Muat Ulang Status
                    </a>
                    <a href="{{ route('client.projects.index') }}" class="w-full rounded-full bg-gray-50 border border-gray-200 text-gray-700 px-8 py-4 text-sm font-bold hover:bg-gray-100 transition flex items-center justify-center gap-2">
                        Daftar Proyek
                    </a>
                </div>
            </div>
            
        @else
            <!-- The Checkout Entry Form (Follows Premium Centered Apple-ish Layout) -->
            <div class="text-center mb-10">
                <!-- Iconic Top Ornaments -->
                <div class="flex justify-center items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-[2rem] bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    
                    <div class="w-20 h-20 rounded-[2.5rem] bg-white border-2 border-black shadow-[0_4px_15px_rgb(0,0,0,0.1)] flex items-center justify-center text-black overflow-hidden relative">
                        <!-- Arsitek Profile img -->
                        <img src="{{ $profileImg }}" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="w-16 h-16 rounded-[2rem] bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>

                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">Checkout Jasa</h1>
                <p class="text-gray-500 font-medium tracking-wide">Lengkapi ringkasan kebutuhan untuk dikirimkan secara langsung ke <span class="font-bold text-gray-800">{{ $architect->name }}</span></p>
            </div>

            <div class="bg-white p-8 md:p-12 rounded-[3rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative max-w-2xl mx-auto">
                
                @if(!$midtransReady)
                    <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-900 shadow-sm">
                        Midtrans belum diatur di server (Aplikasi Test). Konfigurasi tidak valid.
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700 shadow-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('checkout.process') }}" method="POST" x-data="{
                    area: @json(old('area_size') !== null && old('area_size') !== '' ? (float) old('area_size') : null),
                    units: @json(old('units') !== null && old('units') !== '' ? (int) old('units') : 1),
                    pricePerM2: @json(old('price_per_m2') !== null && old('price_per_m2') !== '' ? (float) old('price_per_m2') : (float) $defaultPrice),
                    formatIdr(n) {
                        if (n === null || n === '' || isNaN(Number(n))) return '—';
                        return new Intl.NumberFormat('id-ID').format(Math.round(Number(n)));
                    },
                    get total() {
                        const a = Number(this.area);
                        const p = Number(this.pricePerM2);
                        const u = Number(this.units);
                        if (!a || isNaN(a) || isNaN(p) || !u || isNaN(u)) return null;
                        return Math.round(a * p * u);
                    }
                }">
                    @csrf
                    <input type="hidden" name="architect_id" value="{{ $architect->id }}">

                    <div class="space-y-6">
                        <!-- Tipe Proyek Radio Selection (Sleek Modern Styled) -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 text-center">Tipe Bangunan / Proyek</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="property_type" value="hunian" class="peer hidden" {{ old('property_type', 'hunian') === 'hunian' ? 'checked' : '' }}>
                                    <div class="rounded-2xl border-2 border-gray-100 bg-white p-4 text-center hover:bg-gray-50 peer-checked:border-black peer-checked:bg-gray-900 peer-checked:text-white transition-all shadow-sm">
                                        <svg class="w-6 h-6 mx-auto mb-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                        <span class="block text-sm font-bold">Hunian</span>
                                        <span class="block text-[10px] mt-1 opacity-60">Rumah / Pribadi</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="property_type" value="komersial" class="peer hidden" {{ old('property_type') === 'komersial' ? 'checked' : '' }}>
                                    <div class="rounded-2xl border-2 border-gray-100 bg-white p-4 text-center hover:bg-gray-50 peer-checked:border-black peer-checked:bg-gray-900 peer-checked:text-white transition-all shadow-sm">
                                        <svg class="w-6 h-6 mx-auto mb-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <span class="block text-sm font-bold">Komersial</span>
                                        <span class="block text-[10px] mt-1 opacity-60">Toko / Bisnis</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- 3 Input Grids -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
                            <!-- Area Size -->
                            <div>
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-2 text-center">Luas (m²)</label>
                                <input type="number" name="area_size" x-model.number="area" min="1" step="1" required class="w-full text-center rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-black focus:border-black shadow-sm font-bold text-lg py-3" placeholder="0">
                            </div>
                            
                            <!-- Units -->
                            <div>
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-2 text-center">Jumlah Unit</label>
                                <input type="number" name="units" x-model.number="units" min="1" max="100" step="1" required class="w-full text-center rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-black focus:border-black shadow-sm font-bold text-lg py-3" placeholder="1">
                            </div>
                            
                            <!-- Price per M2 -->
                            <div class="relative">
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-2 text-center text-ellipsis overflow-hidden whitespace-nowrap" title="Harga per m² (Sesuai Profil)">Harga per m² (Rp)</label>
                                <input type="number" name="price_per_m2" x-model.number="pricePerM2" min="0" step="1000" required class="w-full text-center rounded-2xl border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed shadow-none font-bold text-base py-3" readonly>
                                <div class="absolute -top-1 -right-1 bg-blue-100 text-blue-600 rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-bold shadow-sm" title="Terkunci berdasar setelan arsitek">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Total Tagihan Display -->
                        <div class="mt-8 pt-6 border-t border-gray-100/60 text-center relative z-10 before:absolute before:inset-0 before:-z-10 before:bg-gradient-to-b before:from-transparent before:to-gray-50 before:rounded-b-[2.5rem]">
                            <p class="text-xs uppercase tracking-widest font-extrabold text-gray-400 mb-1">Estimasi Total Tagihan</p>
                            <p class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight" x-text="total != null ? 'Rp ' + formatIdr(total) : 'Rp 0'"></p>
                        </div>
                    </div>

                    <!-- Giant Checkout Submit Button -->
                    <div class="mt-10 flex flex-col items-center gap-3">
                        <button type="submit" @if(!$midtransReady) disabled @endif class="w-full sm:max-w-xs flex items-center justify-center gap-3 rounded-[2rem] bg-black px-8 py-4 text-[15px] font-bold text-white shadow-[0_8px_20px_rgb(0,0,0,0.15)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_12px_25px_rgb(0,0,0,0.2)] disabled:opacity-50">
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            Bayar Pemesanan
                        </button>
                        <a href="{{ route('features.profil', $architect->id) }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition tracking-wide uppercase mt-2">
                            Batal & Kembali ke Profil
                        </a>
                    </div>
                </form>
            </div>
            <!-- Bottom decorative spacer -->
            <div class="h-20"></div>
        @endif
        
    </div>
</div>
@endsection
