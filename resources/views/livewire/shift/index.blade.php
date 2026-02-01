<div class="space-y-6 animate-fade-in">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-black text-slate-800">Master Shift</h2>
            <p class="text-sm text-slate-500">Konfigurasi jam kerja untuk penjadwalan.</p>
        </div>
        <button wire:click="create" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Shift
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-bold border border-emerald-100 mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($shifts as $shift)
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-slate-50 to-slate-100 rounded-bl-[3rem] -mr-4 -mt-4 z-0"></div>
            
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg" style="background-color: {{ $shift->color ?? '#3b82f6' }}">
                        <span class="text-lg font-black">{{ substr($shift->nama_shift, 0, 1) }}</span>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="edit({{ $shift->id }})" class="p-2 text-slate-400 hover:text-blue-600 bg-slate-50 rounded-lg hover:bg-blue-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                        </button>
                        <button wire:click="delete({{ $shift->id }})" wire:confirm="Hapus shift ini?" class="p-2 text-slate-400 hover:text-red-600 bg-slate-50 rounded-lg hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $shift->nama_shift }}</h3>
                <div class="flex items-center gap-2 text-slate-500 font-mono text-sm">
                    <span>{{ \Carbon\Carbon::parse($shift->jam_masuk)->format('H:i') }}</span>
                    <span class="text-slate-300">-</span>
                    <span>{{ \Carbon\Carbon::parse($shift->jam_keluar)->format('H:i') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Form Section (Inline - No Modal) -->
    @if($isOpen)
    <div class="bg-white rounded-[2rem] p-8 border border-blue-100 shadow-xl shadow-blue-500/5 mb-8 animate-fade-in-up">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-black text-slate-800">{{ $shiftId ? 'Edit Shift Kerja' : 'Buat Shift Baru' }}</h3>
            <button wire:click="closeForm" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Shift</label>
                <input type="text" wire:model="nama_shift" class="w-full rounded-xl border-slate-200 font-bold focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Pagi / Siang / Malam">
                @error('nama_shift') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jam Masuk</label>
                <input type="time" wire:model="jam_masuk" class="w-full rounded-xl border-slate-200 font-bold focus:border-blue-500 focus:ring-blue-500">
                @error('jam_masuk') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jam Keluar</label>
                <input type="time" wire:model="jam_keluar" class="w-full rounded-xl border-slate-200 font-bold focus:border-blue-500 focus:ring-blue-500">
                @error('jam_keluar') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Warna Label Visual</label>
                <div class="flex flex-wrap gap-3">
                    @foreach(['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#0f172a'] as $c)
                        <button wire:click="$set('color', '{{ $c }}')" class="w-10 h-10 rounded-xl border-2 {{ $color === $c ? 'border-slate-800 scale-110' : 'border-transparent' }} transition-all shadow-sm" style="background-color: {{ $c }}"></button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-50">
            <button wire:click="closeForm" class="px-6 py-2.5 bg-slate-100 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 transition-colors uppercase tracking-widest">Batal</button>
            <button wire:click="store" class="px-8 py-2.5 bg-blue-600 text-white font-bold text-sm rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-600/20 transition-colors uppercase tracking-widest">Simpan Perubahan</button>
        </div>
    </div>
    @endif
</div>