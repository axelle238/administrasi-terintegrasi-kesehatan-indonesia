<div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Form Pengajuan Barang Baru</h2>
        <a href="{{ route('barang.pengadaan.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 font-bold text-sm">Kembali</a>
    </div>

    <form wire:submit.prevent="save" class="space-y-8">
        
        <!-- Header Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Supplier (Opsional)</label>
                <select wire:model="supplier_id" class="w-full rounded-xl border-slate-200 focus:ring-blue-500">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Catatan Pengajuan</label>
                <textarea wire:model="keterangan" rows="1" class="w-full rounded-xl border-slate-200 focus:ring-blue-500" placeholder="Keperluan..."></textarea>
            </div>
        </div>

        <!-- Items -->
        <div class="space-y-4">
            <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs">2</span>
                Daftar Barang
            </h3>

            @foreach($items as $index => $item)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative group" wire:key="item-{{ $item['key'] }}">
                <button type="button" wire:click="removeItem({{ $index }})" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    <!-- Type Selector -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tipe</label>
                        <select wire:model.live="items.{{ $index }}.type" class="w-full text-sm rounded-lg border-slate-200 bg-slate-50">
                            <option value="existing">Stok Lama</option>
                            <option value="new">Barang Baru</option>
                        </select>
                    </div>

                    <!-- Item Name/Select -->
                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Barang</label>
                        @if($item['type'] == 'existing')
                            <select wire:model.live="items.{{ $index }}.barang_id" class="w-full text-sm rounded-lg border-slate-200">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangs as $b)
                                    <option value="{{ $b->id }}">{{ $b->nama_barang }} ({{ $b->stok }})</option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" wire:model="items.{{ $index }}.nama_barang" class="w-full text-sm rounded-lg border-slate-200" placeholder="Nama Barang Baru">
                        @endif
                        @error("items.{$index}.barang_id") <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        @error("items.{$index}.nama_barang") <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Qty -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jumlah</label>
                        <input type="number" wire:model="items.{{ $index }}.jumlah_permintaan" class="w-full text-sm rounded-lg border-slate-200" min="1">
                    </div>

                    <!-- Satuan -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Satuan</label>
                        <input type="text" wire:model="items.{{ $index }}.satuan" class="w-full text-sm rounded-lg border-slate-200" placeholder="Pcs">
                    </div>

                    <!-- Est. Harga -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Est. Harga @</label>
                        <input type="number" wire:model="items.{{ $index }}.estimasi_harga_satuan" class="w-full text-sm rounded-lg border-slate-200" placeholder="0">
                    </div>
                </div>
            </div>
            @endforeach

            <button type="button" wire:click="addItem" class="w-full py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-500 font-bold hover:border-blue-500 hover:text-blue-600 transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Baris Barang
            </button>
        </div>

        <div class="flex justify-end pt-6 border-t border-slate-200">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>