@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Architect Dashboard') }}
        </h2>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Selamat datang di Dashboard Arsitek!
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ubah Profile Arsitek -->
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold mb-4">Pengaturan Profil Arsitek</h3>
                    <p class="text-gray-600 mb-4">Kelola harga per m², spesialisasi, gaya desain, dan deskripsi publik Anda.</p>
                    <a href="{{ route('architect.profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block">Ubah Profil Publik</a>
                </div>

                <!-- Pengaturan Akun Dasar -->
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-gray-500">
                    <h3 class="text-lg font-bold mb-4">Pengaturan Akun Dasar</h3>
                    <p class="text-gray-600 mb-4">Kelola Username, Kata sandi, dan Foto Profil Global Anda.</p>
                    <a href="{{ route('profile.edit') }}" class="bg-gray-500 text-white px-4 py-2 rounded inline-block">Ubah Akun</a>
                </div>

                <!-- CRUD Portofolio -->
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-indigo-500">
                    <h3 class="text-lg font-bold mb-4">Portofolio Karyamu</h3>
                    <p class="text-gray-600 mb-4">Tambahkan proyek dan portofolio untuk menarik lebih banyak klien.</p>
                    <a href="{{ route('architect.portfolios.index') }}" class="bg-indigo-500 text-white px-4 py-2 rounded inline-block">Kelola Portofolio</a>
                </div>

                <!-- Status Project -->
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <h3 class="text-lg font-bold mb-4">Status Proyek</h3>
                    <p class="text-gray-600 mb-4">Kelola status proyek dari klien (Pending, On Progress, Done)</p>
                    <a href="{{ route('architect.projects.index') }}" class="bg-green-500 text-white px-4 py-2 rounded inline-block">Lihat Proyek Aktif</a>
                </div>

                <!-- Message -->
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
                    <h3 class="text-lg font-bold mb-4">Kotak Masuk</h3>
                    <p class="text-gray-600 mb-4">Lihat pesan yang masuk dari klien.</p>
                    <a href="{{ route('chat.index') }}" class="bg-purple-500 text-white px-4 py-2 rounded inline-block">Buka Obrolan</a>
                </div>

                <!-- Pendapatan & Review -->
                <div class="bg-white p-6 rounded-lg shadow md:col-span-2 border-l-4 border-yellow-500">
                    <h3 class="text-lg font-bold mb-2">Riwayat Ulasan & Pendapatan</h3>
                    <p class="text-xl text-green-600 font-bold mb-4">Total Pendapatan (Proyek Selesai): Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    <a href="{{ route('architect.reviews.index') }}" class="bg-yellow-500 text-white px-4 py-2 rounded inline-block">Lihat Ulasan Klien</a>
                </div>
            </div>
        </div>
    </div>
@endsection
