<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('pasien.update', $pasien->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- NIK & BPJS -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="nik" :value="__('NIK')" />
                                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik', $pasien->nik)" required />
                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="no_bpjs" :value="__('No. BPJS (Opsional)')" />
                                <x-text-input id="no_bpjs" class="block mt-1 w-full" type="text" name="no_bpjs" :value="old('no_bpjs', $pasien->no_bpjs)" />
                                <x-input-error :messages="$errors->get('no_bpjs')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="mb-4">
                            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', $pasien->nama_lengkap)" required />
                            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                        </div>

                        <!-- TTL -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir', $pasien->tempat_lahir)" required />
                                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $pasien->tanggal_lahir)" required />
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Jenis Kelamin & Golongan Darah -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select id="jenis_kelamin" name="jenis_kelamin" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="golongan_darah" :value="__('Golongan Darah (Opsional)')" />
                                <select id="golongan_darah" name="golongan_darah" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">- Pilih -</option>
                                    <option value="A" {{ old('golongan_darah', $pasien->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah', $pasien->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah', $pasien->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah', $pasien->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                                <x-input-error :messages="$errors->get('golongan_darah')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Kontak -->
                        <div class="mb-4">
                            <x-input-label for="no_telepon" :value="__('No. Telepon / WhatsApp')" />
                            <x-text-input id="no_telepon" class="block mt-1 w-full" type="text" name="no_telepon" :value="old('no_telepon', $pasien->no_telepon)" required />
                            <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                            <textarea id="alamat" name="alamat" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>{{ old('alamat', $pasien->alamat) }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pasien.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 mr-4">Batal</a>
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
