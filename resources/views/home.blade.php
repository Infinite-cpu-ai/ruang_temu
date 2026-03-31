@extends('layouts.landing')

@section('content')
<section class="pt-24 pb-24 min-h-[calc(100vh-5rem)] flex items-center justify-center">
    <div class="max-w-5xl mx-auto px-6 w-full text-center">
        <h2 class="text-5xl sm:text-6xl font-extrabold tracking-tight text-gray-900 mb-4">
            LOGO
        </h2>
        <h1 class="text-6xl sm:text-7xl font-black tracking-tight text-gray-900 leading-none">
            RUANG TEMU
        </h1>
        <p class="mt-10 text-sm text-gray-400 max-w-xl mx-auto leading-relaxed">
            Tempat kamu mencari, bertanya, konsultasi dan membangun - langsung dengan arsitek pilihan mu
        </p>

        <div class="mt-24 flex justify-center">
            <a
                href="{{ route('needs') }}"
                class="inline-flex items-center gap-4 rounded-full bg-black text-white p-1 pr-8 text-sm font-medium hover:bg-gray-800 transition shadow-[0_4px_14px_rgba(0,0,0,0.15)]"
            >
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white text-black">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="22" y1="2" x2="11" y2="13" stroke-width="2" stroke-linecap="round"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                Find your needs
            </a>
        </div>
    </div>
</section>
@endsection