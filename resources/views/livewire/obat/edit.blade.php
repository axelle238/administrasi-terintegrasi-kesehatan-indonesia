<div class="max-w-4xl mx-auto">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form wire:submit="update">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informasi Umum</h3>
                        
                        <div>
                            <x-input-label for="kode_obat" value="Kode Obat" />
                            <x-text-input wire:model="kode_obat" id="kode_obat" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('kode_obat')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nama_obat" value="Nama Obat" />
                            <x-text-input wire:model="nama_obat" id="nama_obat" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('nama_obat')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="jenis_obat" value="Jenis / Golongan" />
                            <select wire:model="jenis_obat" id="jenis_obat" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Sirup">Sirup</option>
                                <option value="Kapsul">Kapsul</option>
                                <option value="Injeksi">Injeksi</option>
                                <option value="Salep">Salep</option>
                                <option value="Alat Kesehatan">Alat Kesehatan</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_obat')" class="mt-2" />
                        </div>

                         <div>
                            <x-input-label for="satuan" value="Satuan" />
                            <x-text-input wire:model="satuan" id="satuan" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="harga_satuan" value="Harga Satuan (Rp)" />
                            <x-text-input wire:model="harga_satuan" id="harga_satuan" class="block mt-1 w-full" type="number" min="0" required />
                            <x-input-error :messages="$errors->get('harga_satuan')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Inventory & Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Inventaris & Detail</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="stok" value="Stok Saat Ini" />
                                <x-text-input wire:model="stok" id="stok" class="block mt-1 w-full" type="number" min="0" required />
                                <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="min_stok" value="Min. Stok (Alert)" />
                                <x-text-input wire:model="min_stok" id="min_stok" class="block mt-1 w-full" type="number" min="0" required />
                                <x-input-error :messages="$errors->get('min_stok')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="tanggal_kedaluwarsa" value="Tanggal Kedaluwarsa (Exp)" />
                            <x-text-input wire:model="tanggal_kedaluwarsa" id="tanggal_kedaluwarsa" class="block mt-1 w-full" type="date" required />
                            <x-input-error :messages="$errors->get('tanggal_kedaluwarsa')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="batch_number" value="Batch Number" />
                            <x-text-input wire:model="batch_number" id="batch_number" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('batch_number')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="no_izin_edar" value="No. Izin Edar (BPOM)" />
                            <x-text-input wire:model="no_izin_edar" id="no_izin_edar" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('no_izin_edar')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="pabrik" value="Pabrik / Manufaktur" />
                            <x-text-input wire:model="pabrik" id="pabrik" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('pabrik')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('obat.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 underline text-sm mr-4">Batal</a>
                    <x-primary-button wire:loading.attr="disabled">
                        {{ __('Simpan Perubahan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>