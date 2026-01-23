<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Registrasi Pasien Baru') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('pasien.store') }}">
            @csrf

            <!-- Card 1: Identitas Utama -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .667.333 1 1 1v1m2-2c0 .667-.333 1-1 1v1"></path></svg>
                        Identitas Diri
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="nik" :value="__('NIK')" class="text-gray-600" />
                        <x-text-input id="nik" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500" type="text" name="nik" :value="old('nik')" required autofocus placeholder="16 digit angka" />
                        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="no_bpjs" :value="__('No. BPJS (Opsional)')" class="text-gray-600" />
                        <x-text-input id="no_bpjs" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500" type="text" name="no_bpjs" :value="old('no_bpjs')" placeholder="Nomor kartu BPJS" />
                        <x-input-error :messages="$errors->get('no_bpjs')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" class="text-gray-600" />
                        <x-text-input id="nama_lengkap" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required placeholder="Sesuai KTP" />
                        <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" class="text-gray-600" />
                        <x-text-input id="tempat_lahir" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500" type="text" name="tempat_lahir" :value="old('tempat_lahir')" required />
                        <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" class="text-gray-600" />
                        <x-text-input id="tanggal_lahir" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" required />
                        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" class="text-gray-600" />
                        <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 shadow-sm">
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="golongan_darah" :value="__('Golongan Darah (Opsional)')" class="text-gray-600" />
                        <select id="golongan_darah" name="golongan_darah" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 shadow-sm">
                            <option value="">- Pilih -</option>
                            <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                        <x-input-error :messages="$errors->get('golongan_darah')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Card 2: Kontak & Alamat -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Kontak & Domisili
                    </h3>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <x-input-label for="no_telepon" :value="__('No. Telepon / WhatsApp')" class="text-gray-600" />
                        <x-text-input id="no_telepon" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500" type="text" name="no_telepon" :value="old('no_telepon')" required placeholder="Contoh: 08123456789" />
                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="alamat" :value="__('Alamat Lengkap')" class="text-gray-600" />
                        <textarea id="alamat" name="alamat" rows="3" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 shadow-sm" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan">{{ old('alamat') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('pasien.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                <x-primary-button class="bg-teal-600 hover:bg-teal-700 focus:ring-teal-500 px-8 py-3 text-base">
                    {{ __('Simpan Data Pasien') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>