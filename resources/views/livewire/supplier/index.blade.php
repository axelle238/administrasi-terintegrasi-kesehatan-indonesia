<div class="space-y-6">
    
    <!-- Header & Action -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Daftar Supplier / Vendor</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Manajemen rekanan dan supplier logistik.</p>
        </div>
        <button wire:click="create" class="group relative inline-flex items-center justify-center px-6 py-2.5 overflow-hidden font-bold text-white transition-all duration-300 bg-teal-600 rounded-xl hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
            <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
            <span class="relative flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Supplier
            </span>
        </button>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
        <div class="relative max-w-md w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 focus:border-teal-500 focus:ring-teal-500 sm:text-sm transition-shadow" placeholder="Cari supplier, kode, atau kontak...">
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kode</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Supplier</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kontak Person</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Telepon / Email</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($suppliers as $supplier)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-teal-600 dark:text-teal-400">
                                {{ $supplier->kode_supplier ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <div class="font-medium">{{ $supplier->nama_supplier }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($supplier->alamat, 30) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                <div class="flex items-center gap-2">
                                     <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-xs font-bold text-blue-600 dark:text-blue-300">
                                        {{ substr($supplier->kontak_person ?? '?', 0, 1) }}
                                    </div>
                                    {{ $supplier->kontak_person ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col">
                                    <span class="font-mono text-xs">{{ $supplier->telepon ?? '-' }}</span>
                                    <span class="text-xs text-teal-600 dark:text-teal-400">{{ $supplier->email ?? '' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $supplier->id }})" class="text-teal-600 dark:text-teal-400 hover:text-teal-900 dark:hover:text-teal-200 mr-3 transition-colors">Edit</button>
                                <button wire:click="confirmDelete({{ $supplier->id }})" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200 transition-colors">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    <span class="font-medium">Belum ada data supplier.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $suppliers->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    <x-modal wire:model="showModal" name="supplier-modal" focusable>
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ $supplierId ? 'Edit Supplier' : 'Tambah Supplier Baru' }}
                </h2>
                <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form wire:submit="store" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="kode_supplier" value="Kode Supplier" class="dark:text-gray-300" />
                        <x-text-input wire:model="kode_supplier" id="kode_supplier" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: SUP-001" />
                        <x-input-error :messages="$errors->get('kode_supplier')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="nama_supplier" value="Nama Supplier" class="dark:text-gray-300" />
                        <x-text-input wire:model="nama_supplier" id="nama_supplier" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: PT. Medika Jaya" required />
                        <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="kontak_person" value="Kontak Person (PIC)" class="dark:text-gray-300" />
                        <x-text-input wire:model="kontak_person" id="kontak_person" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Nama Sales" />
                        <x-input-error :messages="$errors->get('kontak_person')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="telepon" value="No. Telepon" class="dark:text-gray-300" />
                        <x-text-input wire:model="telepon" id="telepon" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="0812..." />
                        <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="email" value="Email" class="dark:text-gray-300" />
                    <x-text-input wire:model="email" id="email" type="email" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="sales@vendor.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="alamat" value="Alamat Lengkap" class="dark:text-gray-300" />
                    <textarea wire:model="alamat" id="alamat" class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm transition-shadow" rows="3"></textarea>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="keterangan" value="Keterangan" class="dark:text-gray-300" />
                    <textarea wire:model="keterangan" id="keterangan" class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm transition-shadow" rows="2"></textarea>
                    <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                </div>

                <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <x-secondary-button wire:click="$set('showModal', false)" class="dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Batal
                    </x-secondary-button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" name="delete-supplier-modal" focusable>
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <h2 class="text-xl font-bold text-center text-gray-900 dark:text-white mb-2">
                Konfirmasi Hapus
            </h2>
            <p class="text-center text-gray-500 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus data supplier ini? Data yang dihapus tidak dapat dikembalikan.
            </p>
            <div class="mt-6 flex justify-center gap-3">
                <x-secondary-button wire:click="$set('showDeleteModal', false)" class="dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    Batal
                </x-secondary-button>
                <x-danger-button wire:click="delete">
                    Hapus Data
                </x-danger-button>
            </div>
        </div>
    </x-modal>

</div>
