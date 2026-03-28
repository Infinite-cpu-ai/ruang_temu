@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proyek Saya & Status Desain') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-200 mt-4">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-200 p-2">No Proyek</th>
                                <th class="border border-gray-200 p-2">Klien</th>
                                <th class="border border-gray-200 p-2">Detail (Tipe & Luas)</th>
                                <th class="border border-gray-200 p-2">Harga Total</th>
                                <th class="border border-gray-200 p-2 text-center">Status</th>
                                <th class="border border-gray-200 p-2 text-center w-48">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'paid' => 'Dibayar',
                                    'on_progress' => 'Proses Desain',
                                    'completed' => 'Selesai',
                                ];

                                $allowedTransitions = [
                                    'pending' => ['pending', 'paid'],
                                    'paid' => ['paid', 'on_progress'],
                                    'on_progress' => ['on_progress', 'completed'],
                                    'completed' => ['completed'],
                                ];
                            @endphp
                            @foreach($projects as $project)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 p-2">#PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="border border-gray-200 p-2">{{ $project->user->name ?? 'User Dihapus' }}</td>
                                <td class="border border-gray-200 p-2">
                                    {{ $project->property_type }} - {{ $project->area_size }} m²
                                </td>
                                <td class="border border-gray-200 p-2">Rp {{ number_format($project->total_price, 0, ',', '.') }}</td>
                                <td class="border border-gray-200 p-2 text-center">
                                    @if($project->status === 'pending')
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Pending</span>
                                    @elseif($project->status === 'paid')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Dibayar</span>
                                    @elseif($project->status === 'on_progress')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Proses Desain</span>
                                    @elseif($project->status === 'completed')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Selesai</span>
                                    @endif
                                </td>
                                <td class="border border-gray-200 p-2 text-center">
                                    @php
                                        $statusOptions = $allowedTransitions[$project->status] ?? [$project->status];
                                        $isCompleted = $project->status === 'completed';
                                    @endphp
                                    <form action="{{ route('architect.projects.update-status', $project) }}" method="POST" class="flex flex-col gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="w-full rounded border-gray-300 text-sm focus:ring-indigo-500" {{ $isCompleted ? 'disabled' : '' }}>
                                            @foreach($statusOptions as $statusOption)
                                                <option value="{{ $statusOption }}" {{ $project->status === $statusOption ? 'selected' : '' }}>
                                                    {{ $statusLabels[$statusOption] ?? ucfirst(str_replace('_', ' ', $statusOption)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($isCompleted)
                                            <button type="button" class="bg-gray-300 text-gray-600 py-1 px-2 text-xs rounded w-full cursor-not-allowed" disabled>
                                                Final
                                            </button>
                                        @else
                                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white py-1 px-2 text-xs rounded w-full">
                                                Simpan
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($projects->isEmpty())
                            <tr>
                                <td colspan="6" class="border border-gray-200 p-4 text-center text-gray-500">Belum ada proyek.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
