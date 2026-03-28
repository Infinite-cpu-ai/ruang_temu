@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client Dashboard') }}
        </h2>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Selamat datang di Dashboard Klien/User!
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Transaction History -->
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold mb-4">Riwayat Transaksi & Proyek</h3>
                    <p class="text-gray-600 mb-4">Lacak perkembangan dan status desain bersama arsitek Anda.</p>
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('client.projects.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block">Lihat Semua Proyek</a>
                    </div>
                </div>

                <!-- Chat & Messages -->
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-indigo-500">
                    <h3 class="text-lg font-bold mb-4">Obrolan</h3>
                    <p class="text-gray-600 mb-4">Lanjutkan perbincangan dengan arsitek.</p>
                    <a href="{{ route('chat.index') }}" class="bg-indigo-500 text-white px-4 py-2 rounded inline-block">Buka Obrolan</a>
                </div>

                <!-- My Reviews -->
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                    <h3 class="text-lg font-bold mb-4">Ulasan Saya</h3>
                    <p class="text-gray-600 mb-4">Lihat atau ubah kembali ulasan yang telah Anda berikan kepada arsitek.</p>
                    <a href="{{ route('client.reviews.index') }}" class="bg-yellow-500 text-white px-4 py-2 rounded inline-block">Kelola Ulasan</a>
                </div>
                
                <!-- Profile -->
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-gray-500">
                    <h3 class="text-lg font-bold mb-4">Pengaturan Akun</h3>
                    <p class="text-gray-600 mb-4">Ubah detail profil atau kata sandi Anda di sini.</p>
                    <a href="{{ route('profile.edit') }}" class="bg-gray-500 text-white px-4 py-2 rounded inline-block">Ubah Profil</a>
                </div>
            </div>
        </div>
    </div>
@endsection
