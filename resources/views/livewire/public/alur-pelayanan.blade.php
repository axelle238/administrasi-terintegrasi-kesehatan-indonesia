<div class="min-h-screen bg-slate-50 dark:bg-slate-900 font-sans relative overflow-hidden" x-data="{ searchOpen: false }">
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-emerald-50 to-transparent dark:from-slate-800 dark:to-slate-900 -z-10"></div>
    <div class="absolute top-20 right-0 w-96 h-96 bg-blue-100/40 dark:bg-blue-900/20 rounded-full blur-3xl animate-pulse-slow -z-10"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-purple-100/40 dark:bg-purple-900/20 rounded-full blur-3xl animate-float -z-10"></div>

    <!-- Header Section -->
    <div class="relative pt-24 pb-12 text-center px-6">
        <h1 class="text-4xl md:text-5xl font-black text-slate-800 dark:text-white mb-4 tracking-tight">
            Alur <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Pelayanan</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto text-lg leading-relaxed">
            Panduan langkah demi langkah untuk mendapatkan layanan kesehatan terbaik di fasilitas kami. Pilih jenis layanan di bawah ini.
        </p>
        
        <!-- Back to Home -->
        <a href="{{ url('/') }}" class="absolute top-8 left-6 md:left-12 flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-emerald-500 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <!-- Sticky Tabs & Search -->
    <div class="sticky top-0 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-800 transition-all duration-300 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 md:px-6 py-3 flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Tabs (Scrollable) -->
            <div class="w-full md:w-auto flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 md:pb-0 mask-image-linear-fade">
                @foreach($jenisPelayanans as $jenis)
                    <button wire:click="setActiveTab({{ $jenis->id }})" 
                            class="whitespace-nowrap px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-300 flex items-center gap-2 border"
                            :class="{{ $activeTab }} === {{ $jenis->id }} 
                                ? 'bg-emerald-500 text-white border-emerald-500 shadow-lg shadow-emerald-500/30 scale-105' 
                                : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:border-emerald-200 hover:text-emerald-500'">
                        <!-- Dynamic Icon based on name or fixed -->
                        @if($jenis->icon)
                            <i class="w-4 h-4 {{ $jenis->icon }}"></i> 
                        @else
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        @endif
                        {{ $jenis->nama_layanan }}
                    </button>
                @endforeach
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-64 relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input wire:model.live="search" type="text" 
                       class="block w-full pl-10 pr-4 py-2.5 border border-slate-200 dark:border-slate-700 rounded-full leading-5 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-all shadow-sm" 
                       placeholder="Cari langkah...">
            </div>
        </div>
    </div>

    <!-- Timeline Content -->
    <div class="max-w-5xl mx-auto px-4 md:px-6 py-12 min-h-[60vh]">
        
        <!-- Loading State -->
        <div wire:loading class="w-full text-center py-20">
            <div class="inline-flex flex-col items-center justify-center gap-4">
                <div class="w-12 h-12 border-4 border-emerald-200 border-t-emerald-500 rounded-full animate-spin"></div>
                <p class="text-slate-400 font-bold text-sm animate-pulse">Memuat Alur...</p>
            </div>
        </div>

        @if($alurs->isEmpty())
            <div class="text-center py-20" wire:loading.remove>
                <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-700 dark:text-slate-300">Belum ada data</h3>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Silakan pilih layanan lain atau coba kata kunci pencarian baru.</p>
            </div>
        @else
            <div class="relative space-y-12" wire:loading.remove>
                <!-- Central Line -->
                <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-emerald-500 via-teal-400 to-slate-200 dark:to-slate-800 md:-ml-0.5"></div>

                @foreach($alurs as $index => $item)
                    <!-- Timeline Item -->
                    <div class="relative flex flex-col md:flex-row items-center md:justify-between group"
                         x-data="{ show: false }" x-init="setTimeout(() => show = true, {{ $index * 150 }})"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-y-10"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        
                        <!-- Icon Circle (Absolute Center) -->
                        <div class="absolute left-4 md:left-1/2 -ml-4 md:-ml-6 w-8 h-8 md:w-12 md:h-12 rounded-full bg-white dark:bg-slate-900 border-4 border-emerald-100 dark:border-emerald-900/50 shadow-lg shadow-emerald-500/20 z-10 flex items-center justify-center transform transition-transform duration-500 group-hover:scale-110 group-hover:border-emerald-400">
                            <span class="text-xs md:text-sm font-black text-emerald-600 dark:text-emerald-400">{{ $index + 1 }}</span>
                        </div>

                        <!-- Card (Left or Right) -->
                        <div class="w-full md:w-[45%] ml-12 md:ml-0 {{ $index % 2 == 0 ? 'md:pr-12 md:text-right order-1' : 'md:pl-12 md:text-left order-3' }}">
                            <div class="relative p-6 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-xl hover:shadow-emerald-500/5 hover:-translate-y-1 transition-all duration-300 group/card">
                                
                                <!-- Decorative Blob inside card -->
                                <div class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/10 dark:to-teal-900/10 rounded-full blur-2xl opacity-0 group-hover/card:opacity-100 transition-opacity duration-500"></div>

                                <!-- Header -->
                                <div class="flex items-center gap-3 mb-3 {{ $index % 2 == 0 ? 'md:flex-row-reverse' : 'flex-row' }}">
                                    <!-- Icon Step -->
                                    @if($item->icon)
                                        <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-700 text-emerald-500 flex items-center justify-center shrink-0">
                                            <!-- Assuming standard heroicons names stored in DB, otherwise fallback -->
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <!-- Dynamic path logic if feasible, else generic -->
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                        </div>
                                    @endif
                                    <h3 class="text-lg font-black text-slate-800 dark:text-white group-hover/card:text-emerald-600 transition-colors">{{ $item->judul }}</h3>
                                </div>

                                <!-- Body -->
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-4 leading-relaxed">
                                    {{ $item->deskripsi ?? 'Ikuti langkah ini sesuai prosedur yang berlaku.' }}
                                </p>

                                <!-- Meta Badges -->
                                <div class="flex flex-wrap gap-2 {{ $index % 2 == 0 ? 'md:justify-end' : 'justify-start' }}">
                                    @if($item->estimasi_waktu)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold border border-blue-100 dark:border-blue-800">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ $item->estimasi_waktu }}
                                        </span>
                                    @endif
                                    @if($item->dokumen_syarat)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 text-xs font-bold border border-orange-100 dark:border-orange-800" title="{{ $item->dokumen_syarat }}">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            Syarat Dokumen
                                        </span>
                                    @endif
                                    @if($item->target_pasien)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            {{ $item->target_pasien }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Spacer for Desktop Center Alignment -->
                        <div class="hidden md:block w-[10%] order-2"></div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Floating Filter/Info Button (Mobile Only) -->
    <div class="fixed bottom-6 right-6 md:hidden z-50">
        <button class="w-12 h-12 bg-emerald-500 text-white rounded-full shadow-xl flex items-center justify-center active:scale-95 transition-transform" @click="window.scrollTo({top: 0, behavior: 'smooth'})">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
        </button>
    </div>
</div>