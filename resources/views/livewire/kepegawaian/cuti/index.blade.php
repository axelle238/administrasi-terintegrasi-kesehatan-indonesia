<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="text-gray-600">
            @if($isAdmin)
                <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full font-bold">Mode Admin</span>
            @endif
        </div>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 w-full md:w-auto shadow-md transition duration-150 ease-in-out">
            + Ajukan Cuti Baru
        </button>
    </div>

    {{-- Inline Form Section --}}
    @if($isOpen)
        <div class="mb-6 bg-white overflow-hidden shadow-xl sm:rounded-lg border border-indigo-100 p-6 animate-fade-in-down">
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Form Pengajuan Cuti</h3>
                <p class="mt-1 text-sm text-gray-500">Silakan lengkapi formulir di bawah ini untuk mengajukan cuti baru.</p>
            </div>
            
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="jenis_cuti" value="Jenis Cuti" />
                        <select wire:model="jenis_cuti" id="jenis_cuti" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="Cuti Tahunan">Cuti Tahunan</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin (Potong Gaji)</option>
                            <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                        </select>
                        @error('jenis_cuti') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <x-input-label for="tanggal_mulai" value="Tanggal Mulai" />
                        <x-text-input type="date" wire:model="tanggal_mulai" id="tanggal_mulai" class="w-full mt-1" />
                        @error('tanggal_mulai') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <x-input-label for="tanggal_selesai" value="Tanggal Selesai" />
                        <x-text-input type="date" wire:model="tanggal_selesai" id="tanggal_selesai" class="w-full mt-1" />
                        @error('tanggal_selesai') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="keterangan" value="Keterangan / Alasan" />
                        <textarea wire:model="keterangan" id="keterangan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Jelaskan alasan pengajuan cuti..."></textarea>
                        @error('keterangan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6 gap-3">
                    <button type="button" wire:click="$set('isOpen', false)" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">

