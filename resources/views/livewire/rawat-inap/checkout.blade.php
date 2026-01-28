<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Checkout Pasien</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Proses kepulangan pasien rawat inap.</p>
        </div>
        <a href="{{ route('rawat-inap.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-xl font-bold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition ease-in-out duration-150">
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
        <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800">
            <h3 class="text-sm font-bold text-blue-800 dark:text-blue-300">Data Pasien</h3>
            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Nama:</span>
                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $rawatInap->pasien->nama_lengkap }}</span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Kamar:</span>
                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $rawatInap->kamar->nama_kamar }}</span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Masuk:</span>
                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($rawatInap->waktu_masuk)->format('d F Y H:i') }}</span>
                </div>
            </div>
        </div>

        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="waktu_keluar" value="Waktu Keluar" />
                    <x-text-input wire:model="waktu_keluar" id="waktu_keluar" type="datetime-local" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('waktu_keluar')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="checkoutStatus" value="Status Kepulangan" />
                    <select wire:model="checkoutStatus" id="checkoutStatus" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="Pulang">Pulang Sehat / Berobat Jalan</option>
                        <option value="Rujuk">Dirujuk ke RS Lain</option>
                        <option value="Meninggal">Meninggal Dunia</option>
                        <option value="Pulang Paksa">Pulang Atas Permintaan Sendiri</option>
                    </select>
                    <x-input-error :messages="$errors->get('checkoutStatus')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="diagnosa_akhir" value="Diagnosa Akhir / Catatan Pulang" />
                <textarea wire:model="diagnosa_akhir" id="diagnosa_akhir" rows="4" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                <x-input-error :messages="$errors->get('diagnosa_akhir')" class="mt-2" />
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-lg shadow-indigo-500/20">
                    Proses Kepulangan
                </button>
            </div>
        </form>
    </div>
</div>
