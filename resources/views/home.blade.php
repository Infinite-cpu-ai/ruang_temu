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
        <a href="{{ route('needs') }}"
            class="inline-flex items-center gap-3 bg-black text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-800 transition-colors">
                <span class="w-7 h-7 rounded-full border-2 border-white flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </span>
                Find your needs
            </a>
    </div>
</section>
@endsection