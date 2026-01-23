<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('barang.update', $barang->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Kategori & Kode -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="kategori_barang_id" :value="__('Kategori Barang')" />
                                <select id="kategori_barang_id" name="kategori_barang_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">- Pilih Kategori -</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_barang_id', $barang->kategori_barang_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('kategori_barang_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="kode_barang" :value="__('Kode Barang')" />
                                <x-text-input id="kode_barang" class="block mt-1 w-full" type="text" name="kode_barang" :value="old('kode_barang', $barang->kode_barang)" required />
                                <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Nama & Merk -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                                <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang', $barang->nama_barang)" required />
                                <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="merk" :value="__('Merk / Brand (Opsional)')" />
                                <x-text-input id="merk" class="block mt-1 w-full" type="text" name="merk" :value="old('merk', $barang->merk)" />
                                <x-input-error :messages="$errors->get('merk')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Stok & Satuan -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <x-input-label for="stok" :value="__('Jumlah Stok')" />
                                <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok', $barang->stok)" required />
                                <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="satuan" :value="__('Satuan')" />
                                <select id="satuan" name="satuan" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="Unit" {{ $barang->satuan == 'Unit' ? 'selected' : '' }}>Unit</option>
                                    <option value="Pcs" {{ $barang->satuan == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="Set" {{ $barang->satuan == 'Set' ? 'selected' : '' }}>Set</option>
                                    <option value="Box" {{ $barang->satuan == 'Box' ? 'selected' : '' }}>Box</option>
                                    <option value="Buah" {{ $barang->satuan == 'Buah' ? 'selected' : '' }}>Buah</option>
                                </select>
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="kondisi" :value="__('Kondisi Barang')" />
                                <select id="kondisi" name="kondisi" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="Baik" {{ $barang->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ $barang->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ $barang->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                <x-input-error :messages="$errors->get('kondisi')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Lokasi & Tgl Pengadaan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="lokasi_penyimpanan" :value="__('Lokasi Penyimpanan')" />
                                <x-text-input id="lokasi_penyimpanan" class="block mt-1 w-full" type="text" name="lokasi_penyimpanan" :value="old('lokasi_penyimpanan', $barang->lokasi_penyimpanan)" />
                                <x-input-error :messages="$errors->get('lokasi_penyimpanan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_pengadaan" :value="__('Tanggal Pengadaan')" />
                                <x-text-input id="tanggal_pengadaan" class="block mt-1 w-full" type="date" name="tanggal_pengadaan" :value="old('tanggal_pengadaan', $barang->tanggal_pengadaan)" required />
                                <x-input-error :messages="$errors->get('tanggal_pengadaan')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('barang.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
