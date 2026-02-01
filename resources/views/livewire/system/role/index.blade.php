<div class="space-y-8 animate-fade-in">
    <!-- Header Stats & Action -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-800">Peran & Hak Akses</h2>
            <p class="text-slate-500 font-medium mt-2">Kelola akses pengguna ke fitur sistem secara dinamis dan aman.</p>
        </div>
        <a href="{{ route('system.role.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl text-sm font-black uppercase tracking-wider hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Buat Role Baru
        </a>
    </div>

    <!-- Role Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($roles as $role)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative group hover:border-indigo-200 transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg font-black uppercase">
                    {{ substr($role->name, 0, 2) }}
                </div>
                
                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('system.role.edit', $role->id) }}" class="p-2 rounded-lg bg-slate-100 text-slate-500 hover:bg-indigo-100 hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    </a>
                    <button wire:click="delete({{ $role->id }})" 
                            onclick="return confirm('Hapus role ini? User yang memiliki role ini akan kehilangan akses.') || event.stopImmediatePropagation()"
                            class="p-2 rounded-lg bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </div>
            </div>

            <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $role->name }}</h3>
            <p class="text-xs text-slate-400 font-medium mb-6">Guard: {{ $role->guard_name }}</p>

            <div class="flex items-center gap-4 pt-4 border-t border-dashed border-slate-100">
                <div>
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengguna</span>
                    <span class="text-lg font-bold text-slate-700">{{ $role->users_count }}</span>
                </div>
                <div class="w-px h-8 bg-slate-100"></div>
                <div>
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Hak Akses</span>
                    <span class="text-lg font-bold text-indigo-600">{{ $role->permissions_count }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center border-2 border-dashed border-slate-200 rounded-[2rem]">
            <p class="text-slate-400 font-bold">Belum ada role yang dibuat.</p>
        </div>
        @endforelse
    </div>
</div>
