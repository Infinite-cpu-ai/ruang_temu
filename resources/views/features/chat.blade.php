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
            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between gap-3 bg-white">
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

            <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50/50" id="chat-messages">
                <template x-for="msg in messages" :key="msg.id">
                    <div>
                        <div
                            class="flex flex-col gap-1"
                            :class="parseInt(msg.sender_id, 10) === parseInt(myId, 10) ? 'items-end' : 'items-start'"
                        >
                            <div
                                class="px-4 py-2.5 max-w-[85%] sm:max-w-md text-sm leading-relaxed shadow-sm"
                                :class="parseInt(msg.sender_id, 10) === parseInt(myId, 10)
                                    ? 'bg-gray-900 text-white rounded-2xl rounded-br-md'
                                    : 'bg-white text-gray-900 border border-gray-100 rounded-2xl rounded-bl-md'"
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
