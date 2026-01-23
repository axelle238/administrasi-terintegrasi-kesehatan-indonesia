<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" x-data="{ showLocations: false }">
    
    <!-- Mobile Location Toggle -->
    <div class="md:hidden">
        <button @click="showLocations = !showLocations" class="w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-700 font-medium">
            <span>
                <span class="text-xs text-gray-500 uppercase mr-2">Lokasi:</span>
                {{ $selectedLocation ?: 'Pilih Ruangan' }}
            </span>
            <svg class="w-5 h-5 text-gray-400" :class="showLocations ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
        </button>
    </div>

    <div class="flex flex-col md:flex-row gap-6">
        
        <!-- Sidebar Locations -->
        <div class="md:w-64 flex-shrink-0 md:block" :class="showLocations ? 'block' : 'hidden'">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="p-4 bg-teal-50 border-b border-teal-100">
                    <h3 class="font-bold text-teal-800 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        Daftar Ruangan
                    </h3>
                </div>
                <nav class="max-h-[calc(100vh-300px)] overflow-y-auto p-2 space-y-1">
                    @foreach($locations as $loc)
                        <button wire:click="$set('selectedLocation', '{{ $loc }}')" 
                                class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ $selectedLocation === $loc ? 'bg-teal-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}">
                            {{ $loc }}
                        </button>
                    @endforeach
                    @if(empty($locations))
                        <div class="px-3 py-4 text-center text-sm text-gray-400">
                            Belum ada data lokasi.
                        </div>
                    @endif
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $selectedLocation ?: 'Semua Ruangan' }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Kartu Inventaris Ruangan (KIR)</p>
                    </div>
                    
                    <div class="flex gap-2">
                        <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari aset di ruangan ini..." class="text-sm w-full md:w-64" />
                        <button class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 flex items-center gap-2" onclick="window.print()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            Print KIR
                        </button>
                    </div>
                </div>

                <!-- Stats Summary -->
                <div class="grid grid-cols-3 gap-4 mt-6 border-t border-gray-100 pt-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Total Aset</p>
                        <p class="text-xl font-bold text-gray-900">{{ $barangs->total() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Nilai Aset</p>
                        <p class="text-xl font-bold text-teal-600">Rp {{ number_format($barangs->sum('nilai_buku'), 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Kondisi Baik</p>
                        <p class="text-xl font-bold text-green-600">{{ $barangs->where('kondisi', 'Baik')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Asset Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($barangs as $barang)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div class="bg-blue-50 text-blue-600 text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">
                                    {{ $barang->kode_barang }}
                                </div>
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 group-hover:bg-teal-50 group-hover:text-teal-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                </div>
                            </div>
                            <h3 class="font-bold text-gray-900 line-clamp-2 min-h-[3rem]">{{ $barang->nama_barang }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $barang->merk ?? 'Tanpa Merk' }}</p>
                            
                            <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center text-sm">
                                <span class="text-gray-600">{{ $barang->stok }} {{ $barang->satuan }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $barang->kondisi == 'Baik' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $barang->kondisi }}
                                </span>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-2 border-t border-gray-100 flex justify-end">
                            <a href="{{ route('barang.show', $barang->id) }}" wire:navigate class="text-xs font-semibold text-teal-600 hover:text-teal-800">Lihat Detail &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        Tidak ada aset ditemukan di ruangan ini.
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $barangs->links() }}
            </div>
        </div>
    </div>
</div>