<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Arsip Surat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('surat.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Jenis & No Surat -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="jenis_surat" :value="__('Jenis Surat')" />
                                <select id="jenis_surat" name="jenis_surat" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" onchange="togglePengirimPenerima(this.value)">
                                    <option value="Masuk">Surat Masuk</option>
                                    <option value="Keluar">Surat Keluar</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_surat')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nomor_surat" :value="__('Nomor Surat')" />
                                <x-text-input id="nomor_surat" class="block mt-1 w-full" type="text" name="nomor_surat" :value="old('nomor_surat')" required placeholder="Contoh: 440/123/PKM/2024" />
                                <x-input-error :messages="$errors->get('nomor_surat')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Tanggal & Perihal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="tanggal_surat" :value="__('Tanggal Surat')" />
                                <x-text-input id="tanggal_surat" class="block mt-1 w-full" type="date" name="tanggal_surat" :value="old('tanggal_surat')" required />
                                <x-input-error :messages="$errors->get('tanggal_surat')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="perihal" :value="__('Perihal Surat')" />
                                <x-text-input id="perihal" class="block mt-1 w-full" type="text" name="perihal" :value="old('perihal')" required placeholder="Contoh: Undangan Rapat Dinas" />
                                <x-input-error :messages="$errors->get('perihal')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Pengirim & Penerima -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="pengirim" :value="__('Pengirim / Asal Surat')" />
                                <x-text-input id="pengirim" class="block mt-1 w-full" type="text" name="pengirim" :value="old('pengirim')" required placeholder="Instansi/Orang pengirim" />
                                <x-input-error :messages="$errors->get('pengirim')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="penerima" :value="__('Penerima / Tujuan')" />
                                <x-text-input id="penerima" class="block mt-1 w-full" type="text" name="penerima" :value="old('penerima')" required placeholder="Kepada Yth..." />
                                <x-input-error :messages="$errors->get('penerima')" class="mt-2" />
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-6">
                            <x-input-label for="file_surat" :value="__('Upload Scan Surat (PDF/JPG/PNG, Max 2MB)')" />
                            <input type="file" id="file_surat" name="file_surat" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-1">
                            <x-input-error :messages="$errors->get('file_surat')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('surat.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Arsip') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
