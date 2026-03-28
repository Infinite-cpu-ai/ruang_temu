@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
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
                                <th class="border border-gray-200 p-2">Nama</th>
                                <th class="border border-gray-200 p-2">Email</th>
                                <th class="border border-gray-200 p-2">Role</th>
                                <th class="border border-gray-200 p-2">Status</th>
                                <th class="border border-gray-200 p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 p-2">{{ $user->name }}</td>
                                <td class="border border-gray-200 p-2">{{ $user->email }}</td>
                                <td class="border border-gray-200 p-2 capitalize">{{ $user->role }}</td>
                                <td class="border border-gray-200 p-2">
                                    @if($user->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="border border-gray-200 p-2">
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status pengguna ini?');">
                                        @csrf
                                        @method('PATCH')
                                        @if($user->is_active)
                                            <button type="submit" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
                                                Nonaktifkan
                                            </button>
                                        @else
                                            <button type="submit" class="text-sm bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded">
                                                Aktifkan
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($users->isEmpty())
                            <tr>
                                <td colspan="5" class="border border-gray-200 p-4 text-center text-gray-500">Belum ada pengguna.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
