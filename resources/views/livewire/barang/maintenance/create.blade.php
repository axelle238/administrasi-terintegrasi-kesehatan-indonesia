<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Input Data Pemeliharaan</h2>
        <a href="{{ route('barang.maintenance') }}" wire:navigate class="text-gray-600 hover:text-gray-900 font-bold text-sm">Kembali</a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 animate-fade-in relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <svg class="w-64 h-64 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
        </div>

        <form wire:submit.prevent="save" class="relative z-10 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Barang -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Aset / Barang</label>
                    <select wire:model="barang_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all">
                        <option value="">-- Cari Barang --</option>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                        @endforeach
                    </select>
                    @error('barang_id') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Pengerjaan</label>
                    <input type="date" wire:model="tanggal_maintenance" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all">
                    @error('tanggal_maintenance') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kegiatan</label>
                    <select wire:model="jenis_kegiatan" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all">
                        <option value="Preventif">Preventif (Pencegahan)</option>
                        <option value="Perbaikan">Korektif (Perbaikan)</option>
                        <option value="Kalibrasi">Kalibrasi Alat</option>
                    </select>
                </div>

                <!-- Teknisi -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Teknisi / Vendor</label>
                    <input type="text" wire:model="teknisi" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all" placeholder="Nama Teknisi / PT...">
                </div>

                <!-- Biaya -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Biaya (Rp)</label>
                    <input type="number" wire:model="biaya" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all" placeholder="0">
                </div>
                
                <!-- Next Schedule -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jadwal Berikutnya (Opsional)</label>
                    <input type="date" wire:model="tanggal_berikutnya" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all">
                    <p class="text-[10px] text-slate-400 mt-1">Isi jika ini adalah maintenance berkala yang berulang.</p>
                </div>

                <!-- Keterangan -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Hasil Pengerjaan / Keterangan</label>
                    <textarea wire:model="keterangan" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all" placeholder="Deskripsikan hasil perbaikan atau kondisi alat..."></textarea>
                </div>

                <!-- Upload Sertifikat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Upload Sertifikat / Berita Acara (PDF/Img)</label>
                    <input type="file" wire:model="file_sertifikat" class="block w-full text-sm text-slate-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-xs file:font-semibold
                        file:bg-amber-50 file:text-amber-700
                        hover:file:bg-amber-100
                    "/>
                    <div wire:loading wire:target="file_sertifikat" class="text-xs text-amber-500 mt-1 font-bold">Uploading...</div>
                    @error('file_sertifikat') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('barang.maintenance') }}" wire:navigate class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-amber-500 text-white rounded-xl font-bold hover:bg-amber-600 transition-colors shadow-lg shadow-amber-500/30 transform hover:-translate-y-0.5 relative">
                    <span wire:loading.remove wire:target="save">Simpan Data</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>