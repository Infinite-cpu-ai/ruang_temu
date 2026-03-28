@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ulasan Klien') }}
        </h2>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($reviews as $review)
                        <div class="border rounded-lg p-5 shadow-sm bg-gray-50 {{ $review->is_reported ? 'border-red-300' : '' }}">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold">{{ $review->client->name ?? 'User Dihapus' }}</h4>
                                    <p class="text-xs text-gray-500">Proyek #PRJ-{{ str_pad($review->project_id, 4, '0', STR_PAD_LEFT) }} - {{ $review->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="text-yellow-500 font-bold">
                                    ★ {{ $review->rating }}
                                </div>
                            </div>
                            <p class="text-gray-700 italic">"{{ $review->comment }}"</p>
                            
                            @if($review->is_reported)
                                <div class="mt-3 text-xs text-red-600 font-bold">
                                    Status: Ulasan sudah Anda/Admin laporkan atau hapus (Sedang ditinjau).
                                </div>
                            @else
                                <!-- Fitur tambahan kalau waktu mepet belum di handle khusus: report review button. (Bisa abaikan dulu kalau belum diminta) -->
                            @endif
                        </div>
                        @endforeach
                    </div>

                    @if($reviews->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            Belum ada ulasan yang masuk.
                        </div>
                    @endif

                    <div class="mt-6">
                        {{ $reviews->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
