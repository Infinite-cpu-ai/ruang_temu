<section class="space-y-5">
    <div>
        <h2 class="text-base font-extrabold text-red-700">Nonaktifkan Akun</h2>
        <p class="mt-1 text-sm text-red-500/80 font-medium">
            Setelah akun dinonaktifkan, kamu tidak bisa login kembali. Profil juga tidak akan muncul di pencarian publik.
        </p>
    </div>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 rounded-2xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-bold text-red-600 hover:bg-red-100 hover:border-red-300 transition active:scale-[0.97]">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
        </svg>
        Nonaktifkan Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-7">
            @csrf
            @method('delete')

            <div class="mb-6">
                <h2 class="text-lg font-extrabold text-gray-900">Nonaktifkan akun?</h2>
                <p class="mt-2 text-sm text-gray-500 font-medium leading-relaxed">
                    Setelah dikonfirmasi, kamu akan otomatis ter-logout dan akun tidak bisa diakses tanpa bantuan Admin.
                    Masukkan password kamu untuk konfirmasi.
                </p>
            </div>

            <div class="mb-5">
                <label for="delete_password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    Password
                </label>
                <input id="delete_password" name="password" type="password"
                       placeholder="Masukkan password kamu"
                       class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-red-400 transition shadow-sm" />
                @error('password', 'userDeletion')
                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="rounded-2xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="rounded-2xl bg-red-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-red-700 transition active:scale-[0.97]">
                    Ya, Nonaktifkan
                </button>
            </div>
        </form>
    </x-modal>
</section>
