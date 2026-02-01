<div class="space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 rounded-[2rem] shadow-sm border border-emerald-100">
        <div>
            <h2 class="text-xl font-black text-slate-800">Alur Pelayanan Publik</h2>
            <p class="text-sm text-slate-500">Atur langkah-langkah pelayanan yang tampil di halaman depan.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition-all" {{ $isEditing ? 'disabled' : '' }}>
            + Tambah Langkah
        </button>
    </div>

    <!-- Form Inline -->
    @if($isEditing)
    <div class="bg-white p-8 rounded-[2.5rem] shadow-lg border border-emerald-200 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
        <h3 class="text-lg font-black text-slate-800 mb-6">{{ $alurId ? 'Edit Langkah' : 'Langkah Baru' }}</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Judul Langkah</label>
                <input wire:model="judul" type="text" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                @error('judul') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Urutan</label>
                <input wire:model="urutan" type="number" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi Singkat</label>
                <textarea wire:model="deskripsi" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500"></textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Icon (Heroicon Name)</label>
                <input wire:model="icon" type="text" placeholder="e.g. user, clipboard-check" class="w-full rounded-xl border-slate-200 text-sm font-mono text-slate-600">
            </div>
            <div class="flex items-center pt-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input wire:model="is_active" type="checkbox" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-5 h-5">
                    <span class="text-sm font-bold text-slate-700">Tampilkan di Halaman Depan</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold uppercase text-xs hover:bg-slate-50">Batal</button>
            <button wire:click="store" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold uppercase text-xs shadow-lg hover:bg-emerald-700">Simpan</button>
        </div>
    </div>
    @endif

    <!-- List -->
    <div class="grid grid-cols-1 gap-4">
        @forelse($alurs as $alur)
        <div class="bg-white p-4 rounded-2xl border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black text-lg">
                    {{ $alur->urutan }}
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">{{ $alur->judul }}</h4>
                    <p class="text-xs text-slate-500 line-clamp-1">{{ $alur->deskripsi }}</p>
                </div>
            </div>
            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <button wire:click="edit({{ $alur->id }})" class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                </button>
                <button wire:click="delete({{ $alur->id }})" onclick="return confirm('Hapus?') || event.stopImmediatePropagation()" class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:text-rose-600 hover:bg-rose-50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-slate-400 font-bold border-2 border-dashed border-slate-200 rounded-3xl">Belum ada alur pelayanan.</div>
        @endforelse
    </div>
</div>
