<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Detail Pengaduan Masyarakat</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tinjau dan berikan tindak lanjut atas pengaduan dari masyarakat.</p>
        </div>
        <a href="{{ route('admin.masyarakat.pengaduan.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-xl font-bold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info Pelapor -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Informasi Pelapor</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Nama Pelapor</p>
                        <p class="text-sm font-bold text-slate-800 dark:text-white mt-1">{{ $pengaduan->nama_pelapor }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kontak (HP/WA)</p>
                        <p class="text-sm font-bold text-slate-800 dark:text-white mt-1">{{ $pengaduan->no_telepon_pelapor }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Email</p>
                        <p class="text-sm font-medium text-blue-600 mt-1">{{ $pengaduan->email_pelapor ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Waktu Kirim</p>
                        <p class="text-sm text-slate-600 dark:text-slate-300 mt-1">{{ $pengaduan->created_at->translatedFormat('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
            
            @if($pengaduan->file_lampiran)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Lampiran</h3>
                <a href="{{ Storage::url($pengaduan->file_lampiran) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 font-bold hover:underline">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                    Lihat Dokumen / Foto
                </a>
            </div>
            @endif
        </div>

        <!-- Isi Pengaduan & Tanggapan -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Isi Pengaduan</h3>
                    <span class="px-3 py-1 text-xs font-black rounded-full 
                        @if($pengaduan->status == 'Pending') bg-yellow-100 text-yellow-800
                        @elseif($pengaduan->status == 'Diproses') bg-blue-100 text-blue-800
                        @else bg-green-100 text-green-800 @endif uppercase tracking-widest">
                        {{ $pengaduan->status }}
                    </span>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-900/50 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 mb-8">
                    <h4 class="font-bold text-slate-900 dark:text-white mb-2 underline decoration-blue-500 decoration-2 underline-offset-4">{{ $pengaduan->subjek }}</h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed whitespace-pre-line">
                        {{ $pengaduan->isi_pengaduan }}
                    </p>
                </div>

                <hr class="border-slate-100 dark:border-slate-700 mb-8">

                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Berikan Tanggapan / Tindak Lanjut</h3>
                
                <form wire:submit="update" class="space-y-6">
                    <div>
                        <x-input-label for="status" value="Ubah Status Pengaduan" />
                        <select wire:model="status" id="status" class="mt-1 block w-full md:w-64 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="Pending">Pending (Baru)</option>
                            <option value="Diproses">Sedang Diproses</option>
                            <option value="Selesai">Tuntas / Selesai</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="tanggapan" value="Isi Tanggapan Resmi" class="font-bold" />
                        <textarea wire:model="tanggapan" id="tanggapan" rows="6" class="mt-1 block w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Tuliskan jawaban atau langkah penyelesaian untuk pengaduan ini..."></textarea>
                        <x-input-error :messages="$errors->get('tanggapan')" class="mt-2" />
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition shadow-xl shadow-blue-500/20">
                            Simpan Tanggapan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
