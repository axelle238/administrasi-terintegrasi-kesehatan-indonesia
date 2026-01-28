<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Pendaftaran Rawat Inap</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Registrasi pasien masuk ke unit rawat inap.</p>
        </div>
        <a href="{{ route('rawat-inap.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-xl font-bold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition ease-in-out duration-150">
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="pasien_id" value="Pilih Pasien" class="font-bold" />
                    <select wire:model="pasien_id" id="pasien_id" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($pasiens as $pasien)
                            <option value="{{ $pasien->id }}">{{ $pasien->nama_lengkap }} ({{ $pasien->nik }})</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('pasien_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="kamar_id" value="Pilih Kamar / Bed" class="font-bold" />
                    <select wire:model="kamar_id" id="kamar_id" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">-- Pilih Kamar Tersedia --</option>
                        @foreach($availableKamars as $kamar)
                            <option value="{{ $kamar->id }}">{{ $kamar->nama_kamar }} - Kelas {{ $kamar->kelas }} (Sisa: {{ $kamar->kapasitas_bed - $kamar->bed_terisi }})</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('kamar_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="waktu_masuk" value="Waktu Masuk" />
                    <x-text-input wire:model="waktu_masuk" id="waktu_masuk" type="datetime-local" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('waktu_masuk')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="jenis_pembayaran" value="Jenis Pembayaran" />
                    <select wire:model="jenis_pembayaran" id="jenis_pembayaran" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="Umum">Umum / Tunai</option>
                        <option value="BPJS">BPJS Kesehatan</option>
                        <option value="Asuransi Lain">Asuransi Lain</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_pembayaran')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="diagnosa_awal" value="Diagnosa Awal / Alasan Masuk" />
                <textarea wire:model="diagnosa_awal" id="diagnosa_awal" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                <x-input-error :messages="$errors->get('diagnosa_awal')" class="mt-2" />
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-lg shadow-blue-500/20">
                    Proses Pendaftaran
                </button>
            </div>
        </form>
    </div>
</div>
