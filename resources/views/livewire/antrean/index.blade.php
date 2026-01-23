<div class="space-y-6">
    <!-- Form Create Queue -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Ambil Antrean Baru</h3>
        <form wire:submit="createAntrean" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/2">
                <x-input-label for="pasien_id" value="Cari & Pilih Pasien" />
                
                <div class="relative" x-data="{ open: false }">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="searchPasien" 
                        placeholder="Ketik Nama / NIK..." 
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1"
                        @focus="open = true"
                        @click.away="open = false"
                    >
                    
                    @if(!empty($searchPasien))
                        <div x-show="open" class="absolute z-10 w-full bg-white shadow-lg rounded-md mt-1 max-h-60 overflow-y-auto border border-gray-200">
                            <ul>
                                @forelse($pasiens as $p)
                                    <li 
                                        wire:click="$set('pasien_id', {{ $p->id }}); $set('searchPasien', '{{ $p->nama_lengkap }}'); open = false;" 
                                        class="px-4 py-2 hover:bg-indigo-50 cursor-pointer border-b last:border-b-0"
                                    >
                                        <div class="font-bold text-gray-800">{{ $p->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500">NIK: {{ $p->nik }}</div>
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-500 italic">Pasien tidak ditemukan.</li>
                                @endforelse
                            </ul>
                        </div>
                    @endif
                </div>
                <input type="hidden" wire:model="pasien_id">
                <x-input-error :messages="$errors->get('pasien_id')" class="mt-2" />
            </div>

            <div class="w-full md:w-1/3">
                <x-input-label for="poli_id" value="Poli Tujuan" />
                <select wire:model="poli_id" id="poli_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                    <option value="">-- Pilih Poli --</option>
                    @foreach($polis as $poli)
                        <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('poli_id')" class="mt-2" />
            </div>

            <div class="w-full md:w-auto">
                <x-primary-button class="w-full justify-center h-10" wire:loading.attr="disabled">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Ambil Nomor
                </x-primary-button>
            </div>
        </form>
        <div class="mt-2 text-xs text-gray-500">
            *Pastikan pasien sudah terdaftar di sistem Data Pasien.
        </div>
    </div>

    <!-- Queue List -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200" wire:poll.5s>
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Daftar Antrean (Realtime)</h3>
                <span class="text-xs font-semibold bg-green-100 text-green-800 px-2 py-1 rounded-full animate-pulse">● Live Updating</span>
            </div>

            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($antreans as $antrean)
                            <tr class="hover:bg-gray-50 {{ $antrean->status == 'Diperiksa' ? 'bg-blue-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-2xl font-bold text-gray-800">{{ $antrean->nomor_antrean }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $antrean->pasien->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500">BPJS: {{ $antrean->pasien->no_bpjs ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $antrean->poli->nama_poli ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($antrean->created_at)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($antrean->status == 'Menunggu') bg-yellow-100 text-yellow-800
                                        @elseif($antrean->status == 'Diperiksa') bg-blue-100 text-blue-800
                                        @elseif($antrean->status == 'Selesai') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $antrean->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    @if($antrean->status == 'Menunggu')
                                        <button wire:click="updateStatus({{ $antrean->id }}, 'Diperiksa')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                            Panggil
                                        </button>
                                        <button wire:click="updateStatus({{ $antrean->id }}, 'Batal')" class="text-red-600 hover:text-red-900 text-xs">Batal</button>
                                    @elseif($antrean->status == 'Diperiksa')
                                        <button wire:click="updateStatus({{ $antrean->id }}, 'Selesai')" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                                            Selesai
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-xs">History</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada antrean hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View (Cards) -->
            <div class="md:hidden space-y-4">
                @forelse ($antreans as $antrean)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 {{ $antrean->status == 'Diperiksa' ? 'border-l-4 border-l-blue-500' : '' }}">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="text-3xl font-black text-gray-800 block">{{ $antrean->nomor_antrean }}</span>
                                <span class="text-xs text-gray-500 font-medium">{{ $antrean->poli->nama_poli ?? '-' }}</span>
                            </div>
                            <span class="px-2 py-1 text-xs font-bold rounded-full 
                                @if($antrean->status == 'Menunggu') bg-yellow-100 text-yellow-800
                                @elseif($antrean->status == 'Diperiksa') bg-blue-100 text-blue-800
                                @elseif($antrean->status == 'Selesai') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $antrean->status }}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="text-sm font-bold text-gray-900">{{ $antrean->pasien->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">Masuk: {{ \Carbon\Carbon::parse($antrean->created_at)->format('H:i') }}</div>
                        </div>

                        <div class="flex justify-end gap-2 pt-2 border-t border-gray-200">
                            @if($antrean->status == 'Menunggu')
                                <button wire:click="updateStatus({{ $antrean->id }}, 'Batal')" class="px-3 py-1 bg-red-50 text-red-700 text-xs rounded border border-red-200">Batal</button>
                                <button wire:click="updateStatus({{ $antrean->id }}, 'Diperiksa')" class="px-3 py-1 bg-blue-600 text-white text-xs rounded shadow">Panggil</button>
                            @elseif($antrean->status == 'Diperiksa')
                                <button wire:click="updateStatus({{ $antrean->id }}, 'Selesai')" class="px-3 py-1 bg-green-600 text-white text-xs rounded shadow">Selesai</button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-4 text-sm">Belum ada antrean.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
