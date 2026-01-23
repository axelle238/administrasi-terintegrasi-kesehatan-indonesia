<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                Mutasi & Distribusi
            </h2>
            <p class="text-sm text-gray-500 mt-1 ml-10">
                Catat perpindahan lokasi aset atau distribusi barang habis pakai ke unit lain.
            </p>
        </div>
        <button wire:click="create" class="inline-flex items-center px-5 py-2.5 bg-teal-600 text-white rounded-xl font-semibold text-sm shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Catat Mutasi Baru
        </button>
    </div>

    <!-- History List -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Barang</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Perpindahan</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">PJ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($mutasis as $m)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($m->tanggal_mutasi)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $m->barang->nama_barang }}</div>
                                <div class="text-xs text-gray-500 font-mono">{{ $m->barang->kode_barang }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="px-2 py-1 bg-gray-100 rounded text-xs">
                                        {{ $m->ruanganAsal ? $m->ruanganAsal->nama_ruangan : $m->lokasi_asal }}
                                    </span>
                                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                    <span class="px-2 py-1 bg-teal-50 text-teal-700 font-bold rounded text-xs">
                                        {{ $m->ruanganTujuan ? $m->ruanganTujuan->nama_ruangan : $m->lokasi_tujuan }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-gray-900">
                                {{ $m->jumlah }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $m->penanggung_jawab }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada riwayat mutasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-4 p-4 bg-gray-50">
            @forelse($mutasis as $m)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">{{ $m->barang->nama_barang }}</h3>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($m->tanggal_mutasi)->format('d M Y') }}</p>
                        </div>
                        <span class="bg-teal-100 text-teal-800 text-xs font-bold px-2 py-1 rounded-lg">
                            {{ $m->jumlah }} Unit
                        </span>
                    </div>
                    <div class="flex items-center text-xs text-gray-600 mt-3 bg-gray-50 p-2 rounded-lg">
                        <span class="font-medium">{{ $m->ruanganAsal ? $m->ruanganAsal->nama_ruangan : $m->lokasi_asal }}</span>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        <span class="font-bold text-teal-700">{{ $m->ruanganTujuan ? $m->ruanganTujuan->nama_ruangan : $m->lokasi_tujuan }}</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-400 text-right">
                        PJ: {{ $m->penanggung_jawab }}
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-4">Belum ada data.</div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $mutasis->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" wire:click="$set('isOpen', false)"></div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <div class="p-2 bg-teal-100 rounded-lg text-teal-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                        </div>
                        Formulir Mutasi
                    </h3>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Barang</label>
                            <select wire:model.live="barang_id" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                <option value="">-- Cari Barang --</option>
                                @foreach($barangs as $b)
                                    <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('barang_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi Asal</label>
                                <input type="text" wire:model="lokasi_asal" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm bg-gray-50" placeholder="Otomatis..." readonly>
                                @error('lokasi_asal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi Tujuan</label>
                                <select wire:model.live="ruangan_id_tujuan" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($ruangans as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                                    @endforeach
                                </select>
                                @error('ruangan_id_tujuan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah</label>
                                <input type="number" wire:model="jumlah" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm" placeholder="1">
                                @error('jumlah') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
                                <input type="date" wire:model="tanggal_mutasi" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                @error('tanggal_mutasi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Keterangan</label>
                            <textarea wire:model="keterangan" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm" rows="2" placeholder="Alasan mutasi..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                    <button wire:click="save" class="inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2 bg-teal-600 text-base font-bold text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:text-sm">
                        Simpan Data
                    </button>
                    <button wire:click="$set('isOpen', false)" class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-5 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
