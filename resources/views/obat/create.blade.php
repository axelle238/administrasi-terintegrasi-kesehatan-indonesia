<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Data Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('obat.store') }}">
                        @csrf

                        <!-- Kode & Nama -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="kode_obat" :value="__('Kode Obat')" />
                                <x-text-input id="kode_obat" class="block mt-1 w-full" type="text" name="kode_obat" :value="old('kode_obat')" required autofocus placeholder="Contoh: OBT-001" />
                                <x-input-error :messages="$errors->get('kode_obat')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nama_obat" :value="__('Nama Obat')" />
                                <x-text-input id="nama_obat" class="block mt-1 w-full" type="text" name="nama_obat" :value="old('nama_obat')" required placeholder="Contoh: Paracetamol 500mg" />
                                <x-input-error :messages="$errors->get('nama_obat')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Jenis & Satuan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="jenis_obat" :value="__('Jenis Obat')" />
                                <select id="jenis_obat" name="jenis_obat" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="Tablet">Tablet</option>
                                    <option value="Kapsul">Kapsul</option>
                                    <option value="Sirup">Sirup</option>
                                    <option value="Salep">Salep</option>
                                    <option value="Injeksi">Injeksi</option>
                                    <option value="Alat Kesehatan">Alat Kesehatan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_obat')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="satuan" :value="__('Satuan')" />
                                <select id="satuan" name="satuan" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="Pcs">Pcs</option>
                                    <option value="Strip">Strip</option>
                                    <option value="Botol">Botol</option>
                                    <option value="Box">Box</option>
                                    <option value="Ampul">Ampul</option>
                                    <option value="Tube">Tube</option>
                                </select>
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Stok & Min Stok -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="stok" :value="__('Stok Awal')" />
                                <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok', 0)" required />
                                <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="min_stok" :value="__('Stok Minimal (Alert)')" />
                                <x-text-input id="min_stok" class="block mt-1 w-full" type="number" name="min_stok" :value="old('min_stok', 10)" required />
                                <x-input-error :messages="$errors->get('min_stok')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Detail Produksi (Batch, NIE, Pabrik) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <x-input-label for="batch_number" :value="__('Nomor Batch')" />
                                <x-text-input id="batch_number" class="block mt-1 w-full" type="text" name="batch_number" :value="old('batch_number')" placeholder="Opsional" />
                                <x-input-error :messages="$errors->get('batch_number')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="no_izin_edar" :value="__('No. Izin Edar (BPOM)')" />
                                <x-text-input id="no_izin_edar" class="block mt-1 w-full" type="text" name="no_izin_edar" :value="old('no_izin_edar')" placeholder="Opsional" />
                                <x-input-error :messages="$errors->get('no_izin_edar')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="pabrik" :value="__('Pabrik / Principal')" />
                                <x-text-input id="pabrik" class="block mt-1 w-full" type="text" name="pabrik" :value="old('pabrik')" placeholder="Opsional" />
                                <x-input-error :messages="$errors->get('pabrik')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Harga & Expired -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="harga_satuan" :value="__('Harga Satuan (Rp)')" />
                                <x-text-input id="harga_satuan" class="block mt-1 w-full" type="number" name="harga_satuan" :value="old('harga_satuan')" required />
                                <x-input-error :messages="$errors->get('harga_satuan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_kedaluwarsa" :value="__('Tanggal Kedaluwarsa')" />
                                <x-text-input id="tanggal_kedaluwarsa" class="block mt-1 w-full" type="date" name="tanggal_kedaluwarsa" :value="old('tanggal_kedaluwarsa')" required />
                                <x-input-error :messages="$errors->get('tanggal_kedaluwarsa')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="keterangan" :value="__('Keterangan Tambahan (Opsional)')" />
                            <textarea id="keterangan" name="keterangan" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('obat.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Obat') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
