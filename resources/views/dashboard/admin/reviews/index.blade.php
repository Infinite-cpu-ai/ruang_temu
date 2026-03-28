@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Ulasan') }}
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
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-200 p-2">Klien & Arsitek</th>
                                <th class="border border-gray-200 p-2">Rating</th>
                                <th class="border border-gray-200 p-2">Komentar</th>
                                <th class="border border-gray-200 p-2">Status Dilaporkan</th>
                                <th class="border border-gray-200 p-2 w-48 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                            <tr class="{{ $review->is_reported ? 'bg-red-50' : 'hover:bg-gray-50' }}">
                                <td class="border border-gray-200 p-2">
                                    <div class="text-sm">
                                        <span class="font-bold">Klien:</span> {{ $review->client->name ?? 'Deleted User' }} <br>
                                        <span class="font-bold">Arsitek:</span> {{ $review->architect->name ?? 'Deleted User' }}
                                    </div>
                                </td>
                                <td class="border border-gray-200 p-2">
                                    <span class="text-yellow-500 font-bold">★ {{ $review->rating }}</span>
                                </td>
                                <td class="border border-gray-200 p-2">{{ Str::limit($review->comment, 100) }}</td>
                                <td class="border border-gray-200 p-2 text-center">
                                    @if($review->is_reported)
                                        <span class="inline-block px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full font-bold mb-1">
                                            ⚠️ Dilaporkan
                                        </span>
                                        <p class="text-xs text-red-600 truncate max-w-[150px]" title="{{ $review->report_reason }}">{{ $review->report_reason }}</p>
                                    @else
                                        <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aman</span>
                                    @endif
                                </td>
                                <td class="border border-gray-200 p-2 text-center space-y-1">
                                    @if($review->is_reported)
                                    <form action="{{ route('admin.reviews.resolve', $review) }}" method="POST" class="inline-block w-full">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" onclick="return confirm('Tandai ulasan ini sebagai aman?')" class="w-full text-xs bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">
                                            Abaikan Laporan
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline-block w-full mt-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus ulasan ini?')" class="w-full text-xs bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
                                            Hapus Ulasan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($reviews->isEmpty())
                            <tr>
                                <td colspan="5" class="border border-gray-200 p-4 text-center text-gray-500">Belum ada ulasan yang masuk.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
