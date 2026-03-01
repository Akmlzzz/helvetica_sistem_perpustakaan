<div x-data="{ 
    open: false, 
    messages: [
        { role: 'ai', text: 'Halo! Saya Pustakawan AI. Ada yang bisa saya bantu hari ini?' }
    ],
    userInput: '',
    loading: false,
    async sendMessage() {
        if (this.userInput.trim() === '' || this.loading) return;
        
        const userMsg = this.userInput;
        this.messages.push({ role: 'user', text: userMsg });
        this.userInput = '';
        this.loading = true;
        
        // Scroll to bottom
        this.$nextTick(() => {
            const chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight;
        });

        try {
            const response = await fetch('{{ route('api.ai.chat') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: userMsg })
            });
            
            const data = await response.json();
            
            if (data.reply) {
                this.messages.push({ role: 'ai', text: data.reply });
            } else {
                this.messages.push({ role: 'ai', text: 'Maaf, sistem sedang sibuk. Coba lagi nanti ya.' });
            }
        } catch (error) {
            this.messages.push({ role: 'ai', text: 'Waduh, koneksi bermasalah. Pastikan kamu terhubung internet.' });
        } finally {
            this.loading = false;
            this.$nextTick(() => {
                const chatBox = document.getElementById('chat-box');
                chatBox.scrollTop = chatBox.scrollHeight;
            });
        }
    }
}" class="fixed bottom-6 right-6 z-999999">

    <!-- Floating Bubble Button -->
    <button @click="open = !open"
        class="group flex h-14 w-14 items-center justify-center rounded-full bg-linear-to-br from-[#004236] to-[#00644f] text-white shadow-xl transition-all duration-300 hover:scale-110 active:scale-95">
        <svg x-show="!open" class="h-8 w-8 transition-all group-hover:rotate-12" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <svg x-show="open" class="h-7 w-7 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <!-- Badge -->
        <span x-show="!open" class="absolute -right-1 -top-1 flex h-4 w-4">
            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
            <span
                class="relative inline-flex h-4 w-4 rounded-full bg-red-500 text-[10px] font-bold text-white items-center justify-center">1</span>
        </span>
    </button>

    <!-- Chat Window -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-10 scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-10 scale-90"
        class="absolute bottom-20 right-0 h-[500px] w-[350px] overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 flex flex-col"
        style="display: none;">

        <!-- Header -->
        <div class="bg-linear-to-r from-[#004236] to-[#00644f] px-5 py-4 text-white">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span
                        class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-[#004236] bg-green-400"></span>
                </div>
                <div>
                    <h4 class="text-sm font-bold">Pustakawan AI</h4>
                    <p class="text-[10px] text-white/70">Gemini 2.5 Flash &bull;</p>
                </div>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="chat-box" class="flex-1 space-y-4 overflow-y-auto bg-gray-50 p-4 scroll-smooth">
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
                    <!-- AI Icon -->
                    <div x-show="msg.role === 'ai'"
                        class="mr-2 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#004236]/10 text-[#004236]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 0a12.022 12.022 0 01-1.012 5.034" />
                        </svg>
                    </div>

                    <!-- Bubble Text -->
                    <div class="max-w-[80%] rounded-2xl px-4 py-2.5 text-xs shadow-sm"
                        :class="msg.role === 'user' ? 'bg-[#004236] text-white rounded-tr-none' : 'bg-white text-gray-700 border border-gray-100 rounded-tl-none'">
                        <template x-if="msg.role === 'user'">
                            <p class="leading-relaxed whitespace-pre-wrap" x-text="msg.text"></p>
                        </template>
                        <template x-if="msg.role === 'ai'">
                            <div class="leading-relaxed ai-chat-content" x-html="msg.text"></div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Loading Skeleton -->
            <div x-show="loading" class="flex justify-start">
                <div class="mr-2 flex h-8 w-8 animate-pulse items-center justify-center rounded-full bg-gray-200"></div>
                <div class="flex h-10 w-20 animate-pulse items-center justify-center rounded-2xl bg-gray-200 px-4">
                    <div class="flex gap-1">
                        <div class="h-1.5 w-1.5 animate-bounce rounded-full bg-gray-400"></div>
                        <div class="h-1.5 w-1.5 animate-bounce rounded-full bg-gray-400 [animation-delay:0.2s]"></div>
                        <div class="h-1.5 w-1.5 animate-bounce rounded-full bg-gray-400 [animation-delay:0.4s]"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t border-gray-100 p-4 bg-white">
            <form @submit.prevent="sendMessage" class="flex items-center gap-2">
                <input type="text" x-model="userInput" placeholder="Tanya sesuatu..."
                    class="flex-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-2 text-xs focus:border-[#004236] focus:bg-white focus:outline-none transition-all">
                <button type="submit"
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#004236] text-white shadow-md transition-all hover:bg-[#003028] disabled:opacity-50"
                    :disabled="loading">
                    <svg class="h-4 w-4 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
            <p class="mt-2 text-[9px] text-center text-gray-400">AI bisa membuat kesalahan!</p>
        </div>
    </div>
</div>

<style>
    .ai-chat-content p {
        margin-bottom: 0.5rem;
    }

    .ai-chat-content p:last-child {
        margin-bottom: 0;
    }

    .ai-chat-content ul {
        list-style-type: disc;
        margin-left: 1rem;
        margin-bottom: 0.5rem;
    }

    .ai-chat-content ol {
        list-style-type: decimal;
        margin-left: 1rem;
        margin-bottom: 0.5rem;
    }

    .ai-chat-content li {
        margin-bottom: 0.25rem;
    }

    .ai-chat-content strong {
        font-weight: 600;
        color: #004236;
    }

    .ai-chat-content em {
        font-style: italic;
    }
</style>