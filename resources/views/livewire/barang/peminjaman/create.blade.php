<div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Form Peminjaman Aset</h2>
        <a href="{{ route('barang.peminjaman.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 font-bold text-sm">Kembali</a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
        <form wire:submit.prevent="store" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Barang -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Aset / Barang</label>
                    <select wire:model="barang_id" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500">
                        <option value="">-- Cari Barang --</option>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}" {{ $b->stok < 1 || $b->status_ketersediaan != 'Tersedia' ? 'disabled' : '' }}>
                                {{ $b->nama_barang }} ({{ $b->kode_barang }}) 
                                {{ $b->stok < 1 ? '[Habis]' : ($b->status_ketersediaan != 'Tersedia' ? '['.$b->status_ketersediaan.']' : '') }}
                            </option>
                        @endforeach
                    </select>
                    @error('barang_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Pegawai -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Peminjam (Pegawai)</label>
                    <select wire:model="pegawai_id" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500">
                        <option value="">-- Cari Pegawai --</option>
                        @foreach($pegawais as $p)
                            <option value="{{ $p->id }}">{{ $p->user->name ?? '-' }} - {{ $p->jabatan }}</option>
                        @endforeach
                    </select>
                    @error('pegawai_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Pinjam</label>
                    <input type="date" wire:model="tanggal_pinjam" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500">
                    @error('tanggal_pinjam') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Rencana Kembali (Opsional)</label>
                    <input type="date" wire:model="tanggal_kembali_rencana" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500">
                    @error('tanggal_kembali_rencana') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Kondisi & Ket -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kondisi Barang Saat Keluar</label>
                    <select wire:model="kondisi_keluar" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500">
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Keterangan / Keperluan</label>
                    <textarea wire:model="keterangan" rows="3" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500" placeholder="Contoh: Untuk kegiatan penyuluhan..."></textarea>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition">
                    Simpan Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>