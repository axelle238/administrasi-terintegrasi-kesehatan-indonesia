<div class="relative group w-full max-w-md" x-data="{ focused: false }" @click.away="focused = false">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <svg class="h-4 w-4 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </div>
    
    <input 
        wire:model.live.debounce.300ms="query"
        @focus="focused = true"
        type="text" 
        class="block w-full lg:w-96 pl-11 pr-4 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50/50 text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-400 sm:text-sm transition-all shadow-sm hover:bg-white font-medium" 
        placeholder="Cari pasien, pegawai, obat, atau aset..."
    >

    <!-- Dropdown Results -->
    @if(strlen($query) >= 2 && $focused)
        <div class="absolute top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 animate-fade-in-up">
            @if(count($results) > 0)
                <div class="max-h-[400px] overflow-y-auto custom-scrollbar divide-y divide-slate-50">
                    @foreach($results as $result)
                        <a href="{{ $result['url'] }}" class="flex items-center gap-4 p-4 hover:bg-slate-50 transition-colors group/item">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 
                                {{ $result['type'] == 'Pasien' ? 'bg-blue-50 text-blue-600' : '' }}
                                {{ $result['type'] == 'Pegawai' ? 'bg-purple-50 text-purple-600' : '' }}
                                {{ $result['type'] == 'Obat' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                {{ $result['type'] == 'Aset' ? 'bg-amber-50 text-amber-600' : '' }}
                            ">
                                @if($result['type'] == 'Pasien')
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                @elseif($result['type'] == 'Pegawai')
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @elseif($result['type'] == 'Obat')
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-black text-slate-800 truncate group-hover/item:text-blue-600 transition-colors">{{ $result['title'] }}</p>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">{{ $result['type'] }} • {{ $result['subtitle'] }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover/item:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    @endforeach
                </div>
                <div class="px-4 py-3 bg-slate-50 border-t border-slate-100 text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tekan Enter untuk pencarian lanjut</p>
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3 text-slate-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Tidak ditemukan</p>
                    <p class="text-xs text-slate-400 mt-1">Coba kata kunci lain.</p>
                </div>
            @endif
        </div>
    @endif
</div>
