@extends('layouts.landing')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Cari Arsitek</h1>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-8 grid grid-cols-1 sm:grid-cols-4 gap-4">
        <select class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full bg-white text-gray-700 py-2 px-3">
            <option>Semua Budget</option>
            <option>< Rp 100rb / m2</option>
            <option>Rp 100rb - 300rb / m2</option>
            <option>> Rp 300rb / m2</option>
        </select>
        <select class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full bg-white text-gray-700 py-2 px-3">
            <option>Tipe Properti</option>
            <option>Hunian</option>
            <option>Restaurant/Komersial</option>
        </select>
        <select class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full bg-white text-gray-700 py-2 px-3">
            <option>Style Desain</option>
            <option>Minimalist</option>
            <option>Industrial</option>
            <option>Tropical</option>
        </select>
        <button class="bg-indigo-600 text-white rounded-md px-4 py-2 hover:bg-indigo-700 transition font-medium">Terapkan Filter</button>
    </div>

    <!-- dummy grid loop -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @for($i = 1; $i <= 6; $i++)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                [Thumbnail Portofolio]
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-1">Arsitek Dummy {{ $i }}</h3>
                <p class="text-indigo-600 text-sm font-medium mb-4">Spesialisasi: Tropical & Minimalist</p>
                <div class="flex justify-between items-center text-sm text-gray-500 mb-6">
                    <span class="flex items-center text-yellow-500 font-bold">⭐ <span class="text-gray-600 ml-1">4.{{ $i }} / 5.0</span></span>
                    <span class="font-medium text-gray-700">Rp 150.000 / m²</span>
                </div>
                <a href="{{ route('features.profil', $i) }}" class="block w-full text-center bg-gray-50 text-indigo-600 font-medium py-2.5 rounded-md hover:bg-indigo-50 border border-indigo-100 transition">Lihat Profil</a>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection