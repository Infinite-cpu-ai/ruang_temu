@extends('layouts.landing')

@section('content')
<div class="relative min-h-screen bg-[#FAFAFA] overflow-x-hidden">
    {{-- Background blobs --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-gray-200/50 to-transparent blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-gradient-to-tl from-gray-200/50 to-transparent blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-6 py-14 pt-28">

        {{-- Header --}}
        <div class="mb-10">
            <p class="text-sm font-semibold text-gray-400 tracking-widest uppercase mb-2">Akun</p>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Pengaturan Profil</h1>
            <p class="mt-2 text-base text-gray-500 font-medium">Kelola informasi akun dan keamanan kamu.</p>
        </div>

        <div class="space-y-6">

            {{-- Followed Architects --}}
            @if($user->role === 'user' && $followedArchitects->isNotEmpty())
            <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="mb-5">
                    <h2 class="text-base font-extrabold text-gray-900">Arsitek yang Diikuti</h2>
                    <p class="mt-1 text-sm text-gray-400 font-medium">Arsitek berikut tersedia di kotak obrolan kamu.</p>
                </div>
                <ul class="space-y-3">
                    @foreach($followedArchitects as $architect)
                        @php
                            $avatar = asset('images/profiles/profile_placeholder.png');
                            if (filled(data_get($architect->architectProfile, 'profile_image'))) {
                                $avatar = $architect->architectProfile->profile_image;
                            }
                        @endphp
                        <li class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50/80 border border-gray-100 hover:bg-gray-100/80 transition">
                            <div class="h-11 w-11 shrink-0 overflow-hidden rounded-full border-2 border-white shadow-sm bg-gray-200">
                                <img src="{{ $avatar }}" alt="{{ $architect->name }}" class="h-full w-full object-cover" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-gray-900 text-sm truncate">{{ $architect->name }}</p>
                                <p class="text-xs text-gray-400 truncate font-medium">
                                    {{ data_get($architect->architectProfile, 'specialization') ?: 'Arsitek' }}
                                </p>
                            </div>
                            <div class="flex shrink-0 items-center gap-2">
                                <a href="{{ route('features.profil', $architect->id) }}"
                                   class="text-xs font-semibold text-gray-500 hover:text-gray-900 transition px-3 py-1.5 rounded-xl hover:bg-gray-200">
                                    Profil
                                </a>
                                <a href="{{ route('chat.index', $architect->id) }}"
                                   class="rounded-xl bg-gray-900 px-3 py-1.5 text-xs font-bold text-white hover:bg-black transition active:scale-[0.97]">
                                    Chat
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Profile Information --}}
            <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password --}}
            <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Danger Zone --}}
            @if ($user->role !== 'admin')
            <div class="rounded-[2rem] border border-red-100 bg-red-50/50 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                @include('profile.partials.delete-user-form')
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
