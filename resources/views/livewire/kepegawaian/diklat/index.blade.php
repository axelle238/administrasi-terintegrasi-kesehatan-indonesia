<div class="space-y-6 animate-fade-in pb-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-800">Program Pelatihan & Pengembangan</h2>
            <p class="text-sm text-slate-500">Kelola jadwal training, seminar, dan sertifikasi pegawai.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/20 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Jadwal Baru
        </button>
    </div>

    <!-- Form Panel (Inline) -->
    @if($isFormOpen)
    <div class="bg-white p-8 rounded-[2.5rem] border border-indigo-100 shadow-xl relative overflow-hidden animate-fade-in-up">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-widest">{{ $isEditing ? 'Edit Jadwal Diklat' : 'Rencana Diklat Baru' }}</h3>
            <button wire:click="cancel" class="p-2 text-slate-400 hover:text-slate-600 bg-slate-50 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Kegiatan</label>
                <input type="text" wire:model="nama_kegiatan" class="w-full rounded-xl border-slate-200 font-bold text-slate-700 focus:ring-indigo-500" placeholder="Contoh: Pelatihan ACLS Batch 1">
                @error('nama_kegiatan') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Jenis Diklat</label>
                <select wire:model="jenis_diklat" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                    <option value="">Pilih...</option>
                    <option value="Internal">Internal (In-House)</option>
                    <option value="Eksternal">Eksternal</option>
                    <option value="Seminar">Seminar / Workshop</option>
                    <option value="Sertifikasi">Sertifikasi Profesi</option>
                </select>
                @error('jenis_diklat') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Penyelenggara</label>
                <input type="text" wire:model="penyelenggara" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Mulai</label>
                <input type="date" wire:model="tanggal_mulai" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                @error('tanggal_mulai') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Selesai</label>
                <input type="date" wire:model="tanggal_selesai" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                @error('tanggal_selesai') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Total JP</label>
                <input type="number" wire:model="total_jam_pelajaran" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Biaya (Rp)</label>
                <input type="number" wire:model="biaya" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Peserta (Pilih Banyak)</label>
                <div class="h-40 overflow-y-auto border border-slate-200 rounded-xl p-4 bg-slate-50 grid grid-cols-1 md:grid-cols-3 gap-2">
                    @foreach($pegawais as $p)
                        <label class="flex items-center gap-2 p-2 bg-white rounded-lg border border-slate-100 cursor-pointer hover:border-indigo-300">
                            <input type="checkbox" wire:model="selectedPegawais" value="{{ $p->id }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs font-bold text-slate-700">{{ $p->user->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
            <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50">Batal</button>
            <button wire:click="save" class="px-8 py-2.5 rounded-xl bg-indigo-600 text-white font-bold shadow-lg hover:bg-indigo-700">Simpan Jadwal</button>
        </div>
    </div>
    @endif

    <!-- Data List -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($diklats as $d)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:border-indigo-200 transition-all group relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="w-24 h-24 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start gap-4 relative z-10">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex flex-col items-center justify-center border border-indigo-100 shrink-0">
                        <span class="text-xs font-black uppercase">{{ $d->tanggal_mulai->format('M') }}</span>
                        <span class="text-2xl font-black">{{ $d->tanggal_mulai->format('d') }}</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded-lg bg-slate-100 text-slate-500 text-[10px] font-black uppercase">{{ $d->jenis_diklat }}</span>
                            <span class="px-2 py-0.5 rounded-lg {{ $d->status == 'Selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} text-[10px] font-black uppercase">{{ $d->status }}</span>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $d->nama_kegiatan }}</h3>
                        <p class="text-sm text-slate-500 font-medium mt-1">{{ $d->penyelenggara }} • {{ $d->lokasi }}</p>
                        
                        <div class="flex items-center gap-4 mt-4 text-xs font-bold text-slate-400">
                            <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ $d->total_jam_pelajaran }} JP</span>
                            <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"/></svg> {{ $d->pesertas->count() }} Peserta</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button wire:click="edit({{ $d->id }})" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button wire:click="delete({{ $d->id }})" wire:confirm="Hapus jadwal diklat ini?" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200">
            <p class="text-slate-400 font-bold">Belum ada jadwal pelatihan.</p>
        </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $diklats->links() }}
    </div>
</div>