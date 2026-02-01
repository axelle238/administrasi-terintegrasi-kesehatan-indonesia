<div class="w-full bg-white rounded-[3rem] shadow-2xl shadow-indigo-100/50 border border-slate-100 overflow-hidden relative" x-data="{ 
    openPoli: null 
}">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-bl from-indigo-50 to-transparent rounded-bl-full pointer-events-none"></div>

    <div class="flex flex-col lg:flex-row min-h-[600px]">
        <!-- LEFT: Navigation Sidebar -->
        <div class="w-full lg:w-1/3 bg-slate-50/50 border-b lg:border-b-0 lg:border-r border-slate-100 p-6 lg:p-8 flex flex-col">
            
            <div class="mb-8">
                <h3 class="text-xl font-black text-slate-800 mb-2">Pilih Layanan</h3>
                <p class="text-sm text-slate-500">Silakan pilih unit layanan untuk melihat detail prosedur.</p>
            </div>

            <!-- Smart Filter (Tipe Pasien) -->
            <div class="bg-white p-1 rounded-xl shadow-sm border border-slate-200 flex mb-6">
                <button wire:click="setPatientType('Umum')" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all {{ $selectedPatientType == 'Umum' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">Umum</button>
                <button wire:click="setPatientType('BPJS')" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all {{ $selectedPatientType == 'BPJS' ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">BPJS</button>
                <button wire:click="setPatientType('Asuransi')" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all {{ $selectedPatientType == 'Asuransi' ? 'bg-amber-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">Asuransi</button>
            </div>

            <!-- Unit List (Accordion) -->
            <div class="flex-1 overflow-y-auto custom-scrollbar space-y-3 pr-2">
                @forelse($polis as $poli)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden transition-all duration-300 {{ $activePoli === $poli->id ? 'shadow-md ring-2 ring-indigo-100 border-indigo-200' : 'hover:border-indigo-200' }}">
                    <button @click="openPoli = openPoli === {{ $poli->id }} ? null : {{ $poli->id }}; $wire.setPoli({{ $poli->id }})" 
                            class="w-full text-left px-5 py-4 flex justify-between items-center bg-white hover:bg-indigo-50/30 transition-colors">
                        <span class="font-bold text-slate-700 text-sm">{{ $poli->nama_poli }}</span>
                        <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 transition-transform duration-300" :class="openPoli === {{ $poli->id }} ? 'rotate-180 bg-indigo-100 text-indigo-600' : ''">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </button>
                    
                    <div x-show="openPoli === {{ $poli->id }}" x-collapse style="display: none;">
                        <div class="px-3 pb-3 space-y-1 bg-slate-50/50 border-t border-slate-100">
                            @foreach($poli->jenisPelayanans as $jenis)
                            <button wire:click="setLayanan({{ $jenis->id }})" 
                                    class="w-full text-left px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeLayanan === $jenis->id ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-white hover:text-indigo-600 hover:shadow-sm' }}">
                                @if($activeLayanan === $jenis->id)
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                @endif
                                {{ $jenis->nama_layanan }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-400">
                    <p class="text-xs">Data unit layanan belum tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- RIGHT: Detail Content -->
        <div class="w-full lg:w-2/3 p-6 lg:p-10 relative bg-white">
            @if($currentLayanan)
                <div class="animate-fade-in space-y-8">
                    <!-- Header Detail -->
                    <div class="border-b border-slate-100 pb-6">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-indigo-100">
                                {{ $currentLayanan->poli->nama_poli ?? 'Unit' }}
                            </span>
                            <span class="text-slate-300">|</span>
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Untuk Pasien {{ $selectedPatientType }}</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-2">{{ $currentLayanan->nama_layanan }}</h2>
                        <p class="text-slate-500 leading-relaxed max-w-2xl">{{ $currentLayanan->deskripsi }}</p>
                    </div>

                    <!-- Flow Timeline -->
                    @if($alurs->count() > 0)
                    <div class="relative pl-8 md:pl-12 space-y-10 before:absolute before:inset-0 before:ml-4 before:h-full before:w-0.5 before:bg-slate-100">
                        @foreach($alurs as $index => $alur)
                        <div class="relative group">
                            <!-- Number Indicator -->
                            <div class="absolute -left-[45px] md:-left-[61px] top-0 flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full border-4 border-white flex items-center justify-center font-black text-sm shadow-md z-10 transition-transform group-hover:scale-110 {{ $alur->is_critical ? 'bg-rose-500 text-white shadow-rose-200' : 'bg-white text-slate-900 shadow-slate-200 ring-1 ring-slate-200' }}">
                                    {{ $loop->iteration }}
                                </div>
                            </div>

                            <!-- Content Card -->
                            <div class="bg-white rounded-2xl p-6 border border-slate-100 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-300 group-hover:-translate-y-1">
                                <div class="flex flex-col md:flex-row gap-6">
                                    @if($alur->gambar)
                                    <div class="w-full md:w-32 h-32 bg-slate-100 rounded-xl overflow-hidden shrink-0">
                                        <img src="{{ asset('storage/'.$alur->gambar) }}" class="w-full h-full object-cover">
                                    </div>
                                    @endif

                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-bold text-lg text-slate-800">{{ $alur->judul }}</h4>
                                            @if($alur->is_critical)
                                                <span class="px-2 py-0.5 rounded bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-wider">Wajib</span>
                                            @endif
                                        </div>
                                        
                                        <p class="text-sm text-slate-600 mb-4 leading-relaxed">{{ $alur->deskripsi }}</p>

                                        <!-- Meta Info -->
                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 text-slate-600 text-[10px] font-bold border border-slate-200">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                {{ $alur->waktu_range ?? $alur->estimasi_waktu }}
                                            </span>
                                            @if($alur->total_biaya > 0)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-100">
                                                <svg class="w-3 h-3 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Rp {{ number_format($alur->total_biaya, 0, ',', '.') }}
                                            </span>
                                            @endif
                                        </div>

                                        @if($alur->dokumen_syarat)
                                        <div class="mt-4 p-3 bg-amber-50 rounded-xl border border-amber-100 flex gap-3 items-start">
                                            <svg class="w-4 h-4 text-amber-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <div>
                                                <span class="block text-[10px] font-black uppercase text-amber-600 mb-0.5">Persyaratan Dokumen</span>
                                                <p class="text-xs font-bold text-slate-700">{{ $alur->dokumen_syarat }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Belum Ada Data Langkah</h3>
                        <p class="text-slate-500 text-sm max-w-xs mx-auto mt-1">Detail langkah untuk layanan ini sedang disiapkan oleh administrator.</p>
                    </div>
                    @endif
                </div>
            @else
                <!-- Empty State (No Service Selected) -->
                <div class="h-full min-h-[500px] flex flex-col items-center justify-center text-center p-8">
                    <div class="w-32 h-32 bg-indigo-50 rounded-full flex items-center justify-center mb-6 animate-pulse-slow">
                        <svg class="w-16 h-16 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3">Mulai Penelusuran</h3>
                    <p class="text-slate-500 max-w-sm mx-auto leading-relaxed">
                        Pilih <span class="font-bold text-indigo-600">Unit Layanan</span> di sebelah kiri, kemudian pilih jenis tindakan untuk melihat alur selengkapnya.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>