<div class="space-y-6 animate-fade-in">
    <!-- Header & Filter -->
    <div class="flex flex-col md:flex-row justify-between gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-emerald-100">
        <div class="flex items-center gap-4 w-full md:w-auto">
            <h2 class="text-xl font-black text-slate-800 whitespace-nowrap">Daftar Harga</h2>
            <div class="relative w-full">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari layanan..." class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-50 border-none text-sm font-bold focus:ring-emerald-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition-all" {{ $isEditing ? 'disabled' : '' }}>
            + Tambah Layanan
        </button>
    </div>

    <!-- Form Inline -->
    @if($isEditing)
    <div class="bg-white p-8 rounded-[2.5rem] shadow-lg border border-emerald-200 relative overflow-hidden mb-6">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
        <h3 class="text-lg font-black text-slate-800 mb-6">{{ $tindakanId ? 'Edit Layanan' : 'Layanan Baru' }}</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Layanan / Tindakan</label>
                <input wire:model="nama_tindakan" type="text" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                @error('nama_tindakan') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori</label>
                <select wire:model="kategori" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Pilih Kategori</option>
                    <option value="Umum">Umum</option>
                    <option value="Gigi">Gigi & Mulut</option>
                    <option value="KIA">Ibu & Anak (KIA)</option>
                    <option value="Laboratorium">Laboratorium</option>
                    <option value="UGD">Gawat Darurat</option>
                    <option value="Administrasi">Administrasi</option>
                </select>
                @error('kategori') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Harga (Rp)</label>
                <input wire:model="harga" type="number" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                @error('harga') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Unit Poli (Opsional)</label>
                <select wire:model="poli_id" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Tidak Terikat Poli</option>
                    @foreach($polis as $poli)
                        <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi (Untuk Publik)</label>
                <textarea wire:model="deskripsi" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500"></textarea>
            </div>
            <div class="flex items-center pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input wire:model="is_active" type="checkbox" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-5 h-5">
                    <span class="text-sm font-bold text-slate-700">Tampilkan di Daftar Harga</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold uppercase text-xs hover:bg-slate-50">Batal</button>
            <button wire:click="store" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold uppercase text-xs shadow-lg hover:bg-emerald-700">Simpan</button>
        </div>
    </div>
    @endif

    <!-- Data Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tindakans as $tindakan)
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm relative group hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-wider">{{ $tindakan->kategori }}</span>
                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button wire:click="edit({{ $tindakan->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg></button>
                    <button wire:click="delete({{ $tindakan->id }})" onclick="return confirm('Hapus?') || event.stopImmediatePropagation()" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                </div>
            </div>
            
            <h4 class="text-lg font-black text-slate-800 mb-1">{{ $tindakan->nama_tindakan }}</h4>
            <p class="text-xs text-slate-500 line-clamp-2 h-8 mb-4">{{ $tindakan->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            
            <div class="pt-4 border-t border-dashed border-slate-100 flex justify-between items-center">
                <span class="text-xl font-black text-emerald-600">Rp {{ number_format($tindakan->harga, 0, ',', '.') }}</span>
                <span class="text-[10px] font-bold {{ $tindakan->is_active ? 'text-emerald-500' : 'text-rose-500' }}">
                    {{ $tindakan->is_active ? 'PUBLIK' : 'HIDDEN' }}
                </span>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-slate-400 font-bold">Belum ada data layanan.</div>
        @endforelse
    </div>
    
    <div class="pt-4">
        {{ $tindakans->links() }}
    </div>
</div>
