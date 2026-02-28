@props(['banners'])

@if($banners->count() > 0)
<div x-data="{
        activeSlide: 0,
        slides: {{ $banners->count() }},
        autoplayInterval: null,
        
        init() {
            this.startAutoplay();
        },
        
        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                this.next();
            }, 5000);
        },
        
        stopAutoplay() {
            clearInterval(this.autoplayInterval);
        },
        
        next() {
            this.activeSlide = (this.activeSlide + 1) % this.slides;
        },
        
        prev() {
            this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides;
        },
        
        goTo(index) {
            this.activeSlide = index;
            this.stopAutoplay();
            this.startAutoplay();
        }
    }" 
    @mouseenter="stopAutoplay" 
    @mouseleave="startAutoplay"
    class="relative w-full h-[350px] sm:h-[400px] md:h-[500px] overflow-hidden rounded-xl mb-6 md:mb-8 group">

    <!-- Slides -->
    <div class="relative w-full h-full">
        @foreach($banners as $index => $banner)
        <div x-show="activeSlide === {{ $index }}"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 transform scale-105"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute inset-0 w-full h-full">

            <!-- Layer 1: Background -->
            <img src="{{ Storage::url($banner->bg_img) }}" alt="Background" 
                class="absolute inset-0 w-full h-full object-cover z-0" />

            <!-- Overlay Gradient for Readability -->
            <!-- <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/10 to-transparent z-10"></div> -->
            
            <!-- Bottom Fade -->
            <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-[#F4F7FE] dark:from-[#1A222C] to-transparent z-20"></div>

            <!-- Layer 2: Character (Right Side) -->
            @if($banner->char_img)
            <div class="absolute bottom-0 right-0 sm:right-4 md:right-10 z-10 h-[70%] sm:h-[80%] md:h-[90%] w-auto flex items-end">
                <img src="{{ Storage::url($banner->char_img) }}" alt="Character"
                    class="h-full w-auto object-contain drop-shadow-2xl transition-transform duration-700"
                    x-bind:class="activeSlide === {{ $index }} ? 'translate-x-0 opacity-100' : 'translate-x-10 opacity-0'" />
            </div>
            @endif

            <!-- Layer 3: Branding & Content (Left Side) -->
            <div class="absolute top-1/2 -translate-y-1/2 left-4 sm:left-6 md:left-12 z-30 max-w-[70%] sm:max-w-[60%] md:max-w-lg text-white">
                
                <!-- Title Image/Logo -->
                @if($banner->title_img)
                <img src="{{ Storage::url($banner->title_img) }}" alt="Title" 
                    class="h-12 sm:h-16 md:h-32 w-auto object-contain mb-3 sm:mb-4 md:mb-6 animate-fade-in-up" />
                @endif

                <!-- Tags -->
                @if($banner->tags)
                <div class="flex flex-wrap gap-1.5 sm:gap-2 mb-2 sm:mb-4">
                    @foreach(explode(',', $banner->tags) as $tag)
                    <span class="px-2 py-0.5 sm:px-3 sm:py-1 text-[10px] sm:text-xs font-semibold bg-white/20 backdrop-blur-md rounded-full border border-white/30 text-[#084734]">
                        {{ trim($tag) }}
                    </span>
                    @endforeach
                </div>
                @endif

                <!-- Synopsis -->
                @if($banner->synopsis)
                <p class="text-xs sm:text-sm md:text-base text-[#084734] mb-4 sm:mb-6 line-clamp-2 sm:line-clamp-3 drop-shadow-md">
                    {{ $banner->synopsis }}
                </p>
                @endif

                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-2 sm:gap-4">
                    @if($banner->target_link)
                    <a href="{{ $banner->target_link }}" 
                        class="px-4 py-2 sm:px-6 sm:py-2.5 text-xs sm:text-base bg-brand-primary text-white font-bold rounded-lg shadow-lg hover:bg-opacity-90 transition">
                        Lihat Buku
                    </a>
                    @endif
                    <button class="px-4 py-2 sm:px-6 sm:py-2.5 text-xs sm:text-base bg-white/10 backdrop-blur-md border border-[#084734] text-[#084734] font-semibold rounded-lg hover:bg-white/20 transition">
                        + Koleksi Saya
                    </button>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    <!-- Navigation Arrows -->
    <button @click="prev()" 
        class="absolute left-4 top-1/2 -translate-y-1/2 z-40 p-2 rounded-full bg-black/30 text-white hover:bg-black/50 backdrop-blur-sm transition opacity-0 group-hover:opacity-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    
    <button @click="next()" 
        class="absolute right-4 top-1/2 -translate-y-1/2 z-40 p-2 rounded-full bg-black/30 text-white hover:bg-black/50 backdrop-blur-sm transition opacity-0 group-hover:opacity-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>

    <!-- Pagination Dots -->
    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2 z-40">
        <template x-for="i in slides">
            <button @click="goTo(i-1)" 
                class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                :class="activeSlide === i-1 ? 'bg-white w-6' : 'bg-white/50 hover:bg-white/80'">
            </button>
        </template>
    </div>

</div>
@endif
