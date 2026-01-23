<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Kegiatan Luar Gedung</h2>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            + Catat Kegiatan
        </button>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kegiatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">PJ</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Peserta</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($kegiatans as $k)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $k->tanggal_kegiatan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $k->nama_kegiatan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $k->lokasi }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $k->penanggung_jawab }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold">{{ $k->jumlah_peserta }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $kegiatans->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('isOpen', false)"></div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Input Kegiatan UKM</h3>
                    <div class="space-y-4">
                        <div>
                            <x-input-label value="Nama Kegiatan" />
                            <x-text-input wire:model="nama_kegiatan" class="block mt-1 w-full" type="text" />
                            @error('nama_kegiatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label value="Tanggal" />
                                <x-text-input wire:model="tanggal_kegiatan" class="block mt-1 w-full" type="date" />
                                @error('tanggal_kegiatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-input-label value="Jumlah Peserta" />
                                <x-text-input wire:model="jumlah_peserta" class="block mt-1 w-full" type="number" />
                                @error('jumlah_peserta') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <x-input-label value="Lokasi" />
                            <x-text-input wire:model="lokasi" class="block mt-1 w-full" type="text" />
                            @error('lokasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-input-label value="Penanggung Jawab" />
                            <x-text-input wire:model="penanggung_jawab" class="block mt-1 w-full" type="text" />
                            @error('penanggung_jawab') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-input-label value="Hasil Kegiatan / Catatan" />
                            <textarea wire:model="hasil_kegiatan" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="save" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                    <button wire:click="$set('isOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
