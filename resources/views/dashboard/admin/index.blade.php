@extends('layouts.landing')

@section('content')
    <div class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as Admin!") }}
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Aktivitas/Users -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4">Manajemen Pengguna</h3>
                    <p class="text-gray-600 mb-4">Lihat aktivitas, nonaktifkan arsitek/user, dan lihat seluruh pengguna terdaftar.</p>
                    <a href="{{ route('admin.users.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block">Kelola Pengguna & Arsitek</a>
                </div>
                
                <!-- Spesialisasi -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4">Master Spesialisasi</h3>
                    <p class="text-gray-600 mb-4">Tambah, ubah, dan hapus atribut spesialisasi untuk arsitek.</p>
                    <a href="{{ route('admin.specializations.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block">Kelola Spesialisasi</a>
                </div>

                <!-- Reviews -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4">Manajemen Ulasan</h3>
                    <p class="text-gray-600 mb-4">Lihat ulasan masuk. Cek laporan/report ulasan yang dianggap bermasalah.</p>
                    <a href="{{ route('admin.reviews.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block">Cek Ulasan</a>
                </div>
            </div>
        </div>
    </div>
@endsection
