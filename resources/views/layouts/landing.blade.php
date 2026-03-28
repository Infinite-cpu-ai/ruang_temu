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
        <header class="w-full">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">
                <div class="h-20 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="text-sm font-semibold tracking-wide text-gray-900">
                        RUANG TEMU
                    </a>

                    <nav class="hidden md:flex items-center gap-10 text-sm text-gray-500">
                        <a href="{{ route('home') }}" class="hover:text-gray-900 transition">Home</a>
                        <a href="{{ route('needs') }}" class="hover:text-gray-900 transition">Features</a>
                        <a href="{{ route('about') }}" class="hover:text-gray-900 transition">About Us</a>
                        <a href="{{ route('contact') }}" class="hover:text-gray-900 transition">Contact</a>
                    </nav>

                    <div class="flex items-center gap-3">
                        @guest
                            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">
                                Login
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="text-sm font-medium text-gray-900 border border-gray-200 rounded-full px-4 py-2 hover:bg-gray-50 transition"
                            >
                                Register
                            </a>
                        @endguest

                        @auth
                            <a
                                href="{{ route('profile.edit') }}"
                                class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-gray-900 hover:bg-gray-50 transition"
                                aria-label="Account"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1">
            @yield('content')
        </main>
    </div>
</body>
</html>

