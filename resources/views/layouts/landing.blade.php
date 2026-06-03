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
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/assets/logo-ruang-temu.png') }}">
</head>
<body class="bg-white text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col">
        @include('layouts.partials.navbar')

        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>

