<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Manajemen Pemeliharaan & Kalibrasi</h2>
            <p class="text-sm text-slate-500">Jadwal servis rutin dan riwayat perbaikan aset medis/non-medis.</p>
        </div>
        <a href="{{ route('barang.maintenance.create') }}" wire:navigate class="px-6 py-2 bg-amber-500 text-white rounded-xl font-bold text-sm hover:bg-amber-600 flex items-center gap-2 shadow-lg shadow-amber-500/30 transition-all relative z-10">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Jadwal Servis Baru
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari aset atau teknisi..." class="w-full md:w-64 pl-4 pr-4 py-2 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-amber-500">
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-bold">Tanggal</th>
                        <th class="px-6 py-4 font-bold">Aset / Barang</th>
                        <th class="px-6 py-4 font-bold">Kegiatan</th>
                        <th class="px-6 py-4 font-bold">Teknisi</th>
                        <th class="px-6 py-4 font-bold text-right">Biaya</th>
                        <th class="px-6 py-4 font-bold text-center">Next</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($maintenances as $m)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-600">
                            {{ \Carbon\Carbon::parse($m->tanggal_maintenance)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $m->barang->nama_barang ?? '-' }}</div>
                            <div class="text-xs text-slate-400">{{ $m->barang->kode_barang ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-lg text-xs font-bold uppercase {{ $m->jenis_kegiatan == 'Perbaikan' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                {{ $m->jenis_kegiatan }}
                            </span>
                            <div class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $m->keterangan }}</div>
                            @if($m->file_sertifikat)
                                <a href="{{ Storage::url($m->file_sertifikat) }}" target="_blank" class="inline-flex items-center gap-1 text-[10px] font-bold text-teal-600 hover:underline mt-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                    Lihat Sertifikat
                                </a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $m->teknisi ?? '-' }}</td>
                        <td class="px-6 py-4 text-right font-mono">Rp {{ number_format($m->biaya, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($m->tanggal_berikutnya)
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs">
                                    {{ \Carbon\Carbon::parse($m->tanggal_berikutnya)->format('d M') }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada riwayat maintenance.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $maintenances->links() }}
        </div>
    </div>
</div>
