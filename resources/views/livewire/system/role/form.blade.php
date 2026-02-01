<div class="space-y-6 animate-fade-in" x-data="{ 
    activeGroup: 'all', 
    search: '',
    matchSearch(permName, readableName) {
        if (this.search === '') return true;
        let s = this.search.toLowerCase();
        return permName.toLowerCase().includes(s) || readableName.toLowerCase().includes(s);
    }
}">
    
    <!-- Header & Actions -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm sticky top-20 z-20">
        <div class="flex-1 w-full lg:w-auto">
            <h2 class="text-2xl font-black text-slate-800">Konfigurasi Peran</h2>
            <div class="flex items-center gap-4 mt-2 w-full">
                <!-- Role Name Input (Compact) -->
                <div class="relative flex-1 max-w-md">
                    <input wire:model="name" type="text" placeholder="Nama Role (e.g. HR Manager)" 
                           class="w-full pl-4 pr-4 py-2 rounded-xl bg-slate-50 border-0 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500 placeholder-slate-400">
                    @error('name') <span class="absolute -bottom-5 left-0 text-[10px] font-bold text-rose-500">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="flex gap-2 w-full lg:w-auto">
            <button wire:click="syncPermissions" wire:loading.attr="disabled" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-200 transition-colors flex items-center gap-2" title="Scan Fitur Baru">
                <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span class="hidden sm:inline">Sync</span>
            </button>
            <a href="{{ route('system.role.index') }}" class="px-4 py-2.5 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-white transition-colors">
                Batal
            </a>
            <button wire:click="save" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/30">
                Simpan
            </button>
        </div>
    </div>

    @if(empty($groupedPermissions))
        <div class="text-center py-20 bg-white rounded-[2.5rem] border-2 border-dashed border-slate-200">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <p class="text-slate-400 font-bold mb-4">Belum ada permission terdaftar.</p>
            <button wire:click="syncPermissions" class="px-6 py-2 rounded-full bg-indigo-50 text-indigo-600 text-sm font-bold hover:bg-indigo-100 transition-colors">
                Jalankan Auto-Discovery
            </button>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            
            <!-- Sidebar Navigation (Module List) -->
            <div class="w-full lg:w-72 bg-white rounded-[2rem] p-4 border border-slate-100 shadow-sm lg:sticky lg:top-48 max-h-[calc(100vh-12rem)] overflow-y-auto custom-scrollbar">
                <div class="mb-4 px-2">
                    <input x-model="search" type="text" placeholder="Cari fitur spesifik..." 
                           class="w-full bg-slate-50 border-none rounded-xl text-xs font-bold py-2.5 px-4 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <nav class="space-y-1">
                    <button @click="activeGroup = 'all'" 
                            :class="activeGroup === 'all' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50'"
                            class="w-full text-left px-4 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all flex justify-between items-center">
                        <span>Semua Modul</span>
                        <span class="bg-white/20 px-2 py-0.5 rounded text-[10px]">{{ count($groupedPermissions, COUNT_RECURSIVE) - count($groupedPermissions) }}</span>
                    </button>
                    
                    <div class="h-px bg-slate-100 my-2 mx-2"></div>

                    @foreach($groupedPermissions as $group => $permissions)
                    <button @click="activeGroup = '{{ $group }}'" 
                            :class="activeGroup === '{{ $group }}' ? 'bg-white border-l-4 border-indigo-500 text-indigo-700 shadow-sm' : 'border-l-4 border-transparent text-slate-500 hover:bg-slate-50 hover:text-slate-800'"
                            class="w-full text-left px-4 py-2.5 rounded-r-xl text-xs font-bold transition-all flex justify-between items-center group">
                        <span class="truncate pr-2">{{ $group ?: 'Lainnya' }}</span>
                        <span class="text-[10px] font-mono text-slate-300 group-hover:text-slate-400">{{ count($permissions) }}</span>
                    </button>
                    @endforeach
                </nav>
            </div>

            <!-- Permission Grid -->
            <div class="flex-1 w-full">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($groupedPermissions as $group => $permissions)
                    <div x-show="(activeGroup === 'all' || activeGroup === '{{ $group }}') && (search === '' || '{{ strtolower($group) }}'.includes(search.toLowerCase()) || $el.querySelectorAll('label').length > 0)" 
                         class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:border-indigo-200 transition-all duration-300">
                        
                        <!-- Card Header -->
                        <div class="px-5 py-3 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="font-black text-slate-700 text-xs uppercase tracking-wide truncate pr-2" title="{{ $group }}">{{ $group ?: 'Lainnya' }}</h3>
                            <button wire:click="toggleGroup('{{ $group }}')" class="text-[10px] font-bold text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 px-2 py-1 rounded transition-colors whitespace-nowrap">
                                Toggle All
                            </button>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 space-y-2">
                            @foreach($permissions as $perm)
                            <label x-show="matchSearch('{{ $perm['name'] }}', '{{ $perm['readable_name'] }}')" 
                                   class="flex items-start gap-3 cursor-pointer group p-2 rounded-lg hover:bg-indigo-50/50 transition-colors border border-transparent hover:border-indigo-100">
                                <div class="relative flex items-center pt-0.5">
                                    <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm['id'] }}" 
                                           class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-xs font-bold text-slate-700 group-hover:text-indigo-700 transition-colors leading-tight mb-0.5">
                                        {{ $perm['readable_name'] }}
                                    </span>
                                    <span class="block text-[10px] text-slate-400 font-mono truncate" title="{{ $perm['name'] }}">
                                        {{ $perm['name'] }}
                                    </span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Empty State Search -->
                <div x-show="search !== '' && $el.previousElementSibling.querySelectorAll('div[x-show]:not([style*=\'display: none\'])').length === 0" 
                     style="display: none;"
                     class="text-center py-12">
                    <p class="text-slate-400 text-sm">Tidak ada fitur yang cocok dengan pencarian.</p>
                </div>
            </div>
        </div>
    @endif
</div>