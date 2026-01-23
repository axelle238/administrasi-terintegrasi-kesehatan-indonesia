<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Nilai Aset -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Nilai Aset</p>
                <h3 class="text-2xl font-bold text-teal-700 mt-1">Rp {{ number_format($nilaiAset, 0, ',', '.') }}</h3>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="bg-teal-50 text-teal-600 px-2 py-1 rounded text-xs font-bold">{{ $totalAset }} Item</span>
                <span class="text-xs text-gray-400">Total Inventaris</span>
            </div>
        </div>

        <!-- Kondisi Aset -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Kondisi Aset</p>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Baik</span>
                        <span class="font-bold text-gray-900">{{ $kondisiBaik }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalAset > 0 ? ($kondisiBaik / $totalAset) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Perlu Perbaikan</span>
                        <span class="font-bold text-gray-900">{{ $kondisiRusak }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalAset > 0 ? ($kondisiRusak / $totalAset) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance Alert -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jadwal Pemeliharaan</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <h3 class="text-3xl font-bold text-blue-600">{{ $maintenanceDue }}</h3>
                    <span class="text-sm text-gray-500">Aset</span>
                </div>
                <p class="text-xs text-gray-500 mt-2">Perlu pemeliharaan dalam 7 hari kedepan.</p>
                <a href="{{ route('barang.maintenance') }}" class="inline-block mt-3 text-xs font-bold text-blue-600 hover:text-blue-800">Lihat Jadwal &rarr;</a>
            </div>
        </div>

        <!-- Pengadaan Pending -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-yellow-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pengajuan Baru</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <h3 class="text-3xl font-bold text-yellow-600">{{ $pengadaanPending }}</h3>
                    <span class="text-sm text-gray-500">Permintaan</span>
                </div>
                <p class="text-xs text-gray-500 mt-2">Menunggu persetujuan Anda.</p>
                <a href="{{ route('barang.pengadaan.index') }}" class="inline-block mt-3 text-xs font-bold text-yellow-600 hover:text-yellow-800">Review Pengajuan &rarr;</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Activity Feed -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Aktivitas Terkini
            </h3>
            
            <div class="space-y-6">
                @forelse($recentActivities as $log)
                    <div class="flex gap-4 relative">
                        <!-- Connector Line -->
                        @if(!$loop->last)
                            <div class="absolute left-[19px] top-8 bottom-[-24px] w-0.5 bg-gray-100"></div>
                        @endif
                        
                        <!-- Icon -->
                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $log->jenis_transaksi == 'Masuk' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }} ring-4 ring-white z-10">
                            @if($log->jenis_transaksi == 'Masuk')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                            @endif
                        </div>

                        <div class="flex-1 pt-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-bold text-gray-900">
                                        {{ $log->jenis_transaksi }} - {{ $log->barang->nama_barang }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        Oleh: {{ $log->user->name ?? 'System' }} | {{ $log->keterangan }}
                                    </p>
                                </div>
                                <span class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="mt-2 inline-flex items-center px-2 py-1 bg-gray-50 rounded text-xs text-gray-600 font-mono">
                                Jml: {{ $log->jumlah }} | Sisa: {{ $log->stok_terakhir }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">Belum ada aktivitas.</div>
                @endforelse
            </div>
        </div>

        <!-- Right: Low Stock & Quick Links -->
        <div class="space-y-6">
            
            <!-- Low Stock Warning -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Stok Menipis (BHP)
                </h3>
                @if($lowStockItems->count() > 0)
                    <div class="space-y-3">
                        @foreach($lowStockItems as $item)
                            <div class="flex justify-between items-center p-3 bg-red-50 rounded-xl border border-red-100">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $item->nama_barang }}</p>
                                    <p class="text-xs text-red-600 font-semibold">Sisa: {{ $item->stok }} {{ $item->satuan }}</p>
                                </div>
                                <a href="{{ route('barang.show', $item->id) }}" class="text-xs bg-white text-red-600 px-2 py-1 rounded border border-red-200 hover:bg-red-50">Restock</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 bg-green-50 rounded-xl text-green-700 text-sm">
                        Stok barang aman terkendali.
                    </div>
                @endif
            </div>

            <!-- Quick Links -->
            <div class="bg-teal-700 rounded-2xl shadow-lg p-6 text-white">
                <h3 class="font-bold text-lg mb-4">Menu Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('barang.create') }}" class="bg-white/10 hover:bg-white/20 p-3 rounded-xl text-center backdrop-blur-sm transition-colors">
                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span class="text-xs font-semibold">Tambah Aset</span>
                    </a>
                    <a href="{{ route('barang.opname.create') }}" class="bg-white/10 hover:bg-white/20 p-3 rounded-xl text-center backdrop-blur-sm transition-colors">
                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span class="text-xs font-semibold">Stok Opname</span>
                    </a>
                    <a href="{{ route('barang.ruangan') }}" class="bg-white/10 hover:bg-white/20 p-3 rounded-xl text-center backdrop-blur-sm transition-colors">
                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span class="text-xs font-semibold">KIR Ruangan</span>
                    </a>
                    <a href="{{ route('barang.pengadaan.index') }}" class="bg-white/10 hover:bg-white/20 p-3 rounded-xl text-center backdrop-blur-sm transition-colors">
                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="text-xs font-semibold">Pengadaan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
