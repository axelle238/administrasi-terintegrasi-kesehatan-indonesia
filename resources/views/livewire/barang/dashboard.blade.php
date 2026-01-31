<div class="space-y-8 animate-fade-in" x-data="{ activeTab: @entangle('activeTab') }">
    
    <!-- Hero Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Total Aset -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-[2rem] p-6 text-white relative overflow-hidden shadow-xl group hover:scale-[1.02] transition-transform duration-300">
            <div class="absolute right-0 top-0 opacity-10 p-4">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Aset Tercatat</p>
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
            <p class="text-xs text-slate-400">Estimasi total nilai aset saat ini.</p>
        </div>

        <!-- Alkes -->
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm group hover:border-blue-200 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-50 rounded-2xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg uppercase tracking-wider">Alat Medis</span>
            </div>
            <h3 class="text-3xl font-black text-slate-800 mb-1">{{ number_format($totalAlkes) }}</h3>
            <p class="text-xs text-slate-400">Unit alat kesehatan terdaftar.</p>
        </div>

        <!-- Maintenance -->
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm group hover:border-amber-200 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-amber-50 rounded-2xl text-amber-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg uppercase tracking-wider">Perbaikan</span>
            </div>
            <h3 class="text-3xl font-black text-slate-800 mb-1">{{ $kondisiStats['PerluPerbaikan'] }}</h3>
            <p class="text-xs text-slate-400">Aset butuh tindakan segera.</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="border-b border-slate-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            @foreach(['ikhtisar' => 'Ikhtisar & Lokasi', 'stok' => 'Monitoring Stok', 'maintenance' => 'Jadwal Maintenance', 'pengadaan' => 'Pengadaan Baru'] as $key => $label)
                <button wire:click="setTab('{{ $key }}')" 
                    class="{{ $activeTab === $key ? 'border-blue-500 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors uppercase tracking-wider">
                    {{ $label }}
                </button>
            @endforeach
        </nav>
    </div>

    <!-- Tab Contents -->
    <div class="mt-6">
        
        <!-- IKHTISAR -->
        <div x-show="activeTab === 'ikhtisar'" class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in-up">
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

        <!-- MAINTENANCE -->
        <div x-show="activeTab === 'maintenance'" style="display: none;" class="animate-fade-in-up">
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

        <!-- STOK & PENGADAAN (Simple View) -->
        <div x-show="activeTab === 'stok' || activeTab === 'pengadaan'" style="display: none;" class="bg-white p-12 rounded-[2rem] text-center border-2 border-dashed border-slate-200">
            <p class="text-slate-400">Detail data untuk tab ini dapat dilihat pada menu operasional masing-masing.</p>
            <div class="flex justify-center gap-4 mt-4">
                <a href="{{ route('barang.index') }}" class="px-4 py-2 bg-slate-100 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-200">Ke Data Barang</a>
                <a href="{{ route('barang.pengadaan.index') }}" class="px-4 py-2 bg-slate-100 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-200">Ke Pengadaan</a>
            </div>
        </div>

    </div>
</div>
