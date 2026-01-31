<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Formulir Perpindahan Aset</h2>
        <a href="{{ route('barang.mutasi.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 font-bold text-sm">Kembali</a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 animate-fade-in relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <svg class="w-64 h-64 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
        </div>

        <form wire:submit.prevent="store" class="relative z-10 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Barang -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Barang / Aset</label>
                    <select wire:model.live="barang_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">-- Cari Barang --</option>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }} (Stok: {{ $b->stok }})</option>
                        @endforeach
                    </select>
                    @error('barang_id') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Jumlah -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Dipindahkan</label>
                    <input type="number" wire:model="jumlah" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="0">
                    @error('jumlah') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Asal -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ruangan Asal</label>
                    <select wire:model="ruangan_id_asal" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">-- Pilih Ruangan Asal --</option>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                    @error('ruangan_id_asal') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Tujuan -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ruangan Tujuan</label>
                    <select wire:model="ruangan_id_tujuan" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">-- Pilih Ruangan Tujuan --</option>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                    @error('ruangan_id_tujuan') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal & PJ -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Mutasi</label>
                    <input type="date" wire:model="tanggal_mutasi" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    @error('tanggal_mutasi') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Penanggung Jawab</label>
                    <input type="text" wire:model="penanggung_jawab" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" readonly>
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Keterangan / Alasan Mutasi</label>
                <textarea wire:model="keterangan" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Contoh: Pemindahan karena renovasi ruangan..."></textarea>
            </div>

                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <a href="{{ route('barang.mutasi.index') }}" wire:navigate class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">Batal</a>
                                <button type="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5 relative">
                                    <span wire:loading.remove wire:target="store">Simpan Mutasi</span>
                                    <span wire:loading wire:target="store">Menyimpan...</span>
                                </button>
                            </div>        </form>
    </div>
</div>
