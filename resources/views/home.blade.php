@extends('layouts.landing')

@section('content')
<section class="pt-32 pb-24">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center">
            <h1 class="text-6xl font-black tracking-tight text-gray-900 leading-none">
                Where Great<br class="hidden sm:block" />
                Architecture Begins
            </h1>
            <p class="mt-6 text-sm text-gray-400 max-w-2xl mx-auto">
                Tempat kamu mencari, bertanya, konsultasi dan membangun - langsung dengan arsitek pilihan mu
            </p>

            <div class="mt-10 flex justify-center">
                <a
                    href="{{ route('needs') }}"
                    class="inline-flex items-center gap-3 rounded-full bg-black text-white px-6 py-3 text-sm font-medium hover:bg-gray-800 transition"
                >
                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full border-2 border-white">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="22" y1="2" x2="11" y2="13" stroke-width="2" stroke-linecap="round"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    Find your needs
                </a>
            </div>
        </div>
    </div>
</section>
@endsection