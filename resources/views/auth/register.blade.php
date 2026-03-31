<x-guest-layout>
    <div class="relative rounded-[2.5rem] border border-white/40 bg-white/70 backdrop-blur-xl p-8 sm:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-gray-900/5 rounded-bl-full -z-10"></div>
        
        <div class="mb-10 text-center relative z-10">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-3">Buat Akun</h1>
            <p class="text-sm font-medium text-gray-500 max-w-sm mx-auto">
                Daftar sekarang untuk mulai mencari arsitek dan berkonsultasi di RUANG TEMU.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6 relative z-10">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                    class="block w-full rounded-2xl border-gray-200 bg-white/80 px-4 py-3 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm text-sm" placeholder="John Doe">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                    class="block w-full rounded-2xl border-gray-200 bg-white/80 px-4 py-3 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm text-sm" placeholder="nama@email.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" 
                    class="block w-full rounded-2xl border-gray-200 bg-white/80 px-4 py-3 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm text-sm" placeholder="Minimal 8 karakter">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                    class="block w-full rounded-2xl border-gray-200 bg-white/80 px-4 py-3 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900 transition shadow-sm text-sm" placeholder="Ulangi password di atas">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs" />
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full inline-flex justify-center items-center gap-2 rounded-full border border-transparent bg-gray-900 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-gray-900/20 hover:bg-black focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-all active:scale-[0.98]">
                    Daftar Akun Baru
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>

        <div class="mt-10 pt-6 border-t border-gray-100 text-center relative z-10">
            <p class="text-sm font-medium text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-gray-900 hover:underline decoration-2 underline-offset-4 ml-1">Masuk di sini</a>
            </p>
        </div>
    </div>
</x-guest-layout>
