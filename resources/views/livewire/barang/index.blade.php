<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Data Aset & Inventaris
            </h2>
            <p class="text-sm text-gray-500 mt-1 ml-10">
                Kelola seluruh aset, barang inventaris, dan stok logistik sistem SATRIA.
            </p>
        </div>
        <a href="{{ route('barang.create') }}" wire:navigate class="inline-flex items-center px-5 py-2.5 bg-teal-600 text-white rounded-xl font-semibold text-sm shadow-lg hover:bg-teal-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Aset
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500 transition-shadow" placeholder="Cari nama barang, kode, atau merk..." />
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <select wire:model.live="filterKategori" class="rounded-xl border-gray-200 text-sm focus:border-teal-500 focus:ring-teal-500 cursor-pointer hover:bg-gray-50">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterKondisi" class="rounded-xl border-gray-200 text-sm focus:border-teal-500 focus:ring-teal-500 cursor-pointer hover:bg-gray-50">
                <option value="">Semua Kondisi</option>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Informasi Barang</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">Kategori & Lokasi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Kondisi</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($barangs as $barang)
                        <tr class="hover:bg-gray-50/80 transition duration-150 ease-in-out group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-xl bg-teal-50 text-teal-600 font-bold text-lg border border-teal-100 group-hover:scale-105 transition-transform duration-200">
                                        {{ substr($barang->nama_barang, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $barang->nama_barang }}</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-gray-500 font-mono bg-gray-100 px-2 py-0.5 rounded">{{ $barang->kode_barang }}</span>
                                            @if($barang->is_asset)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                    ASET TETAP
                                                </span>
                                            @endif
                                        </div>
                                        @if($barang->merk)
                                            <div class="text-xs text-gray-400 mt-0.5">{{ $barang->merk }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-sm text-gray-900 font-medium">{{ $barang->kategori->nama_kategori ?? '-' }}</div>
                                <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ $barang->lokasi_penyimpanan ?: 'Belum diset' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-lg font-bold {{ $barang->stok <= 5 ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $barang->stok }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $barang->satuan }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $statusClasses = match($barang->kondisi) {
                                        'Baik' => 'bg-green-50 text-green-700 border-green-200',
                                        'Rusak Ringan' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'Rusak Berat' => 'bg-red-50 text-red-700 border-red-200',
                                        default => 'bg-gray-50 text-gray-600 border-gray-200'
                                    };
                                    $dotColor = match($barang->kondisi) {
                                        'Baik' => 'bg-green-500',
                                        'Rusak Ringan' => 'bg-yellow-500',
                                        'Rusak Berat' => 'bg-red-500',
                                        default => 'bg-gray-500'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $statusClasses }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }} mr-2"></span>
                                    {{ $barang->kondisi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('barang.print-label', $barang->id) }}" target="_blank" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors" title="Cetak Label">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h-4v-4H8m13-4V4a1 1 0 00-1-1H4a1 1 0 00-1 1v12a1 1 0 001 1h3m10-3a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2a1 1 0 01-1-1v-4z"></path></svg>
                                    </a>
                                    <a href="{{ route('barang.edit', $barang->id) }}" wire:navigate class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="p-4 bg-gray-50 rounded-full mb-4">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada data aset</h3>
                                    <p class="text-sm text-gray-500 text-center mb-6">Data aset atau barang inventaris belum ditambahkan ke dalam sistem.</p>
                                    <a href="{{ route('barang.create') }}" wire:navigate class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 transition">
                                        Tambah Data Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $barangs->links() }}
        </div>
    </div>
</div>
