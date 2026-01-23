<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Form Stock Opname</h3>
            <div class="w-1/3">
                <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari Obat..." class="w-full" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Obat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok Sistem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok Fisik (Riil)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Selisih</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($obats as $obat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $obat->nama_obat }}</div>
                                <div class="text-xs text-gray-500">{{ $obat->kode_obat }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $obat->stok }} {{ $obat->satuan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap w-32">
                                <x-text-input type="number" wire:model.live="adjustmentValues.{{ $obat->id }}" class="w-full text-sm" placeholder="{{ $obat->stok }}" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                                @if(isset($adjustmentValues[$obat->id]))
                                    @php $diff = $adjustmentValues[$obat->id] - $obat->stok; @endphp
                                    @if($diff == 0)
                                        <span class="text-green-600">Sesuai</span>
                                    @elseif($diff > 0)
                                        <span class="text-blue-600">+{{ $diff }}</span>
                                    @else
                                        <span class="text-red-600">{{ $diff }}</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-text-input type="text" wire:model="notes.{{ $obat->id }}" class="w-full text-sm" placeholder="Alasan..." />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="adjust({{ $obat->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold disabled:opacity-50" 
                                    @if(!isset($adjustmentValues[$obat->id])) disabled @endif>
                                    Simpan
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-gray-500">Data obat kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50">
            {{ $obats->links() }}
        </div>
    </div>
</div>
