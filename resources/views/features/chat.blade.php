@extends('layouts.landing')

@section('content')
<div class="max-w-7xl mx-auto h-[calc(100vh-160px)] py-6 px-4 sm:px-6 lg:px-8" x-data="chatComponent()">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full flex overflow-hidden">
        
        <!-- Contact List (Left Sidebar) -->
        <div class="w-1/3 border-r border-gray-200 bg-gray-50 flex flex-col">
            <div class="p-4 border-b border-gray-200 bg-white">
                <h2 class="text-xl font-bold text-gray-800">Pesan</h2>
            </div>
            <div class="flex-1 overflow-y-auto">
                @forelse($contacts as $contact)
                    @php
                        $contactAvatar = asset('images/profiles/profile_placeholder.png');
                        if (filled(data_get($contact->architectProfile, 'profile_image'))) {
                            $contactAvatar = $contact->architectProfile->profile_image;
                        }
                    @endphp
                    <a href="{{ route('chat.index', $contact->id) }}" class="block p-4 border-b border-gray-100 {{ $targetUser?->id === $contact->id ? 'bg-indigo-50' : 'hover:bg-gray-100' }} cursor-pointer transition">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden border border-gray-200 bg-gray-50">
                                <img src="{{ $contactAvatar }}" alt="" class="w-full h-full object-cover" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900">{{ $contact->name }}</p>
                                <p class="text-xs text-{{ $targetUser?->id === $contact->id ? 'indigo-600' : 'gray-500' }} truncate">{{ $contact->role == 'architect' ? 'Arsitek' : 'Klien' }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-sm text-gray-500">
                        Belum ada obrolan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Window (Right Sidebar) -->
        <div class="w-2/3 flex flex-col bg-white">
            @if($targetUser)
            @php
                $headerAvatar = asset('images/profiles/profile_placeholder.png');
                if (filled(data_get($targetUser->architectProfile, 'profile_image'))) {
                    $headerAvatar = $targetUser->architectProfile->profile_image;
                }
            @endphp
            <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-white shadow-sm z-10">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-200 bg-gray-50 shrink-0">
                        <img src="{{ $headerAvatar }}" alt="" class="w-full h-full object-cover" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-gray-900">{{ $targetUser->name }}</p>
                        <p class="text-xs text-green-500 font-medium">Active (WebSocket)</p>
                    </div>
                </div>
                @if($targetUser->role == 'architect')
                    <a href="{{ route('checkout.index', $targetUser->id) }}" class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">Pesan Sekarang</a>
                @endif
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-slate-50" id="chat-messages">
                <template x-for="msg in messages" :key="msg.id">
                    <div class="flex" :class="msg.sender_id == {{ auth()->id() ?? 'null' }} ? 'items-end justify-end' : 'items-start'">
                        <div 
                            class="px-4 py-2 max-w-md text-sm shadow-sm"
                            :class="msg.sender_id == {{ auth()->id() ?? 'null' }} ? 'bg-indigo-600 text-white rounded-bl-xl rounded-tr-xl rounded-tl-xl' : 'bg-white border border-gray-200 text-gray-800 rounded-br-xl rounded-tr-xl rounded-tl-xl'"
                            x-text="msg.message"
                        >
                        </div>
                    </div>
                </template>
                <div x-show="messages.length === 0" class="text-center text-gray-400 mt-10 text-sm">
                    Mulai konsultasi dengan {{ $targetUser->name }}...
                </div>
            </div>

            <!-- Chat Input form -->
            <div class="p-4 bg-white border-t border-gray-200">
                <form class="flex space-x-2" @submit.prevent="sendMessage">
                    <input type="text" x-model="newMessage" placeholder="Ketik pesan konsultasi..." class="flex-1 border-gray-300 rounded-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4" required>
                    <button type="submit" class="bg-indigo-600 text-white rounded-full p-2 w-10 h-10 flex items-center justify-center hover:bg-indigo-700 transition" :disabled="isSending">
                        <svg class="w-5 h-5 -ml-1 mt-1 transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
            </div>
            @else
            <div class="flex-1 flex flex-col items-center justify-center bg-gray-50 h-full">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <p class="text-gray-500">Pilih profil arsitek untuk mulai berkonsultasi</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add AlpineJS and Axios via CDN to support real-time interactions easily -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('chatComponent', () => ({
        messages: @json($messages ?? []),
        newMessage: '',
        targetId: '{{ $targetUser?->id ?? '' }}',
        isSending: false,
        myId: {{ auth()->id() ?? 'null' }},

        init() {
            this.scrollToBottom();

            // Set up Laravel Echo listener if broadcasting is perfectly registered for front-end
            if (window.Echo && this.myId) {
                window.Echo.private('chat.' + this.myId)
                    .listen('MessageSent', (e) => {
                        if (e.message.sender_id == this.targetId || e.message.receiver_id == this.targetId) {
                            this.messages.push(e.message);
                            this.scrollToBottom();
                        }
                    });
            } else {
                console.log('Echo tidak terdeteksi, websocket front-end listener butuh kompilasi npm & echo import di app.js.');
            }
        },

        sendMessage() {
            if (this.newMessage.trim() === '' || !this.targetId || this.isSending) return;
            
            this.isSending = true;
            axios.post('/chat/send', {
                receiver_id: this.targetId,
                message: this.newMessage,
                _token: '{{ csrf_token() }}'
            }).then(response => {
                this.messages.push(response.data);
                this.newMessage = '';
                this.scrollToBottom();
            }).catch(error => {
                console.error("Gagal mengirim pesan", error);
            }).finally(() => {
                this.isSending = false;
            });
        },

        scrollToBottom() {
            setTimeout(() => {
                const box = document.getElementById('chat-messages');
                if(box) box.scrollTop = box.scrollHeight;
            }, 50);
        }
    }));
});
</script>
@endsection