@extends('layouts.app')
@section('title', 'Dokumentasi Sistem')
@section('content')
<div class="flex flex-col md:flex-row gap-0 md:gap-6 h-[calc(100vh-120px)] bg-white dark:bg-[#052e25]/30 rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-slate-800/50">
    <!-- Kiri: Sidebar Docs -->
    <div class="w-full md:w-64 shrink-0 bg-[#F3F7EB]/30 dark:bg-slate-900/30 border-r border-[#CEF17B]/30 dark:border-slate-800/50 flex flex-col h-full overflow-hidden">
        <div class="p-6 border-b border-[#CEF17B]/30 dark:border-slate-800/50 bg-white dark:bg-transparent">
            <h2 class="text-xl font-bold text-[#004236] dark:text-white mb-4">📖 Docs</h2>
            <div class="relative">
                <input type="text" id="search-docs" placeholder="Cari topik..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700/50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#004236] dark:focus:ring-[#CEF17B] dark:text-gray-200 transition-all">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        <div class="py-3 overflow-y-auto grow docs-nav bg-transparent" id="sidebar-nav">
            @foreach($navigation as $category => $items)
                @php
                    $isGroupActive = collect($items)->contains('slug', $slug);
                @endphp
                <div class="mb-1"
                     x-data="{ open: {{ $isGroupActive ? 'true' : 'false' }} }">

                    {{-- Group header / dropdown trigger --}}
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-left group transition-all duration-200
                                   {{ $isGroupActive ? 'text-[#004236] dark:text-[#CEF17B]' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                        <span class="text-[11px] font-bold uppercase tracking-widest">{{ $category }}</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-300 shrink-0"
                             :class="open ? 'rotate-180' : 'rotate-0'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Sub-menu items with slide animation --}}
                    <div x-show="open"
                         x-transition:enter="transition-all duration-300 ease-out"
                         x-transition:enter-start="max-h-0 opacity-0"
                         x-transition:enter-end="max-h-96 opacity-100"
                         x-transition:leave="transition-all duration-200 ease-in"
                         x-transition:leave-start="max-h-96 opacity-100"
                         x-transition:leave-end="max-h-0 opacity-0"
                         class="overflow-hidden">
                        <ul class="mt-1 mb-2 ml-2 space-y-0.5 border-l-2 border-gray-200 dark:border-slate-700 pl-3">
                            @foreach($items as $item)
                            <li>
                                <a href="{{ route('admin.docs.show', $item['slug']) }}"
                                   class="block px-3 py-2 text-sm rounded-lg transition-all duration-150
                                          {{ $slug === $item['slug']
                                              ? 'bg-[#004236] text-[#CEF17B] font-semibold shadow-sm'
                                              : 'text-gray-600 dark:text-gray-400 hover:bg-[#004236]/10 dark:hover:bg-slate-800/60 hover:text-[#004236] dark:hover:text-[#CEF17B]' }}">
                                    <span class="flex items-center gap-2">
                                        @if($slug === $item['slug'])
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#CEF17B] shrink-0"></span>
                                        @else
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-slate-600 shrink-0"></span>
                                        @endif
                                        {{ $item['title'] }}
                                    </span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tengah: Main Content -->
    <div class="flex-1 overflow-y-auto scroll-smooth p-6 md:p-10 lg:pl-12 bg-white dark:bg-transparent" id="main-content">
        <div class="prose prose-emerald max-w-4xl dark:prose-invert prose-headings:font-bold prose-h1:text-4xl prose-h2:text-2xl prose-a:text-[#004236] dark:prose-a:text-[#CEF17B] hover:prose-a:underline">
            {!! $htmlContent !!}
        </div>
    </div>

    <!-- Kanan: Table of Contents -->
    <div id="toc-container" class="hidden xl:block w-72 shrink-0 px-8 py-10 border-l border-[#CEF17B]/20 dark:border-slate-800/50 overflow-y-auto bg-gray-50/30 dark:bg-transparent">
        <h4 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-6 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#004236] dark:text-[#CEF17B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
            On This Page
        </h4>
        @if(count($toc) > 0)
        <ul class="space-y-3 text-sm relative border-l border-gray-200 dark:border-slate-700 ml-2">
            @foreach($toc as $item)
            <li class="relative {{ $item['level'] === 3 ? 'ml-4' : '' }}">
                <!-- Active dot indicator -->
                <span class="toc-dot hidden absolute -left-[5px] top-1.5 w-2 h-2 rounded-full bg-[#004236] dark:bg-[#CEF17B]"></span>
                <a href="#{{ $item['slug'] }}" class="block pl-4 text-gray-500 hover:text-[#004236] dark:text-gray-400 dark:hover:text-[#CEF17B] transition-colors toc-link" data-target="{{ $item['slug'] }}">
                    {{ $item['title'] }}
                </a>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-sm text-gray-400 dark:text-gray-500 italic">Tidak ada heading di halaman ini.</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<!-- Mermaid.js for diagrams -->
<script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
<script>
    mermaid.initialize({ 
        startOnLoad: true,
        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'default',
        securityLevel: 'loose',
        flowchart: { useMaxWidth: true, htmlLabels: true, curve: 'basis' }
    });
</script>
<script>
    // Search functionality for docs sidebar
    document.getElementById('search-docs').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const navItems = document.querySelectorAll('#sidebar-nav li');
        
        navItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            if(text.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    let observer; // Deklarasi global

    function initTOC() {
        if (observer) {
            observer.disconnect();
        }

        // Active TOC highlighting based on scroll position
        observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Remove active classes
                    document.querySelectorAll('.toc-link').forEach(link => {
                        link.classList.remove('text-[#004236]', 'font-bold', 'dark:text-[#CEF17B]');
                        link.classList.add('text-gray-500', 'dark:text-gray-400');
                        
                        // Hide all dots
                        const dot = link.previousElementSibling;
                        if(dot && dot.classList.contains('toc-dot')) {
                            dot.classList.add('hidden');
                        }

                        // Activate current
                        if(link.getAttribute('data-target') === entry.target.id) {
                            link.classList.remove('text-gray-500', 'dark:text-gray-400');
                            link.classList.add('text-[#004236]', 'font-bold', 'dark:text-[#CEF17B]');
                            if(dot && dot.classList.contains('toc-dot')) {
                                dot.classList.remove('hidden');
                            }
                        }
                    });
                }
            });
        }, { rootMargin: '-20% 0px -80% 0px' });

        document.querySelectorAll('#main-content h2, #main-content h3').forEach(heading => {
            if(heading.id) {
                observer.observe(heading);
            }
        });
    }

    // Inisialisasi awal
    initTOC();

    // 🚀 AJAX Navigation untuk pengalaman pindah halaman tanpa reload (SPA feel)
    document.addEventListener('click', function(e) {
        const link = e.target.closest('#sidebar-nav a');
        if (!link) return;

        e.preventDefault();
        const url = link.getAttribute('href');
        
        // Transisi animasi (fade out content)
        const mainContent = document.getElementById('main-content');
        mainContent.style.opacity = '0.4';
        mainContent.style.transition = 'opacity 0.2s ease-in-out';

        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Ganti konten
                mainContent.innerHTML = doc.getElementById('main-content').innerHTML;
                document.getElementById('toc-container').innerHTML = doc.getElementById('toc-container').innerHTML;
                document.getElementById('sidebar-nav').innerHTML = doc.getElementById('sidebar-nav').innerHTML;

                // Animasi masuk kembali
                mainContent.style.opacity = '1';
                mainContent.scrollTop = 0;

                // Update URL di browser
                history.pushState({}, '', url);

                // Setup ulang observer & scroll spy & Mermaid
                initTOC();
                if (typeof mermaid !== 'undefined') {
                    mermaid.run();
                }

                // Pastikan filter dari input text box apply ulang jika ada text
                document.getElementById('search-docs').dispatchEvent(new Event('input'));
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                window.location.href = url; // Fallback jika fetch error
            });
    });

    // Menangani tombol back/forward di browser
    window.addEventListener('popstate', function() {
        window.location.reload();
    });
</script>
<style>
/* Modern Typography styling inspired by VitePress / Tailwind Docs */
.prose { max-width: 70ch; color: #374151; }
.prose h1 { font-size: 2.25rem; letter-spacing: -0.025em; line-height: 2.5rem; margin-top: 0; margin-bottom: 1.5rem; font-weight: 800; color: #111827; }
.prose h2 { font-size: 1.5rem; letter-spacing: -0.025em; line-height: 2rem; margin-top: 2.5rem; margin-bottom: 1rem; font-weight: 700; border-bottom: 1px solid #e5e7eb; padding-bottom: 0.75rem; color: #1f2937; }
.prose h3 { font-size: 1.25rem; letter-spacing: -0.025em; line-height: 1.75rem; margin-top: 2rem; margin-bottom: 0.75rem; font-weight: 600; color: #374151; }
.prose p { margin-top: 1.25em; margin-bottom: 1.25em; line-height: 1.75; font-size: 1rem; }
.prose ul { padding-left: 1.5em; list-style-type: disc; margin-top: 1em; margin-bottom: 1em; }
.prose ol { padding-left: 1.5em; list-style-type: decimal; margin-top: 1em; margin-bottom: 1em; }
.prose li { margin-top: 0.375em; margin-bottom: 0.375em; }
.prose table { width: 100%; text-align: left; margin-top: 2em; margin-bottom: 2em; font-size: 0.875rem; line-height: 1.5; border-collapse: collapse; overflow: hidden; border-radius: 0.5rem; border: 1px solid #e5e7eb; }
.prose thead { color: #111827; font-weight: 600; border-bottom: 1px solid #e5e7eb; background-color: #f9fafb; }
.prose thead th { padding: 0.75rem 1rem; white-space: nowrap; border-right: 1px solid #e5e7eb; }
.prose thead th:last-child { border-right: none; }
.prose tbody tr { border-bottom: 1px solid #e5e7eb; }
.prose tbody tr:last-child { border-bottom: none; }
.prose tbody td { padding: 0.75rem 1rem; color: #4b5563; border-right: 1px solid #e5e7eb; }
.prose tbody td:last-child { border-right: none; }
.prose tbody tr:nth-child(even) { background-color: #fcfcfd; }
.prose blockquote { border-left-width: 4px; border-color: #004236; padding: 1rem 1.25rem; font-style: normal; color: #4b5563; background-color: #F3F7EB; border-radius: 0 0.5rem 0.5rem 0; margin: 1.5rem 0;}
.prose blockquote p { margin: 0;}
.prose blockquote strong { color: #004236; }
.prose code:not(pre code) { color: #004236; background-color: #F3F7EB; padding: 0.2em 0.4em; border-radius: 0.375rem; font-size: 0.875em; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-weight: 600; }
.prose code::before { content: ""; }
.prose code::after { content: ""; }
.prose pre { color: #f8f8f2; background-color: #1e1e1e; overflow-x: auto; font-size: 0.875em; line-height: 1.7142857; margin-top: 1.5rem; margin-bottom: 1.5rem; border-radius: 0.75rem; padding: 1.25rem; border: 1px solid #2d2d2d; box-shadow: inset 0 0 0 1px rgba(255,255,255,0.1); }
.prose pre code { background-color: transparent; border-width: 0; border-radius: 0; padding: 0; font-weight: 400; color: inherit; font-size: inherit; font-family: inherit; line-height: inherit; }

/* Dark mode overrides */
.dark .prose { color: #d1d5db; }
.dark .prose h1, .dark .prose h2, .dark .prose h3 { color: #f3f4f6; }
.dark .prose h2 { border-color: #374151; }
.dark .prose table { border-color: #374151; }
.dark .prose thead { color: #e5e7eb; background-color: #1f2937; border-color: #374151; }
.dark .prose thead th { border-color: #374151; }
.dark .prose tbody tr { border-color: #374151; }
.dark .prose tbody tr:nth-child(even) { background-color: rgba(255,255,255,0.02); }
.dark .prose tbody td { color: #9ca3af; border-color: #374151; }
.dark .prose blockquote { color: #d1d5db; border-color: #CEF17B; background-color: rgba(206, 241, 123, 0.1);}
.dark .prose blockquote strong { color: #CEF17B; }
.dark .prose code:not(pre code) { color: #CEF17B; background-color: rgba(206, 241, 123, 0.1); }
.dark .prose pre { background-color: #0d1117; border-color: #30363d; }
</style>
@endpush
