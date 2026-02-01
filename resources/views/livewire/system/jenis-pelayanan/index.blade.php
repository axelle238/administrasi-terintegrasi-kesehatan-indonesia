<div class="space-y-6 animate-fade-in">
    
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 rounded-[2rem] shadow-sm border border-emerald-100">
        <div>
            <h2 class="text-xl font-black text-slate-800">Master Jenis Pelayanan</h2>
            <p class="text-sm text-slate-500">Kelola kategori layanan utama (Rawat Jalan, UGD, dll) yang muncul di website.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition-all" {{ $isEditing ? 'disabled' : '' }}>
            + Tambah Jenis
        </button>
    </div>

    <!-- Form Inline -->
    @if($isEditing)
    <div class="bg-white p-8 rounded-[2.5rem] shadow-lg border border-emerald-200 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
        <h3 class="text-lg font-black text-slate-800 mb-6">{{ $jenisId ? 'Edit Jenis Pelayanan' : 'Tambah Jenis Baru' }}</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Layanan</label>
                <input wire:model="nama_layanan" type="text" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                @error('nama_layanan') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Icon (Heroicon)</label>
                <div class="flex gap-2">
                    <input wire:model="icon" type="text" class="w-full rounded-xl border-slate-200 text-sm font-mono text-slate-600">
                    <a href="https://heroicons.com/" target="_blank" class="px-3 py-2 bg-slate-100 rounded-xl text-slate-500 hover:text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi Singkat</label>
                <textarea wire:model="deskripsi" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500"></textarea>
            </div>
            <div>
                <label class="flex items-center gap-2 cursor-pointer bg-slate-50 px-4 py-2 rounded-xl border border-slate-200 hover:bg-white transition-colors">
                    <input wire:model="is_active" type="checkbox" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-5 h-5">
                    <span class="text-sm font-bold text-slate-700">Status Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold uppercase text-xs hover:bg-slate-50">Batal</button>
            <button wire:click="store" class="px-8 py-2.5 rounded-xl bg-emerald-600 text-white font-bold uppercase text-xs shadow-lg hover:bg-emerald-700 transition-colors">Simpan</button>
        </div>
    </div>
    @endif

    <!-- Grid List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($jenisPelayanans as $jenis)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm">
                    <!-- Dynamic Icon Rendering (Simple fallback if not SVG) -->
                    <span class="font-mono text-xs">{{ $jenis->icon }}</span>
                </div>
                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button wire:click="edit({{ $jenis->id }})" class="p-2 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg></button>
                    <button wire:click="delete({{ $jenis->id }})" onclick="return confirm('Hapus jenis pelayanan ini?') || event.stopImmediatePropagation()" class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                </div>
            </div>
            <h4 class="text-lg font-black text-slate-800 mb-2">{{ $jenis->nama_layanan }}</h4>
            <p class="text-sm text-slate-500 line-clamp-2 h-10">{{ $jenis->deskripsi }}</p>
            
            <div class="mt-4 pt-4 border-t border-dashed border-slate-100 flex justify-between items-center">
                <span class="text-[10px] font-bold uppercase tracking-wider {{ $jenis->is_active ? 'text-emerald-500' : 'text-slate-400' }}">
                    {{ $jenis->is_active ? 'Active' : 'Inactive' }}
                </span>
                <span class="text-[10px] font-bold text-slate-400">{{ $jenis->alurs()->count() }} Langkah Alur</span>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-slate-400 font-bold border-2 border-dashed border-slate-200 rounded-[2.5rem]">
            Belum ada jenis pelayanan.
        </div>
        @endforelse
    </div>
</div>
