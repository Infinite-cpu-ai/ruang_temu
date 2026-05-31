@extends('layouts.landing')

@section('content')
<div class="relative min-h-screen bg-[#FAFAFA] overflow-x-hidden" x-data="quickAsk({ sessionId: '{{ $sessionId }}' })">
    <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-gray-200/50 to-transparent blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-gradient-to-tl from-gray-200/50 to-transparent blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-2xl mx-auto px-6 py-14 pt-28">

        {{-- Header --}}
        <div class="text-center mb-10">
            <p class="text-sm font-semibold text-gray-400 tracking-widest uppercase mb-2">Live</p>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Tanya Arsitek</h1>
            <p class="mt-2 text-base text-gray-500 font-medium">Tanyakan apapun seputar desain, material, atau konstruksi.</p>
        </div>

        {{-- Chat Card --}}
        <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl shadow-[0_4px_20px_rgb(0,0,0,0.04)] overflow-hidden">

            {{-- Messages --}}
            <div class="p-7 min-h-[320px] flex flex-col justify-between" id="chat-container">
                <div class="flex-1 overflow-y-auto space-y-4 mb-4" id="chat-messages">

                    {{-- Welcome --}}
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-gray-900 flex items-center justify-center text-white shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div class="rounded-2xl bg-gray-100 px-4 py-3 max-w-md">
                            <p class="text-sm text-gray-700 font-medium leading-relaxed">Halo! Arsitek profesional kami siap menjawab pertanyaanmu secara live. Apa yang ingin kamu tanyakan?</p>
                        </div>
                    </div>

                    {{-- User Question --}}
                    <div x-show="question" x-cloak class="flex items-end justify-end">
                        <div class="rounded-2xl bg-gray-900 px-4 py-3 max-w-md">
                            <p class="text-sm text-white font-medium" x-text="question?.content"></p>
                        </div>
                    </div>

                    {{-- Status: Waiting --}}
                    <div x-show="status === 'open'" x-cloak class="flex justify-center my-3">
                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 border border-amber-200 px-4 py-2 text-xs font-bold text-amber-700">
                            <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                            Menunggu arsitek online...
                        </span>
                    </div>

                    {{-- Status: Claimed --}}
                    <div x-show="status === 'claimed'" x-cloak class="flex justify-center my-3">
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 border border-emerald-200 px-4 py-2 text-xs font-bold text-emerald-700">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Arsitek sedang mengetik jawaban...
                        </span>
                    </div>

                    {{-- Answer --}}
                    <div x-show="answer" x-cloak class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-200 shrink-0">
                            <img :src="answer?.architect?.profile_image ? (answer.architect.profile_image.startsWith('http') ? answer.architect.profile_image : '/storage/'+answer.architect.profile_image) : '/images/profiles/profile_placeholder.png'"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="rounded-2xl bg-gray-50 border border-gray-100 px-4 py-3 max-w-md shadow-sm">
                            <p class="text-[10px] font-bold text-gray-900 uppercase tracking-wider mb-1.5 pb-1.5 border-b border-gray-100"
                               x-text="'Dijawab oleh ' + (answer?.architect?.name || 'Arsitek')"></p>
                            <p class="text-sm text-gray-700 font-medium leading-relaxed" x-text="answer?.content"></p>
                        </div>
                    </div>

                    {{-- Rating (after answer) --}}
                    <div x-show="answer && !rated" x-cloak class="mt-4">
                        <div class="rounded-2xl bg-gray-50 border border-gray-100 p-5 text-center">
                            <p class="text-sm font-bold text-gray-900 mb-3">Bagaimana jawabannya?</p>
                            <div class="flex justify-center gap-1 mb-3">
                                <template x-for="star in 5" :key="star">
                                    <button @click="selectedRating = star" type="button"
                                            class="text-2xl transition hover:scale-110"
                                            :class="star <= selectedRating ? 'text-amber-400' : 'text-gray-300'">
                                        ★
                                    </button>
                                </template>
                            </div>
                            <textarea x-model="ratingFeedback" rows="2" placeholder="Feedback singkat (opsional)..."
                                      class="w-full bg-white border-0 rounded-xl py-2 px-3 text-sm text-gray-700 font-medium focus:ring-2 focus:ring-black transition shadow-sm resize-none mb-3"></textarea>
                            <button @click="submitRating()" :disabled="selectedRating === 0"
                                    class="rounded-xl bg-gray-900 px-5 py-2 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] disabled:opacity-40">
                                Kirim Rating
                            </button>
                        </div>
                    </div>

                    {{-- Rated confirmation --}}
                    <div x-show="rated" x-cloak class="mt-4">
                        <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-4 text-center">
                            <p class="text-sm font-bold text-emerald-700">✅ Terima kasih atas ratingnya!</p>
                        </div>
                    </div>
                </div>

                {{-- Input Form --}}
                <div x-show="!question" x-cloak class="mt-auto border-t border-gray-100 pt-5">
                    <form @submit.prevent="submitQuestion" class="flex items-center gap-3">
                        <input type="text" x-model="inputContent"
                               class="flex-1 bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm"
                               placeholder="Ketik pertanyaanmu di sini...">
                        <button type="submit" :disabled="loading || inputContent.trim() === ''"
                                class="rounded-2xl bg-gray-900 px-5 py-3 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] disabled:opacity-40 shrink-0">
                            <span x-show="!loading">Kirim</span>
                            <span x-show="loading" class="animate-spin">⏳</span>
                        </button>
                    </form>
                </div>

                {{-- CTA after answer --}}
                <div x-show="answer" x-cloak class="mt-4 border-t border-gray-100 pt-5 text-center">
                    <p class="text-sm text-gray-400 font-medium mb-2">Butuh konsultasi lebih detail?</p>
                    @auth
                        @if(auth()->user()->isPremium())
                            <a :href="'/arsitek/' + (answer?.architect_id || '')"
                               class="inline-flex items-center gap-2 text-sm font-bold text-gray-900 hover:underline transition">
                                <span class="flex items-center gap-1.5">
                                    Booking Konsultasi Lanjutan 
                                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                </span>
                            </a>
                        @else
                            <a href="{{ route('upgrade.index') }}"
                               class="inline-flex items-center gap-2 rounded-2xl bg-gray-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-black transition">
                                🔒 Upgrade ke Premium untuk Chat Privat
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 text-sm font-bold text-gray-900 hover:underline transition">
                            Daftar untuk konsultasi lanjutan →
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('quickAsk', ({ sessionId }) => ({
            sessionId,
            inputContent: '',
            question: null,
            status: null,
            answer: null,
            loading: false,
            selectedRating: 0,
            ratingFeedback: '',
            rated: false,

            init() {
                Echo.channel('public.question.' + this.sessionId)
                    .listen('QuestionClaimed', (e) => {
                        this.status = 'claimed';
                        this.scrollToBottom();
                    })
                    .listen('QuestionAnswered', (e) => {
                        this.status = 'answered';
                        this.answer = e.answer;
                        this.scrollToBottom();
                    });
            },

            async submitQuestion() {
                if (this.inputContent.trim() === '') return;
                this.loading = true;
                try {
                    const res = await fetch('{{ route("quick-ask.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ content: this.inputContent })
                    });
                    const data = await res.json();
                    if (data.status === 'success') {
                        this.question = data.question;
                        this.status = 'open';
                        this.inputContent = '';
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                } catch (e) {
                    alert('Gagal mengirim. Pastikan kamu online.');
                } finally {
                    this.loading = false;
                    this.scrollToBottom();
                }
            },

            async submitRating() {
                if (this.selectedRating === 0 || !this.answer) return;
                try {
                    const res = await fetch(`/tanya-arsitek/${this.answer.id}/rate`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            rating: this.selectedRating,
                            feedback: this.ratingFeedback
                        })
                    });
                    const data = await res.json();
                    if (data.status === 'success') {
                        this.rated = true;
                    }
                } catch (e) {
                    console.error('Rating error', e);
                }
            },

            scrollToBottom() {
                setTimeout(() => {
                    const el = document.getElementById('chat-messages');
                    if (el) el.scrollTop = el.scrollHeight;
                }, 100);
            }
        }));
    });
</script>
@endpush
@endsection