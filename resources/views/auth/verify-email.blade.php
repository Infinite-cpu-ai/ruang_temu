<x-guest-layout>
    <div class="rounded-2xl border border-gray-100 bg-white p-8 sm:p-10 shadow-sm">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">Verifikasi email</h1>
            <p class="mt-2 text-sm text-gray-400">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-800">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                @csrf
                <x-primary-button class="w-full justify-center">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full sm:w-auto text-sm text-gray-500 hover:text-gray-900 transition py-2.5 text-center">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
