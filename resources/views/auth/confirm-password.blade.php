<x-guest-layout>
    <div class="rounded-2xl border border-gray-100 bg-white p-8 sm:p-10 shadow-sm">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">Konfirmasi password</h1>
            <p class="mt-2 text-sm text-gray-400">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-2 w-full"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full justify-center">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
