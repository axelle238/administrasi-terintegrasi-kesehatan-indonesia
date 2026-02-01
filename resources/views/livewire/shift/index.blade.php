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

    <!-- Modal Form (Simple Overlay) -->
    @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-[2rem] p-8 w-full max-w-md shadow-2xl animate-fade-in-up">
            <h3 class="text-lg font-black text-slate-800 mb-6">{{ $shiftId ? 'Edit Shift' : 'Buat Shift Baru' }}</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Shift</label>
                    <input type="text" wire:model="nama_shift" class="w-full rounded-xl border-slate-200 font-bold focus:border-blue-500 focus:ring-blue-500" placeholder="Pagi / Siang / Malam">
                    @error('nama_shift') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jam Masuk</label>
                        <input type="time" wire:model="jam_masuk" class="w-full rounded-xl border-slate-200 font-bold focus:border-blue-500 focus:ring-blue-500">
                        @error('jam_masuk') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jam Keluar</label>
                        <input type="time" wire:model="jam_keluar" class="w-full rounded-xl border-slate-200 font-bold focus:border-blue-500 focus:ring-blue-500">
                        @error('jam_keluar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Warna Label</label>
                    <div class="flex gap-3">
                        @foreach(['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'] as $c)
                            <button wire:click="$set('color', '{{ $c }}')" class="w-8 h-8 rounded-full border-2 {{ $color === $c ? 'border-slate-800 scale-110' : 'border-transparent' }} transition-all" style="background-color: {{ $c }}"></button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button wire:click="closeModal" class="px-6 py-2.5 bg-slate-100 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                <button wire:click="store" class="px-6 py-2.5 bg-blue-600 text-white font-bold text-sm rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-600/20 transition-colors">Simpan</button>
            </div>
        </div>
    </div>
    @endif
</div>