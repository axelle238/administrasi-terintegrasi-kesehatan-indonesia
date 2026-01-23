<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pegawai') }}
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

                    <form method="POST" action="{{ route('pegawai.update', $pegawai->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- AKUN LOGIN -->
                        <h3 class="text-lg font-bold text-blue-600 mb-4 border-b pb-2">Informasi Akun Login</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap (User)')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $pegawai->user->name)" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email (Untuk Login)')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $pegawai->user->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <x-input-label for="password" :value="__('Password Baru (Opsional)')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="role" :value="__('Hak Akses (Role)')" />
                                <select id="role" name="role" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="staf" {{ $pegawai->user->role == 'staf' ? 'selected' : '' }}>Staf Tata Usaha</option>
                                    <option value="dokter" {{ $pegawai->user->role == 'dokter' ? 'selected' : '' }}>Dokter</option>
                                    <option value="perawat" {{ $pegawai->user->role == 'perawat' ? 'selected' : '' }}>Perawat</option>
                                    <option value="apoteker" {{ $pegawai->user->role == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                                    <option value="admin" {{ $pegawai->user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                        </div>

                        <!-- DATA PEGAWAI -->
                        <h3 class="text-lg font-bold text-blue-600 mb-4 border-b pb-2">Data Kepegawaian</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="nip" :value="__('NIP')" />
                                <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip', $pegawai->nip)" required />
                                <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jabatan" :value="__('Jabatan')" />
                                <x-text-input id="jabatan" class="block mt-1 w-full" type="text" name="jabatan" :value="old('jabatan', $pegawai->jabatan)" required />
                                <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="status_kepegawaian" :value="__('Status Kepegawaian')" />
                                <select id="status_kepegawaian" name="status_kepegawaian" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="PNS" {{ $pegawai->status_kepegawaian == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="PPPK" {{ $pegawai->status_kepegawaian == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                    <option value="Honorer" {{ $pegawai->status_kepegawaian == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                                    <option value="Kontrak" {{ $pegawai->status_kepegawaian == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                </select>
                                <x-input-error :messages="$errors->get('status_kepegawaian')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_masuk" :value="__('Tanggal Masuk')" />
                                <x-text-input id="tanggal_masuk" class="block mt-1 w-full" type="date" name="tanggal_masuk" :value="old('tanggal_masuk', $pegawai->tanggal_masuk)" required />
                                <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
                            </div>
                        </div>

                        <!-- DATA MEDIS (OPSIONAL) -->
                        <h3 class="text-lg font-bold text-blue-600 mb-4 border-b pb-2 mt-6">Informasi Tenaga Medis (Opsional)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="no_str" :value="__('Nomor STR')" />
                                <x-text-input id="no_str" class="block mt-1 w-full" type="text" name="no_str" :value="old('no_str', $pegawai->no_str)" placeholder="Surat Tanda Registrasi" />
                                <x-input-error :messages="$errors->get('no_str')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="masa_berlaku_str" :value="__('Masa Berlaku STR')" />
                                <x-text-input id="masa_berlaku_str" class="block mt-1 w-full" type="date" name="masa_berlaku_str" :value="old('masa_berlaku_str', $pegawai->masa_berlaku_str)" />
                                <x-input-error :messages="$errors->get('masa_berlaku_str')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="no_sip" :value="__('Nomor SIP')" />
                                <x-text-input id="no_sip" class="block mt-1 w-full" type="text" name="no_sip" :value="old('no_sip', $pegawai->no_sip)" placeholder="Surat Izin Praktik" />
                                <x-input-error :messages="$errors->get('no_sip')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="masa_berlaku_sip" :value="__('Masa Berlaku SIP')" />
                                <x-text-input id="masa_berlaku_sip" class="block mt-1 w-full" type="date" name="masa_berlaku_sip" :value="old('masa_berlaku_sip', $pegawai->masa_berlaku_sip)" />
                                <x-input-error :messages="$errors->get('masa_berlaku_sip')" class="mt-2" />
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-blue-600 mb-4 border-b pb-2 mt-6">Kontak & Alamat</h3>

                        <div class="mb-4">
                            <x-input-label for="no_telepon" :value="__('No. Telepon')" />
                            <x-text-input id="no_telepon" class="block mt-1 w-full" type="text" name="no_telepon" :value="old('no_telepon', $pegawai->no_telepon)" required />
                            <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="alamat" :value="__('Alamat Domisili')" />
                            <textarea id="alamat" name="alamat" rows="2" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>{{ old('alamat', $pegawai->alamat) }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pegawai.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 mr-4">Batal</a>
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
