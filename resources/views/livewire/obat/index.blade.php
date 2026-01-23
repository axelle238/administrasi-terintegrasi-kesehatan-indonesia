<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="w-full md:w-1/3 relative">
            <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari Nama, Kode, Jenis Obat..." class="w-full pl-10" />
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        
        <a href="{{ route('obat.create') }}" wire:navigate class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Obat
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Info Obat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Farmasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($obats as $obat)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 group-hover:text-indigo-600">{{ $obat->nama_obat }}</div>
                                <div class="text-xs text-gray-500 font-mono">Kode: {{ $obat->kode_obat }}</div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 mt-1">
                                    {{ $obat->jenis_obat }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold {{ $obat->stok <= $obat->min_stok ? 'text-red-600 animate-pulse' : 'text-gray-900' }}">
                                    {{ $obat->stok }} {{ $obat->satuan }}
                                </div>
                                <div class="text-xs text-gray-500">Min: {{ $obat->min_stok }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>Exp: <span class="{{ $obat->tanggal_kedaluwarsa < now() ? 'text-red-600 font-bold' : '' }}">{{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->format('d/m/Y') }}</span></div>
                                <div class="text-xs text-gray-400">Batch: {{ $obat->batch_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">
                                Rp {{ number_format($obat->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('obat.kartu-stok', $obat->id) }}" wire:navigate class="text-teal-600 hover:text-teal-900 flex items-center gap-1" title="Kartu Stok">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        <span class="text-xs">Kartu</span>
                                    </a>
                                    <a href="{{ route('obat.edit', $obat->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <button wire:click="delete({{ $obat->id }})" wire:confirm="Hapus data obat ini?" class="text-red-500 hover:text-red-700">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 italic">
                                Tidak ada data obat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden">
            @forelse ($obats as $obat)
                <div class="p-4 border-b border-gray-200 last:border-b-0">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">{{ $obat->nama_obat }}</h4>
                            <div class="text-xs text-gray-500 font-mono">{{ $obat->kode_obat }}</div>
                        </div>
                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded">
                            {{ $obat->jenis_obat }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 my-3 text-sm">
                        <div>
                            <span class="text-xs text-gray-400 block">Stok</span>
                            <span class="font-bold {{ $obat->stok <= $obat->min_stok ? 'text-red-600' : 'text-gray-800' }}">
                                {{ $obat->stok }} {{ $obat->satuan }}
                            </span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block">Harga</span>
                            <span class="font-mono text-gray-800">Rp {{ number_format($obat->harga_satuan, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block">Kadaluarsa</span>
                            <span class="{{ $obat->tanggal_kedaluwarsa < now() ? 'text-red-600 font-bold' : 'text-gray-800' }}">
                                {{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('obat.kartu-stok', $obat->id) }}" wire:navigate class="px-3 py-1.5 bg-teal-50 text-teal-700 rounded-lg text-xs font-bold flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Kartu
                        </a>
                        <a href="{{ route('obat.edit', $obat->id) }}" wire:navigate class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-bold">Edit</a>
                        <button wire:click="delete({{ $obat->id }})" wire:confirm="Hapus?" class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold">Hapus</button>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500 text-sm">Tidak ada data obat.</div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            {{ $obats->links() }}
        </div>
    </div>
</div>
