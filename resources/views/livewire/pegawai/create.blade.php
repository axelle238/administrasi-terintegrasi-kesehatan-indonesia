<div>
    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Akun Login Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 h-fit">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Informasi Akun Login</h3>
                
                <div class="space-y-4">
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Password Default" />
                        <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="role" value="Role / Hak Akses" />
                        <select wire:model.live="role" id="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value="staf">Staf</option>
                            <option value="dokter">Dokter</option>
                            <option value="perawat">Perawat</option>
                            <option value="apoteker">Apoteker</option>
                            <option value="admin">Administrator</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Data Pegawai Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Data Kepegawaian</h3>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="nip" value="NIP / ID Pegawai" />
                            <x-text-input wire:model="nip" id="nip" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="tanggal_masuk" value="Tanggal Masuk" />
                            <x-text-input wire:model="tanggal_masuk" id="tanggal_masuk" class="block mt-1 w-full" type="date" required />
                            <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="jabatan" value="Jabatan" />
                            <x-text-input wire:model="jabatan" id="jabatan" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="status_kepegawaian" value="Status" />
                            <select wire:model="status_kepegawaian" id="status_kepegawaian" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="Kontrak">Kontrak</option>
                                <option value="Tetap">Tetap</option>
                                <option value="Magang">Magang</option>
                            </select>
                            <x-input-error :messages="$errors->get('status_kepegawaian')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="no_telepon" value="No. Telepon" />
                        <x-text-input wire:model="no_telepon" id="no_telepon" class="block mt-1 w-full" type="text" required />
                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alamat" value="Alamat Lengkap" />
                        <textarea wire:model="alamat" id="alamat" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3" required></textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <!-- Fields Khusus Medis -->
                    <div x-show="$wire.role === 'dokter' || $wire.role === 'perawat' || $wire.role === 'apoteker' || $wire.role === 'bidan'" class="pt-4 border-t space-y-4" x-transition>
                        <h4 class="text-md font-bold text-indigo-700 bg-indigo-50 p-2 rounded-lg">Detail Profesi & Izin Praktik</h4>

                        <!-- Poli Selection -->
                        <div>
                            <x-input-label for="poli_id" value="Unit Layanan / Poli" />
                            <select wire:model="poli_id" id="poli_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">-- Pilih Poli --</option>
                                @foreach($polis as $poli)
                                    <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Wajib diisi untuk Dokter/Perawat agar muncul di jadwal.</p>
                            <x-input-error :messages="$errors->get('poli_id')" class="mt-2" />
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- STR -->
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <h5 class="font-bold text-gray-700 text-sm mb-2">Surat Tanda Registrasi (STR)</h5>
                                <div class="space-y-3">
                                    <div>
                                        <x-input-label for="no_str" value="Nomor STR" />
                                        <x-text-input wire:model="no_str" id="no_str" class="block mt-1 w-full text-sm" type="text" />
                                    </div>
                                    <div>
                                        <x-input-label for="masa_berlaku_str" value="Berlaku Hingga" />
                                        <x-text-input wire:model="masa_berlaku_str" id="masa_berlaku_str" class="block mt-1 w-full text-sm" type="date" />
                                    </div>
                                    <div>
                                        <x-input-label for="file_str" value="Upload Dokumen STR (PDF/Img)" />
                                        <input type="file" wire:model="file_str" id="file_str" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-1"/>
                                        <x-input-error :messages="$errors->get('file_str')" class="mt-1" />
                                    </div>
                                </div>
                            </div>

                            <!-- SIP -->
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <h5 class="font-bold text-gray-700 text-sm mb-2">Surat Izin Praktik (SIP)</h5>
                                <div class="space-y-3">
                                    <div>
                                        <x-input-label for="no_sip" value="Nomor SIP" />
                                        <x-text-input wire:model="no_sip" id="no_sip" class="block mt-1 w-full text-sm" type="text" />
                                    </div>
                                    <div>
                                        <x-input-label for="masa_berlaku_sip" value="Berlaku Hingga" />
                                        <x-text-input wire:model="masa_berlaku_sip" id="masa_berlaku_sip" class="block mt-1 w-full text-sm" type="date" />
                                    </div>
                                    <div>
                                        <x-input-label for="file_sip" value="Upload Dokumen SIP (PDF/Img)" />
                                        <input type="file" wire:model="file_sip" id="file_sip" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-1"/>
                                        <x-input-error :messages="$errors->get('file_sip')" class="mt-1" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ijazah -->
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                             <h5 class="font-bold text-gray-700 text-sm mb-2">Dokumen Pendidikan</h5>
                             <div>
                                <x-input-label for="file_ijazah" value="Upload Ijazah Terakhir (PDF/Img)" />
                                <input type="file" wire:model="file_ijazah" id="file_ijazah" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-1"/>
                                <x-input-error :messages="$errors->get('file_ijazah')" class="mt-1" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-6 gap-4">
            <a href="{{ route('pegawai.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 underline text-sm">Batal</a>
            <x-primary-button wire:loading.attr="disabled">
                {{ __('Simpan Data Pegawai') }}
            </x-primary-button>
        </div>
    </form>
</div>