<div class="space-y-6 animate-fade-in">
    
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Konfigurasi Akses</h2>
            <p class="text-slate-500 text-sm">Tentukan fitur apa saja yang dapat diakses oleh peran ini.</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="syncPermissions" wire:loading.attr="disabled" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-indigo-100 transition-colors flex items-center gap-2">
                <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Scan Fitur Baru
            </button>
            <a href="{{ route('system.role.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button wire:click="save" class="px-6 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                Simpan Perubahan
            </button>
        </div>
    </div>

    <!-- Role Name Input -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Role / Peran</label>
        <input wire:model="name" type="text" placeholder="Contoh: Staff Keuangan" class="w-full text-lg font-bold text-slate-800 border-0 border-b-2 border-slate-200 focus:border-blue-500 focus:ring-0 bg-transparent px-0 py-2 placeholder-slate-300">
        @error('name') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>

    <!-- Permission Matrix -->
    @if($groupedPermissions->isEmpty())
        <div class="text-center py-12 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
            <p class="text-slate-400 font-bold mb-2">Belum ada fitur terdaftar.</p>
            <button wire:click="syncPermissions" class="text-blue-600 font-bold hover:underline">Klik di sini untuk memindai fitur sistem</button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($groupedPermissions as $group => $permissions)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-black text-slate-700 text-sm uppercase tracking-wide">{{ $group ?: 'Lainnya' }}</h3>
                    <button wire:click="toggleGroup('{{ $group }}')" class="text-[10px] font-bold text-blue-500 hover:text-blue-700 uppercase">
                        Pilih Semua
                    </button>
                </div>
                <div class="p-4 flex-1">
                    <div class="space-y-3">
                        @foreach($permissions as $perm)
                        <label class="flex items-start gap-3 cursor-pointer group hover:bg-slate-50 p-2 rounded-lg transition-colors -mx-2">
                            <div class="relative flex items-start">
                                <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm->id }}" class="peer h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            </div>
                            <div class="text-sm">
                                <span class="font-bold text-slate-700 block group-hover:text-blue-700 transition-colors">{{ $perm->readable_name }}</span>
                                <span class="text-xs text-slate-400 font-mono">{{ $perm->name }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
