<header
    class="w-full border-b border-gray-100 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="h-20 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="text-sm font-semibold tracking-wide text-gray-900">
                RUANG TEMU
            </a>

            <nav class="hidden md:flex items-center gap-10 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-gray-900 transition">Home</a>
                <a href="{{ route('needs') }}" class="hover:text-gray-900 transition">Features</a>
                <a href="{{ route('quick-ask.index') }}"
                    class="hover:text-black-900 text-gray-900 font-semibold transition">Tanya Arsitek (Live)</a>
                <a href="{{ route('about') }}" class="hover:text-gray-900 transition">About Us</a>
                <a href="{{ route('contact') }}" class="hover:text-gray-900 transition">Contact</a>
            </nav>

            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="text-sm font-medium text-gray-900 border border-gray-200 rounded-full px-4 py-2 hover:bg-gray-50 transition">
                        Register
                    </a>
                @endguest

                @auth
                    @if(auth()->user()->isPremium())
                        <div class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-900 border border-transparent shadow-sm">
                            <span class="text-[10px] font-bold text-white tracking-widest uppercase">Premium</span>
                        </div>
                    @else
                        <a href="{{ route('upgrade.index') }}" class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-gray-200 hover:bg-gray-50 transition shadow-sm">
                            <span class="text-[10px] font-bold text-gray-600 tracking-widest uppercase">Upgrade</span>
                        </a>
                    @endif

                    <details class="relative group">
                        <summary
                            class="list-none w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-900 hover:bg-gray-50 transition cursor-pointer"
                            aria-label="Account menu">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </summary>

                        <div
                            class="absolute right-0 mt-2 w-44 rounded-xl border border-gray-100 bg-white shadow-lg overflow-hidden">
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </details>
                @endauth
            </div>
        </div>
    </div>
</header>