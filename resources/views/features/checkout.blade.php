@extends('layouts.landing')

@section('content')
@php
    $defaultPrice = $defaultPricePerM2 ?? 150000;
    $midtransReady = $midtransReady ?? true;
@endphp
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold tracking-tight text-gray-900 mb-2">Checkout & pemesanan</h1>
    <p class="text-sm text-gray-500 mb-8">Isi detail proyek, lalu bayar lewat Midtrans Snap.</p>

    @if(isset($snapToken) && isset($project))
        {{-- Snap pembayaran --}}
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-base font-semibold text-gray-900 mb-2">Pembayaran</h2>
            <p class="text-sm text-gray-600 mb-2">
                Proyek #{{ $project->id }} — total <strong class="text-gray-900">Rp {{ number_format($project->total_price, 0, ',', '.') }}</strong>
            </p>
            <p class="text-xs text-gray-500 mb-6">Jendela pembayaran Midtrans akan terbuka. Setelah selesai, Anda akan diarahkan ke halaman status.</p>

            <button
                type="button"
                id="midtrans-pay-button"
                class="inline-flex items-center justify-center rounded-full bg-gray-900 px-6 py-3 text-sm font-medium text-white hover:bg-gray-800 transition"
            >
                Bayar sekarang
            </button>
            <p class="mt-4 text-xs text-gray-400">
                Mengalami masalah? <a href="{{ route('checkout.finish', $project) }}" class="underline hover:text-gray-600">Lihat status pembayaran</a>
            </p>
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
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-100 mb-4">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Pembayaran berhasil</h3>
                <p class="text-sm text-gray-500 mt-1">Proyek Anda tercatat dan dapat dilanjutkan oleh arsitek.</p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-6 mb-8 space-y-3 text-sm text-gray-700">
                <div class="flex justify-between gap-4 border-b border-gray-200 pb-2">
                    <span class="text-gray-500">Arsitek</span>
                    <span class="font-medium text-gray-900 text-right">{{ $architect->name }}</span>
                </div>
                <div class="flex justify-between gap-4 border-b border-gray-200 pb-2">
                    <span class="text-gray-500">Tipe proyek</span>
                    <span class="font-medium text-gray-900 text-right">{{ $project->property_type }}</span>
                </div>
                <div class="flex justify-between gap-4 border-b border-gray-200 pb-2">
                    <span class="text-gray-500">Luas</span>
                    <span class="font-medium text-gray-900 text-right">{{ number_format($project->area_size, 0, ',', '.') }} m²</span>
                </div>
                <div class="flex justify-between gap-4 border-b border-gray-200 pb-2">
                    <span class="text-gray-500">Jumlah unit</span>
                    <span class="font-medium text-gray-900 text-right">{{ $project->units ?? 1 }} unit</span>
                </div>
                <div class="flex justify-between gap-4 border-b border-gray-200 pb-2">
                    <span class="text-gray-500">Harga per m²</span>
                    <span class="font-medium text-gray-900 text-right">Rp {{ number_format((float) $project->price_per_m2, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between gap-4 pt-2 text-base font-semibold text-gray-900">
                    <span>Total</span>
                    <span>Rp {{ number_format($project->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('client.projects.index') }}" class="inline-flex justify-center rounded-full bg-gray-900 px-6 py-3 text-sm font-medium text-white hover:bg-gray-800 transition">
                    Lihat proyek saya
                </a>
                <a href="{{ route('home') }}" class="inline-flex justify-center rounded-full border border-gray-200 bg-white px-6 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                    Kembali ke beranda
                </a>
            </div>
        </div>
    @elseif(!empty($paymentPending))
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-amber-100 bg-amber-50/30">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Menunggu pembayaran</h3>
            <p class="text-sm text-gray-600 mb-6">
                Status proyek masih <strong>pending</strong>. Jika Anda sudah menyelesaikan pembayaran di Midtrans, tunggu beberapa saat lalu segarkan halaman ini. Notifikasi dari Midtrans akan memperbarui status otomatis.
            </p>
            <div class="rounded-xl border border-gray-100 bg-white p-4 mb-6 text-sm text-gray-700">
                <p><span class="text-gray-500">Order:</span> RUANGTEMU-P-{{ $project->id }}</p>
                <p class="mt-1"><span class="text-gray-500">Total:</span> Rp {{ number_format($project->total_price, 0, ',', '.') }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('checkout.finish', $project) }}" class="inline-flex justify-center rounded-full bg-gray-900 px-6 py-3 text-sm font-medium text-white hover:bg-gray-800 transition">
                    Segarkan status
                </a>
                <a href="{{ route('client.projects.index') }}" class="inline-flex justify-center rounded-full border border-gray-200 bg-white px-6 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition">
                    Proyek saya
                </a>
            </div>
        </div>
    @else
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
            @if(!$midtransReady)
                <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                    Midtrans belum siap: set <code class="text-xs bg-amber-100 px-1 rounded">MIDTRANS_SERVER_KEY</code> dan <code class="text-xs bg-amber-100 px-1 rounded">MIDTRANS_CLIENT_KEY</code> di file <code class="text-xs">.env</code>, lalu jalankan <code class="text-xs">php artisan config:clear</code>.
                </div>
            @endif

            <form
                action="{{ route('checkout.process') }}"
                method="POST"
                x-data="{
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
                }"
            >
                @csrf
                <input type="hidden" name="architect_id" value="{{ $architect->id }}">

                <h2 class="text-base font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Arsitek</h2>
                <p class="text-sm text-gray-600 mb-6">
                    Anda memesan jasa dari <strong class="text-gray-900">{{ $architect->name }}</strong>.
                </p>

                <h2 class="text-base font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Detail proyek</h2>

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <fieldset class="mb-6">
                    <legend class="text-sm font-medium text-gray-700 mb-3">Tipe proyek</legend>
                    <div class="space-y-3">
                        <label class="flex items-start gap-3 cursor-pointer rounded-xl border border-gray-200 p-4 has-[:checked]:border-gray-900 has-[:checked]:bg-gray-50">
                            <input
                                type="radio"
                                name="property_type"
                                value="hunian"
                                class="mt-1 border-gray-300 text-gray-900 focus:ring-gray-900"
                                {{ old('property_type', 'hunian') === 'hunian' ? 'checked' : '' }}
                                required
                            />
                            <span>
                                <span class="block text-sm font-medium text-gray-900">Rumah hunian</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Tempat tinggal / hunian pribadi</span>
                            </span>
                        </label>
                        <label class="flex items-start gap-3 cursor-pointer rounded-xl border border-gray-200 p-4 has-[:checked]:border-gray-900 has-[:checked]:bg-gray-50">
                            <input
                                type="radio"
                                name="property_type"
                                value="komersial"
                                class="mt-1 border-gray-300 text-gray-900 focus:ring-gray-900"
                                {{ old('property_type') === 'komersial' ? 'checked' : '' }}
                            />
                            <span>
                                <span class="block text-sm font-medium text-gray-900">Komersial / ruang usaha</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Ruko, kantor, toko, atau sejenisnya</span>
                            </span>
                        </label>
                    </div>
                </fieldset>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="area_size" class="block text-sm font-medium text-gray-700 mb-2">Luas (m²)</label>
                        <input
                            id="area_size"
                            type="number"
                            name="area_size"
                            x-model.number="area"
                            min="1"
                            step="1"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10 text-gray-900"
                            placeholder="Contoh: 120"
                            required
                        />
                    </div>
                    <div>
                        <label for="units" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Unit</label>
                        <input
                            id="units"
                            type="number"
                            name="units"
                            x-model.number="units"
                            min="1"
                            max="100"
                            step="1"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10 text-gray-900"
                            placeholder="Contoh: 1"
                            required
                        />
                        <p class="mt-1 text-xs text-gray-500">Jumlah bangunan yang ingin didesain</p>
                    </div>
                    <div>
                        <label for="price_per_m2" class="block text-sm font-medium text-gray-700 mb-2">Harga per m² (Rp)</label>
                        <input
                            id="price_per_m2"
                            type="number"
                            name="price_per_m2"
                            x-model.number="pricePerM2"
                            min="0"
                            step="1000"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-gray-300 focus:ring-2 focus:ring-gray-900/10 text-gray-900"
                            required
                        />
                        <p class="mt-1 text-xs text-gray-500">Default dari profil arsitek: Rp {{ number_format($defaultPrice, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="rounded-xl bg-gray-50 border border-gray-100 px-4 py-3 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <span class="text-sm font-medium text-gray-600">Estimasi total</span>
                    <span class="text-lg font-semibold text-gray-900" x-text="total != null ? 'Rp ' + formatIdr(total) : '—'"></span>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-gray-900 px-6 py-3 text-sm font-medium text-white hover:bg-gray-800 transition disabled:opacity-50"
                        @if(!$midtransReady) disabled @endif
                    >
                        Lanjut ke pembayaran Midtrans
                    </button>
                </div>
            </form>
        </div>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    @endif
</div>
@endsection
