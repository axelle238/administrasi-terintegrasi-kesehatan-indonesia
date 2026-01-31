<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Proses Pengembalian Barang</h2>
        <a href="{{ route('barang.peminjaman.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 font-bold text-sm">Kembali</a>
    </div>

    <!-- Info Peminjaman -->
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-1">No Transaksi</p>
                <p class="font-mono font-bold text-blue-900">{{ $peminjaman->no_transaksi }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-1">Barang</p>
                <p class="font-bold text-blue-900">{{ $peminjaman->barang->nama_barang ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-1">Peminjam</p>
                <p class="font-bold text-blue-900">{{ $peminjaman->pegawai->user->name ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 animate-fade-in relative overflow-hidden">
        <form wire:submit.prevent="save" class="relative z-10 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Kembali (Realisasi)</label>
                    <input type="date" wire:model="tanggal_kembali_realisasi" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all">
                    @error('tanggal_kembali_realisasi') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kondisi Akhir</label>
                    <input type="text" wire:model="kondisi_kembali" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all" placeholder="Contoh: Baik, Rusak Ringan...">
                    @error('kondisi_kembali') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('barang.peminjaman.index') }}" wire:navigate class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-amber-500 text-white rounded-xl font-bold hover:bg-amber-600 transition-colors shadow-lg shadow-amber-500/30 transform hover:-translate-y-0.5 relative">
                    <span wire:loading.remove wire:target="save">Proses Pengembalian</span>
                    <span wire:loading wire:target="save">Memproses...</span>
                </button>
            </div>
        </form>
    </div>
</div>
