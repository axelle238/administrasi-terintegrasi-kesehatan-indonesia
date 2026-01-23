<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Kategori Barang
            </h2>
            <p class="text-sm text-gray-500 mt-1 ml-10">
                Master data kategori untuk pengelompokan aset dan inventaris.
            </p>
        </div>
        <a href="{{ route('kategori-barang.create') }}" wire:navigate class="inline-flex items-center px-5 py-2.5 bg-teal-600 text-white rounded-xl font-semibold text-sm shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kategori
        </a>
    </div>

    <!-- Search -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <div class="relative w-full md:w-1/2 lg:w-1/3">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500 transition-shadow" placeholder="Cari kategori..." />
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Item</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($kategoris as $kategori)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-teal-50 flex items-center justify-center text-teal-600 font-bold border border-teal-100">
                                        {{ substr($kategori->nama_kategori, 0, 1) }}
                                    </div>
                                    <div class="text-sm font-bold text-gray-900">{{ $kategori->nama_kategori }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 max-w-xs truncate">
                                {{ $kategori->deskripsi ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg border border-blue-100">
                                    {{ $kategori->barangs_count }} Item
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('kategori-barang.edit', $kategori->id) }}" wire:navigate class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <button wire:click="delete({{ $kategori->id }})" wire:confirm="Hapus kategori ini? Data barang tidak akan ikut terhapus namun kategori akan kosong." class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                Belum ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden p-4 space-y-4 bg-gray-50">
            @forelse ($kategoris as $kategori)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-teal-50 flex items-center justify-center text-teal-600 font-bold border border-teal-100">
                                {{ substr($kategori->nama_kategori, 0, 1) }}
                            </div>
                            <h3 class="font-bold text-gray-900">{{ $kategori->nama_kategori }}</h3>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded-lg">
                            {{ $kategori->barangs_count }}
                        </span>
                    </div>
                    
                    <p class="text-xs text-gray-500 mb-4 line-clamp-2">
                        {{ $kategori->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </p>

                    <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                        <a href="{{ route('kategori-barang.edit', $kategori->id) }}" wire:navigate class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold">Edit</a>
                        <button wire:click="delete({{ $kategori->id }})" wire:confirm="Hapus kategori?" class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold">Hapus</button>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-4">Belum ada data.</div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $kategoris->links() }}
        </div>
    </div>
</div>
