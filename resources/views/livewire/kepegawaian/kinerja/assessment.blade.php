<div class="space-y-6 animate-fade-in pb-20">
    
    <!-- HEADER & NAVIGATION -->
    <div class="flex justify-between items-center bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-black text-slate-800">Evaluasi Kinerja Pegawai</h2>
            <p class="text-sm text-slate-500">Sistem penilaian KPI (Key Performance Indicator) Terpadu.</p>
        </div>
        @if($viewMode == 'list')
            <button wire:click="createPeriode" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Buka Periode Baru
            </button>
        @else
            <button wire:click="backToList" class="px-6 py-3 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </button>
        @endif
    </div>

    <!-- VIEW: LIST PERIODE -->
    @if($viewMode == 'list')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($periodes as $p)
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:border-indigo-200 hover:shadow-md transition-all group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-10 -mt-10 opacity-50 group-hover:scale-110 transition-transform"></div>
            
            <div class="relative z-10">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-[10px] font-black uppercase tracking-wider mb-4 inline-block">
                    {{ $p->is_active ? 'Sedang Berlangsung' : 'Selesai' }}
                </span>
                <h3 class="text-2xl font-black text-slate-800 mb-1">{{ $p->judul }}</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">
                    {{ $p->tanggal_mulai->format('d M') }} - {{ $p->tanggal_selesai->format('d M Y') }}
                </p>

                <div class="flex items-center justify-between">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-slate-200 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-slate-300 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-slate-400 border-2 border-white flex items-center justify-center text-[9px] text-white font-bold">+{{ $p->penilaians_count }}</div>
                    </div>
                    <button wire:click="openScoring({{ $p->id }})" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition-colors">
                        Kelola Penilaian &rarr;
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- VIEW: CREATE PERIODE -->
    @if($viewMode == 'create_period')
    <div class="bg-white p-8 rounded-[2.5rem] border border-indigo-100 shadow-xl max-w-2xl mx-auto animate-fade-in-up">
        <h3 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-widest text-center">Setup Periode Penilaian</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Judul Periode</label>
                <input type="text" wire:model="judul_periode" class="w-full rounded-xl border-slate-200 font-bold focus:ring-indigo-500" placeholder="Contoh: Q1 2024 Performance Review">
                @error('judul_periode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Mulai</label>
                    <input type="date" wire:model="tgl_mulai" class="w-full rounded-xl border-slate-200 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Selesai</label>
                    <input type="date" wire:model="tgl_selesai" class="w-full rounded-xl border-slate-200 font-bold">
                </div>
            </div>
            <button wire:click="savePeriode" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg hover:bg-indigo-700 mt-4">Simpan & Aktifkan</button>
        </div>
    </div>
    @endif

    <!-- VIEW: SCORING DASHBOARD -->
    @if($viewMode == 'scoring')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- List Pegawai (Sidebar) -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden h-[600px] flex flex-col">
            <div class="p-6 border-b border-slate-100 bg-slate-50">
                <h4 class="font-black text-slate-800">Daftar Pegawai</h4>
                <input type="text" placeholder="Cari nama..." class="mt-2 w-full rounded-xl border-none bg-white text-sm font-bold shadow-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="overflow-y-auto flex-1 p-4 space-y-2">
                @foreach($pegawais as $peg)
                <div wire:click="selectPegawai({{ $peg->id }})" 
                     class="p-3 rounded-xl border cursor-pointer transition-all flex items-center gap-3 {{ $selectedPegawaiId == $peg->id ? 'bg-indigo-50 border-indigo-200 ring-1 ring-indigo-300' : 'bg-white border-slate-100 hover:border-indigo-200' }}">
                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-black text-slate-500 text-xs">
                        {{ substr($peg->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">{{ $peg->user->name }}</p>
                        <p class="text-[10px] text-slate-500 uppercase">{{ $peg->jabatan }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Scoring Form (Main Area) -->
        <div class="lg:col-span-2">
            @if($selectedPegawaiId)
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl animate-fade-in-up">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-slate-800">Formulir Penilaian</h3>
                            <p class="text-sm text-slate-500">Isi skor untuk setiap indikator kinerja.</p>
                        </div>
                        <div class="px-4 py-2 bg-slate-100 rounded-xl">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Indikator</span>
                            <p class="text-xl font-black text-indigo-600 text-center">{{ $indikators->count() }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @foreach($indikators as $ind)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <div class="flex justify-between items-center mb-2">
                                <label class="font-bold text-slate-700 text-sm">{{ $ind->nama_indikator }}</label>
                                <span class="text-[10px] font-black bg-white px-2 py-1 rounded border border-slate-200 text-slate-400">Bobot: {{ $ind->bobot }}%</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <input type="range" wire:model.live="scores.{{ $ind->id }}" min="0" max="100" step="1" class="flex-1 h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                                <input type="number" wire:model.live="scores.{{ $ind->id }}" class="w-20 rounded-xl border-slate-200 text-center font-black text-indigo-600" min="0" max="100">
                            </div>
                        </div>
                        @endforeach

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Catatan Penilai (Feedback)</label>
                            <textarea wire:model="catatan_penilai" class="w-full rounded-2xl border-slate-200 p-4 font-medium text-slate-700 focus:ring-indigo-500" rows="4" placeholder="Berikan masukan konstruktif..."></textarea>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
                        <button wire:click="saveScore" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan & Finalisasi
                        </button>
                    </div>
                </div>
            @else
                <div class="h-full flex flex-col items-center justify-center text-center p-12 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200 opacity-75">
                    <svg class="w-20 h-20 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <h3 class="text-lg font-black text-slate-400">Pilih Pegawai</h3>
                    <p class="text-sm text-slate-400 max-w-xs">Klik salah satu pegawai di daftar sebelah kiri untuk mulai melakukan penilaian kinerja.</p>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>