<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RUANG TEMU</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/assets/favicon-rounded.png') }}">
</head>
<body class="bg-[#FAFAFA] text-gray-900 antialiased relative overflow-x-hidden min-h-screen">
    <!-- Premium Global Decorative Blobs -->
    <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-gray-200/50 to-transparent blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-gradient-to-tl from-gray-200/50 to-transparent blur-3xl"></div>
    </div>

    <div class="min-h-screen flex flex-col relative z-10 font-[Inter]">
        @include('layouts.partials.navbar')

        <main class="flex-1 flex flex-col items-center justify-center px-6 py-12 sm:py-20 mt-16 sm:mt-24">
            <div class="w-full max-w-md animate-fade-in-up">
                {{ $slot }}

                <p class="mt-8 text-center text-sm text-gray-400 font-medium">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 hover:text-black transition-colors duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke beranda
                    </a>
                </p>
            </div>
        </main>
    </div>
</body>
</html>
