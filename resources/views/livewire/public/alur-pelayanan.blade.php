<div class="min-h-screen bg-slate-50 dark:bg-slate-900 font-sans relative overflow-hidden" x-data="{ searchOpen: false }">
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-emerald-50 to-transparent dark:from-slate-800 dark:to-slate-900 -z-10"></div>
    <div class="absolute top-20 right-0 w-96 h-96 bg-blue-100/40 dark:bg-blue-900/20 rounded-full blur-3xl animate-pulse-slow -z-10"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-purple-100/40 dark:bg-purple-900/20 rounded-full blur-3xl animate-float -z-10"></div>

    <!-- Header Section -->
    <div class="relative pt-24 pb-8 text-center px-6">
        <h1 class="text-4xl md:text-5xl font-black text-slate-800 dark:text-white mb-4 tracking-tight">
            Alur <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Pelayanan</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto text-lg leading-relaxed">
            Panduan lengkap layanan kesehatan kami. Gunakan filter untuk menemukan prosedur yang Anda butuhkan.
        </p>
        
        <a href="{{ url('/') }}" class="absolute top-8 left-6 md:left-12 flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-emerald-500 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <!-- Sticky Tabs & Search -->
    <div class="sticky top-0 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-800 transition-all duration-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-3 flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Tabs (Scrollable) -->
            <div class="w-full md:w-auto flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 md:pb-0 mask-image-linear-fade">
                @foreach($jenisPelayanans as $jenis)
                    <button wire:click="setActiveTab({{ $jenis->id }})" 
                            class="whitespace-nowrap px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-300 flex items-center gap-2 border"
                            :class="{{ $activeTab }} === {{ $jenis->id }} 
                                ? 'bg-emerald-500 text-white border-emerald-500 shadow-lg shadow-emerald-500/30 scale-105' 
                                : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:border-emerald-200 hover:text-emerald-500'">
                        @if($jenis->icon) <i class="w-4 h-4 {{ $jenis->icon }}"></i> @endif
                        {{ $jenis->nama_layanan }}
                    </button>
                @endforeach
            </div>

            <!-- Search -->
            <div class="w-full md:w-72 relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input wire:model.live="search" type="text" 
                       class="block w-full pl-10 pr-4 py-2.5 border border-slate-200 dark:border-slate-700 rounded-full leading-5 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-all shadow-sm" 
                       placeholder="Cari langkah atau kata kunci (e.g. BPJS)...">
            </div>
        </div>
    </div>

    <!-- Timeline Content -->
    <div class="max-w-5xl mx-auto px-4 md:px-6 py-12 min-h-[60vh]">
        
        <div wire:loading class="w-full text-center py-20">
            <div class="inline-flex flex-col items-center justify-center gap-4">
                <div class="w-12 h-12 border-4 border-emerald-200 border-t-emerald-500 rounded-full animate-spin"></div>
                <p class="text-slate-400 font-bold text-sm animate-pulse">Sedang memuat informasi...</p>
            </div>
        </div>

        @if($alurs->isEmpty())
            <div class="text-center py-20" wire:loading.remove>
                <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-700 dark:text-slate-300">Data belum tersedia</h3>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Coba gunakan kata kunci lain atau pilih tab layanan berbeda.</p>
            </div>
        @else
            <div class="relative space-y-12" wire:loading.remove>
                <!-- Central Line -->
                <div class="absolute left-6 md:left-1/2 top-4 bottom-4 w-0.5 bg-gradient-to-b from-emerald-500 via-teal-400 to-slate-200 dark:to-slate-800 md:-ml-0.5"></div>

                @foreach($alurs as $index => $item)
                    <div class="relative flex flex-col md:flex-row items-center md:justify-between group" x-data="{ expanded: false }">
                        
                        <!-- Icon Circle -->
                        <div class="absolute left-2 md:left-1/2 md:-ml-6 top-0 w-10 h-10 md:w-12 md:h-12 rounded-full bg-white dark:bg-slate-800 border-4 {{ $item->is_critical ? 'border-rose-100 text-rose-500' : 'border-emerald-100 text-emerald-500' }} shadow-md z-10 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-110 cursor-pointer" @click="expanded = !expanded">
                            <span class="font-black text-sm">{{ $index + 1 }}</span>
                        </div>

                        <!-- Card -->
                        <div class="w-full md:w-[45%] ml-12 md:ml-0 {{ $index % 2 == 0 ? 'md:pr-12 md:text-right order-1' : 'md:pl-12 md:text-left order-3' }}">
                            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 border {{ $item->is_critical ? 'border-rose-200 ring-4 ring-rose-50/50' : 'border-slate-100 dark:border-slate-700 hover:border-emerald-200' }} shadow-sm hover:shadow-xl transition-all duration-300 relative overflow-hidden cursor-pointer group/card" @click="expanded = !expanded">
                                
                                <!-- Badges (Position based on alignment) -->
                                <div class="absolute top-0 {{ $index % 2 == 0 ? 'left-0 rounded-br-2xl' : 'right-0 rounded-bl-2xl' }} flex">
                                    @if($item->tipe_alur == 'Online')
                                        <div class="bg-sky-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 shadow-sm">Online</div>
                                    @elseif($item->tipe_alur == 'Hybrid')
                                        <div class="bg-purple-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 shadow-sm">Hybrid</div>
                                    @endif
                                    
                                    @if($item->is_critical)
                                        <div class="bg-rose-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 shadow-sm">Wajib</div>
                                    @endif
                                </div>

                                <!-- Header -->
                                <div class="mt-4 mb-3">
                                    <h3 class="text-lg md:text-xl font-black text-slate-800 dark:text-white mb-1 group-hover/card:text-emerald-600 transition-colors">{{ $item->judul }}</h3>
                                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 leading-relaxed">{{ $item->deskripsi }}</p>
                                </div>

                                <!-- Tags & Badges -->
                                <div class="flex flex-wrap gap-2 mb-4 {{ $index % 2 == 0 ? 'md:justify-end' : 'justify-start' }}">
                                    @if($item->jam_operasional)
                                        <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-bold border border-indigo-100 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ $item->jam_operasional }}
                                        </span>
                                    @endif
                                    
                                    @foreach($item->tags ?? [] as $tag)
                                        <span class="px-2 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 text-[10px] font-bold">#{{ $tag }}</span>
                                    @endforeach
                                </div>

                                <!-- Expandable Indicator -->
                                <div class="flex {{ $index % 2 == 0 ? 'md:justify-end' : 'justify-start' }}">
                                    <button class="text-xs font-bold text-emerald-500 flex items-center gap-1 group-hover/card:underline">
                                        Lihat Detail 
                                        <svg class="w-4 h-4 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </button>
                                </div>

                                <!-- Detailed Content (Collapsible) -->
                                <div x-show="expanded" x-collapse style="display: none;">
                                    <div class="pt-6 mt-4 border-t border-slate-100 dark:border-slate-700 space-y-6 text-left">
                                        
                                        <!-- Video -->
                                        @if($item->video_url)
                                            <div class="rounded-xl overflow-hidden shadow-sm border border-slate-200">
                                                <div class="aspect-w-16 aspect-h-9 bg-slate-900">
                                                    <iframe src="{{ str_replace('watch?v=', 'embed/', $item->video_url) }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full min-h-[200px]"></iframe>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Info Grid -->
                                        <div class="grid grid-cols-1 gap-4">
                                            @if($item->gambar)
                                                <img src="{{ asset('storage/'.$item->gambar) }}" class="w-full h-40 object-cover rounded-xl shadow-sm">
                                            @endif

                                            <div class="space-y-3 text-sm">
                                                @if($item->lokasi)
                                                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-700/50">
                                                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg></div>
                                                        <div>
                                                            <p class="text-[10px] font-black uppercase text-slate-400">Lokasi</p>
                                                            <p class="font-bold text-slate-700 dark:text-slate-200">{{ $item->lokasi }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($item->dokumen_syarat)
                                                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-700/50">
                                                        <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center shrink-0"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg></div>
                                                        <div>
                                                            <p class="text-[10px] font-black uppercase text-slate-400">Syarat Dokumen</p>
                                                            <p class="font-bold text-slate-700 dark:text-slate-200">{{ $item->dokumen_syarat }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        @if($item->file_template || $item->action_url)
                                            <div class="flex flex-wrap gap-3 pt-2">
                                                @if($item->file_template)
                                                    <a href="{{ asset('storage/'.$item->file_template) }}" target="_blank" class="flex-1 py-2.5 px-4 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl text-center hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                                        Download Dokumen
                                                    </a>
                                                @endif
                                                @if($item->action_url)
                                                    <a href="{{ $item->action_url }}" class="flex-1 py-2.5 px-4 bg-emerald-500 text-white text-xs font-bold rounded-xl text-center hover:bg-emerald-600 shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                                                        {{ $item->action_label ?? 'Buka Link' }}
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- FAQ -->
                                        @if(count($item->faq ?? []) > 0)
                                            <div class="space-y-3 pt-2 border-t border-dashed border-slate-200">
                                                @foreach($item->faq as $qa)
                                                    <div class="bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded-lg border border-yellow-100 dark:border-yellow-800">
                                                        <p class="text-xs font-bold text-yellow-700 dark:text-yellow-400 mb-1">Q: {{ $qa['q'] }}</p>
                                                        <p class="text-xs text-slate-600 dark:text-slate-300">A: {{ $qa['a'] }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
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
</div>