<div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Tambah Poli Baru</h2>
            <p class="text-sm text-slate-500">Buat unit layanan atau poliklinik baru dalam sistem.</p>
        </div>
        <a href="{{ route('system.poli.index') }}" wire:navigate class="text-slate-500 hover:text-slate-700 font-bold text-sm">Kembali</a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8">
            <form wire:submit.prevent="save" class="space-y-6">
                
                <!-- Kode Poli -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kode Poli</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-slate-400 font-mono font-bold">#</span>
                        </div>
                        <input type="text" wire:model="kode_poli" placeholder="Contoh: P-001" 
                            class="w-full pl-8 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-mono font-bold text-slate-700 placeholder-slate-400 uppercase">
                    </div>
                    @error('kode_poli') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nama Poli -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Unit / Poliklinik</label>
                    <input type="text" wire:model="nama_poli" placeholder="Contoh: Poli Umum, Poli Gigi" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-bold text-slate-700 placeholder-slate-400">
                    @error('nama_poli') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Keterangan -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Keterangan Operasional</label>
                    <textarea wire:model="keterangan" rows="4" placeholder="Deskripsi singkat mengenai layanan poli ini..."
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-medium text-slate-700 placeholder-slate-400"></textarea>
                </div>

                <!-- Actions -->
                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <a href="{{ route('system.poli.index') }}" wire:navigate class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
                        <svg wire:loading.remove class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        <svg wire:loading class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>