<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Buat Pengajuan Baru
            </h2>
            <p class="text-sm text-gray-500 mt-1 ml-10">
                Isi formulir untuk mengajukan pengadaan barang atau aset baru.
            </p>
        </div>
        <a href="{{ route('barang.pengadaan.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
            Kembali
        </a>
    </div>

    <form wire:submit="save">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-900">Detail Permintaan</h3>
            </div>
            
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Supplier / Vendor (Opsional)</label>
                        <select wire:model="supplier_id" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->nama_supplier }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Jika kosong, bagian pengadaan akan menentukan supplier.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan / Alasan Pengadaan</label>
                        <textarea wire:model="keterangan" rows="2" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm" placeholder="Contoh: Stok menipis, kebutuhan poli gigi..."></textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="font-bold text-gray-800">Daftar Barang</h4>
                    @foreach($items as $index => $item)
                        <div class="flex flex-col lg:flex-row gap-4 p-4 border border-gray-200 rounded-xl bg-gray-50 items-start lg:items-center relative" wire:key="item-{{ $item['key'] }}">
                            
                            <!-- Type Selection -->
                            <div class="w-full lg:w-32">
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tipe</label>
                                <select wire:model.live="items.{{ $index }}.type" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                    <option value="existing">Barang Lama</option>
                                    <option value="new">Barang Baru</option>
                                </select>
                            </div>

                            <!-- Item Selection / Input -->
                            <div class="flex-1 w-full">
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                    {{ $items[$index]['type'] === 'existing' ? 'Pilih Barang' : 'Nama Barang Baru' }}
                                </label>
                                
                                @if($items[$index]['type'] === 'existing')
                                    <select wire:model.live="items.{{ $index }}.barang_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach($barangs as $b)
                                            <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                    @error('items.'.$index.'.barang_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                @else
                                    <input type="text" wire:model="items.{{ $index }}.nama_barang" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm" placeholder="Nama barang...">
                                    @error('items.'.$index.'.nama_barang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                @endif
                            </div>

                            <!-- Qty -->
                            <div class="w-full lg:w-24">
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jumlah</label>
                                <input type="number" wire:model="items.{{ $index }}.jumlah_permintaan" min="1" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm text-center">
                                @error('items.'.$index.'.jumlah_permintaan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Satuan -->
                            <div class="w-full lg:w-24">
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Satuan</label>
                                <input type="text" wire:model="items.{{ $index }}.satuan" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm" {{ $items[$index]['type'] === 'existing' ? 'readonly' : '' }}>
                                @error('items.'.$index.'.satuan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Est Price -->
                            <div class="w-full lg:w-40">
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Est. Harga @</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" wire:model="items.{{ $index }}.estimasi_harga_satuan" class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm text-right">
                                </div>
                            </div>

                            @if(count($items) > 1)
                                <button type="button" wire:click="removeItem({{ $index }})" class="text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 lg:mt-6 self-end lg:self-auto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <button type="button" wire:click="addItem" class="inline-flex items-center text-sm font-semibold text-teal-600 hover:text-teal-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Tambah Barang Lain
                    </button>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-teal-600 text-white rounded-xl font-bold shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5">
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>
