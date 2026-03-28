<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RUANG TEMU</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
</head>
<body class="bg-white text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col">
        @include('layouts.partials.navbar')

        <main class="flex-1 flex flex-col items-center justify-center px-6 py-12 sm:py-16">
            <div class="w-full max-w-md">
                {{ $slot }}

                <p class="mt-8 text-center text-sm text-gray-400">
                    <a href="{{ route('home') }}" class="hover:text-gray-900 transition">← Kembali ke beranda</a>
                </p>
            </div>
        </main>
    </div>
</body>
</html>
