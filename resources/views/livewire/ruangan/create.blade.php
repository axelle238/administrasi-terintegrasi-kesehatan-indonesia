<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
        <form wire:submit.prevent="save">
            <div class="space-y-4">
                <div>
                    <x-input-label value="Nama Ruangan" />
                    <x-text-input wire:model="nama_ruangan" class="w-full mt-1" />
                    @error('nama_ruangan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-input-label value="Lokasi / Gedung" />
                    <x-text-input wire:model="lokasi" class="w-full mt-1" />
                    @error('lokasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-input-label value="Kapasitas (Orang/Barang)" />
                    <x-text-input type="number" wire:model="kapasitas" class="w-full mt-1" />
                    @error('kapasitas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('ruangan.index') }}" wire:navigate class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
