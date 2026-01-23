<div class="max-w-4xl mx-auto">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form wire:submit="update">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Column 1 -->
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="kategori_barang_id" value="Kategori Barang" />
                            <select wire:model="kategori_barang_id" id="kategori_barang_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kategori_barang_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kode_barang" value="Kode Barang" />
                            <x-text-input wire:model="kode_barang" id="kode_barang" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nama_barang" value="Nama Barang" />
                            <x-text-input wire:model="nama_barang" id="nama_barang" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="merk" value="Merk / Brand" />
                            <x-text-input wire:model="merk" id="merk" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('merk')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="stok" value="Stok Saat Ini" />
                                <x-text-input wire:model="stok" id="stok" class="block mt-1 w-full" type="number" min="0" required />
                                <p class="text-xs text-gray-500 mt-1">Untuk transaksi masuk/keluar gunakan menu Detail.</p>
                                <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="satuan" value="Satuan (Unit)" />
                                <x-text-input wire:model="satuan" id="satuan" class="block mt-1 w-full" type="text" required />
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="kondisi" value="Kondisi" />
                            <select wire:model="kondisi" id="kondisi" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                            <x-input-error :messages="$errors->get('kondisi')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_pengadaan" value="Tanggal Pengadaan" />
                            <x-text-input wire:model="tanggal_pengadaan" id="tanggal_pengadaan" class="block mt-1 w-full" type="date" required />
                            <x-input-error :messages="$errors->get('tanggal_pengadaan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="lokasi_penyimpanan" value="Lokasi Penyimpanan" />
                            <x-text-input wire:model="lokasi_penyimpanan" id="lokasi_penyimpanan" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('lokasi_penyimpanan')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('barang.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 underline text-sm mr-4">Batal</a>
                    <x-primary-button wire:loading.attr="disabled">
                        {{ __('Simpan Perubahan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>