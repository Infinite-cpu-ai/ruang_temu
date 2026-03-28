<x-guest-layout>
    <div class="rounded-2xl border border-gray-100 bg-white p-8 sm:p-10 shadow-sm">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">Login</h1>
            <p class="mt-2 text-sm text-gray-400">
                Masuk untuk konsultasi dan kelola proyekmu di RUANG TEMU.
            </p>
        </div>

        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-2 w-full"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center">
                <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900" name="remember">
                    <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-500 hover:text-gray-900 transition text-center sm:text-left" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @else
                    <span></span>
                @endif

                <x-primary-button class="w-full sm:w-auto justify-center">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

        <p class="mt-8 text-center text-sm text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-gray-900 hover:underline">Register</a>
        </p>
    </div>
</x-guest-layout>
