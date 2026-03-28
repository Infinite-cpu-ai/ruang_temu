@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Spesialisasi') }}
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

            <div class="mb-4">
                <a href="{{ route('admin.specializations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Tambah Spesialisasi
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-200 p-2">Nama Spesialisasi</th>
                                <th class="border border-gray-200 p-2">Deskripsi</th>
                                <th class="border border-gray-200 p-2 text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($specializations as $spec)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 p-2 font-semibold">{{ $spec->name }}</td>
                                <td class="border border-gray-200 p-2">{{ Str::limit($spec->description, 100) }}</td>
                                <td class="border border-gray-200 p-2 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.specializations.edit', $spec) }}" class="text-sm bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-2 rounded">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.specializations.destroy', $spec) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($specializations->isEmpty())
                            <tr>
                                <td colspan="3" class="border border-gray-200 p-4 text-center text-gray-500">Data spesialisasi masih kosong.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $specializations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
