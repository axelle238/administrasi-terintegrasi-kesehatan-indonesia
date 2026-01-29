<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    @if($isOpen)
        <!-- MODE: FORMULIR INPUT (Halaman Penuh) -->
        <div class="space-y-6">
            <!-- Header Form -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <div class="p-2 bg-teal-100 dark:bg-teal-900/50 rounded-lg text-teal-600 dark:text-teal-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </div>
                        Formulir Pemeliharaan Aset
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 ml-12">
                        Catat detail kegiatan perawatan, perbaikan, atau kalibrasi alat.
                    </p>
                </div>
                <button wire:click="$set('isOpen', false)" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-semibold text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all">
                    <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali
                </button>
            </div>

            <!-- Card Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <form wire:submit.prevent="save" class="p-8 space-y-8">
                    <!-- Section 1: Data Aset -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="col-span-2">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Informasi Aset & Waktu</h3>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pilih Aset / Barang</label>
                            <select wire:model="barang_id" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5">
                                <option value="">-- Cari Aset --</option>
                                @foreach($barangs as $b)
                                    <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('barang_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Kegiatan</label>
                            <input type="date" wire:model="tanggal_maintenance" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5">
                            @error('tanggal_maintenance') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Section 2: Detail Kegiatan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="col-span-2">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Detail Pengerjaan</h3>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jenis Kegiatan</label>
                            <select wire:model="jenis_kegiatan" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5">
                                <option value="Pemeliharaan Rutin">Pemeliharaan Rutin</option>
                                <option value="Perbaikan">Perbaikan Kerusakan</option>
                                <option value="Kalibrasi">Kalibrasi Alat</option>
                                <option value="Pemeriksaan">Pemeriksaan Fisik</option>
                            </select>
                            @error('jenis_kegiatan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Teknisi / Vendor Pelaksana</label>
                            <input type="text" wire:model="teknisi" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5" placeholder="Nama teknisi atau perusahaan vendor...">
                            @error('teknisi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Keterangan / Hasil Pengerjaan</label>
                            <textarea wire:model="keterangan" rows="3" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Deskripsikan apa saja yang dilakukan..."></textarea>
                            @error('keterangan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Section 3: Biaya & Jadwal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="col-span-2">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Biaya & Tindak Lanjut</h3>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Biaya (Rp)</label>
                            <div class="relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" wire:model="biaya" class="block w-full pl-10 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5" placeholder="0">
                            </div>
                            @error('biaya') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jadwal Pemeliharaan Berikutnya</label>
                            <input type="date" wire:model="tanggal_berikutnya" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5">
                            <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ada jadwal rutin.</p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <button type="button" wire:click="$set('isOpen', false)" class="text-gray-600 dark:text-gray-400 font-medium hover:text-gray-900 dark:hover:text-white text-sm">
                            Batalkan
                        </button>
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-teal-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <!-- MODE: TABEL LIST DATA -->
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <div class="p-2 bg-teal-100 dark:bg-teal-900/50 rounded-lg text-teal-600 dark:text-teal-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        Log Pemeliharaan & Kalibrasi
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 ml-12">
                        Riwayat perbaikan, servis rutin, dan kalibrasi alat kesehatan.
                    </p>
                </div>
                <button wire:click="create" class="group relative inline-flex items-center justify-center px-6 py-2.5 overflow-hidden font-bold text-white transition-all duration-300 bg-teal-600 rounded-xl hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
                    <span class="relative flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Catat Pemeliharaan
                    </span>
                </button>
            </div>

            <!-- Search -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
                <div class="relative w-full md:w-1/2 lg:w-1/3">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 focus:border-teal-500 focus:ring-teal-500 sm:text-sm transition-shadow" placeholder="Cari nama aset..." />
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                        <thead class="bg-gray-50/50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aset</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kegiatan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Teknisi</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Biaya</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Reminder</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse ($maintenances as $log)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $log->tanggal_maintenance->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $log->barang->nama_barang }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ $log->barang->kode_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800 mb-1">
                                            {{ $log->jenis_kegiatan }}
                                        </span>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-xs">{{ $log->keterangan }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $log->teknisi ?? 'Internal' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($log->biaya, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($log->tanggal_berikutnya)
                                            <span class="text-teal-600 dark:text-teal-400 font-medium">{{ $log->tanggal_berikutnya->format('d/m/Y') }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12 text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                            <p>Belum ada riwayat pemeliharaan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $maintenances->links() }}
                </div>
            </div>
        </div>
    @endif
</div>