<div class="min-h-screen bg-slate-50 pt-24 pb-12 print:bg-white print:pt-0 font-sans">
    
    <!-- Decorative Background -->
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-900 to-slate-50 z-0 print:hidden"></div>
    <div class="absolute top-0 left-0 w-full h-96 bg-[url('https://www.transparenttextures.com/patterns/medical-icons.png')] opacity-10 z-0 print:hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header Section -->
        <div class="text-center mb-10 print:hidden animate-fade-in-up">
            <span class="px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-indigo-100 text-xs font-bold uppercase tracking-[0.2em] backdrop-blur-md mb-4 inline-block shadow-lg">
                Panduan Layanan Digital
            </span>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight drop-shadow-sm">Alur Pelayanan Pasien</h1>
            <p class="text-lg text-indigo-100 max-w-2xl mx-auto font-medium leading-relaxed">
                Transparansi prosedur, waktu, dan biaya untuk pengalaman berobat yang lebih nyaman dan terencana.
            </p>
        </div>

        <!-- Print Header (Only Print) -->
        <div class="hidden print:block text-center mb-8 border-b-2 border-black pb-4">
            <h1 class="text-3xl font-black uppercase">Panduan Layanan {{ $currentLayanan->nama_layanan ?? '' }}</h1>
            <p class="text-sm">Unit: {{ $currentLayanan->poli->nama_poli ?? '' }} | Tipe Pasien: {{ $selectedPatientType }}</p>
        </div>

        <!-- MAIN LAYOUT WRAPPER -->
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            
            <!-- LEFT SIDEBAR: Navigation & Filter -->
            <div class="w-full lg:w-1/4 space-y-6 lg:sticky lg:top-24 print:hidden animate-fade-in-up" style="animation-delay: 100ms;">
                
                <!-- 1. SMART FILTER (Patient Type) -->
                <div class="bg-white rounded-3xl p-2 shadow-xl shadow-indigo-900/10 border border-white/50 backdrop-blur-xl">
                    <div class="text-center mb-2 mt-2">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Anda Pasien Apa?</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1 bg-slate-100 p-1.5 rounded-2xl">
                        @foreach(['Umum', 'BPJS', 'Asuransi'] as $type)
                        <button wire:click="setPatientType('{{ $type }}')" 
                                class="py-2.5 rounded-xl text-xs font-black transition-all duration-300 relative overflow-hidden {{ $selectedPatientType == $type ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-black/5' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}">
                            {{ $type }}
                            @if($selectedPatientType == $type)
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1 h-1 bg-indigo-600 rounded-full mb-1"></div>
                            @endif
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- 2. UNIT SELECTOR (Accordion Style) -->
                <div class="bg-white rounded-3xl shadow-xl shadow-indigo-900/5 border border-slate-100 overflow-hidden">
                    <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                        <h3 class="font-black text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            Pilih Unit Layanan
                        </h3>
                    </div>
                    
                    <div class="max-h-[60vh] overflow-y-auto custom-scrollbar p-3 space-y-1">
                        @foreach($polis as $poli)
                        <button wire:click="setPoli({{ $poli->id }})" 
                                class="w-full text-left px-4 py-3.5 rounded-2xl text-sm font-bold transition-all duration-200 flex justify-between items-center group {{ $activePoli === $poli->id ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/30' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                            <span class="{{ $activePoli === $poli->id ? 'translate-x-1' : '' }} transition-transform duration-300">{{ $poli->nama_poli }}</span>
                            @if($activePoli === $poli->id)
                                <svg class="w-4 h-4 text-indigo-200 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            @endif
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- 3. ESTIMASI SUMMARY (Sticky Card) -->
                @if($currentLayanan)
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    
                    <h3 class="font-black text-emerald-100 mb-4 text-xs uppercase tracking-widest relative z-10">Ringkasan Estimasi</h3>
                    
                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-emerald-100 uppercase">Total Biaya</p>
                                <p class="text-xl font-black">Rp {{ number_format($alurs->sum('total_biaya'), 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-emerald-100 uppercase">Total Waktu</p>
                                <p class="text-lg font-bold">{{ $alurs->sum('waktu_min') }}-{{ $alurs->sum('waktu_max') }} Menit</p>
                            </div>
                        </div>
                    </div>

                    <button onclick="window.print()" class="w-full mt-6 py-3 bg-white text-emerald-700 font-bold rounded-xl shadow-lg shadow-black/10 hover:bg-emerald-50 transition-colors flex items-center justify-center gap-2 text-sm relative z-10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Simpan / Cetak
                    </button>
                </div>
                @endif
            </div>

            <!-- RIGHT CONTENT: Service & Flow -->
            <div class="w-full lg:w-3/4 print:w-full space-y-8 animate-fade-in-up" style="animation-delay: 200ms;">
                
                @if($activePoli && count($layanans) > 0)
                <!-- SERVICE TYPE HORIZONTAL SCROLL -->
                <div class="print:hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-black text-slate-800 flex items-center gap-2">
                            <span class="w-2 h-6 bg-indigo-500 rounded-full"></span>
                            Jenis Layanan di {{ $polis->find($activePoli)->nama_poli }}
                        </h3>
                    </div>
                    <div class="flex gap-4 overflow-x-auto pb-4 custom-scrollbar snap-x">
                        @foreach($layanans as $layanan)
                        <button wire:click="setLayanan({{ $layanan->id }})" 
                                class="flex-shrink-0 snap-start min-w-[200px] p-4 rounded-2xl border transition-all duration-300 text-left relative group overflow-hidden {{ $activeLayanan === $layanan->id ? 'bg-indigo-600 border-indigo-600 shadow-xl shadow-indigo-500/20' : 'bg-white border-slate-200 hover:border-indigo-300 hover:shadow-md' }}">
                            <div class="flex justify-between items-start mb-3 relative z-10">
                                <div class="p-2 rounded-lg {{ $activeLayanan === $layanan->id ? 'bg-white/20 text-white' : 'bg-indigo-50 text-indigo-600' }}">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                </div>
                                @if($activeLayanan === $layanan->id)
                                <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                @endif
                            </div>
                            <h4 class="font-bold text-sm mb-1 relative z-10 {{ $activeLayanan === $layanan->id ? 'text-white' : 'text-slate-700' }}">{{ $layanan->nama_layanan }}</h4>
                            <p class="text-[10px] line-clamp-2 relative z-10 {{ $activeLayanan === $layanan->id ? 'text-indigo-100' : 'text-slate-400' }}">{{ $layanan->deskripsi }}</p>
                            
                            @if($activeLayanan === $layanan->id)
                                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
                            @endif
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($currentLayanan)
                <!-- FLOW CONTENT CARD -->
                <div class="bg-white rounded-[3rem] p-8 md:p-10 shadow-2xl shadow-indigo-100/50 border border-slate-100 relative min-h-[500px] animate-fade-in print:shadow-none print:border-none print:p-0">
                    
                    <!-- Search Bar -->
                    <div class="mb-8 relative z-20 print:hidden">
                        <div class="relative">
                            <input wire:model.live="search" type="text" placeholder="Cari langkah prosedur (contoh: pembayaran, resep)..." class="w-full pl-12 pr-6 py-4 rounded-2xl bg-slate-50 border-none text-slate-700 font-bold focus:ring-2 focus:ring-indigo-500 placeholder:text-slate-400 shadow-inner transition-shadow focus:bg-white">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>

                    <!-- Flow Timeline -->
                    <div class="relative pl-4 md:pl-8 space-y-12 z-10">
                        <!-- Connecting Line -->
                        <div class="absolute left-[27px] md:left-[43px] top-4 bottom-12 w-0.5 bg-gradient-to-b from-indigo-200 via-purple-200 to-slate-100 print:border-l print:border-black print:left-4"></div>

                        @forelse($alurs as $index => $alur)
                        <div class="relative group print:break-inside-avoid">
                            <!-- Step Indicator -->
                            <div class="absolute -left-[45px] md:-left-[61px] top-0 flex flex-col items-center z-20 print:-left-[20px]">
                                <div class="w-12 h-12 md:w-16 md:h-16 rounded-full {{ $alur->is_critical ? 'bg-rose-500 shadow-rose-500/30' : 'bg-indigo-600 shadow-indigo-600/30' }} flex items-center justify-center text-white font-black text-lg md:text-xl shadow-lg ring-4 ring-white transition-transform group-hover:scale-110 duration-300 print:bg-white print:text-black print:border-2 print:border-black print:w-8 print:h-8 print:text-sm print:ring-0">
                                    {{ $index + 1 }}
                                </div>
                            </div>

                            <!-- Content Card -->
                            <div class="ml-4 md:ml-6 bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 hover:shadow-xl hover:border-indigo-100 transition-all duration-300 relative overflow-hidden group-hover:-translate-y-1 print:border-black print:shadow-none print:rounded-lg print:p-4 print:mb-4">
                                @if($alur->is_critical)
                                    <div class="absolute top-0 right-0 bg-rose-100 text-rose-600 text-[10px] font-black uppercase px-4 py-1.5 rounded-bl-2xl print:border print:border-black print:bg-white print:text-black">Wajib</div>
                                @endif

                                <div class="flex flex-col md:flex-row gap-8">
                                    <!-- Image (Hidden on Print) -->
                                    @if($alur->gambar)
                                    <div class="w-full md:w-40 h-40 rounded-2xl bg-slate-100 overflow-hidden shrink-0 shadow-inner print:hidden group-hover:shadow-md transition-shadow">
                                        <img src="{{ asset('storage/'.$alur->gambar) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                                    </div>
                                    @endif

                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-3 mb-3">
                                            <h3 class="text-xl md:text-2xl font-black text-slate-800 group-hover:text-indigo-700 transition-colors">{{ $alur->judul }}</h3>
                                            @if(!empty($alur->visibility_rules['target_pasien']))
                                                <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-600 text-[10px] font-bold border border-indigo-100 print:border-black print:text-black">
                                                    Khusus {{ implode('/', $alur->visibility_rules['target_pasien']) }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="flex flex-wrap gap-2 mb-6">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 text-slate-600 text-xs font-bold border border-slate-200 group-hover:border-indigo-200 transition-colors print:border-black">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                {{ $alur->waktu_range ?? $alur->estimasi_waktu }}
                                            </span>
                                            @if($alur->total_biaya > 0)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100 print:border-black print:text-black">
                                                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Rp {{ number_format($alur->total_biaya, 0, ',', '.') }}
                                            </span>
                                            @endif
                                        </div>

                                        <p class="text-slate-600 leading-relaxed mb-6">{{ $alur->deskripsi }}</p>

                                        <!-- Detail Grid -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @if($alur->dokumen_syarat)
                                            <div class="p-4 bg-orange-50 rounded-xl border border-orange-100/50 print:bg-white print:border-black">
                                                <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest mb-2 print:text-black">Persiapkan Dokumen</p>
                                                <ul class="list-disc list-inside text-xs font-bold text-slate-700 print:text-black space-y-1">
                                                    @foreach(explode(',', $alur->dokumen_syarat) as $syarat)
                                                        <li>{{ trim($syarat) }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                            
                                            @if($alur->output_langkah)
                                            <div class="p-4 bg-blue-50 rounded-xl border border-blue-100/50 print:bg-white print:border-black">
                                                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2 print:text-black">Hasil / Output</p>
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    <span class="text-sm font-bold text-slate-700 print:text-black">{{ $alur->output_langkah }}</span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Download -->
                                        @if($alur->file_template)
                                        <div class="mt-6 pt-4 border-t border-slate-100 print:hidden">
                                            <a href="{{ asset('storage/'.$alur->file_template) }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors group/link">
                                                <span class="p-1.5 bg-indigo-50 rounded-lg group-hover/link:bg-indigo-100 transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg></span>
                                                Unduh Formulir Pendukung
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-20 text-center">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Informasi Alur</h3>
                            <p class="text-slate-500 max-w-xs mx-auto">Informasi prosedur untuk layanan ini sedang dalam proses pembaruan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                @else
                <div class="h-full min-h-[500px] flex items-center justify-center bg-white/50 border-2 border-dashed border-slate-200 rounded-[3rem] p-10 text-center print:hidden">
                    <div class="max-w-sm">
                        <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6 text-indigo-300 animate-pulse-slow">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 mb-2">Mulai Penelusuran</h3>
                        <p class="text-slate-500">Silakan pilih <span class="font-bold text-indigo-600">Unit Layanan</span> di sebelah kiri untuk melihat detail prosedur, biaya, dan waktu layanan.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
