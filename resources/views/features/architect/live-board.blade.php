@extends('layouts.landing')

@section('content')
<div class="bg-gray-50 min-h-screen py-12" x-data="liveBoard()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Live Question Board</h1>
                <p class="mt-2 text-sm text-gray-500">Ambil dan jawab pertanyaan klien secara langsung. Siapa cepat dia dapat!</p>
            </div>
            <div>
                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <span class="h-2 w-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                    Live Connected
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="board-container">
            <!-- Iterate over initial server-rendered data, managed by Alpine -->
            <template x-for="question in board" :key="question.id">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden transition-all duration-300 transform hover:-translate-y-1" :class="{'opacity-50 grayscale': question.status === 'claimed' && question.architect_id !== currentUserId, 'ring-2 ring-blue-500': question.architect_id === currentUserId}">
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-sm font-medium text-gray-500" x-text="question.client ? 'Klien Terdaftar' : 'Guest User'"></h3>
                            <span class="text-xs text-gray-400" x-text="formatDate(question.created_at)"></span>
                        </div>
                        
                        <p class="text-gray-900 font-medium mb-6 line-clamp-3" x-text="question.content"></p>

                        <!-- Buttons/Actions -->
                        <div class="mt-4 border-t pt-4">
                            <!-- OPEN STATUS -->
                            <template x-if="question.status === 'open'">
                                <button @click="claim(question.id)" class="w-full bg-black text-white px-4 py-2 rounded-full font-medium text-sm hover:bg-gray-800 transition">
                                    Ambil Pertanyaan
                                </button>
                            </template>

                            <!-- CLAIMED BY OTHERS -->
                            <template x-if="question.status === 'claimed' && question.architect_id !== currentUserId">
                                <span class="w-full bg-gray-100 text-gray-500 px-4 py-2 rounded-full font-medium text-sm block text-center">
                                    Sudah Diambil
                                </span>
                            </template>

                            <!-- CLAIMED BY ME -->
                            <template x-if="question.status === 'claimed' && question.architect_id === currentUserId">
                                <div class="space-y-3">
                                    <textarea x-model="answers[question.id]" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-3" rows="3" placeholder="Tulis jawaban Anda..."></textarea>
                                    <button @click="answer(question.id)" :disabled="!answers[question.id]" class="w-full bg-blue-600 text-white px-4 py-2 rounded font-medium text-sm hover:bg-blue-700 disabled:opacity-50">
                                        Kirim Jawaban
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                    
                </div>
            </template>
            
            <template x-if="board.length === 0">
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                     <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                     </svg>
                     <p class="mt-4 text-gray-500 font-medium text-lg">Belum ada pertanyaan aktif.</p>
                     <p class="text-gray-400 text-sm">Menunggu umpan pertanyaan klien...</p>
                </div>
            </template>
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

            init() {
                // Listen to the public board where all new questions and claimed events go
                Echo.channel('public.questions.board')
                    .listen('QuestionCreated', (e) => {
                        console.log('New Question Arrived:', e);
                        // unshift to top
                        this.board.unshift(e.question);
                    })
                    .listen('QuestionClaimed', (e) => {
                        console.log('Question claimed on board:', e);
                        const idx = this.board.findIndex(q => q.id === e.questionId);
                        if (idx !== -1) {
                            this.board[idx].status = 'claimed';
                            this.board[idx].architect_id = e.architectId;
                            
                            // Immediately remove it from view unless it was claimed by ME
                            if (e.architectId !== this.currentUserId) {
                                setTimeout(() => {
                                    this.board.splice(idx, 1);
                                }, 3000); // give 3 seconds of visual fade before disappearing
                            }
                        }
                    });
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
                        // Optimistic update done in event listener or locally
                        const idx = this.board.findIndex(q => q.id === questionId);
                        if (idx !== -1) {
                            this.board[idx].status = 'claimed';
                            this.board[idx].architect_id = this.currentUserId;
                        }
                    } else {
                        alert(data.message);
                        // Refresh board or remove the claimed item
                    }
                } catch (e) {
                    console.error('Claim Error', e);
                }
            },

            async answer(questionId) {
                const content = this.answers[questionId];
                if (!content) return;

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
                        // Remove from the board as it's completed
                        const idx = this.board.findIndex(q => q.id === questionId);
                        if (idx !== -1) {
                            this.board.splice(idx, 1);
                        }
                        delete this.answers[questionId];
                        alert('Jawaban berhasil dikirim ke Klien!');
                    } else {
                        alert(data.message);
                    }
                } catch (e) {
                    console.error('Answer Error', e);
                }
            },

            formatDate(isoString) {
                if (!isoString) return '';
                const date = new Date(isoString);
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
        }));
    });
</script>
@endpush
@endsection
