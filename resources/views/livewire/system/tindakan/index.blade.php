<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    {{-- Header & Search --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="w-full md:w-1/3">
            <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari Tindakan / Poli..." class="w-full" />
        </div>
        @if(!$isOpen)
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
            Tambah Tindakan Medis
        </button>
        @endif
    </div>

    {{-- Form Section (Inline - No Modal) --}}
    @if($isOpen)
    <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-indigo-100 transition-all duration-300 ease-in-out">
        <div class="px-6 py-4 border-b border-gray-100 bg-indigo-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-indigo-900">
                {{ $tindakanId ? 'Edit Data Tindakan' : 'Tambah Tindakan Baru' }}
            </h3>
            <button wire:click="$set('isOpen', false)" class="text-gray-400 hover:text-gray-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form wire:submit.prevent="save">
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <x-input-label value="Nama Tindakan Medis" />
                        <x-text-input wire:model="nama_tindakan" class="w-full mt-1" placeholder="Contoh: Pemeriksaan Umum" />
                        @error('nama_tindakan') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label value="Poli / Unit Terkait" />
                        <select wire:model="poli_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Pilih Poli --</option>
                            @foreach($polis as $poli)
                                <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                            @endforeach
                        </select>
                        @error('poli_id') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <x-input-label value="Tarif Layanan (Rp)" />
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                            <x-text-input wire:model="harga" type="number" class="w-full pl-10" placeholder="0" />
                        </div>
                        @error('harga') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition">
                    Simpan Data
                </button>
                <button type="button" wire:click="$set('isOpen', false)" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Poli Terkait</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Tindakan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tarif (Rp)</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($tindakans as $tindakan)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">
                                <span class="bg-indigo-50 px-2 py-1 rounded-md">{{ $tindakan->poli->nama_poli ?? 'Umum' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $tindakan->nama_tindakan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">Rp {{ number_format($tindakan->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $tindakan->id }})" class="text-indigo-600 hover:text-indigo-900 mr-4 font-semibold hover:underline">Edit</button>
                                <button wire:click="delete({{ $tindakan->id }})" wire:confirm="Apakah Anda yakin ingin menghapus tindakan medis ini?" class="text-red-600 hover:text-red-900 font-semibold hover:underline">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">Belum ada data tindakan medis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">{{ $tindakans->links() }}</div>
    </div>
</div>