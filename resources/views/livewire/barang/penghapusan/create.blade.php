<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Form Usulan Penghapusan</h2>
        <a href="{{ route('barang.penghapusan.index') }}" class="text-gray-600 hover:text-gray-900">Kembali</a>
    </div>

    <form wire:submit="save">
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan Umum / Judul Usulan</label>
            <textarea wire:model="keterangan" class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500" rows="2" placeholder="Contoh: Penghapusan aset elektronik tahun 2025"></textarea>
        </div>

        <div class="space-y-4">
            @foreach($items as $index => $item)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 relative" wire:key="item-{{ $item['key'] }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Barang</label>
                            <select wire:model.live="items.{{ $index }}.barang_id" class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                                <option value="">-- Pilih Aset --</option>
                                @foreach($barangs as $b)
                                    <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error("items.{$index}.barang_id") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nilai Buku (Otomatis)</label>
                            <input type="text" value="Rp {{ number_format($item['nilai_buku'] ?? 0, 0, ',', '.') }}" readonly class="w-full bg-gray-50 rounded-lg border-gray-300 text-gray-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jumlah</label>
                            <input type="number" wire:model.blur="items.{{ $index }}.jumlah" class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kondisi</label>
                            <select wire:model.blur="items.{{ $index }}.kondisi_terakhir" class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                                <option value="Rusak Berat">Rusak Berat</option>
                                <option value="Hilang">Hilang</option>
                                <option value="Kadaluarsa">Kadaluarsa</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Alasan Detail</label>
                            <input type="text" wire:model.blur="items.{{ $index }}.alasan" class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500" placeholder="Jelaskan kerusakan atau alasan penghapusan...">
                            @error("items.{$index}.alasan") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    @if(count($items) > 1)
                        <button type="button" wire:click="removeItem({{ $index }})" class="absolute top-4 right-4 text-red-400 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-4 flex justify-between">
            <button type="button" wire:click="addItem" class="text-sm font-bold text-red-600 hover:text-red-800 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Item Lain
            </button>
            
            <button type="submit" class="px-6 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg hover:bg-red-700 transition transform hover:-translate-y-0.5">
                Simpan Usulan
            </button>
        </div>
    </form>
</div>
