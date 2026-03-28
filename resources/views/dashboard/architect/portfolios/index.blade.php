@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Portofolio Saya') }}
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
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('architect.portfolios.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    + Tambah Portofolio
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($portfolios as $portfolio)
                        <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                            <img src="{{ Storage::url($portfolio->image) }}" alt="{{ $portfolio->title }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2">{{ $portfolio->title }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($portfolio->description, 100) }}</p>
                                
                                <div class="flex justify-between items-center mt-4">
                                    <a href="{{ route('architect.portfolios.edit', $portfolio) }}" class="text-sm bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('architect.portfolios.destroy', $portfolio) }}" method="POST" onsubmit="return confirm('Hapus portofolio ini secara permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($portfolios->isEmpty())
                        <div class="text-center py-12 text-gray-500">
                            Anda belum menambahkan portofolio satupun.
                        </div>
                    @endif

                    <div class="mt-6">
                        {{ $portfolios->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
