@extends('layouts.landing')

@section('content')
<div class="max-w-7xl mx-auto h-[calc(100vh-160px)] py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full flex overflow-hidden">
        
        <!-- Contact List (Left Sidebar) -->
        <div class="w-1/3 border-r border-gray-200 bg-gray-50 flex flex-col">
            <div class="p-4 border-b border-gray-200 bg-white">
                <h2 class="text-xl font-bold text-gray-800">Pesan</h2>
            </div>
            <div class="flex-1 overflow-y-auto">
                <!-- Dummy Active Contact -->
                <div class="p-4 border-b border-gray-100 bg-indigo-50 cursor-pointer">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-indigo-200 rounded-full flex-shrink-0"></div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-900">Arsitek Dummy 1</p>
                            <p class="text-xs text-indigo-600 truncate">Halo, apakah bisa direvisi bagian...</p>
                        </div>
                    </div>
                </div>
                <!-- Dummy Inactive Contact -->
                <div class="p-4 border-b border-gray-100 hover:bg-gray-100 cursor-pointer transition">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0"></div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-700">Arsitek Dummy 2</p>
                            <p class="text-xs text-gray-500 truncate">Baik pak, terima kasih infonya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Window (Right Sidebar) -->
        <div class="w-2/3 flex flex-col bg-white">
            <div class="p-4 border-b border-gray-200 flex items-center bg-white shadow-sm z-10">
                <div class="w-10 h-10 bg-indigo-200 rounded-full"></div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-gray-900">Arsitek Dummy 1</p>
                    <p class="text-xs text-green-500 font-medium">Online</p>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-slate-50">
                <!-- Receiver Bubble -->
                <div class="flex items-start">
                    <div class="bg-white border border-gray-200 text-gray-800 rounded-br-xl rounded-tr-xl rounded-tl-xl px-4 py-2 max-w-md shadow-sm text-sm">
                        Halo, saya tertarik dengan portofolio Anda. Boleh konsultasi soal desain rumah 150m2?
                    </div>
                </div>
                <!-- Sender Bubble -->
                <div class="flex items-end justify-end shadow-sm">
                    <div class="bg-indigo-600 text-white rounded-bl-xl rounded-tr-xl rounded-tl-xl px-4 py-2 max-w-md text-sm">
                        Halo bapak! Tentu bisa, silahkan infokan kebutuhan ruangannya, nanti kita bisa jadwalkan meeting online.
                    </div>
                </div>
            </div>

            <!-- Chat Input form -->
            <div class="p-4 bg-white border-t border-gray-200">
                <form class="flex space-x-2">
                    <input type="text" placeholder="Ketik pesan..." class="flex-1 border-gray-300 rounded-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4">
                    <button type="button" class="bg-indigo-600 text-white rounded-full p-2 w-10 h-10 flex items-center justify-center hover:bg-indigo-700 transition">
                        <svg class="w-5 h-5 -ml-1 mt-1 transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection