<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="w-full md:w-1/3">
            <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari Kamar / Bangsal..." class="w-full" />
        </div>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 w-full md:w-auto shadow-md">
            + Tambah Kamar
        </button>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kamar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bangsal</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Kapasitas (KRIS)</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">KRIS Compliant</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga/Malam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($kamars as $kamar)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $kamar->nomor_kamar }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $kamar->nama_bangsal }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $kamar->bed_terisi }} / {{ $kamar->kapasitas_bed }} Bed</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($kamar->is_kris_compliant)
                                    <span class="text-green-600 font-bold" title="Memenuhi 12 Kriteria KRIS">✓ Ya</span>
                                @else
                                    <span class="text-red-600 font-bold">✗ Tidak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900 font-mono">
                                Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 text-xs font-semibold rounded-full {{ $kamar->status == 'Tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $kamar->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $kamar->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-gray-500">Data kamar tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t">{{ $kamars->links() }}</div>
    </div>

    {{-- Modal --}}
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" wire:click="$set('isOpen', false)"></div>
                <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $kamarId ? 'Edit Kamar' : 'Tambah Kamar Baru' }}</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label value="Nomor Kamar" />
                                        <x-text-input wire:model="nomor_kamar" class="w-full mt-1" />
                                        @error('nomor_kamar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <x-input-label value="Nama Bangsal" />
                                        <x-text-input wire:model="nama_bangsal" placeholder="Mawar, Melati, dll" class="w-full mt-1" />
                                        @error('nama_bangsal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label value="Kapasitas Bed (Max 4)" />
                                        <x-text-input type="number" wire:model="kapasitas_bed" class="w-full mt-1" />
                                        @error('kapasitas_bed') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <x-input-label value="Harga/Malam (Rp)" />
                                        <x-text-input type="number" wire:model="harga_per_malam" class="w-full mt-1" />
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="is_kris_compliant" id="kris" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <label for="kris" class="ml-2 text-sm text-gray-600">Sesuai Standar KRIS (Kelas Rawat Inap Standar)</label>
                                </div>

                                <div>
                                    <x-input-label value="Status" />
                                    <select wire:model="status" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Penuh">Penuh</option>
                                        <option value="Renovasi">Renovasi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:w-auto sm:text-sm">
                                Simpan
                            </button>
                            <button type="button" wire:click="$set('isOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>