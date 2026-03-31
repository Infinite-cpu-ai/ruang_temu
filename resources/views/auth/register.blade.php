<x-guest-layout>
    <div
        class="relative rounded-[2.5rem] border border-white/40 bg-white/70 backdrop-blur-xl p-8 sm:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">

        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-gray-900/5 rounded-bl-full -z-10"></div>

        <div class="mb-10 text-center relative z-10">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-3">Buat Akun</h1>
            <p class="text-sm font-medium text-gray-500 max-w-sm mx-auto">
                Daftar sebagai klien untuk mencari arsitek, atau sebagai arsitek untuk menawarkan jasa.
            </p>
        </div>

        <!-- Role Switcher -->
        <div class="relative z-10 mb-8" x-data="{ role: '{{ old('role', 'user') }}' }">
            <div class="flex rounded-2xl bg-gray-100 p-1 gap-1">
                <button type="button" @click="role = 'user'"
                    :class="role === 'user' ? 'bg-gray-900 shadow-sm text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200'"
                    class="flex-1 flex items-center justify-center gap-2 rounded-xl py-2.5 text-sm font-bold transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Saya Klien
                </button>
                <button type="button" @click="role = 'architect'"
                    :class="role === 'architect' ? 'bg-gray-900 shadow-sm text-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200'"
                    class="flex-1 flex items-center justify-center gap-2 rounded-xl py-2.5 text-sm font-bold transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Saya Arsitek
                </button>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf
                <input type="hidden" name="role" :value="role">

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        autocomplete="name"
                        class="block w-full rounded-2xl border-gray-200 bg-white/80 px-4 py-3 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm text-sm"
                        placeholder="John Doe">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="username"
                        class="block w-full rounded-2xl border-gray-200 bg-white/80 px-4 py-3 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm text-sm"
                        placeholder="nama@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full rounded-2xl border-gray-200 bg-white/80 px-4 py-3 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm text-sm"
                        placeholder="Minimal 8 karakter">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi
                        Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password"
                        class="block w-full rounded-2xl border-gray-200 bg-white/80 px-4 py-3 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm text-sm"
                        placeholder="Ulangi password di atas">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs" />
                </div>

                <!-- Context note -->
                <div x-show="role === 'architect'"
                    class="rounded-2xl bg-gray-50 border border-gray-100 px-4 py-3 text-xs text-gray-500 font-medium"
                    x-cloak>
                    🏛️ Setelah daftar, lengkapi profil arsitek Anda di dashboard agar bisa ditemukan oleh klien.
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center gap-2 rounded-full border border-transparent bg-gray-900 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-gray-900/20 hover:bg-black focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-all active:scale-[0.98]">
                        <span x-text="role === 'architect' ? 'Daftar sebagai Arsitek' : 'Daftar sebagai Klien'">Daftar
                            sebagai Klien</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-10 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm font-medium text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}"
                        class="font-bold text-gray-900 hover:underline decoration-2 underline-offset-4 ml-1">Masuk di
                        sini</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>