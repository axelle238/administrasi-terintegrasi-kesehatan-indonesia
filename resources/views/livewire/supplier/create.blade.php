<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
        <form wire:submit.prevent="save">
            <div class="space-y-4">
                <div>
                    <x-input-label value="Nama Supplier" />
                    <x-text-input wire:model="nama_supplier" class="w-full mt-1" />
                    @error('nama_supplier') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-input-label value="Kontak (HP/Telp)" />
                    <x-text-input wire:model="kontak" class="w-full mt-1" />
                    @error('kontak') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-input-label value="Email" />
                    <x-text-input type="email" wire:model="email" class="w-full mt-1" />
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-input-label value="Alamat" />
                    <textarea wire:model="alamat" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('supplier.index') }}" wire:navigate class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
