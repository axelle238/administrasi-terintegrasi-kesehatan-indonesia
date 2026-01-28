<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Catat Kegiatan UKM</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan Upaya Kesehatan Masyarakat (Posyandu, Penyuluhan, Kunjungan Lapangan, dll).</p>
        </div>
        <a href="{{ route('ukm.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-xl font-bold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <form wire:submit="save" class="p-6 md:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Kegiatan -->
                <div class="space-y-2">
                    <x-input-label for="nama_kegiatan" value="Nama Kegiatan" class="font-bold" />
                    <x-text-input wire:model="nama_kegiatan" id="nama_kegiatan" type="text" class="block w-full mt-1" placeholder="Contoh: Posyandu Balita RW 01" required />
                    <x-input-error :messages="$errors->get('nama_kegiatan')" />
                </div>

                <!-- Jenis Kegiatan -->
                <div class="space-y-2">
                    <x-input-label for="jenis_kegiatan" value="Jenis UKM" />
                    <select wire:model="jenis_kegiatan" id="jenis_kegiatan" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Promosi Kesehatan">Promosi Kesehatan</option>
                        <option value="Kesehatan Lingkungan">Kesehatan Lingkungan</option>
                        <option value="KIA & KB">KIA & KB</option>
                        <option value="Gizi">Gizi</option>
                        <option value="Pencegahan Penyakit">Pencegahan Penyakit</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_kegiatan')" />
                </div>

                <!-- Tanggal -->
                <div class="space-y-2">
                    <x-input-label for="tanggal_kegiatan" value="Tanggal Pelaksanaan" />
                    <x-text-input wire:model="tanggal_kegiatan" id="tanggal_kegiatan" type="date" class="block w-full mt-1" required />
                    <x-input-error :messages="$errors->get('tanggal_kegiatan')" />
                </div>

                <!-- Lokasi -->
                <div class="space-y-2">
                    <x-input-label for="lokasi" value="Lokasi Kegiatan" />
                    <x-text-input wire:model="lokasi" id="lokasi" type="text" class="block w-full mt-1" placeholder="Nama Posyandu / Desa / Kantor RW" required />
                    <x-input-error :messages="$errors->get('lokasi')" />
                </div>

                <!-- Jumlah Peserta -->
                <div class="space-y-2">
                    <x-input-label for="jumlah_peserta" value="Estimasi Jumlah Peserta" />
                    <x-text-input wire:model="jumlah_peserta" id="jumlah_peserta" type="number" class="block w-full mt-1" placeholder="0" />
                    <x-input-error :messages="$errors->get('jumlah_peserta')" />
                </div>

                <!-- File Laporan -->
                <div class="space-y-2">
                    <x-input-label for="file_laporan" value="Dokumentasi / Laporan (Opsional)" />
                    <input type="file" wire:model="file_laporan" id="file_laporan" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all" />
                    <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold">Maksimal 10MB (PDF/JPG/PNG)</p>
                    <x-input-error :messages="$errors->get('file_laporan')" />
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="space-y-2">
                <x-input-label for="deskripsi" value="Narasi / Deskripsi Kegiatan" />
                <textarea wire:model="deskripsi" id="deskripsi" rows="4" class="block w-full mt-1 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow" placeholder="Tuliskan ringkasan hasil kegiatan atau temuan penting di lapangan..."></textarea>
                <x-input-error :messages="$errors->get('deskripsi')" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg shadow-blue-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Simpan Laporan UKM
                </button>
            </div>
        </form>
    </div>
</div>
