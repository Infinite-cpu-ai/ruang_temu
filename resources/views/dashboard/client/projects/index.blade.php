@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proyek Saya') }}
        </h2>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">
                     <!-- Filters -->
                    <div class="mb-6 flex gap-2 overflow-x-auto">
                        <a href="{{ route('client.projects.index') }}" class="px-4 py-2 text-sm rounded-md border {{ !request('status') ? 'bg-indigo-600 text-white border-transparent' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                            Semua
                        </a>
                        <a href="{{ route('client.projects.index', ['status' => 'pending']) }}" class="px-4 py-2 text-sm rounded-md border {{ request('status') === 'pending' ? 'bg-yellow-500 text-white border-transparent' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                            Pending
                        </a>
                        <a href="{{ route('client.projects.index', ['status' => 'on_progress']) }}" class="px-4 py-2 text-sm rounded-md border {{ request('status') === 'on_progress' ? 'bg-blue-500 text-white border-transparent' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                            On Progress
                        </a>
                        <a href="{{ route('client.projects.index', ['status' => 'completed']) }}" class="px-4 py-2 text-sm rounded-md border {{ request('status') === 'completed' ? 'bg-green-500 text-white border-transparent' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                            Selesai
                        </a>
                        <a href="{{ route('client.projects.index', ['status' => 'cancelled']) }}" class="px-4 py-2 text-sm rounded-md border {{ request('status') === 'cancelled' ? 'bg-red-500 text-white border-transparent' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                            Dibatalkan
                        </a>
                    </div>

                    @if($projects->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            Tidak ada proyek ditemukan.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul / Arsitek</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mulai - Selesai (Est)</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 w-full mb-6">
                                    @foreach($projects as $project)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900">{{ $project->title }}</div>
                                                <div class="text-sm text-gray-500">{{ $project->architect->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $project->start_date ? $project->start_date->format('d M Y') : '-' }} <br>
                                                {{ $project->end_date ? $project->end_date->format('d M Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                Rp {{ number_format($project->budget, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($project->status == 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($project->status == 'on_progress') bg-blue-100 text-blue-800
                                                    @elseif($project->status == 'completed') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @if($project->status == 'completed' && !$project->review)
                                                    <a href="{{ route('client.reviews.create', $project) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md">Beri Ulasan</a>
                                                @elseif($project->review)
                                                    <span class="text-green-600">Sudah Direview</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $projects->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection