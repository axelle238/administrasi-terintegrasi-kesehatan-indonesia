<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-emerald-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Alur Pelayanan Publik</h2>
            <p class="text-sm text-slate-500 mt-1">Konfigurasi tahapan layanan yang akan ditampilkan di halaman depan.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition-all flex items-center gap-2" {{ $isEditing ? 'disabled' : '' }}>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Langkah
        </button>
    </div>

    <!-- Form Inline -->
    @if($isEditing)
    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-emerald-200 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
        <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
            <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></span>
            {{ $alurId ? 'Edit Langkah Alur' : 'Buat Langkah Baru' }}
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Pelayanan</label>
                <select wire:model="jenis_pelayanan_id" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">-- Umum / Tanpa Kategori --</option>
                    @foreach($jenisPelayanans as $jenis)
                        <option value="{{ $jenis->id }}">{{ $jenis->nama_layanan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Judul Langkah</label>
                <input wire:model="judul" type="text" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                @error('judul') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Target Pasien</label>
                <select wire:model="target_pasien" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="Umum">Umum (Semua)</option>
                    <option value="BPJS">Pasien BPJS</option>
                    <option value="Baru">Pasien Baru</option>
                    <option value="Lama">Pasien Lama</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Urutan Tampil</label>
                <input wire:model="urutan" type="number" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Estimasi Waktu (Opsional)</label>
                <input wire:model="estimasi_waktu" type="text" placeholder="Contoh: 10-15 Menit" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi Singkat</label>
                <textarea wire:model="deskripsi" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500"></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Dokumen Persyaratan (Pisahkan koma)</label>
                <input wire:model="dokumen_syarat" type="text" placeholder="KTP, Kartu BPJS, Surat Rujukan" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Icon (Heroicon Name)</label>
                <div class="flex gap-2">
                    <input wire:model="icon" type="text" placeholder="e.g. user, clipboard-check" class="w-full rounded-xl border-slate-200 text-sm font-mono text-slate-600">
                    <a href="https://heroicons.com/" target="_blank" class="px-3 py-2 bg-slate-100 rounded-xl text-slate-500 hover:text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                </div>
            </div>
            <div class="flex items-center pt-6">
                <label class="flex items-center gap-2 cursor-pointer bg-slate-50 px-4 py-2 rounded-xl border border-slate-200 hover:bg-white transition-colors">
                    <input wire:model="is_active" type="checkbox" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-5 h-5">
                    <span class="text-sm font-bold text-slate-700">Aktifkan Status</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
            <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold uppercase text-xs hover:bg-slate-50 transition-colors">Batal</button>
            <button wire:click="store" class="px-8 py-2.5 rounded-xl bg-emerald-600 text-white font-bold uppercase text-xs shadow-lg hover:bg-emerald-700 transition-colors">Simpan Perubahan</button>
        </div>
    </div>
    @endif

    <!-- Timeline List -->
    <div class="relative pl-8 border-l-2 border-emerald-100 space-y-8">
        @forelse($alurs as $alur)
        <div class="relative group">
            <!-- Connector Dot -->
            <div class="absolute -left-[41px] top-0 flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-white border-4 border-emerald-100 flex items-center justify-center text-emerald-600 font-black shadow-sm group-hover:scale-110 group-hover:border-emerald-200 transition-all z-10">
                    {{ $alur->urutan }}
                </div>
            </div>

            <!-- Card Content -->
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            @if($alur->jenisPelayanan)
                                <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-wider">{{ $alur->jenisPelayanan->nama_layanan }}</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-wider">Umum</span>
                            @endif
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-wider">{{ $alur->target_pasien }}</span>
                            @if(!$alur->is_active)
                                <span class="px-2 py-1 rounded-full bg-rose-100 text-rose-600 text-[10px] font-bold uppercase">Non-Aktif</span>
                            @endif
                        </div>
                        <h4 class="text-xl font-black text-slate-800 mb-2">{{ $alur->judul }}</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ $alur->deskripsi }}</p>
                        
                        @if($alur->dokumen_syarat || $alur->estimasi_waktu)
                        <div class="mt-4 pt-4 border-t border-dashed border-slate-100 flex flex-wrap gap-4 text-xs font-bold text-slate-400">
                            @if($alur->estimasi_waktu)
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>{{ $alur->estimasi_waktu }}</span>
                            </div>
                            @endif
                            @if($alur->dokumen_syarat)
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                <span>Syarat: {{ $alur->dokumen_syarat }}</span>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex md:flex-col gap-2 shrink-0">
                        <button wire:click="edit({{ $alur->id }})" class="p-2 rounded-xl bg-slate-50 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" title="Edit">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </button>
                        <button wire:click="delete({{ $alur->id }})" onclick="return confirm('Hapus langkah ini?') || event.stopImmediatePropagation()" class="p-2 rounded-xl bg-slate-50 text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-slate-50 p-12 text-center rounded-[2.5rem] border-2 border-dashed border-slate-200 -ml-8">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-sm">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            </div>
            <h3 class="font-bold text-slate-800">Belum Ada Alur</h3>
            <p class="text-sm text-slate-400">Tambahkan langkah pertama untuk panduan pasien.</p>
        </div>
        @endforelse
    </div>
</div>