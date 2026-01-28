<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Detail Aset & Inventaris</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Informasi lengkap, riwayat stok, dan pemeliharaan.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('barang.edit', $barang->id) }}" wire:navigate class="px-4 py-2 bg-yellow-500 text-white font-bold rounded-xl hover:bg-yellow-600 transition shadow-lg shadow-yellow-500/20 text-xs uppercase tracking-widest">
                Edit Data
            </a>
            <a href="{{ route('barang.index') }}" wire:navigate class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 transition text-xs uppercase tracking-widest">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info Utama -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 dark:bg-blue-900/20 rounded-bl-full -mr-8 -mt-8"></div>
                
                <div class="flex items-start gap-6 relative z-10">
                    <div class="w-24 h-24 bg-slate-50 dark:bg-slate-700 rounded-2xl flex items-center justify-center text-4xl font-black text-slate-300">
                        {{ substr($barang->nama_barang, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-black text-slate-900 dark:text-white">{{ $barang->nama_barang }}</h1>
                                <p class="text-sm font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $barang->kode_barang }}</p>
                            </div>
                            <span class="px-3 py-1 bg-{{ $barang->kondisi == 'Baik' ? 'green' : 'red' }}-100 text-{{ $barang->kondisi == 'Baik' ? 'green' : 'red' }}-800 text-xs font-black rounded-full uppercase tracking-widest">
                                {{ $barang->kondisi }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Kategori</p>
                                <p class="text-sm font-bold text-slate-700 dark:text-gray-300">{{ $barang->kategori->nama_kategori ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Merk / Brand</p>
                                <p class="text-sm font-bold text-slate-700 dark:text-gray-300">{{ $barang->merk ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Lokasi</p>
                                <p class="text-sm font-bold text-slate-700 dark:text-gray-300">{{ $barang->ruangan->nama_ruangan ?? $barang->lokasi_penyimpanan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Stok Saat Ini</p>
                                <p class="text-xl font-black text-blue-600">{{ $barang->stok }} <span class="text-xs text-slate-400 font-bold">{{ $barang->satuan }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab History & Maintenance -->
            <div x-data="{ activeTab: 'riwayat' }" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="flex border-b border-gray-100 dark:border-gray-700">
                    <button @click="activeTab = 'riwayat'" :class="activeTab === 'riwayat' ? 'bg-blue-50 text-blue-600 border-b-2 border-blue-600' : 'text-slate-500 hover:bg-slate-50'" class="flex-1 py-4 text-sm font-bold uppercase tracking-widest transition-all">
                        Riwayat Stok
                    </button>
                    <button @click="activeTab = 'maintenance'" :class="activeTab === 'maintenance' ? 'bg-blue-50 text-blue-600 border-b-2 border-blue-600' : 'text-slate-500 hover:bg-slate-50'" class="flex-1 py-4 text-sm font-bold uppercase tracking-widest transition-all">
                        Pemeliharaan (Maintenance)
                    </button>
                </div>

                <div class="p-6">
                    <!-- Riwayat Stok -->
                    <div x-show="activeTab === 'riwayat'" class="space-y-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-slate-800 dark:text-white">Kartu Stok</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Tipe</th>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Jumlah</th>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Sisa</th>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">User</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach($riwayats as $log)
                                        <tr>
                                            <td class="px-4 py-3 text-xs text-slate-600 dark:text-gray-300">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 text-[10px] font-black rounded uppercase tracking-widest {{ $log->jenis_transaksi == 'Masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                    {{ $log->jenis_transaksi }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm font-bold text-slate-800 dark:text-white">{{ $log->jumlah }}</td>
                                            <td class="px-4 py-3 text-sm font-bold text-slate-800 dark:text-white">{{ $log->stok_terakhir }}</td>
                                            <td class="px-4 py-3 text-xs text-slate-500">{{ $log->user->name ?? 'System' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $riwayats->links() }}
                    </div>

                    <!-- Maintenance Log -->
                    <div x-show="activeTab === 'maintenance'" style="display: none;" class="space-y-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-slate-800 dark:text-white">Log Perbaikan & Servis</h3>
                            <a href="{{ route('barang.maintenance.create', $barang->id) }}" wire:navigate class="px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 uppercase tracking-widest transition shadow-lg shadow-blue-500/20">
                                + Catat Maintenance
                            </a>
                        </div>
                        
                        @if($maintenances->count() > 0)
                            <div class="space-y-4">
                                @foreach($maintenances as $m)
                                    <div class="p-4 rounded-xl border border-slate-100 dark:border-gray-700 bg-slate-50 dark:bg-gray-700/50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $m->jenis_kegiatan }}</span>
                                                    <span class="text-xs text-slate-500">({{ \Carbon\Carbon::parse($m->tanggal_maintenance)->format('d F Y') }})</span>
                                                </div>
                                                <p class="text-xs text-slate-600 dark:text-gray-300 mt-1">{{ $m->keterangan }}</p>
                                                <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-widest">Teknisi: {{ $m->teknisi ?? '-' }}</p>
                                            </div>
                                            <span class="text-sm font-bold text-slate-700 dark:text-gray-200">Rp {{ number_format($m->biaya, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-400 font-bold text-sm">
                                Belum ada riwayat pemeliharaan.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Kanan: Form Transaksi Cepat & Detail Aset -->
        <div class="space-y-6">
            <!-- Form Stok Cepat -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-indigo-500 p-6">
                <h3 class="text-sm font-black text-indigo-600 uppercase tracking-widest mb-4">Catat Transaksi Stok</h3>
                
                <form wire:submit="saveTransaksi" class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-slate-500">Jenis</label>
                        <div class="grid grid-cols-2 gap-2 mt-1">
                            <button type="button" wire:click="$set('jenis_transaksi', 'Masuk')" class="px-3 py-2 rounded-lg text-xs font-bold border transition {{ $jenis_transaksi == 'Masuk' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-white border-slate-200 text-slate-500' }}">
                                Masuk (+)
                            </button>
                            <button type="button" wire:click="$set('jenis_transaksi', 'Keluar')" class="px-3 py-2 rounded-lg text-xs font-bold border transition {{ $jenis_transaksi == 'Keluar' ? 'bg-red-100 border-red-500 text-red-700' : 'bg-white border-slate-200 text-slate-500' }}">
                                Keluar (-)
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500">Jumlah</label>
                        <input type="number" wire:model="jumlah" class="w-full mt-1 border-slate-200 rounded-xl text-sm font-bold focus:ring-indigo-500 focus:border-indigo-500" placeholder="0">
                        <x-input-error :messages="$errors->get('jumlah')" class="mt-1" />
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500">Tanggal</label>
                        <input type="date" wire:model="tanggal_transaksi" class="w-full mt-1 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500">Keterangan</label>
                        <input type="text" wire:model="keterangan" class="w-full mt-1 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Pengadaan baru / Rusak">
                    </div>

                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
                        Simpan Transaksi
                    </button>
                </form>
            </div>

            @if($barang->is_asset)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Nilai Aset</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Harga Perolehan</span>
                        <span class="font-bold text-slate-800 dark:text-white">Rp {{ number_format($barang->harga_perolehan, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Masa Manfaat</span>
                        <span class="font-bold text-slate-800 dark:text-white">{{ $barang->masa_manfaat }} Tahun</span>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex justify-between">
                        <span class="text-slate-500 font-bold">Nilai Buku (Saat Ini)</span>
                        <span class="font-black text-blue-600">Rp {{ number_format($barang->nilai_buku, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>