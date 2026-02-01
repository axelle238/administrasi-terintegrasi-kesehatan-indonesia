<div class="space-y-6 animate-fade-in">
    <!-- Header Profile Summary -->
    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
        
        <!-- Avatar -->
        <div class="relative shrink-0">
            <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg overflow-hidden bg-slate-100">
                @if($pegawai->foto_profil)
                    <img src="{{ Storage::url($pegawai->foto_profil) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-4xl font-black text-slate-300">
                        {{ substr($pegawai->user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="absolute bottom-2 right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white border-2 border-white shadow-sm" title="Status Aktif">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
            </div>
        </div>

        <!-- Info -->
        <div class="flex-1 text-center md:text-left relative z-10">
            <div class="flex flex-col md:flex-row items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight">{{ $pegawai->user->name }}</h2>
                    <p class="text-slate-500 font-medium text-lg">{{ $pegawai->jabatan ?? 'Pegawai' }} • {{ $pegawai->nip ?? '-' }}</p>
                    <div class="flex items-center justify-center md:justify-start gap-3 mt-3">
                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider border border-blue-100">
                            {{ $pegawai->status_kepegawaian ?? 'Aktif' }}
                        </span>
                        @if($pegawai->poli)
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold uppercase tracking-wider border border-emerald-100">
                            {{ $pegawai->poli->nama_poli }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <button onclick="window.print()" class="px-6 py-2.5 bg-slate-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-slate-700 transition-all shadow-lg shadow-slate-800/20">
                        Cetak Dossier
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white p-2 rounded-2xl border border-slate-100 shadow-sm flex overflow-x-auto">
        @php
            $tabs = [
                'profil' => 'Biodata & Profil',
                'riwayat' => 'Riwayat Jabatan',
                'dokumen' => 'Dokumen & Kredensial',
                'pelanggaran' => 'Disiplin & Sanksi'
            ];
        @endphp
        @foreach($tabs as $key => $label)
            <button wire:click="setTab('{{ $key }}')" 
                class="flex-1 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all whitespace-nowrap {{ $activeTab === $key ? 'bg-blue-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <!-- Tab Content Area -->
    <div class="min-h-[400px]">
        @if($activeTab === 'profil')
            <livewire:pegawai.tabs.profil :pegawai="$pegawai" wire:key="tab-profil-{{ $pegawai->id }}" />
        @elseif($activeTab === 'riwayat')
            <livewire:pegawai.tabs.riwayat :pegawai="$pegawai" wire:key="tab-riwayat-{{ $pegawai->id }}" />
        @elseif($activeTab === 'dokumen')
            <livewire:pegawai.tabs.dokumen :pegawai="$pegawai" wire:key="tab-dokumen-{{ $pegawai->id }}" />
        @elseif($activeTab === 'pelanggaran')
            <div class="bg-white p-12 text-center rounded-[2.5rem] border border-dashed border-slate-200">
                <p class="text-slate-400 font-bold">Modul Disiplin Segera Hadir</p>
            </div>
        @endif
    </div>
</div>