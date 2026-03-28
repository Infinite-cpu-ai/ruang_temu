@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Review') }}
        </h2>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Edit Ulasan untuk Arsitek: {{ $review->architect->name }}</h3>
                        <p class="text-sm text-gray-500 mt-2">Dibuat pada: {{ $review->created_at->format('d M Y') }}</p>
                    </div>

                    <form action="{{ route('client.reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="rating" :value="__('Rating (1-5)')" />
                            <select id="rating" name="rating" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>5 - Sangat Baik</option>
                                <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>4 - Baik</option>
                                <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>3 - Cukup</option>
                                <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>2 - Kurang</option>
                                <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>1 - Sangat Kurang</option>
                            </select>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="comment" :value="__('Komentar')" />
                            <textarea id="comment" name="comment" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>{{ old('comment', $review->comment) }}</textarea>
                            <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('client.reviews.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Update Review') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection