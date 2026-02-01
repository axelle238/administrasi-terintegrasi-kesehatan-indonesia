<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-indigo-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Master Data Alur Pelayanan</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola hierarki layanan: Unit &rarr; Jenis Pelayanan &rarr; Langkah Alur.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-all flex items-center gap-2 transform hover:-translate-y-1">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Jenis Layanan
        </button>
    </div>

    <!-- Form Section (Jenis Pelayanan) -->
    @if($isFormOpen)
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-indigo-200 relative overflow-hidden ring-4 ring-indigo-50/50 mb-8">
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-400 via-purple-500 to-pink-500"></div>
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-slate-800">{{ $jenisId ? 'Edit Jenis Pelayanan' : 'Buat Jenis Pelayanan Baru' }}</h3>
                <button wire:click="cancel" class="text-slate-400 hover:text-rose-500"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Unit / Poliklinik (Parent)</label>
                    <select wire:model="poli_id" class="w-full rounded-xl border-slate-200 text-sm font-bold py-3 focus:ring-indigo-500">
                        <option value="">-- Pilih Unit Layanan --</option>
                        @foreach($listPolis as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                        @endforeach
                    </select>
                    @error('poli_id') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Layanan</label>
                    <input wire:model="nama_layanan" type="text" placeholder="Contoh: Cabut Gigi Dewasa" class="w-full rounded-xl border-slate-200 text-sm font-bold py-3 focus:ring-indigo-500">
                    @error('nama_layanan') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Icon (Heroicon)</label>
                    <input wire:model="icon" type="text" class="w-full rounded-xl border-slate-200 text-sm font-mono py-3 focus:ring-indigo-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi Singkat</label>
                    <textarea wire:model="deskripsi" rows="3" class="w-full rounded-xl border-slate-200 text-sm p-3 focus:ring-indigo-500"></textarea>
                </div>
                <div class="md:col-span-2 pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs uppercase hover:bg-slate-50">Batal</button>
                    <button wire:click="store" class="px-8 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs uppercase hover:bg-indigo-700 shadow-lg shadow-indigo-500/30">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Unit List Accordion -->
    <div class="space-y-6" x-data="{ activePoli: null }">
        @forelse($polis as $poli)
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
            <!-- Header Poli -->
            <button @click="activePoli = activePoli === {{ $poli->id }} ? null : {{ $poli->id }}" class="w-full flex justify-between items-center p-6 bg-slate-50/50 hover:bg-slate-50 transition-colors text-left">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-lg">
                        {{ substr($poli->nama_poli, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800">{{ $poli->nama_poli }}</h3>
                        <p class="text-sm text-slate-500 font-medium">{{ $poli->jenis_pelayanans_count }} Jenis Layanan Terdaftar</p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-300" :class="activePoli === {{ $poli->id }} ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>

            <!-- List Jenis Pelayanan -->
            <div x-show="activePoli === {{ $poli->id }}" x-collapse style="display: none;">
                <div class="p-6 pt-0 grid grid-cols-1 gap-4">
                    @forelse($poli->jenisPelayanans as $jenis)
                    <div class="flex flex-col md:flex-row md:items-center justify-between p-4 rounded-2xl border border-slate-100 bg-white hover:border-indigo-200 transition-all group">
                        <div class="flex items-center gap-4 mb-4 md:mb-0">
                            <div class="p-3 bg-slate-50 rounded-xl text-slate-500 group-hover:text-indigo-600 group-hover:bg-indigo-50 transition-colors">
                                {{-- Render Icon dynamic or fallback --}}
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $jenis->nama_layanan }}</h4>
                                <p class="text-xs text-slate-500">{{ Str::limit($jenis->deskripsi, 60) }}</p>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-[10px] font-bold bg-slate-100 text-slate-500 px-2 py-0.5 rounded">{{ $jenis->alur_pelayanans_count }} Langkah</span>
                                    <span class="text-[10px] font-bold {{ $jenis->is_active ? 'text-emerald-600' : 'text-rose-500' }}">{{ $jenis->is_active ? 'Aktif' : 'Non-Aktif' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <a href="{{ route('system.alur.manage', $jenis->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                                Kelola Alur
                            </a>
                            <button wire:click="edit({{ $jenis->id }})" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit Info">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </button>
                            <button wire:click="delete({{ $jenis->id }})" onclick="confirm('Hapus layanan ini beserta seluruh alurnya?') || event.stopImmediatePropagation()" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-slate-400 italic text-sm">Belum ada jenis pelayanan di unit ini.</div>
                    @endforelse
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white rounded-[2rem] border border-slate-100">
            <p class="text-slate-400 font-bold">Belum ada Unit/Poli terdaftar. Silakan tambahkan Poli terlebih dahulu.</p>
        </div>
        @endforelse
    </div>
</div>
