<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header & Action -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Supplier / Vendor</h2>
            <button wire:click="create" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg font-medium flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Supplier
            </button>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <div class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Cari supplier, kode, atau kontak...">
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Supplier</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak Person</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon / Email</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($suppliers as $supplier)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $supplier->kode_supplier ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $supplier->nama_supplier }}
                                    <div class="text-xs text-gray-500">{{ Str::limit($supplier->alamat, 30) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $supplier->kontak_person ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex flex-col">
                                        <span>{{ $supplier->telepon ?? '-' }}</span>
                                        <span class="text-xs text-blue-600">{{ $supplier->email ?? '' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit({{ $supplier->id }})" class="text-teal-600 hover:text-teal-900 mr-3">Edit</button>
                                    <button wire:click="confirmDelete({{ $supplier->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada data supplier.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <x-modal name="supplier-modal" :show="$showModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                {{ $supplierId ? 'Edit Supplier' : 'Tambah Supplier Baru' }}
            </h2>

            <form wire:submit="store" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="kode_supplier" value="Kode Supplier" />
                        <x-text-input wire:model="kode_supplier" id="kode_supplier" class="block mt-1 w-full" placeholder="Contoh: SUP-001" />
                        <x-input-error :messages="$errors->get('kode_supplier')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="nama_supplier" value="Nama Supplier" />
                        <x-text-input wire:model="nama_supplier" id="nama_supplier" class="block mt-1 w-full" placeholder="Contoh: PT. Medika Jaya" required />
                        <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="kontak_person" value="Kontak Person (PIC)" />
                        <x-text-input wire:model="kontak_person" id="kontak_person" class="block mt-1 w-full" placeholder="Nama Sales" />
                        <x-input-error :messages="$errors->get('kontak_person')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="telepon" value="No. Telepon" />
                        <x-text-input wire:model="telepon" id="telepon" class="block mt-1 w-full" placeholder="0812..." />
                        <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" type="email" class="block mt-1 w-full" placeholder="sales@vendor.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="alamat" value="Alamat Lengkap" />
                    <textarea wire:model="alamat" id="alamat" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" rows="3"></textarea>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="keterangan" value="Keterangan" />
                    <textarea wire:model="keterangan" id="keterangan" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" rows="2"></textarea>
                    <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button wire:click="$set('showModal', false)">
                        Batal
                    </x-secondary-button>
                    <x-primary-button>
                        Simpan
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="delete-supplier-modal" :show="$showDeleteModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Konfirmasi Hapus
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Apakah Anda yakin ingin menghapus data supplier ini? Data yang dihapus tidak dapat dikembalikan.
            </p>
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="$set('showDeleteModal', false)">
                    Batal
                </x-secondary-button>
                <x-danger-button wire:click="delete">
                    Hapus
                </x-danger-button>
            </div>
        </div>
    </x-modal>

</div>
