<div x-data="{ 
    open: false,
    playing: false,
    volume: 50,
    currentTrackIndex: 0,
    duration: 0,
    currentTime: 0,
    tracks: [
        { title: 'Midnight Library', artist: 'Lofi Ambient', url: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3' },
        { title: 'Rainy Day Reading', artist: 'Piano & Rain', url: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3' },
        { title: 'Nature Whispers', artist: 'Forest Sounds', url: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3' },
        { title: 'Classical Study', artist: 'Soft Strings', url: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3' }
    ],
    get currentTrack() {
        return this.tracks[this.currentTrackIndex];
    },
    init() {
        this.$watch('volume', value => {
            this.$refs.audio.volume = value / 100;
        });
    },
    togglePlay() {
        if (this.playing) {
            this.$refs.audio.pause();
        } else {
            this.$refs.audio.play();
        }
        this.playing = !this.playing;
    },
    nextTrack() {
        this.currentTrackIndex = (this.currentTrackIndex + 1) % this.tracks.length;
        this.loadAndPlay();
    },
    prevTrack() {
        this.currentTrackIndex = (this.currentTrackIndex - 1 + this.tracks.length) % this.tracks.length;
        this.loadAndPlay();
    },
    loadAndPlay() {
        this.$nextTick(() => {
            this.$refs.audio.load();
            if (this.playing) this.$refs.audio.play();
        });
    },
    formatTime(seconds) {
        if (!seconds) return '0:00';
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    }
}" class="fixed bottom-6 right-24 z-999999">

    <!-- Audio Element -->
    <audio x-ref="audio" @timeupdate="currentTime = $el.currentTime" @loadedmetadata="duration = $el.duration"
        @ended="nextTrack()">
        <source :src="currentTrack.url" type="audio/mpeg">
    </audio>

    <!-- Floating Bubble Button (Right Side, next to Chatbot) -->
    <button @click="open = !open"
        class="group flex h-14 w-14 items-center justify-center rounded-full bg-linear-to-br from-[#084734] to-[#0a5c44] text-white shadow-xl transition-all duration-300 hover:scale-110 active:scale-95 border border-[#ceedb2]/20">
        <div class="relative flex items-center justify-center">
            <!-- Music Icon -->
            <svg x-show="!open" class="h-7 w-7 transition-all group-hover:rotate-12" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
            </svg>
            <!-- Close Icon -->
            <svg x-show="open" class="h-7 w-7 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>

            <!-- Playing Animation Waves -->
            <span x-show="playing && !open" class="absolute -top-1 -right-1 flex h-4 w-4">
                <span
                    class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#cef17b] opacity-75"></span>
                <span class="relative inline-flex h-4 w-4 rounded-full bg-[#cef17b]"></span>
            </span>
        </div>
    </button>

    <!-- Player Window -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-10 scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-10 scale-90"
        class="absolute bottom-20 right-0 w-72 overflow-hidden rounded-2xl bg-white/90 backdrop-blur-xl shadow-2xl ring-1 ring-black/5 flex flex-col border border-white/20"
        style="display: none;">

        <!-- Header / Track Info -->
        <div class="bg-linear-to-r from-[#084734] to-[#0a5c44] px-5 py-6 text-white relative overflow-hidden">
            <!-- Decorative Visualizer Circles -->
            <div class="absolute top-0 right-0 -mr-4 -mt-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -ml-4 -mb-4 h-16 w-16 rounded-full bg-[#cef17b]/20 blur-xl"></div>

            <div class="relative z-10">
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#cef17b]/80 mb-1">Now Playing</p>
                <h4 class="text-lg font-bold truncate" x-text="currentTrack.title"></h4>
                <p class="text-xs text-white/70" x-text="currentTrack.artist"></p>
            </div>

            <!-- Progress Bar -->
            <div class="mt-4 h-1.5 w-full bg-black/20 rounded-full overflow-hidden">
                <div class="h-full bg-[#cef17b] transition-all duration-300"
                    :style="`width: ${(currentTime / duration) * 100}%` "></div>
            </div>
            <div class="flex justify-between mt-1 px-0.5">
                <span class="text-[9px] text-white/50" x-text="formatTime(currentTime)"></span>
                <span class="text-[9px] text-white/50" x-text="formatTime(duration)"></span>
            </div>
        </div>

        <!-- Controls Area -->
        <div class="p-5 space-y-6">
            <!-- Main Buttons -->
            <div class="flex items-center justify-center gap-6">
                <!-- Previous -->
                <button @click="prevTrack()" class="text-gray-400 hover:text-[#084734] transition-colors">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 6h2v12H6zm3.5 6l8.5 6V6z" />
                    </svg>
                </button>

                <!-- Play/Pause -->
                <button @click="togglePlay()"
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-[#084734] text-white shadow-lg hover:shadow-[#084734]/20 transition-all hover:scale-105 active:scale-95">
                    <svg x-show="!playing" class="h-6 w-6 ml-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                    <svg x-show="playing" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"
                        style="display: none;">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                    </svg>
                </button>

                <!-- Next -->
                <button @click="nextTrack()" class="text-gray-400 hover:text-[#084734] transition-colors">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z" />
                    </svg>
                </button>
            </div>

            <!-- Volume Control -->
            <div class="flex items-center gap-3">
                <svg @click="volume = 0" class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                </svg>
                <div class="relative flex-1 group">
                    <input type="range" x-model="volume" min="0" max="100"
                        class="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#084734] hover:bg-gray-300 transition-colors">
                </div>
                <svg @click="volume = 100" class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                </svg>
            </div>

            <!-- Playlist Snippet -->
            <div class="border-t border-gray-100 pt-4">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Library Playlists</p>
                <div class="space-y-2">
                    <template x-for="(track, index) in tracks" :key="index">
                        <button @click="currentTrackIndex = index; loadAndPlay()"
                            class="w-full flex items-center justify-between text-left px-3 py-2 rounded-xl transition-all"
                            :class="currentTrackIndex === index ? 'bg-[#084734]/5 text-[#084734] font-bold' : 'text-gray-500 hover:bg-gray-50'">
                            <span class="text-xs truncate" x-text="track.title"></span>
                            <div x-show="currentTrackIndex === index && playing" class="flex gap-0.5">
                                <span class="w-0.5 h-3 bg-[#084734] animate-bounce [animation-delay:-0.1s]"></span>
                                <span class="w-0.5 h-3 bg-[#084734] animate-bounce [animation-delay:-0.3s]"></span>
                                <span class="w-0.5 h-3 bg-[#084734] animate-bounce [animation-delay:-0.2s]"></span>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 flex items-center justify-center gap-1.5">
            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
            <p class="text-[9px] text-gray-400 font-medium uppercase tracking-tight">Audio Quality: Lossless High
                Fidelity</p>
        </div>
    </div>
</div>

<style>
    /* Custom style for range input to make it look even more premium */
    input[type='range']::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 12px;
        height: 12px;
        background: #084734;
        cursor: pointer;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
</style>