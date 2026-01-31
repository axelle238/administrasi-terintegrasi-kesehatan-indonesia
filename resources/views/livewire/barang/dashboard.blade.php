<div class="space-y-8 animate-fade-in">
    
    <!-- Filter Bar -->
    <div class="flex justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
        <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Dashboard Aset
        </h2>
        
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Mode View:</span>
            <div class="flex bg-slate-100 rounded-lg p-1">
                <button wire:click="setFilterTipe('all')" class="px-3 py-1 text-xs font-bold rounded-md transition-all {{ $filterTipe === 'all' ? 'bg-white shadow text-blue-600' : 'text-slate-500 hover:text-slate-700' }}">Semua</button>
                <button wire:click="setFilterTipe('medis')" class="px-3 py-1 text-xs font-bold rounded-md transition-all {{ $filterTipe === 'medis' ? 'bg-white shadow text-emerald-600' : 'text-slate-500 hover:text-slate-700' }}">Alat Kesehatan</button>
                <button wire:click="setFilterTipe('umum')" class="px-3 py-1 text-xs font-bold rounded-md transition-all {{ $filterTipe === 'umum' ? 'bg-white shadow text-amber-600' : 'text-slate-500 hover:text-slate-700' }}">Umum</button>
            </div>
        </div>
    </div>

    <!-- Hero Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Aset -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-[2rem] p-6 text-white relative overflow-hidden shadow-xl group hover:scale-[1.02] transition-transform duration-300">
            <div class="absolute right-0 top-0 opacity-10 p-4">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">
                    {{ $filterTipe === 'medis' ? 'Total Alkes' : ($filterTipe === 'umum' ? 'Total Aset Umum' : 'Total Aset') }}
                </p>
                <h2 class="text-4xl font-black mb-4">{{ number_format($totalAset) }} <span class="text-lg font-medium text-slate-500">Unit</span></h2>
                <div class="flex gap-2">
                    <span class="px-2 py-1 rounded bg-blue-500/20 text-blue-300 text-[10px] font-bold border border-blue-500/30">{{ $kondisiStats['Baik'] }} Baik</span>
                    <span class="px-2 py-1 rounded bg-red-500/20 text-red-300 text-[10px] font-bold border border-red-500/30">{{ $kondisiStats['Rusak'] }} Rusak</span>
                </div>
            </div>
        </div>

        <!-- Valuasi -->
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm group hover:border-emerald-200 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg uppercase tracking-wider">Valuasi</span>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-1">Rp {{ number_format($nilaiAsetTotal / 1000000, 1) }} M</h3>
            <p class="text-xs text-slate-400">Nilai buku aset {{ $filterTipe === 'all' ? 'keseluruhan' : ($filterTipe === 'medis' ? 'medis' : 'umum') }}.</p>
        </div>

        @if($filterTipe === 'medis' || $filterTipe === 'all')
        <!-- Kalibrasi (Khusus Medis) -->
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm group hover:border-blue-200 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-50 rounded-2xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg uppercase tracking-wider">Kalibrasi</span>
            </div>
            <h3 class="text-3xl font-black text-slate-800 mb-1">{{ number_format($kalibrasiDue) }}</h3>
            <p class="text-xs text-slate-400">Alat perlu kalibrasi < 60 hari.</p>
        </div>
        @else
        <!-- Placeholder Umum -->
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm group hover:border-blue-200 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-50 rounded-2xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                </div>
                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg uppercase tracking-wider">Kategori</span>
            </div>
            <h3 class="text-3xl font-black text-slate-800 mb-1">{{ $tabData['distribusiKategori']->count() ?? 0 }}</h3>
            <p class="text-xs text-slate-400">Jenis kategori aktif.</p>
        </div>
        @endif

        <!-- Maintenance -->
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm group hover:border-amber-200 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-amber-50 rounded-2xl text-amber-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg uppercase tracking-wider">Perbaikan</span>
            </div>
            <h3 class="text-3xl font-black text-slate-800 mb-1">{{ $kondisiStats['PerluPerbaikan'] }}</h3>
            <p class="text-xs text-slate-400">Aset perlu tindakan.</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="border-b border-slate-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            @foreach(['ikhtisar' => 'Ikhtisar & Lokasi', 'stok' => 'Monitoring Stok', 'maintenance' => 'Jadwal Maintenance', 'pengadaan' => 'Pengadaan Baru'] as $key => $label)
                <a href="{{ route('barang.dashboard', ['activeTab' => $key, 'filterTipe' => $filterTipe]) }}" wire:navigate
                    class="{{ $activeTab === $key ? 'border-blue-500 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors uppercase tracking-wider relative block">
                    {{ $label }}
                </a>
            @endforeach
        </nav>
    </div>

    <!-- Tab Contents -->
    <div class="mt-6">
        
        <!-- IKHTISAR -->
        @if($activeTab === 'ikhtisar')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in-up" wire:key="tab-content-ikhtisar">
            <!-- Lokasi Aset -->
            <div class="lg:col-span-2 bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <h4 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Distribusi Aset per Ruangan
                </h4>
                <div class="space-y-4">
                    @foreach($tabData['lokasiAset'] ?? [] as $lokasi)
                    <div class="group">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-bold text-slate-700">{{ $lokasi->nama_ruangan }}</span>
                            <span class="font-bold text-slate-500">{{ $lokasi->barangs_count }} Item</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-blue-500 h-2 rounded-full transition-all duration-1000 group-hover:bg-blue-400" style="width: {{ ($lokasi->barangs_count / ($totalAset > 0 ? $totalAset : 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <h4 class="font-bold text-slate-800 mb-6">Aktivitas Terkini</h4>
                <div class="space-y-6 relative border-l-2 border-slate-100 ml-3">
                    @foreach($tabData['recentActivities'] ?? [] as $log)
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-2 border-white {{ $log->jenis_transaksi == 'Masuk' ? 'bg-emerald-500' : 'bg-amber-500' }}"></div>
                        <p class="text-xs text-slate-400 font-bold mb-0.5">{{ $log->created_at->diffForHumans() }}</p>
                        <p class="text-sm font-bold text-slate-800">{{ $log->jenis_transaksi }} - {{ $log->barang->nama_barang ?? 'Unknown' }}</p>
                        <p class="text-xs text-slate-500">Oleh: {{ $log->user->name ?? 'System' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- STOK (Monitoring) -->
        @if($activeTab === 'stok')
        <div class="grid grid-cols-1 gap-6 animate-fade-in-up" wire:key="tab-content-stok">
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <h4 class="font-bold text-slate-800 mb-6">Stok Menipis (Consumables)</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 rounded-l-xl">Barang</th>
                                <th class="px-4 py-3 text-center">Stok</th>
                                <th class="px-4 py-3 rounded-r-xl text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($tabData['lowStockItems'] ?? [] as $item)
                            <tr>
                                <td class="px-4 py-3 font-bold text-slate-700">{{ $item->nama_barang }}</td>
                                <td class="px-4 py-3 text-center font-black text-red-600">{{ $item->stok }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold">Low</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-slate-400">Stok aman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- MAINTENANCE -->
        @if($activeTab === 'maintenance')
        <div class="animate-fade-in-up" wire:key="tab-content-maintenance">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Stat Biaya -->
                <div class="bg-amber-50 rounded-[2rem] p-6 border border-amber-100">
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-2">Biaya Servis Bulan Ini</p>
                    <h3 class="text-3xl font-black text-amber-900">Rp {{ number_format($tabData['biayaMaintenanceBulanIni'] ?? 0) }}</h3>
                </div>
                
                <!-- Rasio -->
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 col-span-2 flex items-center justify-around">
                    <div class="text-center">
                        <p class="text-3xl font-black text-blue-600">{{ $tabData['maintenanceRatio']['preventif'] ?? 0 }}</p>
                        <p class="text-xs font-bold text-slate-400 uppercase">Preventif</p>
                    </div>
                    <div class="h-12 w-px bg-slate-200"></div>
                    <div class="text-center">
                        <p class="text-3xl font-black text-red-500">{{ $tabData['maintenanceRatio']['korektif'] ?? 0 }}</p>
                        <p class="text-xs font-bold text-slate-400 uppercase">Perbaikan (Rusak)</p>
                    </div>
                    @if($filterTipe === 'medis' || $filterTipe === 'all')
                    <div class="h-12 w-px bg-slate-200"></div>
                    <div class="text-center">
                        <p class="text-3xl font-black text-emerald-600">{{ $tabData['maintenanceRatio']['kalibrasi'] ?? 0 }}</p>
                        <p class="text-xs font-bold text-slate-400 uppercase">Kalibrasi</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h4 class="font-bold text-slate-800">Jadwal Maintenance Mendatang (30 Hari)</h4>
                    <a href="{{ route('barang.maintenance') }}" class="text-xs font-bold text-blue-600 hover:underline">Kelola Jadwal &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Aset / Barang</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($tabData['maintenanceDue'] ?? [] as $m)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($m->tanggal_berikutnya)->format('d M Y') }}
                                    <br>
                                    <span class="text-[10px] {{ \Carbon\Carbon::parse($m->tanggal_berikutnya)->isPast() ? 'text-red-500' : 'text-slate-400' }}">
                                        {{ \Carbon\Carbon::parse($m->tanggal_berikutnya)->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $m->barang->nama_barang }}</div>
                                    <div class="text-xs text-slate-400">{{ $m->barang->kode_barang }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ str_contains(strtolower($m->barang->kategori->nama_kategori ?? ''), 'medis') ? 'bg-red-100 text-red-600' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $m->barang->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Terjadwal</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400">Tidak ada jadwal maintenance dalam 30 hari ke depan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- PENGADAAN -->
        @if($activeTab === 'pengadaan')
        <div class="grid grid-cols-1 gap-6 animate-fade-in-up" wire:key="tab-content-pengadaan">
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-bold text-slate-800">Pengajuan Pending</h4>
                    <a href="{{ route('barang.pengadaan.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Kelola Pengadaan &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 rounded-l-xl">No. Pengajuan</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3 rounded-r-xl">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($tabData['pengadaanPending'] ?? [] as $p)
                            <tr>
                                <td class="px-4 py-3 font-bold text-slate-700">{{ $p->nomor_pengajuan }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold">Pending</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-slate-400">Tidak ada pengajuan pending.</td>
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