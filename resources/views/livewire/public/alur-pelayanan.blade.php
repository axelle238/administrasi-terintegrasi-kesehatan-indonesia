<div class="min-h-screen bg-slate-50 pt-24 pb-12 print:bg-white print:pt-0">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <!-- Header (Hidden on Print) -->
        <div class="text-center mb-12 print:hidden">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tight">Alur Pelayanan Pasien</h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto">Panduan lengkap prosedur layanan di setiap unit untuk kenyamanan kunjungan Anda.</p>
        </div>

        <!-- Print Header (Only Print) -->
        <div class="hidden print:block text-center mb-8 border-b-2 border-black pb-4">
            <h1 class="text-3xl font-black uppercase">Panduan Layanan {{ $currentLayanan->nama_layanan ?? '' }}</h1>
            <p class="text-sm">Unit: {{ $currentLayanan->poli->nama_poli ?? '' }}</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar: Unit & Layanan Selector (Hidden on Print) -->
            <div class="w-full lg:w-1/3 space-y-6 print:hidden">
                
                <!-- Unit Selector (Poli) -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-black text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        Pilih Unit Layanan
                    </h3>
                    <div class="space-y-2 max-h-[300px] overflow-y-auto custom-scrollbar pr-2">
                        @foreach($polis as $poli)
                        <button wire:click="setPoli({{ $poli->id }})" 
                                class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all flex justify-between items-center {{ $activePoli === $poli->id ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                            {{ $poli->nama_poli }}
                            @if($activePoli === $poli->id)
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            @endif
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Service Selector (Jenis Layanan) -->
                @if($activePoli && count($layanans) > 0)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 animate-fade-in-up">
                    <h3 class="font-black text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Pilih Jenis Tindakan
                    </h3>
                    <div class="space-y-2">
                        @foreach($layanans as $layanan)
                        <button wire:click="setLayanan({{ $layanan->id }})" 
                                class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all border-l-4 {{ $activeLayanan === $layanan->id ? 'border-pink-500 bg-pink-50 text-pink-700' : 'border-transparent bg-white hover:bg-slate-50 text-slate-600' }}">
                            {{ $layanan->nama_layanan }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Total Estimasi (Calculator) -->
                @if($currentLayanan)
                <div class="bg-emerald-50 rounded-3xl p-6 border border-emerald-100 animate-fade-in-up">
                    <h3 class="font-black text-emerald-800 mb-4 text-sm uppercase tracking-widest">Estimasi Total</h3>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-bold text-emerald-600">Total Biaya</span>
                        <span class="text-lg font-black text-emerald-900">Rp {{ number_format($alurs->sum('total_biaya'), 0, ',', '.') }}</span>
                    </div>
                    <!-- Note: Summing 'estimasi_waktu' string is hard, ideally use integer column -->
                    <div class="text-xs text-emerald-500 mt-2 italic">*Estimasi biaya dapat berubah sesuai tindakan medis tambahan.</div>
                    
                    <button onclick="window.print()" class="w-full mt-4 py-3 bg-white text-emerald-700 font-bold rounded-xl shadow-sm hover:bg-emerald-100 transition-colors flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Cetak Brosur
                    </button>
                </div>
                @endif
            </div>

            <!-- Content: Flow Timeline -->
            <div class="w-full lg:w-2/3 print:w-full">
                @if($currentLayanan)
                <div class="bg-white rounded-[3rem] p-8 md:p-10 shadow-xl border border-slate-100 min-h-[600px] relative overflow-hidden animate-fade-in print:shadow-none print:border-none print:p-0">
                    <!-- Background Blob (Hidden on Print) -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none print:hidden"></div>

                    <!-- Detail Header -->
                    <div class="relative z-10 mb-8 border-b border-slate-100 pb-8 print:hidden">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-4">
                            <div>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-[10px] font-black uppercase tracking-wider mb-3 inline-block">
                                    {{ $currentLayanan->poli->nama_poli ?? 'Unit' }}
                                </span>
                                <h2 class="text-3xl font-black text-slate-900 mb-2">{{ $currentLayanan->nama_layanan }}</h2>
                            </div>
                            
                            <!-- Smart Filter (NEW) -->
                            <div class="bg-slate-100 p-1 rounded-xl flex">
                                <button wire:click="setPatientType('Umum')" class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ $selectedPatientType == 'Umum' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">Umum</button>
                                <button wire:click="setPatientType('BPJS')" class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ $selectedPatientType == 'BPJS' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">BPJS</button>
                                <button wire:click="setPatientType('Asuransi')" class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ $selectedPatientType == 'Asuransi' ? 'bg-white text-amber-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">Asuransi</button>
                            </div>
                        </div>
                        <p class="text-slate-500 leading-relaxed">{{ $currentLayanan->deskripsi }}</p>
                    </div>

                    <!-- Search Step (Hidden on Print) -->
                    <div class="mb-8 relative z-10 print:hidden">
                        <input wire:model.live="search" type="text" placeholder="Cari langkah prosedur..." class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none text-slate-800 font-bold focus:ring-2 focus:ring-indigo-500 placeholder:text-slate-400">
                    </div>

                    <!-- Timeline -->
                    <div class="relative pl-8 md:pl-10 border-l-2 border-indigo-100 space-y-10 z-10 print:border-black print:pl-6 print:space-y-6">
                        @forelse($alurs as $alur)
                        <div class="relative group print:break-inside-avoid">
                            <!-- Dot -->
                            <div class="absolute -left-[41px] md:-left-[49px] top-0 flex flex-col items-center print:-left-[31px]">
                                <div class="w-8 h-8 rounded-full {{ $alur->is_critical ? 'bg-rose-500 ring-4 ring-rose-100' : 'bg-indigo-500 ring-4 ring-indigo-100' }} flex items-center justify-center text-white font-black text-xs shadow-md z-10 print:bg-black print:text-white print:ring-0">
                                    {{ $alur->urutan }}
                                </div>
                            </div>

                            <!-- Card -->
                            <div class="bg-slate-50 hover:bg-white rounded-2xl p-6 border border-slate-100 hover:shadow-lg transition-all duration-300 print:bg-white print:border-black print:p-4">
                                <div class="flex flex-col md:flex-row gap-6 print:block">
                                    <!-- Image (Hidden on Print to save ink) -->
                                    @if($alur->gambar)
                                    <div class="w-full md:w-32 h-32 bg-white rounded-xl overflow-hidden shadow-sm shrink-0 print:hidden">
                                        <img src="{{ asset('storage/'.$alur->gambar) }}" class="w-full h-full object-cover">
                                    </div>
                                    @endif

                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-slate-800 mb-2 flex items-center gap-2 print:text-black">
                                            {{ $alur->judul }}
                                            @if($alur->is_critical)
                                                <span class="text-[9px] bg-rose-100 text-rose-600 px-2 py-0.5 rounded uppercase font-black print:border print:border-black print:text-black print:bg-white">Wajib</span>
                                            @endif
                                        </h3>
                                        
                                        <div class="flex flex-wrap gap-2 mb-4 print:mb-2">
                                            <span class="text-[10px] font-bold bg-white px-2 py-1 rounded border border-slate-200 text-slate-500 flex items-center gap-1 print:border-black print:text-black">
                                                <svg class="w-3 h-3 print:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                {{ $alur->waktu_range ?? $alur->estimasi_waktu }}
                                            </span>
                                            @if($alur->total_biaya > 0)
                                            <span class="text-[10px] font-bold bg-emerald-50 px-2 py-1 rounded border border-emerald-100 text-emerald-600 print:bg-white print:border-black print:text-black">
                                                Rp {{ number_format($alur->total_biaya) }}
                                            </span>
                                            @endif
                                        </div>

                                        <p class="text-slate-600 text-sm leading-relaxed mb-4 print:text-black">{{ $alur->deskripsi }}</p>

                                        <!-- Requirements Box -->
                                        @if($alur->dokumen_syarat)
                                        <div class="bg-indigo-50/50 rounded-xl p-4 border border-indigo-100/50 print:bg-white print:border-black print:p-2 print:mb-2">
                                            <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-2 print:text-black">Persyaratan</p>
                                            <p class="text-xs font-bold text-indigo-900 print:text-black">{{ $alur->dokumen_syarat }}</p>
                                        </div>
                                        @endif
                                        
                                        <!-- Output Box -->
                                        @if($alur->output_langkah)
                                        <div class="mt-2 bg-emerald-50/50 rounded-xl p-4 border border-emerald-100/50 print:bg-white print:border-black print:p-2">
                                            <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2 print:text-black">Hasil Tahapan</p>
                                            <p class="text-xs font-bold text-emerald-900 print:text-black">{{ $alur->output_langkah }}</p>
                                        </div>
                                        @endif

                                        <!-- Downloads (Hidden on Print) -->
                                        @if($alur->file_template)
                                        <div class="mt-4 pt-4 border-t border-slate-200 print:hidden">
                                            <a href="{{ asset('storage/'.$alur->file_template) }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:underline">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                                Unduh Dokumen Pendukung
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-12 text-center print:hidden">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <p class="text-slate-400">Belum ada langkah prosedur yang ditemukan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                @else
                <div class="flex items-center justify-center h-full min-h-[400px] bg-white rounded-[3rem] border border-slate-100 shadow-lg p-10 text-center print:hidden">
                    <div>
                        <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6 text-indigo-300 animate-pulse-slow">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 mb-2">Pilih Unit & Layanan</h3>
                        <p class="text-slate-500 max-w-sm mx-auto">Silakan pilih unit layanan di sebelah kiri untuk melihat detail prosedur pelayanan.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>