@extends('layouts.landing')

@php
    $answeredCount = \App\Models\Answer::where('architect_id', auth()->id())->count();
    $badge = $answeredCount >= 20 ? ['Top Consultant', '🏆'] : ($answeredCount >= 10 ? ['Fast Responder', '⚡'] : ($answeredCount >= 3 ? ['Active Expert', '🎯'] : ['Newcomer', '🌱']));
@endphp

@section('content')
<div class="relative min-h-screen bg-[#FAFAFA] overflow-x-hidden" x-data="liveBoard()">
    <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-gray-200/50 to-transparent blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-gradient-to-tl from-gray-200/50 to-transparent blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 py-14 pt-28">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-10 gap-4 flex-wrap">
            <div>
                <p class="text-sm font-semibold text-gray-400 tracking-widest uppercase mb-2">Live</p>
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Jawab Pertanyaan Klien</h1>
                <p class="mt-2 text-base text-gray-500 font-medium">Ambil pertanyaan, jawab cepat & solutif, bangun reputasimu.</p>
            </div>

            <div class="flex items-center gap-4">
                {{-- Reputation Badge --}}
                @php
                    $answeredCount = auth()->user()->answers()->count() ?? 0;
                    $badge = $answeredCount >= 20 ? ['Top Consultant', '🏆'] : ($answeredCount >= 10 ? ['Fast Responder', '⚡'] : ($answeredCount >= 3 ? ['Active Expert', '🎯'] : ['Newcomer', '🌱']));
                @endphp
                <div class="rounded-2xl bg-white/70 backdrop-blur-xl border border-white/60 shadow-[0_4px_20px_rgb(0,0,0,0.04)] px-4 py-3 text-center">
                    <div class="text-lg font-extrabold text-gray-900">{{ $answeredCount }}</div>
                    <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Terjawab</div>
                </div>
                <div class="rounded-2xl bg-white/70 backdrop-blur-xl border border-white/60 shadow-[0_4px_20px_rgb(0,0,0,0.04)] px-4 py-3 text-center">
                    <div class="text-base font-extrabold text-gray-900">{{ $badge[1] }} {{ $badge[0] }}</div>
                    <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Badge</div>
                </div>
                <div class="flex items-center gap-2 rounded-full bg-emerald-50 border border-emerald-200 px-4 py-2 text-xs font-bold text-emerald-700">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Connected
                </div>
            </div>
        </div>

        {{-- Board --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="board-container">

            <template x-for="question in board" :key="question.id">
                <div class="group relative bg-white/70 backdrop-blur-xl rounded-3xl border border-white/60 shadow-[0_4px_20px_rgb(0,0,0,0.04)] overflow-hidden transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_20px_40px_rgb(0,0,0,0.07)] flex flex-col"
                     :class="{
                         'opacity-40 grayscale': question.status === 'claimed' && question.architect_id !== currentUserId,
                         'ring-2 ring-gray-900': question.status === 'claimed' && question.architect_id === currentUserId
                     }">

                    {{-- Top bar --}}
                    <div class="flex items-center justify-between px-5 pt-5 pb-3 border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-gray-200 overflow-hidden">
                                <img src="/images/profiles/profile_placeholder.png" class="w-full h-full object-cover" />
                            </div>
                            <span class="text-xs font-semibold text-gray-500" x-text="question.client ? 'Klien Terdaftar' : 'Guest'"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            {{-- Timer (only shown when claimed by me) --}}
                            <template x-if="question.status === 'claimed' && question.architect_id === currentUserId">
                                <span class="text-xs font-bold text-amber-600 bg-amber-50 border border-amber-200 rounded-full px-2.5 py-1 font-mono" x-text="timers[question.id] ?? '10:00'"></span>
                            </template>
                            <span class="text-[10px] text-gray-400 font-medium" x-text="formatDate(question.created_at)"></span>
                        </div>
                    </div>

                    {{-- Question --}}
                    <div class="px-5 py-4 flex-1">
                        <p class="text-sm font-semibold text-gray-900 leading-relaxed line-clamp-4" x-text="question.content"></p>
                    </div>

                    {{-- Action --}}
                    <div class="px-5 pb-5">
                        {{-- Open: Take Question --}}
                        <template x-if="question.status === 'open'">
                            <button @click="claim(question.id)"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-gray-900 px-4 py-2.5 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Ambil Pertanyaan
                            </button>
                        </template>

                        {{-- Claimed by others --}}
                        <template x-if="question.status === 'claimed' && question.architect_id !== currentUserId">
                            <span class="w-full flex items-center justify-center gap-2 rounded-2xl bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Sudah Diambil
                            </span>
                        </template>

                        {{-- Claimed by me: Answer --}}
                        <template x-if="question.status === 'claimed' && question.architect_id === currentUserId">
                            <div class="space-y-3">
                                <textarea x-model="answers[question.id]" rows="3"
                                          placeholder="Tulis jawaban yang cepat, solutif, dan praktis..."
                                          class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm resize-none"></textarea>
                                <button @click="submitAnswer(question.id)"
                                        :disabled="!answers[question.id] || answers[question.id].trim() === ''"
                                        class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-gray-900 px-4 py-2.5 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] disabled:opacity-40 disabled:cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Kirim Jawaban
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Empty State --}}
            <template x-if="board.length === 0">
                <div class="col-span-1 md:col-span-2 lg:col-span-3">
                    <div class="rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-16 shadow-[0_4px_20px_rgb(0,0,0,0.04)] text-center">
                        <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-5">
                            <svg class="w-9 h-9 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900 mb-2">Belum ada pertanyaan</h3>
                        <p class="text-gray-400 text-sm font-medium">Menunggu pertanyaan baru dari klien...</p>
                        <div class="flex items-center justify-center gap-2 mt-4 text-xs text-gray-400 font-medium">
                            <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Live monitoring aktif
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- How It Works --}}
        <div class="mt-12 rounded-[2rem] border border-white/60 bg-white/70 backdrop-blur-xl p-7 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
            <h2 class="text-sm font-extrabold text-gray-900 uppercase tracking-widest mb-5">Cara Kerja</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach([
                    ['1', 'Ambil Pertanyaan', 'Klik "Ambil Pertanyaan" — pertanyaan langsung terkunci untukmu selama 10 menit.', '⚡'],
                    ['2', 'Jawab Cepat', 'Tulis jawaban yang singkat, solutif, dan praktis. Timer berjalan!', '⏱️'],
                    ['3', 'Dapat Rating', 'Klien akan memberi rating setelah membaca jawabanmu.', '⭐'],
                    ['4', 'Naik Level', 'Semakin sering menjawab dengan baik, reputasimu naik dan badge bertambah.', '🏆'],
                ] as $step)
                <div class="rounded-2xl bg-gray-50/80 border border-gray-100 p-4">
                    <div class="text-2xl mb-2">{{ $step[3] }}</div>
                    <div class="text-xs font-extrabold text-gray-900 mb-1">{{ $step[1] }}</div>
                    <div class="text-[11px] text-gray-400 font-medium leading-relaxed">{{ $step[2] }}</div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('liveBoard', () => ({
            board: @json($questions),
            currentUserId: {{ auth()->id() }},
            answers: {},
            timers: {},
            intervals: {},

            init() {
                // Start timers for already-claimed questions
                this.board.forEach(q => {
                    if (q.status === 'claimed' && q.architect_id === this.currentUserId) {
                        this.startTimer(q.id);
                    }
                });

                Echo.channel('public.questions.board')
                    .listen('QuestionCreated', (e) => {
                        this.board.unshift(e.question);
                    })
                    .listen('QuestionClaimed', (e) => {
                        const idx = this.board.findIndex(q => q.id === e.questionId);
                        if (idx !== -1) {
                            this.board[idx].status = 'claimed';
                            this.board[idx].architect_id = e.architectId;
                            if (e.architectId === this.currentUserId) {
                                this.startTimer(e.questionId);
                            } else {
                                setTimeout(() => { this.board.splice(idx, 1); }, 3000);
                            }
                        }
                    });
            },

            startTimer(questionId, seconds = 600) {
                let remaining = seconds;
                this.timers[questionId] = this.formatTime(remaining);
                this.intervals[questionId] = setInterval(() => {
                    remaining--;
                    this.timers[questionId] = this.formatTime(remaining);
                    if (remaining <= 0) {
                        clearInterval(this.intervals[questionId]);
                        // Auto-remove if time runs out
                        const idx = this.board.findIndex(q => q.id === questionId);
                        if (idx !== -1) this.board.splice(idx, 1);
                    }
                }, 1000);
            },

            formatTime(seconds) {
                const m = Math.floor(seconds / 60).toString().padStart(2, '0');
                const s = (seconds % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            },

            async claim(questionId) {
                try {
                    const res = await fetch(`/architect/dashboard/live-board/${questionId}/claim`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    const data = await res.json();
                    if (data.status === 'success') {
                        const idx = this.board.findIndex(q => q.id === questionId);
                        if (idx !== -1) {
                            this.board[idx].status = 'claimed';
                            this.board[idx].architect_id = this.currentUserId;
                            this.startTimer(questionId);
                        }
                    } else {
                        alert(data.message);
                    }
                } catch (e) {
                    console.error('Claim Error', e);
                }
            },

            async submitAnswer(questionId) {
                const content = this.answers[questionId];
                if (!content || !content.trim()) return;

                try {
                    const res = await fetch(`/architect/dashboard/live-board/${questionId}/answer`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ content: content })
                    });
                    const data = await res.json();
                    if (data.status === 'success') {
                        clearInterval(this.intervals[questionId]);
                        const idx = this.board.findIndex(q => q.id === questionId);
                        if (idx !== -1) this.board.splice(idx, 1);
                        delete this.answers[questionId];
                    } else {
                        alert(data.message);
                    }
                } catch (e) {
                    console.error('Answer Error', e);
                }
            },

            formatDate(isoString) {
                if (!isoString) return '';
                return new Date(isoString).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
        }));
    });
</script>
@endpush
@endsection
