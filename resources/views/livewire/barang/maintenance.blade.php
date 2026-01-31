<div class="space-y-6 animate-fade-in">
    <!-- Header & Actions -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Jurnal Pemeliharaan Aset</h2>
            <p class="text-slate-500 font-medium">Rekam jejak servis, perbaikan, dan kalibrasi alat.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('barang.maintenance.create') }}" wire:navigate class="px-6 py-3 bg-amber-500 text-white rounded-2xl font-bold text-sm hover:bg-amber-600 hover:shadow-lg hover:shadow-amber-500/30 transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                Catat Maintenance Baru
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-2 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col lg:flex-row gap-2">
        <div class="relative w-full lg:w-96">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari aset, teknisi, atau keterangan..." class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-amber-500 transition-all">
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>
    </div>

    <!-- Timeline / List Style -->
    <div class="space-y-4">
        @forelse($maintenances as $item)
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:border-amber-200 transition-all group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50/50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            
            <div class="flex flex-col lg:flex-row gap-6 relative z-10">
                <!-- Date Badge -->
                <div class="flex flex-col items-center justify-center w-20 h-20 bg-slate-50 rounded-2xl border border-slate-100 shrink-0">
                    <span class="text-xs font-bold text-slate-400 uppercase">{{ $item->tanggal_maintenance->format('M') }}</span>
                    <span class="text-2xl font-black text-slate-800">{{ $item->tanggal_maintenance->format('d') }}</span>
                    <span class="text-xs font-bold text-slate-400">{{ $item->tanggal_maintenance->format('Y') }}</span>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $item->jenis_kegiatan == 'Kalibrasi' ? 'bg-blue-100 text-blue-700' : ($item->jenis_kegiatan == 'Perbaikan' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ $item->jenis_kegiatan }}
                        </span>
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                            {{ $item->barang->kode_barang }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-black text-slate-800 mb-1 group-hover:text-amber-600 transition-colors">
                        {{ $item->barang->nama_barang }}
                    </h3>
                    
                    <p class="text-slate-600 text-sm mb-4 line-clamp-2">
                        {{ $item->keterangan }}
                    </p>

                    <div class="flex flex-wrap items-center gap-6 text-xs font-bold text-slate-400 uppercase tracking-wide">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            {{ $item->teknisi ?? 'Internal' }}
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Rp {{ number_format($item->biaya) }}
                        </div>
                        @if($item->tanggal_berikutnya)
                        <div class="flex items-center gap-2 text-amber-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Next: {{ $item->tanggal_berikutnya->format('d M Y') }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col items-end justify-center gap-2 shrink-0">
                    @if($item->file_sertifikat)
                    <a href="{{ Storage::url($item->file_sertifikat) }}" target="_blank" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-bold text-xs hover:bg-blue-100 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Lihat Dokumen
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Belum Ada Data Maintenance</h3>
            <p class="text-slate-500 text-sm">Mulai catat aktivitas pemeliharaan aset Anda.</p>
        </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $maintenances->links() }}
    </div>
</div>