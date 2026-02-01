<div class="space-y-8 animate-fade-in">
    <!-- Header Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between h-32 relative overflow-hidden group hover:border-blue-200 transition-all">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest relative z-10">Total SDM</span>
            <div class="relative z-10">
                <h3 class="text-3xl font-black text-slate-800">{{ $totalPegawai }}</h3>
                <p class="text-[10px] font-bold text-blue-500 mt-1">Personil Aktif</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between h-32 relative overflow-hidden group hover:border-emerald-200 transition-all">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest relative z-10">Tenaga Medis</span>
            <div class="relative z-10">
                <div class="flex gap-3 text-sm font-bold text-slate-600">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> {{ $totalDokter }} Dr</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-teal-500"></span> {{ $totalPerawat }} Prw</span>
                </div>
            </div>
        </div>

        <button wire:click="$set('filterStatus', '{{ $filterStatus == 'ews_str' ? '' : 'ews_str' }}')" class="bg-white p-5 rounded-3xl shadow-sm border {{ $filterStatus == 'ews_str' ? 'border-rose-500 ring-2 ring-rose-200' : 'border-slate-100' }} flex flex-col justify-between h-32 relative overflow-hidden group hover:border-rose-200 transition-all text-left">
            <div class="absolute right-0 top-0 w-24 h-24 bg-rose-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest relative z-10">Warning STR</span>
            <div class="relative z-10">
                <h3 class="text-3xl font-black {{ $ewsStr > 0 ? 'text-rose-600' : 'text-slate-800' }}">{{ $ewsStr }}</h3>
                <p class="text-[10px] font-bold text-rose-400 mt-1">Kedaluwarsa < 3 Bln</p>
            </div>
        </button>

        <button wire:click="$set('filterStatus', '{{ $filterStatus == 'ews_sip' ? '' : 'ews_sip' }}')" class="bg-white p-5 rounded-3xl shadow-sm border {{ $filterStatus == 'ews_sip' ? 'border-amber-500 ring-2 ring-amber-200' : 'border-slate-100' }} flex flex-col justify-between h-32 relative overflow-hidden group hover:border-amber-200 transition-all text-left">
            <div class="absolute right-0 top-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest relative z-10">Warning SIP</span>
            <div class="relative z-10">
                <h3 class="text-3xl font-black {{ $ewsSip > 0 ? 'text-amber-600' : 'text-slate-800' }}">{{ $ewsSip }}</h3>
                <p class="text-[10px] font-bold text-amber-500 mt-1">Kedaluwarsa < 3 Bln</p>
            </div>
        </button>
    </div>

    <!-- Toolbar & Filter -->
    <div class="bg-white p-4 rounded-3xl shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between gap-4 items-center">
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative w-full md:w-64">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari Nama / NIP..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 text-sm font-bold placeholder-slate-400 focus:ring-blue-500 focus:border-blue-500">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            
            <select wire:model.live="filterRole" class="pl-4 pr-10 py-2.5 rounded-xl border-slate-200 text-sm font-bold text-slate-600 focus:ring-blue-500 focus:border-blue-500 bg-slate-50">
                <option value="">Semua Jabatan</option>
                <option value="dokter">Dokter</option>
                <option value="perawat">Perawat</option>
                <option value="apoteker">Apoteker</option>
                <option value="staf">Staf Admin</option>
            </select>
        </div>

        <div class="flex gap-3">
             <button wire:click="syncBpjs" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-slate-50 hover:text-blue-600 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                Sync BPJS
            </button>
            <a href="{{ route('pegawai.create') }}" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Pegawai
            </a>
        </div>
    </div>

    <!-- Employee Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($pegawais as $pegawai)
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative group hover:border-blue-300 hover:shadow-md transition-all">
            <!-- Action Menu (Absolute) -->
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="p-2 bg-slate-100 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 inline-block shadow-sm border border-slate-200" title="Lihat Dossier">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </a>
            </div>

            <!-- Avatar & Role -->
            <div class="flex items-start gap-4 mb-4">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-xl font-black text-slate-400 overflow-hidden shrink-0">
                    @if($pegawai->foto)
                        <img src="{{ Storage::url($pegawai->foto) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($pegawai->user->name ?? 'X', 0, 1) }}
                    @endif
                </div>
                <div class="min-w-0">
                    <h4 class="font-bold text-slate-800 line-clamp-1 text-sm">{{ $pegawai->user->name ?? 'Tanpa Nama' }}</h4>
                    <p class="text-xs text-slate-400 font-medium mb-2">{{ $pegawai->nip ?? 'NIP: -' }}</p>
                    <span class="px-2 py-1 rounded bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-wider">
                        {{ $pegawai->user->role ?? 'Staff' }}
                    </span>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="grid grid-cols-2 gap-y-3 gap-x-2 text-xs border-t border-dashed border-slate-100 pt-4 mb-4">
                <div>
                    <span class="block text-slate-400 font-bold uppercase text-[9px]">Jabatan</span>
                    <span class="font-bold text-slate-700 truncate block">{{ $pegawai->jabatan ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-slate-400 font-bold uppercase text-[9px]">Poli / Unit</span>
                    <span class="font-bold text-slate-700 truncate block">{{ $pegawai->poli->nama_poli ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-slate-400 font-bold uppercase text-[9px]">STR Expired</span>
                    <span class="font-bold {{ $pegawai->masa_berlaku_str && \Carbon\Carbon::parse($pegawai->masa_berlaku_str)->isPast() ? 'text-rose-600' : 'text-slate-700' }}">
                        {{ $pegawai->masa_berlaku_str ? \Carbon\Carbon::parse($pegawai->masa_berlaku_str)->format('d M Y') : '-' }}
                    </span>
                </div>
                <div>
                    <span class="block text-slate-400 font-bold uppercase text-[9px]">SIP Expired</span>
                    <span class="font-bold {{ $pegawai->masa_berlaku_sip && \Carbon\Carbon::parse($pegawai->masa_berlaku_sip)->isPast() ? 'text-rose-600' : 'text-slate-700' }}">
                        {{ $pegawai->masa_berlaku_sip ? \Carbon\Carbon::parse($pegawai->masa_berlaku_sip)->format('d M Y') : '-' }}
                    </span>
                </div>
            </div>

            <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="block w-full text-center py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                Buka Dossier Digital
            </a>
        </div>
        @empty
        <div class="col-span-full p-12 text-center border-2 border-dashed border-slate-200 rounded-3xl">
            <p class="text-slate-400 font-bold">Tidak ada data pegawai yang cocok dengan filter.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $pegawais->links() }}
    </div>
</div>