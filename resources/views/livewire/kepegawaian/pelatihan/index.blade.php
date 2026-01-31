<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Portofolio Kompetensi</h2>
            <p class="text-sm text-slate-500">Rekam jejak pelatihan dan sertifikasi profesional Anda.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Input Pelatihan
        </button>
    </div>

    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="$set('isOpen', false)"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-8 pt-8 pb-6">
                    <h3 class="text-lg font-black text-slate-800 mb-6">Tambah Riwayat Pelatihan</h3>
                    <form wire:submit.prevent="save" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Nama Pelatihan</label>
                            <input type="text" wire:model="nama_pelatihan" class="w-full rounded-xl border-slate-200 font-bold">
                            @error('nama_pelatihan') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Penyelenggara</label>
                            <input type="text" wire:model="penyelenggara" class="w-full rounded-xl border-slate-200 font-medium">
                            @error('penyelenggara') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Tanggal Mulai</label>
                                <input type="date" wire:model="tanggal_mulai" class="w-full rounded-xl border-slate-200 font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Tanggal Selesai</label>
                                <input type="date" wire:model="tanggal_selesai" class="w-full rounded-xl border-slate-200 font-medium">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Durasi (Jam)</label>
                                <input type="number" wire:model="durasi_jam" class="w-full rounded-xl border-slate-200 font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">No. Sertifikat</label>
                                <input type="text" wire:model="nomor_sertifikat" class="w-full rounded-xl border-slate-200 font-medium">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Upload Sertifikat</label>
                            <input type="file" wire:model="file_sertifikat" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        <div class="pt-4 flex justify-end gap-2">
                            <button type="button" wire:click="$set('isOpen', false)" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-sm font-bold">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold hover:bg-indigo-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($pelatihans as $p)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 relative group hover:shadow-lg transition-all">
            <div class="absolute top-6 right-6">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-wider">Selesai</span>
            </div>
            
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 leading-tight">{{ $p->nama_pelatihan }}</h3>
                    <p class="text-xs text-slate-500 font-medium">{{ $p->penyelenggara }}</p>
                </div>
            </div>
            
            <div class="space-y-2 text-sm text-slate-600 mb-6">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span>{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ $p->durasi_jam }} Jam Pelajaran</span>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                @if($p->file_sertifikat)
                <a href="{{ Storage::url($p->file_sertifikat) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Lihat Sertifikat
                </a>
                @else
                <span class="text-xs text-slate-400 italic">Tidak ada sertifikat</span>
                @endif
                
                <button wire:click="delete({{ $p->id }})" class="text-xs font-bold text-red-400 hover:text-red-600">Hapus</button>
            </div>
        </div>
        @empty
        <div class="col-span-2 text-center py-12 bg-white rounded-[2.5rem] border border-slate-100">
            <p class="text-slate-400 font-bold">Belum ada riwayat pelatihan.</p>
        </div>
        @endforelse
    </div>
</div>