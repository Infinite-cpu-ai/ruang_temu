@extends('layouts.landing')

@section('content')
<div class="bg-gray-50 min-h-screen py-12" x-data="quickAsk({ sessionId: '{{ $sessionId }}' })">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Tanya Arsitek</h1>
            <p class="mt-4 text-lg text-gray-500">Tanyakan apapun seputar desain bangunan, dekorasi, atau konstruksi.</p>
        </div>

        <!-- Chat Container -->
        <div class="bg-white shadow rounded-lg p-6 min-h-[400px] flex flex-col justify-between" id="chat-container">
            
            <div class="flex-1 overflow-y-auto space-y-4 mb-4" id="chat-messages">
                <!-- Welcome Message -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 bg-gray-100 rounded-lg p-3 max-w-lg">
                        <p class="text-sm text-gray-800">Halo! Saya asisten virtual Ruang Temu. Arsitek profesional kami siap menjawab pertanyaan Anda secara live. Apa yang ingin Anda tanyakan hari ini?</p>
                    </div>
                </div>

                <!-- User Question -->
                <div x-show="question" x-cloak class="flex items-end justify-end mt-4">
                    <div class="bg-blue-600 rounded-lg p-3 max-w-lg text-white">
                        <p class="text-sm" x-text="question?.content"></p>
                    </div>
                </div>

                <!-- Status Waiting/Claimed -->
                <div x-show="status === 'open'" x-cloak class="flex justify-center my-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                        <span class="animate-pulse h-2 w-2 bg-yellow-500 rounded-full mr-2"></span>
                        Menunggu Arsitek online...
                    </span>
                </div>
                
                <div x-show="status === 'claimed'" x-cloak class="flex justify-center my-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200 shadow-sm">
                        <span class="animate-pulse h-2 w-2 bg-green-500 rounded-full mr-2"></span>
                        Arsitek sedang mengetik jawaban...
                    </span>
                </div>

                <!-- Answer -->
                <div x-show="answer" x-cloak class="flex items-start mt-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full overflow-hidden bg-gray-200">
                            <img :src="answer?.architect?.profile_image ? '/storage/'+answer.architect.profile_image : '/images/profiles/profile_placeholder.png'" class="h-full w-full object-cover">
                        </div>
                    </div>
                    <div class="ml-3 bg-gray-100 rounded-lg p-3 max-w-lg border border-gray-200 shadow-sm">
                        <p class="text-xs text-blue-600 font-bold mb-1 border-b pb-1" x-text="'Dijawab oleh Arsitek ' + (answer?.architect?.name || '')"></p>
                        <p class="text-sm text-gray-800" x-text="answer?.content"></p>
                    </div>
                </div>
            </div>

            <!-- Input Form (Only show if open/empty) -->
            <div x-show="!question" x-cloak class="mt-auto border-t pt-4">
                <form @submit.prevent="submitQuestion" class="flex items-center gap-2">
                    <input type="text" x-model="inputContent" class="flex-1 w-full rounded-full border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3" placeholder="Ketik pertanyaan Anda di sini... (Cth: Atap spandek panas gak ya?)">
                    <button type="submit" :disabled="loading || inputContent.trim() === ''" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-full shadow-md text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50 transition w-24">
                        <span x-show="!loading">Kirim</span>
                        <span x-show="loading" class="animate-spin">⌛</span>
                    </button>
                </form>
            </div>
            
            <div x-show="answer" x-cloak class="mt-auto border-t pt-4 text-center">
                <p class="text-sm text-gray-500 mb-2">Ingin bertanya lebih spesifik atau butuh desain khusus?</p>
                <a :href="'/arsitek/' + (answer?.architect_id || '')" class="text-blue-600 hover:text-blue-800 font-bold underline transition">Booking Konsultasi Lanjutan dengan Arsitek Ini ✨</a>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('quickAsk', ({ sessionId }) => ({
            sessionId: sessionId,
            inputContent: '',
            question: null,
            status: null,
            answer: null,
            loading: false,

            init() {
                // Subscribe to the private-like public channel for this specific session
                Echo.channel('public.question.' + this.sessionId)
                    .listen('QuestionClaimed', (e) => {
                        console.log('Question claimed by architect:', e);
                        this.status = 'claimed';
                        this.scrollToBottom();
                    })
                    .listen('QuestionAnswered', (e) => {
                        console.log('Question answered:', e);
                        this.status = 'answered';
                        this.answer = e.answer;
                        this.scrollToBottom();
                    });
            },

            async submitQuestion() {
                if (this.inputContent.trim() === '') return;
                this.loading = true;

                try {
                    const response = await fetch('{{ route("quick-ask.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ content: this.inputContent })
                    });
                    
                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        this.question = data.question;
                        this.status = 'open';
                        this.inputContent = '';
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                } catch (error) {
                    console.error('Error submitting question:', error);
                    alert('Gagal mengirim pertanyaan. Pastikan Anda online.');
                } finally {
                    this.loading = false;
                    this.scrollToBottom();
                }
            },
            
            scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('chat-messages');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                }, 100);
            }
        }));
    });
</script>
@endpush
@endsection
