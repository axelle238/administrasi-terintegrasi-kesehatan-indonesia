<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Edit Data Supplier</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pembaruan informasi untuk {{ $supplier->nama_supplier }}</p>
        </div>
        <a href="{{ route('supplier.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-xl font-bold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <form wire:submit="save" class="p-6 md:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Supplier -->
                <div class="space-y-2">
                    <x-input-label for="kode_supplier" value="Kode Supplier" class="dark:text-gray-300" />
                    <x-text-input wire:model="kode_supplier" id="kode_supplier" type="text" class="block w-full mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: SUP-001" />
                    <x-input-error :messages="$errors->get('kode_supplier')" />
                </div>

                <!-- Nama Supplier -->
                <div class="space-y-2">
                    <x-input-label for="nama_supplier" value="Nama Supplier" class="dark:text-gray-300 font-bold" />
                    <x-text-input wire:model="nama_supplier" id="nama_supplier" type="text" class="block w-full mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nama Perusahaan / Vendor" required />
                    <x-input-error :messages="$errors->get('nama_supplier')" />
                </div>

                <!-- Kontak Person -->
                <div class="space-y-2">
                    <x-input-label for="kontak_person" value="Kontak Person (PIC)" class="dark:text-gray-300" />
                    <x-text-input wire:model="kontak_person" id="kontak_person" type="text" class="block w-full mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nama Sales / Penanggung Jawab" />
                    <x-input-error :messages="$errors->get('kontak_person')" />
                </div>

                <!-- Telepon -->
                <div class="space-y-2">
                    <x-input-label for="telepon" value="Nomor Telepon" class="dark:text-gray-300" />
                    <x-text-input wire:model="telepon" id="telepon" type="text" class="block w-full mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="0812..." />
                    <x-input-error :messages="$errors->get('telepon')" />
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <x-input-label for="email" value="Email" class="dark:text-gray-300" />
                    <x-text-input wire:model="email" id="email" type="email" class="block w-full mt-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="sales@perusahaan.com" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>
            </div>

            <!-- Alamat -->
            <div class="space-y-2">
                <x-input-label for="alamat" value="Alamat Lengkap" class="dark:text-gray-300" />
                <textarea wire:model="alamat" id="alamat" rows="3" class="block w-full mt-1 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow"></textarea>
                <x-input-error :messages="$errors->get('alamat')" />
            </div>

            <!-- Keterangan -->
            <div class="space-y-2">
                <x-input-label for="keterangan" value="Keterangan Tambahan" class="dark:text-gray-300" />
                <textarea wire:model="keterangan" id="keterangan" rows="2" class="block w-full mt-1 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow"></textarea>
                <x-input-error :messages="$errors->get('keterangan')" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('supplier.index') }}" wire:navigate class="px-6 py-2.5 text-sm font-bold text-gray-700 dark:text-gray-300 hover:text-gray-900 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-8 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg shadow-indigo-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
