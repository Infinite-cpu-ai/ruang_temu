@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($user->role === 'user' && $followedArchitects->isNotEmpty())
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900">Arsitek yang Anda ikuti</h3>
                <p class="mt-1 text-sm text-gray-500">Hanya arsitek berikut yang tercantum di obrolan Anda.</p>
                <ul class="mt-6 divide-y divide-gray-100 border-t border-b border-gray-100">
                    @foreach($followedArchitects as $architect)
                        @php
                            $avatar = asset('images/profiles/profile_placeholder.png');
                            if (filled(data_get($architect->architectProfile, 'profile_image'))) {
                                $avatar = $architect->architectProfile->profile_image;
                            }
                        @endphp
                        <li class="flex items-center gap-4 py-4">
                            <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border border-gray-200 bg-gray-50">
                                <img src="{{ $avatar }}" alt="" class="h-full w-full object-cover" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-gray-900 truncate">{{ $architect->name }}</p>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ data_get($architect->architectProfile, 'specialization') ?: 'Arsitek' }}
                                </p>
                            </div>
                            <div class="flex shrink-0 flex-col gap-2 sm:flex-row sm:items-center">
                                <a href="{{ route('features.profil', $architect->id) }}" class="text-xs font-medium text-gray-900 underline decoration-gray-300 underline-offset-2 hover:decoration-gray-900">
                                    Profil
                                </a>
                                <a href="{{ route('chat.index', $architect->id) }}" class="rounded-full bg-gray-900 px-3 py-1.5 text-xs font-medium text-white hover:bg-gray-800">
                                    Chat
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
