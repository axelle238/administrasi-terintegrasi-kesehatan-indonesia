<div class="space-y-6 animate-fade-in" x-data="{
    activeGroup: 'all',
    search: '',
    matchSearch(permName, readableName) {
        if (this.search === '') return true;
        let s = this.search.toLowerCase();
        return permName.toLowerCase().includes(s) || readableName.toLowerCase().includes(s);
    }
}">
    
    <!-- Sticky Header & Actions -->
    <div class="sticky top-20 z-40 bg-white/80 backdrop-blur-xl p-4 rounded-[2rem] border border-white/20 shadow-xl shadow-slate-200/20 mb-8">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4 w-full lg:w-auto">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20 shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                </div>
                <div class="flex-1">
                    <input wire:model="name" type="text" placeholder="Nama Role (e.g. HR Manager)" 
                           class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-500 focus:ring-0 text-xl font-black text-slate-800 placeholder-slate-300 px-0 py-1 transition-all">
                    @error('name') <span class="text-[10px] font-bold text-rose-500 block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center gap-2 w-full lg:w-auto justify-end">
                <button wire:click="syncPermissions" wire:loading.attr="disabled" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-colors" title="Scan Fitur Baru">
                    <svg wire:loading.remove class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    <svg wire:loading class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
                
                <a href="{{ route('system.role.index') }}" class="px-6 py-3 border border-slate-200 text-slate-500 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                
                <button wire:click="save" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5">
                    Simpan Konfigurasi
                </button>
            </div>
        </div>
    </div>

    @if(empty($groupedPermissions))
        <div class="flex flex-col items-center justify-center py-24 bg-white rounded-[3rem] border border-dashed border-slate-200 text-center">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 text-slate-300">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800">Database Fitur Kosong</h3>
            <p class="text-slate-400 max-w-xs mt-2 mb-8">Sistem belum memindai daftar fitur yang tersedia. Jalankan scan untuk memulai.</p>
            <button wire:click="syncPermissions" class="px-8 py-3 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-bold hover:bg-indigo-100 transition-colors">
                Mulai Auto-Discovery
            </button>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            
            <!-- Sidebar Navigation (Sticky & Scrollspy-like) -->
            <div class="w-full lg:w-72 shrink-0">
                <div class="bg-white rounded-[2rem] p-2 shadow-sm border border-slate-100 lg:sticky lg:top-48 overflow-hidden">
                    <div class="p-2 mb-2">
                        <div class="relative">
                            <input x-model="search" type="text" placeholder="Cari izin akses..." 
                                   class="w-full bg-slate-50 border-none rounded-xl text-xs font-bold py-3 pl-9 pr-4 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/20 text-slate-700">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>
                    
                    <div class="max-h-[60vh] overflow-y-auto custom-scrollbar px-2 pb-2 space-y-1">
                        <button @click="activeGroup = 'all'" 
                                :class="activeGroup === 'all' ? 'bg-slate-800 text-white shadow-lg shadow-slate-800/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700'"
                                class="w-full text-left px-4 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all flex justify-between items-center group">
                            <span>Semua Modul</span>
                            <span :class="activeGroup === 'all' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-400'" class="px-2 py-0.5 rounded text-[10px] font-mono transition-colors">{{ count($groupedPermissions, COUNT_RECURSIVE) - count($groupedPermissions) }}</span>
                        </button>
                        
                        <div class="h-px bg-slate-100 my-2 mx-4"></div>

                        @foreach($groupedPermissions as $group => $permissions)
                        <button @click="activeGroup = '{{ $group }}'" 
                                :class="activeGroup === '{{ $group }}' ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700'"
                                class="w-full text-left px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex justify-between items-center group">
                            <span class="truncate pr-2">{{ $group ?: 'Lainnya' }}</span>
                            <span class="text-[9px] font-mono text-slate-300 group-hover:text-slate-400">{{ count($permissions) }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Permission Grid (Ultra Compact) -->
            <div class="flex-1 w-full min-w-0">
                <div class="space-y-6">
                    @foreach($groupedPermissions as $group => $permissions)
                    <div x-show="(activeGroup === 'all' || activeGroup === '{{ $group }}') && (search === '' || '{{ strtolower($group) }}'.includes(search.toLowerCase()) || $el.querySelectorAll('label').length > 0)" 
                         class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden transition-all duration-300">
                        
                        <!-- Group Header -->
                        <div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-white border-b border-slate-100 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-8 bg-indigo-500 rounded-full"></div>
                                <h3 class="font-black text-slate-700 text-sm uppercase tracking-wide">{{ $group ?: 'General' }}</h3>
                            </div>
                            <button wire:click="toggleGroup('{{ $group }}')" class="text-[10px] font-bold text-indigo-500 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                                Pilih Semua
                            </button>
                        </div>

                        <!-- Grid Body -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-x-6 gap-y-3">
                                @foreach($permissions as $perm)
                                <label x-show="matchSearch('{{ $perm['name'] }}', '{{ $perm['readable_name'] }}')" 
                                       class="flex items-start gap-3 cursor-pointer group p-2 -ml-2 rounded-xl hover:bg-indigo-50/50 transition-colors">
                                    
                                    <div class="relative flex items-center pt-0.5">
                                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm['id'] }}" 
                                               class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                                    </div>
                                    
                                    <div class="min-w-0 flex-1 leading-snug">
                                        <span class="block text-xs font-bold text-slate-600 group-hover:text-indigo-700 transition-colors">
                                            {{ $perm['readable_name'] }}
                                        </span>
                                        <span class="block text-[10px] text-slate-400 font-mono mt-0.5 truncate group-hover:text-indigo-400/70" title="{{ $perm['name'] }}">
                                            {{ $perm['name'] }}
                                        </span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Empty State Search -->
                <div x-show="search !== '' && $el.querySelectorAll('div[x-show]:not([style*=\'display: none\'])').length === 0" 
                     style="display: none;"
                     class="text-center py-20">
                    <p class="text-slate-400 text-sm font-bold">Tidak ada fitur yang cocok dengan pencarian "<span x-text="search"></span>".</p>
                </div>
            </div>
        </div>
    @endif
</div>
