<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    @if($isOpen)
        <!-- MODE: FORMULIR INPUT -->
        <div class="space-y-6">
            <!-- Header Form -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <div class="p-2 bg-teal-100 rounded-lg text-teal-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        Formulir Mutasi Baru
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 ml-12">
                        Silakan lengkapi data perpindahan aset atau distribusi barang di bawah ini.
                    </p>
                </div>
                <button wire:click="$set('isOpen', false)" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali
                </button>
            </div>

            <!-- Card Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 space-y-8">
                    <!-- Section 1: Informasi Barang -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="col-span-2">
                            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Informasi Barang</h3>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Barang</label>
                            <select wire:model.live="barang_id" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5">
                                <option value="">-- Cari Barang yang Tersedia --</option>
                                @foreach($barangs as $b)
                                    <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }} (Stok: {{ $b->stok }})</option>
                                @endforeach
                            </select>
                            @error('barang_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-400 mt-2">Pilih barang yang stoknya > 0.</p>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Asal (Saat Ini)</label>
                            <input type="text" wire:model="lokasi_asal" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm bg-gray-50 text-gray-500 cursor-not-allowed" placeholder="Otomatis terisi setelah memilih barang..." readonly>
                            @error('lokasi_asal') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Section 2: Tujuan & Detail -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="col-span-3">
                            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Detail Perpindahan</h3>
                        </div>

                        <div class="col-span-3 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ruangan Tujuan</label>
                            <select wire:model.live="ruangan_id_tujuan" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5">
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($ruangans as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                                @endforeach
                            </select>
                            @error('ruangan_id_tujuan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-3 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Barang</label>
                            <input type="number" wire:model="jumlah" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5" placeholder="Contoh: 5">
                            @error('jumlah') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-3 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mutasi</label>
                            <input type="date" wire:model="tanggal_mutasi" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5">
                            @error('tanggal_mutasi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-3">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan / Alasan Mutasi</label>
                            <textarea wire:model="keterangan" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" rows="3" placeholder="Jelaskan alasan pemindahan aset ini secara rinci..."></textarea>
                            @error('keterangan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="bg-gray-50 px-8 py-5 flex items-center justify-between border-t border-gray-100">
                    <button wire:click="$set('isOpen', false)" class="text-gray-600 font-medium hover:text-gray-900 text-sm">
                        Batalkan
                    </button>
                    <button wire:click="save" class="inline-flex items-center px-6 py-2.5 bg-teal-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Simpan Data Mutasi
                    </button>
                </div>
            </div>
        </div>
    @else
        <!-- MODE: TABEL LIST DATA -->
        <div class="space-y-6">
            <!-- Header List -->
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

            <!-- Tabel Data -->
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
                                            <span class="px-2 py-1 bg-gray-100 rounded text-xs font-medium border border-gray-200">
                                                {{ $m->ruanganAsal ? $m->ruanganAsal->nama_ruangan : $m->lokasi_asal }}
                                            </span>
                                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                            <span class="px-2 py-1 bg-teal-50 text-teal-700 font-bold rounded text-xs border border-teal-100">
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
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                            <p>Belum ada riwayat mutasi barang.</p>
                                        </div>
                                    </td>
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
                            <div class="flex items-center text-xs text-gray-600 mt-3 bg-gray-50 p-2 rounded-lg border border-gray-100">
                                <span class="font-medium truncate max-w-[40%]">{{ $m->ruanganAsal ? $m->ruanganAsal->nama_ruangan : $m->lokasi_asal }}</span>
                                <svg class="w-3 h-3 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                <span class="font-bold text-teal-700 truncate max-w-[40%]">{{ $m->ruanganTujuan ? $m->ruanganTujuan->nama_ruangan : $m->lokasi_tujuan }}</span>
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
        </div>
    @endif
</div>