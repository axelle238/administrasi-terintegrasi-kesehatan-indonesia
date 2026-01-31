<div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Proses Pengembalian Barang</h2>
        <a href="{{ route('barang.peminjaman.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 font-bold text-sm">Kembali</a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <!-- Summary -->
        <div class="p-6 bg-slate-50 border-b border-slate-100 grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Barang</p>
                <p class="text-lg font-black text-slate-800">{{ $peminjaman->barang->nama_barang }}</p>
                <p class="text-xs text-slate-500">{{ $peminjaman->barang->kode_barang }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Peminjam</p>
                <p class="text-lg font-black text-slate-800">{{ $peminjaman->pegawai->user->name }}</p>
                <p class="text-xs text-slate-500">Tgl Pinjam: {{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            </div>
        </div>

        <form wire:submit.prevent="save" class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Dikembalikan</label>
                    <input type="date" wire:model="tanggal_kembali_realisasi" class="w-full rounded-xl border-slate-200 focus:ring-green-500">
                    @error('tanggal_kembali_realisasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kondisi Akhir</label>
                    <select wire:model="kondisi_kembali" class="w-full rounded-xl border-slate-200 focus:ring-green-500">
                        <option value="Baik">Baik (Sesuai Awal)</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                        <option value="Hilang">Hilang</option>
                    </select>
                    @error('kondisi_kembali') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-xl font-bold shadow-lg hover:bg-green-700 transition">
                    Selesaikan Pengembalian
                </button>
            </div>
        </form>
    </div>
</div>