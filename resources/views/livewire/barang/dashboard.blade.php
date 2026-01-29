<div class="space-y-6">
    <!-- Header Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Aset -->
        <div class="bg-gradient-to-br from-indigo-600 to-blue-700 p-6 rounded-3xl text-white shadow-xl shadow-indigo-500/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-indigo-100 uppercase tracking-widest mb-1">Total Aset Tercatat</p>
            <h3 class="text-3xl font-black">{{ number_format($totalAset) }} <span class="text-sm font-medium opacity-70">Unit</span></h3>
            <p class="mt-4 text-[10px] font-medium bg-indigo-500/30 px-2 py-1 rounded inline-block">Termasuk alat medis & non-medis</p>
        </div>

        <!-- Valuasi Aset -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Estimasi Nilai Aset</p>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white">Rp {{ number_format($nilaiAsetTotal, 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                <span class="text-xs text-gray-500 font-medium">Valuasi harga perolehan</span>
            </div>
        </div>

        <!-- Kondisi Aset -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Status Kondisi Fisik</p>
            <div class="flex gap-2 h-4 mb-2">
                <div class="bg-emerald-500 h-full rounded-l-full" style="width: {{ ($kondisiStats['Baik'] / max($totalAset, 1)) * 100 }}%" title="Baik"></div>
                <div class="bg-yellow-500 h-full" style="width: {{ ($kondisiStats['PerluPerbaikan'] / max($totalAset, 1)) * 100 }}%" title="Perlu Perbaikan"></div>
                <div class="bg-red-500 h-full rounded-r-full" style="width: {{ ($kondisiStats['Rusak'] / max($totalAset, 1)) * 100 }}%" title="Rusak Berat"></div>
            </div>
            <div class="flex justify-between text-[10px] font-bold text-gray-500">
                <span class="flex items-center gap-1"><div class="w-2 h-2 bg-emerald-500 rounded-full"></div> {{ $kondisiStats['Baik'] }} Baik</span>
                <span class="flex items-center gap-1"><div class="w-2 h-2 bg-red-500 rounded-full"></div> {{ $kondisiStats['Rusak'] }} Rusak</span>
            </div>
        </div>

        <!-- Shortcut -->
        <div class="bg-slate-50 dark:bg-slate-700/50 p-6 rounded-3xl border border-slate-200 dark:border-slate-600 flex flex-col justify-center items-center text-center gap-3">
            <a href="{{ route('barang.create') }}" class="w-full py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
                + Registrasi Aset Baru
            </a>
            <a href="{{ route('barang.pengadaan.create') }}" class="w-full py-2 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-500 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold hover:border-indigo-500 hover:text-indigo-600 transition">
                Ajukan Pengadaan
            </a>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="border-b border-gray-100 dark:border-gray-700 px-6 pt-4 flex gap-8 overflow-x-auto">
            <button wire:click="setTab('ikhtisar')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'ikhtisar' ? 'text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}">
                Ringkasan Inventaris
                @if($activeTab == 'ikhtisar') <div class="absolute bottom-0 left-0 w-full h-1 bg-indigo-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('stok')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'stok' ? 'text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}">
                Monitoring Stok & Obat
                @if($activeTab == 'stok') <div class="absolute bottom-0 left-0 w-full h-1 bg-indigo-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('maintenance')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'maintenance' ? 'text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}">
                Jadwal Pemeliharaan
                @if($activeTab == 'maintenance') <div class="absolute bottom-0 left-0 w-full h-1 bg-indigo-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('pengadaan')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'pengadaan' ? 'text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}">
                Pengadaan & Budget
                @if($activeTab == 'pengadaan') <div class="absolute bottom-0 left-0 w-full h-1 bg-indigo-600 rounded-t-full"></div> @endif
            </button>
        </div>

        <div class="p-8 min-h-[400px]">
            <!-- TAB 1: IKHTISAR -->
            @if($activeTab == 'ikhtisar')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up">
                    <div class="lg:col-span-2 space-y-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Aktivitas Inventaris Terkini</h4>
                        <div class="space-y-4">
                            @foreach($tabData['recentActivities'] as $act)
                                <div class="flex items-start gap-4 p-4 bg-slate-50 dark:bg-slate-700/30 rounded-2xl border border-slate-100 dark:border-slate-700">
                                    <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-600 flex items-center justify-center shadow-sm text-lg font-bold text-indigo-600">
                                        {{ substr($act->jenis_transaksi, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <h5 class="text-sm font-bold text-gray-900 dark:text-white">{{ $act->barang->nama_barang }}</h5>
                                            <span class="text-[10px] text-gray-400">{{ $act->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <span class="font-bold text-gray-700 dark:text-gray-300">{{ $act->jenis_transaksi }}</span> 
                                            sebanyak {{ $act->jumlah }} unit.
                                            <span class="italic text-gray-400">Oleh: {{ $act->user->name ?? 'System' }}</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Sebaran Lokasi Aset</h4>
                        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                            @foreach($tabData['lokasiAset'] as $lokasi)
                                <div class="flex items-center justify-between p-4 border-b border-gray-50 dark:border-gray-700 last:border-0 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $lokasi->nama_ruangan }}</span>
                                    </div>
                                    <span class="text-xs font-black bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 px-2 py-1 rounded-lg">{{ $lokasi->barangs_count }} Item</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 2: STOK -->
            @if($activeTab == 'stok')
                <div class="space-y-8 animate-fade-in-up">
                    <!-- Warning Alert -->
                    @if($tabData['lowStockItems']->isNotEmpty())
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-2xl p-4 flex items-start gap-4">
                            <div class="p-2 bg-red-100 dark:bg-red-800 text-red-600 dark:text-red-200 rounded-lg">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-red-800 dark:text-red-300">Peringatan Stok Menipis</h4>
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">Beberapa barang habis pakai telah mencapai batas minimum stok. Segera lakukan pengadaan.</p>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Barang Perlu Restock</h4>
                            <div class="space-y-3">
                                @forelse($tabData['lowStockItems'] as $item)
                                    <div class="flex items-center justify-between p-3 rounded-xl border border-red-100 dark:border-red-900/30 bg-white dark:bg-slate-700/20">
                                        <div>
                                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $item->nama_barang }}</p>
                                            <p class="text-[10px] text-gray-500 font-mono">{{ $item->kode_barang }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xl font-black text-red-600">{{ $item->stok }}</span>
                                            <span class="text-[10px] text-gray-400 block">{{ $item->satuan }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-400 text-sm py-4">Semua stok aman.</p>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Flow Barang (7 Hari)</h4>
                            <div class="h-64 flex items-end justify-between gap-3 bg-slate-50 dark:bg-slate-700/30 rounded-2xl p-4 border border-slate-100 dark:border-slate-700">
                                @foreach($tabData['flowStok']['labels'] as $idx => $label)
                                    <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                        <div class="flex gap-1 items-end w-full justify-center h-full">
                                            <!-- Masuk -->
                                            <div class="w-3 bg-emerald-500 rounded-t-sm" style="height: {{ min(100, $tabData['flowStok']['in'][$idx] * 5) }}%"></div>
                                            <!-- Keluar -->
                                            <div class="w-3 bg-amber-500 rounded-t-sm" style="height: {{ min(100, $tabData['flowStok']['out'][$idx] * 5) }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-bold text-gray-400 mt-2">{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex justify-center gap-4 mt-4 text-xs font-bold">
                                <span class="flex items-center gap-1 text-emerald-600"><div class="w-2 h-2 bg-emerald-500 rounded-full"></div> Masuk</span>
                                <span class="flex items-center gap-1 text-amber-600"><div class="w-2 h-2 bg-amber-500 rounded-full"></div> Keluar</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 3: MAINTENANCE -->
            @if($activeTab == 'maintenance')
                <div class="animate-fade-in-up">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Jadwal Pemeliharaan (14 Hari Kedepan)</h4>
                        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold">Total Biaya Bulan Ini: Rp {{ number_format($tabData['biayaMaintenanceBulanIni'], 0, ',', '.') }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($tabData['maintenanceDue'] as $m)
                            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-l-4 border-indigo-500 shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-indigo-500 bg-indigo-50 px-2 py-1 rounded uppercase tracking-wider">
                                        {{ \Carbon\Carbon::parse($m->tanggal_berikutnya)->format('d M Y') }}
                                    </span>
                                    @if(\Carbon\Carbon::parse($m->tanggal_berikutnya)->isToday())
                                        <span class="text-[10px] font-black text-red-600 animate-pulse">HARI INI</span>
                                    @endif
                                </div>
                                <h5 class="font-bold text-gray-900 dark:text-white mt-2">{{ $m->barang->nama_barang }}</h5>
                                <p class="text-xs text-gray-500 mt-1">Kode: {{ $m->barang->kode_barang }}</p>
                                <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                    <span class="text-xs text-gray-400">Teknisi: {{ $m->teknisi ?? 'Internal' }}</span>
                                    <a href="{{ route('barang.maintenance.create', $m->barang_id) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Proses &rarr;</a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-400 border border-dashed border-gray-200 rounded-2xl">
                                Tidak ada jadwal pemeliharaan mendesak.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            <!-- TAB 4: PENGADAAN -->
            @if($activeTab == 'pengadaan')
                <div class="space-y-6 animate-fade-in-up">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Pengajuan Pengadaan Pending</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-400 uppercase bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 rounded-l-lg">Tanggal</th>
                                        <th class="px-4 py-3">Judul Pengadaan</th>
                                        <th class="px-4 py-3 text-right">Estimasi Biaya</th>
                                        <th class="px-4 py-3 text-center rounded-r-lg">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse($tabData['pengadaanPending'] as $p)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30">
                                            <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $p->created_at->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3 font-bold text-gray-800 dark:text-gray-200">{{ $p->judul_pengadaan }}</td>
                                            <td class="px-4 py-3 text-right font-mono font-medium">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold">Menunggu</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">Tidak ada pengajuan pending.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
