<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Catat Pemeliharaan Aset</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan riwayat service, perbaikan, atau maintenance rutin untuk {{ $barang->nama_barang }}.</p>
        </div>
        <a href="{{ route('barang.show', $barang->id) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-xl font-bold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition ease-in-out duration-150">
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <form wire:submit="save" class="p-6 md:p-8 space-y-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white dark:bg-gray-800 rounded-lg flex items-center justify-center text-blue-600 font-bold text-xl shadow-sm">
                        {{ substr($barang->nama_barang, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-900 dark:text-blue-100">{{ $barang->nama_barang }}</h3>
                        <p class="text-xs text-blue-600 dark:text-blue-300">{{ $barang->kode_barang }} | Merk: {{ $barang->merk ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="m_tanggal" value="Tanggal Pelaksanaan" />
                    <x-text-input wire:model="m_tanggal" id="m_tanggal" type="date" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('m_tanggal')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="m_kegiatan" value="Jenis Kegiatan" />
                    <select wire:model="m_kegiatan" id="m_kegiatan" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="Pemeliharaan Rutin">Pemeliharaan Rutin</option>
                        <option value="Perbaikan Ringan">Perbaikan Ringan</option>
                        <option value="Perbaikan Berat">Perbaikan Berat / Service Besar</option>
                        <option value="Kalibrasi">Kalibrasi Alat</option>
                        <option value="Penggantian Sparepart">Penggantian Sparepart</option>
                    </select>
                    <x-input-error :messages="$errors->get('m_kegiatan')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="m_teknisi" value="Teknisi / Vendor Pelaksana" />
                    <x-text-input wire:model="m_teknisi" id="m_teknisi" type="text" class="mt-1 block w-full" placeholder="Nama Teknisi atau Perusahaan" />
                    <x-input-error :messages="$errors->get('m_teknisi')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="m_biaya" value="Biaya (Rp)" />
                    <x-text-input wire:model="m_biaya" id="m_biaya" type="number" class="mt-1 block w-full" placeholder="0" />
                    <x-input-error :messages="$errors->get('m_biaya')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="m_keterangan" value="Keterangan / Hasil Pengerjaan" />
                <textarea wire:model="m_keterangan" id="m_keterangan" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Deskripsikan apa yang dilakukan dan hasilnya..."></textarea>
                <x-input-error :messages="$errors->get('m_keterangan')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="m_tanggal_berikutnya" value="Jadwal Pemeliharaan Berikutnya (Opsional)" />
                <x-text-input wire:model="m_tanggal_berikutnya" id="m_tanggal_berikutnya" type="date" class="mt-1 block w-full md:w-1/2" />
                <p class="text-xs text-gray-500 mt-1">Isi jika perlu dijadwalkan ulang.</p>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-lg shadow-blue-500/20">
                    Simpan Data Pemeliharaan
                </button>
            </div>
        </form>
    </div>
</div>
