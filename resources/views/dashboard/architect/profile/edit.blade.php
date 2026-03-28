@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Profil & Keahlian') }}
        </h2>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <form action="{{ route('architect.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Image -->
                            <div class="mb-4 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil Arsitek</label>
                                @if($profile->profile_image)
                                    <img src="{{ Storage::url($profile->profile_image) }}" alt="Profile" class="h-24 w-24 object-cover rounded-full mb-3">
                                @endif
                                <input type="file" name="profile_image" class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100
                                "/>
                                @error('profile_image')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Spesialisasi -->
                            <div class="mb-4 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Spesialisasi (Bisa pilih lebih dari satu)</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                    @foreach($specializations as $spec)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="specializations[]" value="{{ $spec->id }}" 
                                                {{ in_array($spec->id, $selectedSpecializations) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-600">{{ $spec->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('specializations')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga -->
                            <div class="mb-4">
                                <label for="price_per_m2" class="block text-sm font-medium text-gray-700">Harga per m² (Rp)</label>
                                <input type="number" name="price_per_m2" id="price_per_m2" value="{{ old('price_per_m2', $profile->price_per_m2) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <!-- Lokasi -->
                            <div class="mb-4">
                                <label for="location" class="block text-sm font-medium text-gray-700">Lokasi / Kota</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $profile->location) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Contoh: Jakarta Selatan">
                            </div>

                            <!-- Style -->
                            <div class="mb-4">
                                <label for="style" class="block text-sm font-medium text-gray-700">Gaya Desain</label>
                                <input type="text" name="style" id="style" value="{{ old('style', $profile->style) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Contoh: Skandinavia, Modern Tropis">
                            </div>

                            <!-- Timeline -->
                            <div class="mb-4">
                                <label for="timeline" class="block text-sm font-medium text-gray-700">Estimasi Timeline Kerja</label>
                                <input type="text" name="timeline" id="timeline" value="{{ old('timeline', $profile->timeline) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Contoh: 1-3 Bulan">
                            </div>

                        </div>

                        <div class="flex justify-end gap-2 text-right mt-6 pt-4 border-t">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-red-200">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-red-600 mb-2">Zona Berbahaya</h3>
                    <p class="text-sm text-gray-600 mb-4">Aksi ini akan menyembunyikan profil Anda dari pencarian dan menonaktifkan login Anda. Anda tidak bisa mengembalikannya sendiri tanpa bantuan Admin.</p>
                    
                    <form action="{{ route('architect.profile.deactivate') }}" method="POST" onsubmit="return confirm('Apakah Anda sangat yakin ingin menonaktifkan akun ini?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Nonaktifkan Akun Saya
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
