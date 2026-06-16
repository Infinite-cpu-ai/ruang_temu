@extends('layouts.landing')

@section('content')
<div class="max-w-7xl mx-auto min-h-[calc(100vh-160px)] py-6 px-4 sm:px-6 lg:px-8" x-data="chatComponent()">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm min-h-[560px] h-[calc(100vh-200px)] sm:h-[calc(100vh-180px)] flex overflow-hidden max-h-[820px]">
        <!-- Contact list -->
        <div class="w-full sm:w-[360px] shrink-0 border-r border-gray-100 bg-gray-50/80 flex flex-col">
            <div class="p-4 border-b border-gray-100 bg-white">
                <h2 class="text-lg font-semibold tracking-tight text-gray-900">Pesan</h2>
                <p class="text-xs text-gray-500 mt-0.5">Pilih kontak untuk mulai mengobrol</p>
            </div>
            <div class="flex-1 overflow-y-auto">
                @forelse($contacts as $contact)
                    @php
                        $contactAvatar = $contact->role == 'architect' && $contact->architectProfile 
                            ? $contact->architectProfile->profile_image_url 
                            : $contact->profile_image_url;
                        $isActive = $targetUser?->id === $contact->id;
                    @endphp
                    <a
                        href="{{ route('chat.index', $contact->id) }}"
                        class="block px-4 py-3 border-b border-gray-100/80 transition {{ $isActive ? 'bg-white shadow-[inset_3px_0_0_0_#111827]' : 'hover:bg-white/90' }}"
                    >
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden border border-gray-200 bg-gray-100">
                                <img src="{{ $contactAvatar }}" alt="" class="w-full h-full object-cover" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $contact->name }}</p>
                                <p class="text-xs truncate {{ $isActive ? 'text-gray-900 font-medium' : 'text-gray-500' }}">
                                    {{ $contact->role == 'architect' ? 'Arsitek' : 'Klien' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-6 text-center text-sm text-gray-500">
                        Belum ada kontak. Untuk klien, daftar arsitek aktif akan muncul di sini setelah tersedia di sistem.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Thread -->
        <div class="flex-1 flex flex-col bg-white min-w-0">
            @if($targetUser)
            @php
                $headerAvatar = $targetUser->role == 'architect' && $targetUser->architectProfile 
                    ? $targetUser->architectProfile->profile_image_url 
                    : $targetUser->profile_image_url;
            @endphp
            <div x-show="!selectionMode" class="px-4 py-3 border-b border-gray-100 flex items-center justify-between gap-3 bg-white">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-200 bg-gray-50 shrink-0">
                        <img src="{{ $headerAvatar }}" alt="" class="w-full h-full object-cover" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $targetUser->name }}</p>
                        <p class="text-xs text-gray-500">{{ $targetUser->role == 'architect' ? 'Arsitek' : 'Klien' }}</p>
                    </div>
                </div>
                @if($targetUser->role == 'architect')
                    <a
                        href="{{ route('checkout.index', $targetUser->id) }}"
                        class="shrink-0 text-xs font-medium bg-gray-900 text-white px-3 py-2 rounded-full hover:bg-gray-800 transition"
                    >
                        Pesan desain
                    </a>
                @endif
            </div>

            <!-- Action Bar (Selection Mode) -->
            <div x-show="selectionMode" x-cloak class="px-4 py-3 border-b border-gray-100 flex items-center justify-between gap-3 bg-gray-900 text-white transition-all">
                <div class="flex items-center gap-3">
                    <button @click="cancelSelection" class="p-2 -ml-2 rounded-full hover:bg-gray-800 transition text-gray-300 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <span class="font-bold text-sm" x-text="selectedMessages.length + ' dipilih'"></span>
                </div>
                <button @click="deleteSelected" class="p-2 -mr-2 rounded-full hover:bg-red-500/20 text-red-400 transition" title="Hapus pesan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50/50" id="chat-messages">
                <template x-for="msg in messages" :key="msg.id">
                    <div>
                        <div
                            class="flex flex-col gap-1 relative"
                            :class="[
                                parseInt(msg.sender_id, 10) === parseInt(myId, 10) ? 'items-end' : 'items-start',
                                parseInt(msg.sender_id, 10) === parseInt(myId, 10) ? 'cursor-pointer' : ''
                            ]"
                            @touchstart="startPress(msg.id, msg.sender_id)"
                            @touchend="cancelPress"
                            @touchmove="cancelPress"
                            @mousedown="startPress(msg.id, msg.sender_id)"
                            @mouseup="cancelPress"
                            @mouseleave="cancelPress"
                            @contextmenu.prevent="startPress(msg.id, msg.sender_id); cancelPress()"
                            @click="selectionMode && parseInt(msg.sender_id, 10) === parseInt(myId, 10) ? toggleSelect(msg.id) : null"
                        >
                            <!-- Selection Overlay -->
                            <div x-show="selectionMode && parseInt(msg.sender_id, 10) === parseInt(myId, 10)" 
                                 class="absolute inset-0 z-10 rounded-2xl flex items-center justify-center transition-colors border-2"
                                 :class="selectedMessages.includes(msg.id) ? 'bg-black/20 border-gray-900' : 'bg-transparent border-transparent'"
                            >
                                <div x-show="selectedMessages.includes(msg.id)" class="absolute -top-2 -right-2 bg-gray-900 text-white rounded-full p-0.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>

                            <div
                                class="px-4 py-2.5 max-w-[85%] sm:max-w-md text-sm leading-relaxed shadow-sm transition-opacity"
                                :class="[
                                    parseInt(msg.sender_id, 10) === parseInt(myId, 10)
                                        ? 'bg-gray-900 text-white rounded-2xl rounded-br-md'
                                        : 'bg-white text-gray-900 border border-gray-100 rounded-2xl rounded-bl-md',
                                    selectionMode && parseInt(msg.sender_id, 10) === parseInt(myId, 10) && !selectedMessages.includes(msg.id) ? 'opacity-70' : 'opacity-100'
                                ]"
                            >
                                <span x-text="msg.message"></span>
                            </div>
                            <div
                                class="flex items-center gap-1 px-0.5"
                                x-show="parseInt(msg.sender_id, 10) === parseInt(myId, 10)"
                            >
                                <span
                                    class="inline-flex items-center justify-center"
                                    x-html="receiptMarkup(msg)"
                                    :title="receiptTitle(msg)"
                                ></span>
                            </div>
                        </div>
                    </div>
                </template>
                <div x-show="messages.length === 0" class="text-center text-gray-400 mt-10 text-sm">
                    Mulai konsultasi dengan {{ $targetUser->name }}…
                </div>
            </div>

            <div class="p-4 bg-white border-t border-gray-100">
                <form class="flex gap-2 items-center" @submit.prevent="sendMessage">
                    <label class="sr-only" for="chat-input">Pesan</label>
                    <input
                        id="chat-input"
                        type="text"
                        x-model="newMessage"
                        placeholder="Ketik pesan…"
                        class="flex-1 min-w-0 border border-gray-200 rounded-full shadow-sm focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 bg-white"
                        autocomplete="off"
                        required
                    />
                    <button
                        type="submit"
                        class="shrink-0 bg-gray-900 text-white rounded-full p-2.5 w-11 h-11 flex items-center justify-center hover:bg-gray-800 transition disabled:opacity-50"
                        :disabled="isSending"
                        aria-label="Kirim"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 ml-0.5">
                            <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                        </svg>
                    </button>
                </form>
            </div>
            @else
            <div class="flex-1 flex flex-col items-center justify-center bg-gray-50/50 p-8 text-center">
                <svg class="w-14 h-14 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <p class="text-gray-600 text-sm max-w-xs">Pilih kontak di daftar kiri untuk membuka percakapan.</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('chatComponent', () => ({
        messages: @json($messages ?? []),
        newMessage: '',
        targetId: @json($targetUser?->id),
        isSending: false,
        myId: {{ auth()->id() ?? 'null' }},
        
        selectionMode: false,
        selectedMessages: [],
        pressTimer: null,

        init() {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (token) {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            }

            this.scrollToBottom();

            if (!window.Echo || !this.myId) {
                return;
            }

            window.Echo.private('chat.' + this.myId)
                .listen('.MessageSent', (e) => {
                    const m = e.message;
                    if (m.sender_id == this.targetId || m.receiver_id == this.targetId) {
                        if (!this.messages.some((row) => row.id === m.id)) {
                            this.messages.push(m);
                        }
                        this.scrollToBottom();
                    }
                    if (parseInt(m.receiver_id, 10) === parseInt(this.myId, 10) && parseInt(m.sender_id, 10) === parseInt(this.targetId, 10)) {
                        axios.post('/chat/receipt/delivered', { message_id: m.id }).catch(() => {});
                    }
                })
                .listen('.MessageReceiptUpdated', (e) => {
                    this.applyReceiptPatch(e.message);
                    this.scrollToBottom();
                })
                .listen('.MessagesDeleted', (e) => {
                    const deletedIds = e.messageIds || [];
                    this.messages = this.messages.filter(m => !deletedIds.includes(m.id));
                    
                    // Filter selection if active
                    this.selectedMessages = this.selectedMessages.filter(id => !deletedIds.includes(id));
                    if (this.selectedMessages.length === 0) {
                        this.selectionMode = false;
                    }
                });
        },

        applyReceiptPatch(patch) {
            const id = patch.id;
            const i = this.messages.findIndex((row) => row.id === id);
            if (i === -1) {
                return;
            }
            const next = { ...this.messages[i] };
            if (patch.delivered_at !== undefined) {
                next.delivered_at = patch.delivered_at;
            }
            if (patch.read_at !== undefined) {
                next.read_at = patch.read_at;
            }
            if (patch.is_read !== undefined) {
                next.is_read = patch.is_read;
            }
            this.messages.splice(i, 1, next);
        },

        receiptTitle(msg) {
            if (msg.read_at) {
                return 'Dibaca';
            }
            if (msg.delivered_at) {
                return 'Diterima di perangkat penerima';
            }
            return 'Terkirim';
        },

        receiptMarkup(msg) {
            if (msg.read_at) {
                return '<span class="text-xs font-bold leading-none tracking-tight text-blue-600 tabular-nums select-none" aria-hidden="true">✓✓</span>';
            }
            if (msg.delivered_at) {
                return '<span class="text-xs font-bold leading-none tracking-tight text-gray-400 tabular-nums select-none" aria-hidden="true">✓✓</span>';
            }
            return '<span class="text-xs font-bold text-gray-400 select-none" aria-hidden="true">✓</span>';
        },

        sendMessage() {
            if (this.newMessage.trim() === '' || !this.targetId || this.isSending) {
                return;
            }

            this.isSending = true;
            axios
                .post('/chat/send', {
                    receiver_id: this.targetId,
                    message: this.newMessage,
                })
                .then((response) => {
                    this.messages.push(response.data);
                    this.newMessage = '';
                    this.scrollToBottom();
                })
                .catch((error) => {
                    console.error('Gagal mengirim pesan', error);
                })
                .finally(() => {
                    this.isSending = false;
                });
        },

        startPress(msgId, senderId) {
            if (parseInt(senderId, 10) !== parseInt(this.myId, 10)) return;
            
            if (this.selectionMode) {
                // If already in selection mode, let the @click handle it
                return;
            }

            this.pressTimer = setTimeout(() => {
                this.selectionMode = true;
                this.selectedMessages.push(msgId);
                // Vibrate for feedback if supported
                if (navigator.vibrate) navigator.vibrate(50);
            }, 500);
        },

        cancelPress() {
            if (this.pressTimer) {
                clearTimeout(this.pressTimer);
                this.pressTimer = null;
            }
        },

        toggleSelect(msgId) {
            const index = this.selectedMessages.indexOf(msgId);
            if (index > -1) {
                this.selectedMessages.splice(index, 1);
                if (this.selectedMessages.length === 0) {
                    this.selectionMode = false;
                }
            } else {
                this.selectedMessages.push(msgId);
            }
        },

        cancelSelection() {
            this.selectionMode = false;
            this.selectedMessages = [];
        },

        deleteSelected() {
            if (this.selectedMessages.length === 0) return;
            
            if (!confirm('Hapus ' + this.selectedMessages.length + ' pesan? Pesan akan dihapus secara permanen untuk kedua belah pihak.')) return;

            axios.delete('/chat/messages', {
                data: { message_ids: this.selectedMessages }
            }).then(response => {
                const deletedIds = response.data.deleted_ids || [];
                this.messages = this.messages.filter(m => !deletedIds.includes(m.id));
                this.cancelSelection();
            }).catch(error => {
                alert('Gagal menghapus pesan.');
                console.error(error);
            });
        },

        scrollToBottom() {
            setTimeout(() => {
                const box = document.getElementById('chat-messages');
                if (box) {
                    box.scrollTop = box.scrollHeight;
                }
            }, 50);
        },
    }));
});
</script>
@endpush
@endsection
