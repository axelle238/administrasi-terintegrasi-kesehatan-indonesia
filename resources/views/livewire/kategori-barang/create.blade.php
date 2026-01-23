<div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tambah Kategori
            </h2>
            <p class="text-sm text-gray-500 mt-1 ml-10">
                Buat kategori baru untuk pengelompokan aset.
            </p>
        </div>
        <a href="{{ route('kategori-barang.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-900">Formulir Kategori</h3>
        </div>
        
        <div class="p-6">
            <form wire:submit="save">
                <div class="space-y-6">
                    <div>
                        <x-input-label for="nama_kategori" value="Nama Kategori" class="mb-2" />
                        <x-text-input wire:model="nama_kategori" id="nama_kategori" class="block w-full rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="text" placeholder="Contoh: Alat Medis, Furniture..." required autofocus />
                        <x-input-error :messages="$errors->get('nama_kategori')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="deskripsi" value="Deskripsi (Opsional)" class="mb-2" />
                        <textarea wire:model="deskripsi" id="deskripsi" rows="4" class="block w-full rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm" placeholder="Keterangan tambahan..."></textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end pt-4">
                        <button type="submit" class="px-6 py-3 bg-teal-600 text-white rounded-xl font-bold shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5" wire:loading.attr="disabled">
                            Simpan Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
