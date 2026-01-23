<div class="max-w-4xl mx-auto">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form wire:submit="update">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Identitas -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Identitas Utama</h3>
                        
                        <div>
                            <x-input-label for="nik" value="NIK (Nomor Induk Kependudukan)" />
                            <x-text-input wire:model="nik" id="nik" class="block mt-1 w-full" type="text" maxlength="16" required />
                            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="no_bpjs" value="Nomor BPJS / JKN (Jika Ada)" />
                            <x-text-input wire:model="no_bpjs" id="no_bpjs" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('no_bpjs')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nama_lengkap" value="Nama Lengkap" />
                            <x-text-input wire:model="nama_lengkap" id="nama_lengkap" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                                <x-text-input wire:model="tempat_lahir" id="tempat_lahir" class="block mt-1 w-full" type="text" required />
                                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                                <x-text-input wire:model="tanggal_lahir" id="tanggal_lahir" class="block mt-1 w-full" type="date" required />
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                                <select wire:model="jenis_kelamin" id="jenis_kelamin" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Pilih...</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="golongan_darah" value="Gol. Darah" />
                                <select wire:model="golongan_darah" id="golongan_darah" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
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

                    <!-- Kontak & Alamat -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Kontak & Domisili</h3>

                        <div>
                            <x-input-label for="no_telepon" value="Nomor Telepon / HP" />
                            <x-text-input wire:model="no_telepon" id="no_telepon" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="alamat" value="Alamat Lengkap" />
                            <textarea wire:model="alamat" id="alamat" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('pasien.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 underline text-sm mr-4">Batal</a>
                    <x-primary-button wire:loading.attr="disabled">
                        {{ __('Perbarui Data Pasien') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>