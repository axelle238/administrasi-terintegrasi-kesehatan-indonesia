<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 pb-20">
    <!-- Header Action -->
    <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Portofolio Kompetensi</h2>
            <p class="text-sm text-slate-500">Kelola riwayat pelatihan, seminar, dan sertifikat profesional Anda.</p>
        </div>
        @if(!$isOpen)
        <button wire:click="create" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 flex items-center gap-2 transform hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
            Upload Sertifikat
        </button>
        @endif
    </div>

    <!-- Form Upload -->
    @if($isOpen)
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-indigo-100 p-8 animate-fade-in relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <svg class="w-48 h-48 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
        </div>

        <form wire:submit.prevent="save" class="relative z-10 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Pelatihan / Seminar / Workshop</label>
                    <input type="text" wire:model="nama_pelatihan" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-800" placeholder="Contoh: Advanced Life Support (ACLS)">
                    @error('nama_pelatihan') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Penyelenggara</label>
                    <input type="text" wire:model="penyelenggara" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl" placeholder="Kemenkes / IDI / PPNI">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi (Kota/Online)</label>
                    <input type="text" wire:model="lokasi" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Mulai</label>
                    <input type="date" wire:model="tanggal_mulai" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Selesai</label>
                    <input type="date" wire:model="tanggal_selesai" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Jam Pelajaran (JPL/SKP)</label>
                    <input type="number" wire:model="jumlah_jam" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl" placeholder="0">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Sertifikat</label>
                    <input type="text" wire:model="nomor_sertifikat" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-mono">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Upload File Sertifikat (PDF/Image)</label>
                    <div class="border-2 border-dashed border-indigo-200 rounded-xl p-8 text-center bg-indigo-50 hover:bg-indigo-100 transition cursor-pointer relative">
                        <input type="file" wire:model="file_sertifikat" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="space-y-2">
                            <svg class="w-10 h-10 text-indigo-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                            <p class="text-sm font-bold text-indigo-600">Klik atau Drag file ke sini</p>
                            <p class="text-xs text-indigo-400">Maksimal 5MB</p>
                        </div>
                    </div>
                    <div wire:loading wire:target="file_sertifikat" class="text-xs text-indigo-500 font-bold mt-2">Mengupload...</div>
                    @error('file_sertifikat') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <button type="button" wire:click="$set('isOpen', false)" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg">Simpan Data</button>
            </div>
        </form>
    </div>
    @endif

    <!-- Timeline List -->
    <div class="space-y-6">
        @forelse($pelatihans as $p)
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col md:flex-row gap-6 relative overflow-hidden group">
            <div class="absolute left-0 top-0 bottom-0 w-2 {{ $p->status_validasi == 'Valid' ? 'bg-emerald-500' : ($p->status_validasi == 'Pending' ? 'bg-amber-500' : 'bg-red-500') }}"></div>
            
            <!-- Date Badge -->
            <div class="flex flex-col items-center justify-center w-20 h-20 bg-slate-50 rounded-2xl border border-slate-200 shrink-0">
                <span class="text-xs font-bold text-slate-400 uppercase">{{ $p->tanggal_mulai->format('M') }}</span>
                <span class="text-2xl font-black text-slate-800">{{ $p->tanggal_mulai->format('d') }}</span>
                <span class="text-xs font-bold text-slate-400">{{ $p->tanggal_mulai->format('Y') }}</span>
            </div>

            <div class="flex-1">
                <div class="flex justify-between items-start">
                    <h3 class="text-xl font-black text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $p->nama_pelatihan }}</h3>
                    <div class="flex items-center gap-2">
                        @if($p->file_sertifikat)
                        <a href="{{ Storage::url($p->file_sertifikat) }}" target="_blank" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-indigo-100 hover:text-indigo-600 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </a>
                        @endif
                        <button wire:click="delete({{ $p->id }})" wire:confirm="Hapus riwayat pelatihan ini?" class="p-2 bg-slate-100 text-red-400 rounded-lg hover:bg-red-100 hover:text-red-600 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                </div>
                
                <p class="text-sm font-bold text-slate-500 mt-1 uppercase tracking-wide">{{ $p->penyelenggara }} • {{ $p->lokasi ?? 'Online' }}</p>
                
                <div class="mt-4 flex flex-wrap gap-3">
                    <span class="px-3 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">
                        {{ $p->jumlah_jam }} Jam Pelajaran
                    </span>
                    <span class="px-3 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600 font-mono">
                        No: {{ $p->nomor_sertifikat ?? '-' }}
                    </span>
                    <span class="px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest {{ $p->status_validasi == 'Valid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $p->status_validasi }}
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16 border-2 border-dashed border-slate-200 rounded-[2.5rem]">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-700">Belum Ada Riwayat Pelatihan</h3>
            <p class="text-slate-400 text-sm">Mulai bangun portofolio kompetensi Anda sekarang.</p>
        </div>
        @endforelse
    </div>
</div>
