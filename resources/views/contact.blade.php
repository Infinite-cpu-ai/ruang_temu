@extends('layouts.landing')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start pt-32 px-4">
    
    {{-- Logo & Brand --}}
    <div class="text-center mb-10">
        <img src="{{ asset('images/assets/Logo Ruang Temu.png') }}" alt="Ruang Temu" class="h-32 sm:h-40 mx-auto object-contain">
    </div>

    {{-- Contact Info - Horizontal --}}
    <div class="flex flex-wrap justify-center gap-8 text-gray-400 text-sm mb-12">
        <span>Instagram: ...</span>
        <span>Gmail: ...</span>
        <span>Fax: ...</span>
        <span>Linkidn: ...</span>
    </div>

    {{-- CTA Button --}}
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
@endsection