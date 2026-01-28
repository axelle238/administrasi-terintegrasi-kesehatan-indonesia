<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Tambah Ruangan Baru</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Silakan isi formulir di bawah ini untuk menambahkan ruangan baru ke sistem inventaris.</p>
        </div>
        <a href="{{ route('ruangan.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-xl font-bold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <form wire:submit="save" class="p-6 md:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Ruangan -->
                <div class="space-y-2">
                    <x-input-label for="kode_ruangan" value="Kode Ruangan" class="dark:text-gray-300" />
                    <x-text-input wire:model="kode_ruangan" id="kode_ruangan" type="text" class="block w-full mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: R-001" />
                    <x-input-error :messages="$errors->get('kode_ruangan')" />
                </div>

                <!-- Nama Ruangan -->
                <div class="space-y-2">
                    <x-input-label for="nama_ruangan" value="Nama Ruangan" class="dark:text-gray-300 font-bold" />
                    <x-text-input wire:model="nama_ruangan" id="nama_ruangan" type="text" class="block w-full mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Poliklinik Umum" required />
                    <x-input-error :messages="$errors->get('nama_ruangan')" />
                </div>

                <!-- Lokasi Gedung -->
                <div class="space-y-2">
                    <x-input-label for="lokasi_gedung" value="Lokasi / Gedung" class="dark:text-gray-300" />
                    <x-text-input wire:model="lokasi_gedung" id="lokasi_gedung" type="text" class="block w-full mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Gedung A Lantai 1" />
                    <x-input-error :messages="$errors->get('lokasi_gedung')" />
                </div>

                <!-- Penanggung Jawab -->
                <div class="space-y-2">
                    <x-input-label for="penanggung_jawab" value="Penanggung Jawab (PIC)" class="dark:text-gray-300" />
                    <x-text-input wire:model="penanggung_jawab" id="penanggung_jawab" type="text" class="block w-full mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nama Penanggung Jawab" />
                    <x-input-error :messages="$errors->get('penanggung_jawab')" />
                </div>
            </div>

            <!-- Keterangan -->
            <div class="space-y-2">
                <x-input-label for="keterangan" value="Keterangan Ruangan" class="dark:text-gray-300" />
                <textarea wire:model="keterangan" id="keterangan" rows="3" class="block w-full mt-1 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow" placeholder="Detail tambahan mengenai kapasitas atau fungsi ruangan..."></textarea>
                <x-input-error :messages="$errors->get('keterangan')" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('ruangan.index') }}" wire:navigate class="px-6 py-2.5 text-sm font-bold text-gray-700 dark:text-gray-300 hover:text-gray-900 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-8 py-2.5 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg shadow-blue-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Simpan Data Ruangan
                </button>
            </div>
        </form>
    </div>
</div>
