<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="w-full md:w-1/3">
            <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari Kamar / Bangsal..." class="w-full" />
        </div>
        @if(!$isOpen)
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 w-full md:w-auto shadow-md transition duration-150 ease-in-out uppercase text-xs tracking-widest">
            Tambah Kamar Baru
        </button>
        @endif
    </div>

    {{-- Form Section (Inline - No Modal) --}}
    @if($isOpen)
    <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-indigo-100 transition-all duration-300 ease-in-out mb-6">
        <div class="px-6 py-4 border-b border-gray-100 bg-indigo-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-indigo-900">
                {{ $kamarId ? 'Edit Data Kamar' : 'Tambah Kamar Baru' }}
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
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Nomor Kamar" />
                            <x-text-input wire:model="nomor_kamar" class="w-full mt-1" placeholder="Cth: 101" />
                            @error('nomor_kamar') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-input-label value="Nama Bangsal" />
                            <x-text-input wire:model="nama_bangsal" placeholder="Mawar, Melati" class="w-full mt-1" />
                            @error('nama_bangsal') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <x-input-label value="Status Kamar" />
                        <select wire:model="status" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Penuh">Penuh</option>
                            <option value="Renovasi">Renovasi</option>
                            <option value="Dibersihkan">Dibersihkan</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Kapasitas Bed (Max 4)" />
                            <x-text-input type="number" wire:model="kapasitas_bed" class="w-full mt-1" min="1" max="6" />
                            @error('kapasitas_bed') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-input-label value="Harga/Malam (Rp)" />
                            <x-text-input type="number" wire:model="harga_per_malam" class="w-full mt-1" />
                        </div>
                    </div>

                    <div class="flex items-center pt-6">
                        <input type="checkbox" wire:model="is_kris_compliant" id="kris" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-5 w-5">
                        <label for="kris" class="ml-2 text-sm text-gray-700 font-medium">Sesuai Standar KRIS (Kelas Rawat Inap Standar)</label>
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
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kamar</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Bangsal</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Okupansi (KRIS)</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">KRIS Compliant</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Harga/Malam</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($kamars as $kamar)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                <span class="bg-gray-100 px-2 py-1 rounded border border-gray-300">{{ $kamar->nomor_kamar }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $kamar->nama_bangsal }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                <span class="{{ $kamar->bed_terisi >= $kamar->kapasitas_bed ? 'text-red-600 font-bold' : 'text-green-600 font-bold' }}">
                                    {{ $kamar->bed_terisi }} / {{ $kamar->kapasitas_bed }}
                                </span> Bed
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($kamar->is_kris_compliant)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        Ya
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Tidak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900 font-mono font-bold">
                                Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $kamar->status == 'Tersedia' ? 'bg-green-100 text-green-800 border border-green-200' : 
                                      ($kamar->status == 'Penuh' ? 'bg-red-100 text-red-800 border border-red-200' : 
                                      'bg-yellow-100 text-yellow-800 border border-yellow-200') }}">
                                    {{ $kamar->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $kamar->id }})" class="text-indigo-600 hover:text-indigo-900 font-semibold hover:underline">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-10 text-center text-gray-500 italic">Data kamar tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">{{ $kamars->links() }}</div>
    </div>
</div>