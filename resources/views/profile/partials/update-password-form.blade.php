<section>
    <div class="mb-6">
        <h2 class="text-base font-extrabold text-gray-900">Ubah Password</h2>
        <p class="mt-1 text-sm text-gray-400 font-medium">Gunakan password yang panjang dan acak agar akun tetap aman.</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <label for="update_password_current_password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                Password Saat Ini
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                   autocomplete="current-password"
                   class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm" />
            @error('current_password', 'updatePassword')
                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- New Password --}}
        <div>
            <label for="update_password_password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                Password Baru
            </label>
            <input id="update_password_password" name="password" type="password"
                   autocomplete="new-password"
                   class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm" />
            @error('password', 'updatePassword')
                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                Konfirmasi Password Baru
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                   autocomplete="new-password"
                   class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm" />
            @error('password_confirmation', 'updatePassword')
                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Save --}}
        <div class="flex items-center gap-4 pt-1">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-2xl bg-gray-900 px-6 py-3 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] shadow-sm">
                Simpan Password
            </button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2500)"
                   class="text-sm font-semibold text-emerald-600 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Password diperbarui!
                </p>
            @endif
        </div>
    </form>
</section>
