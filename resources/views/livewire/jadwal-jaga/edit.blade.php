<div class="max-w-2xl mx-auto">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form wire:submit="update">
                <div class="space-y-6">
                    
                    <div>
                        <x-input-label for="tanggal" value="Tanggal Jaga" />
                        <x-text-input wire:model="tanggal" id="tanggal" class="block mt-1 w-full" type="date" required />
                        <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="pegawai_id" value="Pilih Pegawai" />
                        <select wire:model="pegawai_id" id="pegawai_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">
                                    {{ $pegawai->user->name }} - {{ ucfirst($pegawai->user->role) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('pegawai_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="shift_id" value="Pilih Shift" />
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                            @foreach($shifts as $shift)
                                <label class="relative flex flex-col bg-white p-4 rounded-lg border cursor-pointer hover:bg-gray-50 focus-within:ring-2 focus-within:ring-indigo-500">
                                    <input type="radio" wire:model="shift_id" value="{{ $shift->id }}" class="sr-only" name="shift_id">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-900">{{ $shift->nama_shift }}</span>
                                        <div x-show="$wire.shift_id == {{ $shift->id }}" class="text-indigo-600">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $shift->jam_mulai }} - {{ $shift->jam_selesai }}
                                    </div>
                                    <!-- Highlight Border Logic -->
                                    <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" :class="$wire.shift_id == {{ $shift->id }} ? 'border-indigo-500' : 'border-transparent'" aria-hidden="true"></div>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('shift_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="status_kehadiran" value="Status Kehadiran" />
                        <select wire:model="status_kehadiran" id="status_kehadiran" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value="Belum Hadir">Belum Hadir</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Alpha">Alpha</option>
                        </select>
                        <x-input-error :messages="$errors->get('status_kehadiran')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('jadwal-jaga.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 underline text-sm mr-4">Batal</a>
                        <x-primary-button wire:loading.attr="disabled">
                            {{ __('Perbarui Jadwal') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>