<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Pendaftaran Pasien Baru
            </h2>
            <p class="text-sm text-gray-500 mt-1 ml-10">
                Isi formulir lengkap untuk mendaftarkan pasien baru ke dalam database SATRIA.
            </p>
        </div>
        <a href="{{ route('pasien.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <form wire:submit="save" class="space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Panel: Identitas & Domisili -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Identitas -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Identitas Utama</h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nik" value="NIK (Nomor Induk Kependudukan)" class="mb-2" />
                                <x-text-input wire:model="nik" id="nik" class="block w-full bg-gray-50 focus:bg-white transition-colors" type="text" maxlength="16" placeholder="16 Digit NIK" required />
                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="nama_lengkap" value="Nama Lengkap" class="mb-2" />
                                <x-text-input wire:model="nama_lengkap" id="nama_lengkap" class="block w-full font-medium" type="text" placeholder="Sesuai KTP" required />
                                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tempat_lahir" value="Tempat Lahir" class="mb-2" />
                                <x-text-input wire:model="tempat_lahir" id="tempat_lahir" class="block w-full" type="text" required />
                                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="mb-2" />
                                <x-text-input wire:model="tanggal_lahir" id="tanggal_lahir" class="block w-full" type="date" required />
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="jenis_kelamin" value="Jenis Kelamin" class="mb-2" />
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="jenis_kelamin" value="Laki-laki" class="peer sr-only">
                                        <div class="text-center p-3 rounded-lg border border-gray-200 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 hover:bg-gray-50 transition-all">
                                            <span class="block text-sm font-semibold">Laki-laki</span>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" wire:model="jenis_kelamin" value="Perempuan" class="peer sr-only">
                                        <div class="text-center p-3 rounded-lg border border-gray-200 peer-checked:bg-pink-50 peer-checked:border-pink-500 peer-checked:text-pink-700 hover:bg-gray-50 transition-all">
                                            <span class="block text-sm font-semibold">Perempuan</span>
                                        </div>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="golongan_darah" value="Golongan Darah" class="mb-2" />
                                <select wire:model="golongan_darah" id="golongan_darah" class="appearance-none w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block p-3 pr-8">
                                    <option value="">Tidak Tahu</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                                <x-input-error :messages="$errors->get('golongan_darah')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Kontak & Domisili</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <x-input-label for="no_telepon" value="Nomor Telepon / WhatsApp" class="mb-2" />
                            <x-text-input wire:model="no_telepon" id="no_telepon" class="block w-full" type="text" placeholder="08..." required />
                            <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="alamat" value="Alamat Lengkap" class="mb-2" />
                            <textarea wire:model="alamat" id="alamat" rows="3" class="block w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm transition-colors" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan" required></textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Penjamin & Aksi -->
            <div class="space-y-6">
                <!-- Penjamin -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-8">
                     <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Penjamin (BPJS/JKN)</h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <div>
                            <x-input-label for="asuransi" value="Jenis Penjamin" class="mb-2" />
                            <select wire:model="asuransi" id="asuransi" class="appearance-none w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block p-3 pr-8">
                                <option value="Umum">Umum (Mandiri)</option>
                                <option value="BPJS">BPJS Kesehatan</option>
                                <option value="Jamkesda">Jamkesda</option>
                                <option value="Asuransi Swasta">Asuransi Swasta</option>
                            </select>
                        </div>

                        <div class="pt-2 pb-2 border-t border-b border-gray-100 bg-gray-50/50 rounded-lg px-3">
                            <x-input-label for="no_bpjs" value="Cek Kepesertaan BPJS" class="mb-2 text-xs font-bold uppercase text-gray-500" />
                            <div class="flex gap-2">
                                <x-text-input wire:model="no_bpjs" id="no_bpjs" class="block w-full text-sm" type="text" placeholder="No. Kartu BPJS" />
                                <button type="button" wire:click="checkBpjs" wire:loading.attr="disabled" class="px-3 py-2 bg-teal-600 text-white rounded-lg shadow-sm hover:bg-teal-700 focus:ring-2 focus:ring-teal-500 transition-colors disabled:opacity-50">
                                    <svg wire:loading.remove wire:target="checkBpjs" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <svg wire:loading wire:target="checkBpjs" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- BPJS Status Feedback -->
                            @if($bpjsStatus === 'active')
                                <div class="mt-3 flex items-start gap-2 text-green-700 bg-green-50 p-2 rounded border border-green-100 text-xs">
                                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ $bpjsMessage }}</span>
                                </div>
                            @elseif($bpjsStatus === 'inactive')
                                <div class="mt-3 flex items-start gap-2 text-red-700 bg-red-50 p-2 rounded border border-red-100 text-xs">
                                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ $bpjsMessage }}</span>
                                </div>
                            @elseif($bpjsStatus === 'error')
                                <div class="mt-3 flex items-start gap-2 text-gray-600 bg-gray-50 p-2 rounded border border-gray-200 text-xs">
                                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ $bpjsMessage }}</span>
                                </div>
                            @endif
                            <x-input-error :messages="$errors->get('no_bpjs')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="faskes_asal" value="Faskes Perujuk" class="mb-2" />
                            <x-text-input wire:model="faskes_asal" id="faskes_asal" class="block w-full" type="text" placeholder="Jika ada rujukan" />
                        </div>

                        <!-- PRB -->
                        <div class="pt-4 border-t border-gray-100">
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="checkbox" wire:model="is_prb" class="rounded-md border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500 h-5 w-5 transition ease-in-out duration-150">
                                <span class="text-sm font-semibold text-gray-700 group-hover:text-teal-700 transition">Peserta Program Rujuk Balik (PRB)</span>
                            </label>
                            
                            <div x-show="$wire.is_prb" x-transition class="mt-4 space-y-4 pl-8 border-l-2 border-teal-100">
                                <div>
                                    <x-input-label for="no_prb" value="Nomor PRB / SRB" class="mb-1 text-xs" />
                                    <x-text-input wire:model="no_prb" id="no_prb" class="block w-full text-sm" type="text" placeholder="No. Surat Rujuk Balik" />
                                </div>
                                <div>
                                    <x-input-label for="catatan_prb" value="Catatan / Obat Rutin" class="mb-1 text-xs" />
                                    <textarea wire:model="catatan_prb" id="catatan_prb" class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-teal-500 focus:ring-teal-500" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <x-primary-button class="w-full justify-center py-3 text-base bg-teal-600 hover:bg-teal-700 active:bg-teal-800 focus:ring-teal-500 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5" wire:loading.attr="disabled">
                                <span wire:loading.remove>Simpan Data Pasien</span>
                                <span wire:loading class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Menyimpan...
                                </span>
                            </x-primary-button>
                            
                            <a href="{{ route('pasien.index') }}" wire:navigate class="mt-3 block w-full text-center py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                Batalkan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
