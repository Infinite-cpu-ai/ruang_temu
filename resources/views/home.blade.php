@extends('layouts.landing')

@section('content')
<section class="pt-20 pb-24">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center">
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-gray-900 leading-[1.05]">
                Where Great<br class="hidden sm:block" />
                Architecture Begins
            </h1>
            <p class="mt-6 text-sm sm:text-base text-gray-400 max-w-2xl mx-auto">
                Tempat kamu mencari, bertanya, konsultasi dan membangun - langsung dengan arsitek pilihan mu
            </p>

            <div class="mt-10 flex justify-center">
                <a
                    href="{{ route('needs') }}"
                    class="inline-flex items-center gap-3 rounded-full bg-black text-white px-7 py-3 text-sm font-medium shadow-sm hover:bg-gray-900 transition"
                >
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-white/10">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2L11 13"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2l-7 20-4-9-9-4 20-7z"></path>
                        </svg>
                    </span>
                    Find your needs
                </a>
            </div>
        </div>
    </div>
</section>
@endsection