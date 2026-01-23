<div class="max-w-2xl mx-auto">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form wire:submit="update">
                <div class="space-y-6">
                    <div>
                        <x-input-label for="nama_shift" value="Nama Shift" />
                        <x-text-input wire:model="nama_shift" id="nama_shift" class="block mt-1 w-full" type="text" required autofocus />
                        <x-input-error :messages="$errors->get('nama_shift')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="jam_mulai" value="Jam Mulai" />
                            <x-text-input wire:model="jam_mulai" id="jam_mulai" class="block mt-1 w-full" type="time" required />
                            <x-input-error :messages="$errors->get('jam_mulai')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="jam_selesai" value="Jam Selesai" />
                            <x-text-input wire:model="jam_selesai" id="jam_selesai" class="block mt-1 w-full" type="time" required />
                            <x-input-error :messages="$errors->get('jam_selesai')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('shift.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 underline text-sm mr-4">Batal</a>
                        <x-primary-button wire:loading.attr="disabled">
                            {{ __('Perbarui Shift') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>