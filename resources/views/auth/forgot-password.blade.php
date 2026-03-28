<x-guest-layout>
    <div class="rounded-2xl border border-gray-100 bg-white p-8 sm:p-10 shadow-sm">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">Lupa password</h1>
            <p class="mt-2 text-sm text-gray-400">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>
        </div>

        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full justify-center">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
