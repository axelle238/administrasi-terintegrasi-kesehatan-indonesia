<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header & Action -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Ruangan</h2>
            <button wire:click="create" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg font-medium flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Ruangan
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
                <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Cari nama, kode, atau PIC...">
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Ruangan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi / Gedung</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PIC</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($ruangans as $ruangan)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $ruangan->kode_ruangan ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $ruangan->nama_ruangan }}
                                    <div class="text-xs text-gray-500">{{ Str::limit($ruangan->keterangan, 30) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $ruangan->lokasi_gedung ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $ruangan->penanggung_jawab ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit({{ $ruangan->id }})" class="text-teal-600 hover:text-teal-900 mr-3">Edit</button>
                                    <button wire:click="confirmDelete({{ $ruangan->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada data ruangan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $ruangans->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <x-modal name="ruangan-modal" :show="$showModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                {{ $ruanganId ? 'Edit Ruangan' : 'Tambah Ruangan Baru' }}
            </h2>

            <form wire:submit="store" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="kode_ruangan" value="Kode Ruangan" />
                        <x-text-input wire:model="kode_ruangan" id="kode_ruangan" class="block mt-1 w-full" placeholder="Contoh: R-001" />
                        <x-input-error :messages="$errors->get('kode_ruangan')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="nama_ruangan" value="Nama Ruangan" />
                        <x-text-input wire:model="nama_ruangan" id="nama_ruangan" class="block mt-1 w-full" placeholder="Contoh: Gudang Farmasi" required />
                        <x-input-error :messages="$errors->get('nama_ruangan')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="lokasi_gedung" value="Lokasi / Gedung" />
                    <x-text-input wire:model="lokasi_gedung" id="lokasi_gedung" class="block mt-1 w-full" placeholder="Contoh: Lantai 1, Gedung A" />
                    <x-input-error :messages="$errors->get('lokasi_gedung')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="penanggung_jawab" value="Penanggung Jawab (PIC)" />
                    <x-text-input wire:model="penanggung_jawab" id="penanggung_jawab" class="block mt-1 w-full" placeholder="Nama Personil" />
                    <x-input-error :messages="$errors->get('penanggung_jawab')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="keterangan" value="Keterangan" />
                    <textarea wire:model="keterangan" id="keterangan" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" rows="3"></textarea>
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
    <x-modal name="delete-ruangan-modal" :show="$showDeleteModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Konfirmasi Hapus
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Apakah Anda yakin ingin menghapus data ruangan ini? Data yang dihapus tidak dapat dikembalikan.
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
