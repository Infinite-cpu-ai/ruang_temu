@extends('layouts.landing')

@section('content')
<div class="relative min-h-screen bg-[#FAFAFA] overflow-x-hidden">
    <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-gray-200/50 to-transparent blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-gradient-to-tl from-gray-200/50 to-transparent blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 py-14 pt-28">

        {{-- Header --}}
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-sm font-semibold text-gray-400 tracking-widest uppercase mb-2">Arsitek</p>
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Portofolio Saya</h1>
                <p class="mt-2 text-base text-gray-500 font-medium">Kelola karya terbaikmu yang akan dilihat klien.</p>
            </div>
            <a href="{{ route('architect.portfolios.create') }}"
               class="inline-flex items-center gap-2 rounded-2xl bg-gray-900 px-5 py-3 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Portofolio
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-100 px-5 py-4 text-emerald-700 font-semibold text-sm shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl bg-red-50 border border-red-100 px-5 py-4 text-red-600 font-semibold text-sm shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @if($portfolios->isEmpty())
            {{-- Empty State --}}
            <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-16 shadow-[0_4px_20px_rgb(0,0,0,0.04)] text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-5">
                    <svg class="w-9 h-9 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-2">Belum ada portofolio</h3>
                <p class="text-gray-400 text-sm font-medium mb-6">Tampilkan karya terbaikmu agar klien tertarik menyewamu.</p>
                <a href="{{ route('architect.portfolios.create') }}"
                   class="inline-flex items-center gap-2 rounded-2xl bg-gray-900 px-6 py-3 text-sm font-bold text-white hover:bg-black transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Tambah Portofolio Pertama
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($portfolios as $portfolio)
                <div class="group relative bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-[0_2px_15px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-300 ease-out flex flex-col">

                    {{-- Image --}}
                    <div class="h-52 bg-gray-100 overflow-hidden relative">
                        <img src="{{ $portfolio->image_url }}"
                             alt="{{ $portfolio->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out"
                             onerror="this.src='{{ asset('images/portofolios/portofolio_placeholder.png') }}'" />
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-extrabold text-gray-900 text-sm leading-tight mb-2 line-clamp-2">{{ $portfolio->title }}</h3>
                        @if($portfolio->description)
                            <p class="text-xs text-gray-400 font-medium line-clamp-2 flex-1 mb-4">{{ $portfolio->description }}</p>
                        @else
                            <div class="flex-1 mb-4"></div>
                        @endif

                        <div class="flex items-center gap-2 border-t border-gray-100 pt-4">
                            <a href="{{ route('architect.portfolios.edit', $portfolio) }}"
                               class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('architect.portfolios.destroy', $portfolio) }}" method="POST"
                                  onsubmit="return confirm('Hapus portofolio ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-red-100 bg-red-50 px-3 py-2 text-xs font-bold text-red-500 hover:bg-red-100 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $portfolios->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
