<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <!-- Header Action -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100 gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Laporan Kinerja Harian</h2>
            <p class="text-sm text-slate-500">Catat progres pekerjaan, kendala, dan hasil kerja harian Anda.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            {{ $isOpen ? 'Tutup Formulir' : 'Tambah Laporan Baru' }}
        </button>
    </div>

    <!-- Inline Form (Replaces Modal) -->
    @if($isOpen)
    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-indigo-100 animate-fade-in relative">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-black text-slate-800 flex items-center gap-2">
                <span class="w-2 h-8 bg-indigo-500 rounded-full"></span>
                {{ $activityId ? 'Edit Laporan Kinerja' : 'Formulir Laporan Baru' }}
            </h3>
            <button wire:click="$set('isOpen', false)" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Waktu & Tanggal</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Tanggal Kegiatan</label>
                        <input type="date" wire:model="tanggal" class="w-full rounded-xl border-slate-200 font-bold bg-white focus:ring-indigo-500 transition-all">
                        @error('tanggal') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Jam Mulai</label>
                        <input type="time" wire:model="jam_mulai" class="w-full rounded-xl border-slate-200 font-bold bg-white focus:ring-indigo-500 transition-all">
                        @error('jam_mulai') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Jam Selesai</label>
                        <input type="time" wire:model="jam_selesai" class="w-full rounded-xl border-slate-200 font-bold bg-white focus:ring-indigo-500 transition-all">
                        @error('jam_selesai') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Judul Aktivitas</label>
                        <input type="text" wire:model="aktivitas" class="w-full rounded-xl border-slate-200 font-bold placeholder-slate-300 focus:ring-indigo-500" placeholder="Contoh: Rapat Koordinasi Tim...">
                        @error('aktivitas') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Detail Deskripsi</label>
                        <textarea wire:model="deskripsi" rows="4" class="w-full rounded-xl border-slate-200 font-medium placeholder-slate-300 focus:ring-indigo-500" placeholder="Jelaskan detail pekerjaan yang dilakukan..."></textarea>
                        @error('deskripsi') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Prioritas</label>
                            <select wire:model="prioritas" class="w-full rounded-xl border-slate-200 font-bold bg-slate-50 focus:bg-white focus:ring-indigo-500">
                                <option value="Low">Low (Rendah)</option>
                                <option value="Normal">Normal</option>
                                <option value="High">High (Tinggi)</option>
                                <option value="Urgent">Urgent (Segera)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Progress (%)</label>
                            <div class="flex items-center gap-3 bg-slate-50 p-2 rounded-xl border border-slate-200">
                                <input type="range" wire:model.live="persentase_selesai" min="0" max="100" step="10" class="w-full h-2 bg-slate-300 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <span class="text-sm font-black text-indigo-600 w-12 text-right">{{ $persentase_selesai }}%</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Kendala Teknis (Opsional)</label>
                        <input type="text" wire:model="kendala_teknis" class="w-full rounded-xl border-slate-200 font-medium focus:ring-red-500" placeholder="Ada hambatan?">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">File Bukti Kerja</label>
                        <input type="file" wire:model="file_bukti_kerja" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all border border-slate-200 rounded-xl">
                        @error('file_bukti_kerja') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" wire:click="$set('isOpen', false)" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">Batal</button>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg transition flex items-center gap-2">
                    <span wire:loading.remove>Simpan Laporan</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Task List -->
    <div class="space-y-4">
        @forelse($laporans as $lkh)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 hover:shadow-md transition-shadow relative group">
            <!-- Progress Bar Background -->
            <div class="absolute bottom-0 left-0 h-1.5 bg-indigo-500 rounded-bl-3xl transition-all duration-1000 opacity-50" style="width: {{ $lkh->persentase_selesai }}%"></div>
            
            <div class="flex flex-col md:flex-row justify-between gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        @php
                            $badgeColor = match($lkh->prioritas) {
                                'Urgent' => 'bg-red-100 text-red-700',
                                'High' => 'bg-orange-100 text-orange-700',
                                'Low' => 'bg-emerald-100 text-emerald-700',
                                default => 'bg-blue-100 text-blue-700'
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $badgeColor }}">
                            {{ $lkh->prioritas }}
                        </span>
                        <span class="text-xs font-mono font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-md">
                            {{ \Carbon\Carbon::parse($lkh->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($lkh->jam_selesai)->format('H:i') }}
                        </span>
                        <span class="text-xs font-bold text-slate-500 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            {{ \Carbon\Carbon::parse($lkh->tanggal)->format('d M Y') }}
                        </span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-slate-800 mb-2 leading-tight">{{ $lkh->aktivitas }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-50">{{ $lkh->deskripsi }}</p>
                    
                    @if($lkh->kendala_teknis)
                    <div class="mt-3 bg-red-50 p-3 rounded-xl border border-red-100 flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <p class="text-xs text-red-700 font-medium"><span class="font-bold">Kendala:</span> {{ $lkh->kendala_teknis }}</p>
                    </div>
                    @endif
                </div>

                <div class="flex flex-col items-end gap-4 min-w-[140px] border-l border-slate-50 pl-6 md:border-l-0 md:pl-0">
                    <div class="text-right">
                        <span class="block text-3xl font-black text-indigo-600 leading-none">{{ $lkh->persentase_selesai }}%</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Progress</span>
                    </div>
                    
                    <div class="flex gap-2 w-full justify-end">
                        @if($lkh->file_bukti_kerja)
                        <a href="{{ Storage::url($lkh->file_bukti_kerja) }}" target="_blank" class="p-2.5 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors" title="Lihat Bukti">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </a>
                        @endif
                        <button wire:click="edit({{ $lkh->id }})" class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 transition-colors" title="Edit">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </button>
                        <button wire:click="delete({{ $lkh->id }})" onclick="confirm('Hapus laporan ini?') || event.stopImmediatePropagation()" class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors" title="Hapus">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16 bg-white rounded-[3rem] border border-slate-100">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 text-slate-300 mb-6">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Belum Ada Aktivitas</h3>
            <p class="text-slate-500 max-w-sm mx-auto mt-2 text-sm leading-relaxed">Mulai hari produktifmu dengan mencatat tugas pertama. Setiap progres kecil sangat berarti!</p>
            <button wire:click="create" class="mt-6 px-6 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold text-sm hover:bg-indigo-100 transition">
                + Tambah Sekarang
            </button>
        </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $laporans->links() }}
    </div>
</div>
