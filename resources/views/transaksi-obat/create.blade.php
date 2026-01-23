<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Catat Transaksi Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('transaksi-obat.store') }}">
                        @csrf

                        <!-- Obat & Jenis -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="obat_id" :value="__('Pilih Obat')" />
                                <select id="obat_id" name="obat_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full select2">
                                    <option value="">- Pilih Obat -</option>
                                    @foreach($obats as $obat)
                                        <option value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('obat_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jenis_transaksi" :value="__('Jenis Transaksi')" />
                                <select id="jenis_transaksi" name="jenis_transaksi" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="Masuk">Masuk (Stok Bertambah)</option>
                                    <option value="Keluar">Keluar (Stok Berkurang)</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_transaksi')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Jumlah & Tanggal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah Item')" />
                                <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah')" required min="1" />
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_transaksi" :value="__('Tanggal Transaksi')" />
                                <x-text-input id="tanggal_transaksi" class="block mt-1 w-full" type="date" name="tanggal_transaksi" :value="old('tanggal_transaksi', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_transaksi')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <x-input-label for="keterangan" :value="__('Keterangan (Opsional)')" />
                            <textarea id="keterangan" name="keterangan" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" placeholder="Contoh: Pembelian Batch 2024 / Resep Pasien A">{{ old('keterangan') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('transaksi-obat.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Transaksi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
