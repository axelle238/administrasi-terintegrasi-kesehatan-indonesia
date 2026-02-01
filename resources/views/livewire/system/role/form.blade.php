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
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm sticky top-20 z-30 backdrop-blur-md bg-white/90">
        <div class="flex-1 w-full lg:w-auto">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-800">Konfigurasi Peran</h2>
                    <p class="text-xs text-slate-500 font-medium">Atur hak akses secara spesifik.</p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
            <div class="relative flex-1 lg:w-64">
                <input wire:model="name" type="text" placeholder="Nama Role (e.g. HR Manager)" 
                       class="w-full pl-4 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500 placeholder-slate-400">
                @error('name') <span class="absolute -bottom-4 left-0 text-[10px] font-bold text-rose-500">{{ $message }}</span> @enderror
            </div>

            <button wire:click="syncPermissions" wire:loading.attr="disabled" class="px-3 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-200 transition-colors flex items-center gap-2" title="Scan Fitur Baru">
                <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
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
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            
            <!-- Sidebar Navigation (Compact) -->
            <div class="w-full lg:w-64 bg-white rounded-[1.5rem] p-3 border border-slate-100 shadow-sm lg:sticky lg:top-48 max-h-[calc(100vh-12rem)] overflow-y-auto custom-scrollbar">
                <div class="mb-3 px-1">
                    <input x-model="search" type="text" placeholder="Cari fitur..." 
                           class="w-full bg-slate-50 border-none rounded-lg text-[11px] font-bold py-2 px-3 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <nav class="space-y-0.5">
                    <button @click="activeGroup = 'all'" 
                            :class="activeGroup === 'all' ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50'"
                            class="w-full text-left px-3 py-2 rounded-lg text-[11px] font-black uppercase tracking-wider transition-all flex justify-between items-center">
                        <span>Semua Modul</span>
                        <span class="bg-white px-1.5 py-0.5 rounded border border-slate-100 text-[9px]">{{ count($groupedPermissions, COUNT_RECURSIVE) - count($groupedPermissions) }}</span>
                    </button>
                    
                    <div class="h-px bg-slate-100 my-2 mx-2"></div>

                    @foreach($groupedPermissions as $group => $permissions)
                    <button @click="activeGroup = '{{ $group }}'" 
                            :class="activeGroup === '{{ $group }}' ? 'bg-slate-800 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700'"
                            class="w-full text-left px-3 py-2 rounded-lg text-[11px] font-bold transition-all flex justify-between items-center group">
                        <span class="truncate pr-2">{{ $group ?: 'Lainnya' }}</span>
                        <span class="text-[9px] font-mono opacity-50">{{ count($permissions) }}</span>
                    </button>
                    @endforeach
                </nav>
            </div>

            <!-- Permission Grid (Compact & Dense) -->
            <div class="flex-1 w-full">
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                    @foreach($groupedPermissions as $group => $permissions)
                    <div x-show="(activeGroup === 'all' || activeGroup === '{{ $group }}') && (search === '' || '{{ strtolower($group) }}'.includes(search.toLowerCase()) || $el.querySelectorAll('label').length > 0)" 
                         class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:border-indigo-200 transition-all duration-300">
                        
                        <!-- Card Header -->
                        <div class="px-4 py-2.5 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="font-black text-slate-700 text-[11px] uppercase tracking-wider truncate pr-2" title="{{ $group }}">{{ $group ?: 'Lainnya' }}</h3>
                            <button wire:click="toggleGroup('{{ $group }}')" class="text-[10px] font-bold text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 px-2 py-0.5 rounded transition-colors whitespace-nowrap">
                                Toggle All
                            </button>
                        </div>

                        <!-- Card Body (Scrollable & Grid) -->
                        <div class="p-3 max-h-60 overflow-y-auto custom-scrollbar bg-white">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-1">
                                @foreach($permissions as $perm)
                                <label x-show="matchSearch('{{ $perm['name'] }}', '{{ $perm['readable_name'] }}')" 
                                       class="flex items-center gap-2 cursor-pointer group p-1.5 rounded-lg hover:bg-indigo-50 transition-colors border border-transparent hover:border-indigo-100">
                                    <div class="relative flex items-center shrink-0">
                                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm['id'] }}" 
                                               class="w-3.5 h-3.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all">
                                    </div>
                                    <div class="min-w-0 flex-1 leading-tight">
                                        <span class="block text-[11px] font-bold text-slate-700 group-hover:text-indigo-700 transition-colors truncate">
                                            {{ $perm['readable_name'] }}
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
                <div x-show="search !== '' && $el.previousElementSibling.querySelectorAll('div[x-show]:not([style*=\'display: none\'])').length === 0" 
                     style="display: none;"
                     class="text-center py-12">
                    <p class="text-slate-400 text-sm font-bold">Tidak ada fitur yang cocok dengan pencarian.</p>
                </div>
            </div>
        </div>
    @endif
</div>