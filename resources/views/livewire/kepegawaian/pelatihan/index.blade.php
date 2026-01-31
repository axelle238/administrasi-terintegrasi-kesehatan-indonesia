<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <!-- Header Action -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100 gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Portofolio Kompetensi</h2>
            <p class="text-sm text-slate-500">Rekam jejak pelatihan dan sertifikasi profesional Anda.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            {{ $isOpen ? 'Tutup Formulir' : 'Input Pelatihan' }}
        </button>
    </div>

    <!-- Inline Form (Replaces Modal) -->
    @if($isOpen)
    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-indigo-100 animate-fade-in relative">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-black text-slate-800 flex items-center gap-2">
                <span class="w-2 h-8 bg-indigo-500 rounded-full"></span>
                Tambah Riwayat Pelatihan
            </h3>
            <button wire:click="$set('isOpen', false)" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Nama Pelatihan / Seminar</label>
                    <input type="text" wire:model="nama_pelatihan" class="w-full rounded-xl border-slate-200 font-bold bg-slate-50 focus:bg-white transition-all placeholder-slate-300" placeholder="Contoh: Workshop Manajemen Risiko...">
                    @error('nama_pelatihan') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Penyelenggara</label>
                    <input type="text" wire:model="penyelenggara" class="w-full rounded-xl border-slate-200 font-bold bg-slate-50 focus:bg-white transition-all" placeholder="Nama instansi/lembaga">
                    @error('penyelenggara') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Detail Pelaksanaan</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Tanggal Mulai</label>
                        <input type="date" wire:model="tanggal_mulai" class="w-full rounded-xl border-slate-200 font-medium focus:ring-indigo-500">
                        @error('tanggal_mulai') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Tanggal Selesai</label>
                        <input type="date" wire:model="tanggal_selesai" class="w-full rounded-xl border-slate-200 font-medium focus:ring-indigo-500">
                        @error('tanggal_selesai') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Durasi Total (Jam)</label>
                        <input type="number" wire:model="durasi_jam" class="w-full rounded-xl border-slate-200 font-medium focus:ring-indigo-500" placeholder="Total JP">
                        @error('durasi_jam') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Nomor Sertifikat (Opsional)</label>
                    <input type="text" wire:model="nomor_sertifikat" class="w-full rounded-xl border-slate-200 font-medium" placeholder="No. Sertifikat jika ada">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Upload Sertifikat (PDF/Gambar)</label>
                    <input type="file" wire:model="file_sertifikat" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all border border-slate-200 rounded-xl">
                    @error('file_sertifikat') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" wire:click="$set('isOpen', false)" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">Batal</button>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg transition flex items-center gap-2">
                    <span wire:loading.remove>Simpan Data</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($pelatihans as $p)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 relative group hover:shadow-lg transition-all hover:-translate-y-1">
            <div class="absolute top-6 right-6">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm">Selesai</span>
            </div>
            
            <div class="flex items-start gap-4 mb-6">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center shadow-lg shadow-indigo-200 shrink-0">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <div class="pr-16">
                    <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1">{{ $p->nama_pelatihan }}</h3>
                    <p class="text-sm text-slate-500 font-medium flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        {{ $p->penyelenggara }}
                    </p>
                </div>
            </div>
            
            <div class="bg-slate-50 rounded-2xl p-4 mb-6 border border-slate-100">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center gap-2 text-slate-600">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span class="font-bold">{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-600">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="font-bold">{{ $p->durasi_jam }} Jam Pelajaran</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-2">
                @if($p->file_sertifikat)
                <a href="{{ Storage::url($p->file_sertifikat) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-xs font-bold hover:bg-indigo-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Lihat Sertifikat
                </a>
                @else
                <span class="px-4 py-2 bg-slate-50 text-slate-400 rounded-xl text-xs font-bold italic">Tanpa Sertifikat</span>
                @endif
                
                <button wire:click="delete({{ $p->id }})" onclick="confirm('Hapus data pelatihan ini?') || event.stopImmediatePropagation()" class="p-2 text-slate-400 hover:text-red-500 transition-colors" title="Hapus Data">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-1 md:col-span-2 text-center py-16 bg-white rounded-[3rem] border border-slate-100">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 text-slate-300 mb-6">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Portofolio Masih Kosong</h3>
            <p class="text-slate-500 max-w-sm mx-auto mt-2 text-sm leading-relaxed">Tambahkan riwayat pelatihan, workshop, atau sertifikasi yang pernah Anda ikuti untuk melengkapi profil kompetensi.</p>
            <button wire:click="create" class="mt-6 px-6 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold text-sm hover:bg-indigo-100 transition">
                + Mulai Input
            </button>
        </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $pelatihans->links() }}
    </div>
</div>
