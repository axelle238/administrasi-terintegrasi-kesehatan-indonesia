<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <div class="w-1/3">
            <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari Poli..." class="w-full" />
        </div>
        <a href="{{ route('system.poli.create') }}" wire:navigate class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Tambah Poli
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Poli</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($polis as $poli)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $poli->kode_poli }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $poli->nama_poli }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $poli->keterangan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('system.poli.edit', $poli->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <button wire:click="delete({{ $poli->id }})" wire:confirm="Hapus Poli?" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4 text-gray-500">Data kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50">{{ $polis->links() }}</div>
    </div>
</div>