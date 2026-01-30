<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Registrasi Inap</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pendaftaran pasien baru untuk rawat inap.</p>
        </div>
        <a href="{{ route('rawat-inap.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-bold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150">
            Batal
        </a>
    </div>

    <form wire:submit="save" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
        
        <div class="space-y-6">
            <!-- Patient Search -->
            <div class="space-y-2" x-data="{ open: false }">
                <x-input-label for="pasien_id" value="Cari Pasien" />
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="searchPasien" 
                        placeholder="Ketik Nama atau NIK..." 
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        @focus="open = true"
                        @click.away="open = false"
                    >
                    @if(!empty($searchPasien) && count($pasiens) > 0)
                        <div x-show="open" class="absolute z-10 w-full bg-white dark:bg-gray-800 shadow-xl rounded-xl mt-1 max-h-60 overflow-y-auto border border-gray-100 dark:border-gray-700">
                            <ul>
                                @foreach($pasiens as $p)
                                    <li 
                                        wire:click="$set('pasien_id', {{ $p->id }}); $set('searchPasien', '{{ $p->nama_lengkap }}'); open = false;" 
                                        class="px-4 py-3 hover:bg-indigo-50 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-50 dark:border-gray-700 last:border-b-0"
                                    >
                                        <div class="font-bold text-gray-800 dark:text-white text-sm">{{ $p->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">NIK: {{ $p->nik }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @elseif(!empty($searchPasien))
                         <div x-show="open" class="absolute z-10 w-full bg-white dark:bg-gray-800 shadow-xl rounded-xl mt-1 p-4 text-sm text-gray-500 dark:text-gray-400 text-center border border-gray-100 dark:border-gray-700">
                            Pasien tidak ditemukan.
                        </div>
                    @endif
                </div>
                @if($pasien_id)
                    <div class="mt-2 p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-100 dark:border-indigo-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-sm font-bold text-indigo-700 dark:text-indigo-300">Pasien Terpilih</span>
                    </div>
                @endif
                <x-input-error :messages="$errors->get('pasien_id')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kamar -->
                <div>
                    <x-input-label for="kamar_id" value="Pilih Kamar Tersedia" />
                    <select wire:model="kamar_id" id="kamar_id" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($availableKamars as $kamar)
                            <option value="{{ $kamar->id }}">
                                {{ $kamar->nama_kamar }} - {{ $kamar->nama_bangsal }} ({{ $kamar->kelas }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('kamar_id')" class="mt-2" />
                </div>

                <!-- Waktu Masuk -->
                <div>
                    <x-input-label for="waktu_masuk" value="Waktu Masuk" />
                    <x-text-input wire:model="waktu_masuk" id="waktu_masuk" type="datetime-local" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('waktu_masuk')" class="mt-2" />
                </div>
            </div>

            <!-- Diagnosa & Pembayaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="diagnosa_awal" value="Diagnosa Awal (Indikasi Rawat)" />
                    <x-text-input wire:model="diagnosa_awal" id="diagnosa_awal" type="text" class="mt-1 block w-full" placeholder="Contoh: Demam Berdarah Dengue" />
                    <x-input-error :messages="$errors->get('diagnosa_awal')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="jenis_pembayaran" value="Metode Pembayaran" />
                    <select wire:model="jenis_pembayaran" id="jenis_pembayaran" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="Umum">Umum / Mandiri</option>
                        <option value="BPJS">BPJS Kesehatan</option>
                        <option value="Asuransi Lain">Asuransi Lain</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_pembayaran')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-8">
            <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-lg shadow-indigo-500/20">
                Simpan & Daftarkan
            </button>
        </div>
    </form>
</div>