@extends('layouts.landing')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout & Pembayaran</h1>

    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
        
        @if(!isset($paymentSuccess))
            <!-- STATE 1: FORM PENGISIAN DETAIL PROYEK -->
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <input type="hidden" name="architect_id" value="{{ $architect->id }}">
                
                <!-- Mock Price. In a real app, retrieve from ArchitectProfile -->
                <input type="hidden" name="price_per_m2" value="150000">

                <h3 class="text-xl font-semibold mb-4 border-b pb-2">Detail Arsitek</h3>
                <p class="text-gray-700 mb-6">Anda akan memesan jasa dari <strong>{{ $architect->name ?? 'Arsitek Dummy '.request()->route('architectId') }}</strong>.</p>

                <h3 class="text-xl font-semibold mb-4 border-b pb-2">Detail Properti</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Properti</label>
                        <select name="property_type" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="Hunian">Rumah Hunian</option>
                            <option value="Komersial">Komersial / Restaurant</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Luas Area (m2)</label>
                        <input type="number" name="area_size" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: 100" required min="10">
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md font-medium hover:bg-indigo-700 shadow-sm transition">
                        Lanjut ke Ringkasan
                    </button>
                </div>
            </form>

        @else
            <!-- STATE 2: SUCCESS -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Pemesanan Berhasil</h3>
                <p class="text-gray-500">Terima kasih, pembayaran untuk desain Anda telah kami terima.</p>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8 space-y-4 text-gray-700">
                <div class="flex justify-between border-b border-gray-200 pb-2">
                    <span class="font-medium">Arsitek:</span>
                    <span>{{ $architect->name ?? 'Arsitek Dummy' }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-2">
                    <span class="font-medium">Tipe Properti:</span>
                    <span>{{ $project->property_type }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-2">
                    <span class="font-medium">Luas Area:</span>
                    <span>{{ $project->area_size }} m2</span>
                </div>
                <div class="flex justify-between text-xl font-bold text-indigo-900 pt-2">
                    <span>Total Tagihan:</span>
                    <span>Rp {{ number_format($project->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="flex justify-center space-x-4">
                <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-md font-bold hover:bg-indigo-700 shadow-lg transition transform hover:scale-105">
                    Kembali ke Beranda
                </a>
            </div>
        @endif
    </div>
</div>
@endsection