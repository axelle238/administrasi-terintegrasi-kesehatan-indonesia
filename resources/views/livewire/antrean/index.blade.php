<div class="space-y-6">
    <!-- Mini Dashboard: Realtime Queue Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-indigo-600 to-blue-700 p-5 rounded-2xl text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-20 h-20 bg-white/10 rounded-bl-full -mr-4 -mt-4"></div>
            <p class="text-xs font-bold text-indigo-100 uppercase tracking-widest mb-1">Total Antrean</p>
            <h3 class="text-3xl font-black">{{ $totalAntrean }}</h3>
            <p class="text-[10px] mt-2 opacity-80">Terdaftar hari ini</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border-l-4 border-yellow-400 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Menunggu</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $sisaAntrean }}</h3>
                </div>
                <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border-l-4 border-blue-500 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Sedang Diproses</p>
                    <h3 class="text-3xl font-black text-blue-600">{{ $sedangDiproses }}</h3>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600 animate-pulse">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border-l-4 border-green-500 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Selesai</p>
                    <h3 class="text-3xl font-black text-green-600">{{ $selesai }}</h3>
                </div>
                <div class="p-2 bg-green-50 rounded-lg text-green-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Create Queue -->
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <div class="w-1 h-6 bg-indigo-600 rounded-full"></div>
            Ambil Antrean Baru
        </h3>
        <form wire:submit="createAntrean" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/2">
                <x-input-label for="pasien_id" value="Cari & Pilih Pasien" />
                
                <div class="relative" x-data="{ open: false }">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="searchPasien" 
                        placeholder="Ketik Nama / NIK..." 
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm block mt-1 transition-shadow"
                        @focus="open = true"
                        @click.away="open = false"
                    >
                    
                    @if(!empty($searchPasien))
                        <div x-show="open" class="absolute z-10 w-full bg-white shadow-xl rounded-xl mt-1 max-h-60 overflow-y-auto border border-gray-100">
                            <ul>
                                @forelse($pasiens as $p)
                                    <li 
                                        wire:click="$set('pasien_id', {{ $p->id }}); $set('searchPasien', '{{ $p->nama_lengkap }}'); open = false;" 
                                        class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-gray-50 last:border-b-0"
                                    >
                                        <div class="font-bold text-gray-800 text-sm">{{ $p->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500 font-mono">NIK: {{ $p->nik }}</div>
                                    </li>
                                @empty
                                    <li class="px-4 py-3 text-gray-500 italic text-sm">Pasien tidak ditemukan.</li>
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
                <select wire:model="poli_id" id="poli_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm block mt-1 w-full" required>
                    <option value="">-- Pilih Poli --</option>
                    @foreach($polis as $poli)
                        <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('poli_id')" class="mt-2" />
            </div>

            <div class="w-full md:w-auto">
                <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-indigo-500/30" wire:loading.attr="disabled">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Ambil Nomor
                </button>
            </div>
        </form>
    </div>

    <!-- Queue List -->
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100" wire:poll.5s>
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                    Daftar Antrean (Realtime)
                </h3>
                <span class="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded-full animate-pulse flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Live Update
                </span>
            </div>
        </div>

        <!-- Desktop View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nomor</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Poli</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Waktu Masuk</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse ($antreans as $antrean)
                        <tr class="hover:bg-gray-50 transition-colors {{ $antrean->status == 'Diperiksa' ? 'bg-blue-50/50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-2xl font-black text-gray-800 tracking-tighter">{{ $antrean->nomor_antrean }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $antrean->pasien->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    @if($antrean->pasien->no_bpjs)
                                        <span class="text-green-600 font-medium">BPJS: {{ $antrean->pasien->no_bpjs }}</span>
                                    @else
                                        <span class="text-gray-400">UMUM</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                {{ $antrean->poli->nama_poli ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ \Carbon\Carbon::parse($antrean->created_at)->format('H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase tracking-wider
                                    @if($antrean->status == 'Menunggu') bg-yellow-100 text-yellow-800
                                    @elseif($antrean->status == 'Diperiksa') bg-blue-100 text-blue-800
                                    @elseif($antrean->status == 'Selesai') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $antrean->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                @if($antrean->status == 'Menunggu')
                                    <button wire:click="updateStatus({{ $antrean->id }}, 'Diperiksa')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all transform hover:-translate-y-0.5">
                                        Panggil
                                    </button>
                                    <button wire:click="updateStatus({{ $antrean->id }}, 'Batal')" class="text-red-500 hover:text-red-700 text-xs font-bold px-2">Batal</button>
                                @elseif($antrean->status == 'Diperiksa')
                                    <button wire:click="updateStatus({{ $antrean->id }}, 'Selesai')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all transform hover:-translate-y-0.5">
                                        Selesai
                                    </button>
                                @else
                                    <span class="text-gray-300 text-xs font-medium italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400 italic bg-gray-50/30">
                                Belum ada antrean hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4 p-4">
            @forelse ($antreans as $antrean)
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm {{ $antrean->status == 'Diperiksa' ? 'ring-2 ring-blue-500' : '' }}">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-3xl font-black text-gray-800 block tracking-tighter">{{ $antrean->nomor_antrean }}</span>
                            <span class="text-xs text-gray-500 font-bold uppercase">{{ $antrean->poli->nama_poli ?? '-' }}</span>
                        </div>
                        <span class="px-2 py-1 text-[10px] font-black uppercase rounded-lg 
                            @if($antrean->status == 'Menunggu') bg-yellow-100 text-yellow-800
                            @elseif($antrean->status == 'Diperiksa') bg-blue-100 text-blue-800
                            @elseif($antrean->status == 'Selesai') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $antrean->status }}
                        </span>
                    </div>
                    
                    <div class="mb-4 pt-3 border-t border-gray-100">
                        <div class="text-sm font-bold text-gray-900">{{ $antrean->pasien->nama_lengkap }}</div>
                        <div class="text-xs text-gray-500 mt-1 flex justify-between">
                            <span>Masuk: {{ \Carbon\Carbon::parse($antrean->created_at)->format('H:i') }}</span>
                            <span class="{{ $antrean->pasien->no_bpjs ? 'text-green-600 font-bold' : 'text-gray-400' }}">{{ $antrean->pasien->no_bpjs ? 'BPJS' : 'UMUM' }}</span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        @if($antrean->status == 'Menunggu')
                            <button wire:click="updateStatus({{ $antrean->id }}, 'Batal')" class="px-3 py-2 bg-white border border-red-200 text-red-600 text-xs font-bold rounded-lg">Batal</button>
                            <button wire:click="updateStatus({{ $antrean->id }}, 'Diperiksa')" class="px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg shadow-sm">Panggil</button>
                        @elseif($antrean->status == 'Diperiksa')
                            <button wire:click="updateStatus({{ $antrean->id }}, 'Selesai')" class="px-4 py-2 bg-green-600 text-white text-xs font-bold rounded-lg shadow-sm">Selesai</button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-8 text-sm italic">Belum ada antrean.</div>
            @endforelse
        </div>
    </div>
</div>