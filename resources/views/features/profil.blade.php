@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-100">
        <!-- Header Profile -->
        <div class="bg-indigo-600 h-32 relative">
            <!-- Optional Cover Pattern/Icon here -->
        </div>
        <div class="px-8 pb-8 flex flex-col sm:flex-row justify-between items-end sm:items-center -mt-16 relative z-10">
            <div class="flex items-center w-full sm:w-auto">
                <div class="w-32 h-32 bg-white rounded-full border-4 border-white shadow-lg overflow-hidden flex items-center justify-center shrink-0">
                    <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <div class="mt-16 sm:mt-0 sm:ml-6 text-center sm:text-left flex-1 min-w-0">
                    <h1 class="text-3xl font-bold text-gray-900 truncate">Arsitek Dummy {{ request()->id }}</h1>
                    <p class="text-gray-500 mt-1">Spesialisasi: Architecture & Interior Design</p>
                </div>
            </div>
            <div class="mt-6 sm:mt-0 w-full sm:w-auto flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('checkout.index', request()->id) }}" class="flex-1 bg-emerald-600 text-white px-6 py-2.5 rounded-md font-medium hover:bg-emerald-700 text-center shadow-sm transition">Pesan Desain</a>
                <a href="{{ route('chat.index') }}" class="flex-1 bg-indigo-600 text-white px-6 py-2.5 rounded-md font-medium hover:bg-indigo-700 text-center shadow-sm transition">Mulai Konsultasi</a>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="border-t border-gray-100 grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 bg-gray-50/50">
            <div class="p-6 text-center">
                <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Harga per m²</div>
                <div class="mt-2 text-2xl font-bold text-gray-900">Rp 150.000</div>
            </div>
            <div class="p-6 text-center">
                <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Rating</div>
                <div class="mt-2 text-2xl font-bold text-gray-900">⭐ 4.8 <span class="text-lg text-gray-400 font-medium">/ 5.0</span></div>
            </div>
            <div class="p-6 text-center">
                <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Lokasi Utama</div>
                <div class="mt-2 text-xl font-semibold text-gray-900">Jakarta Selatan</div>
            </div>
        </div>
    </div>
    
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Portofolio & Karya</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @for($i=1; $i<=6; $i++)
                <div class="aspect-[4/3] bg-gray-200 rounded-xl flex items-center justify-center text-gray-400 font-medium border border-gray-100 shadow-sm hover:shadow-md transition cursor-pointer overflow-hidden group">
                    <span class="group-hover:scale-110 transition duration-300">Gambar Portofolio {{ $i }}</span>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection