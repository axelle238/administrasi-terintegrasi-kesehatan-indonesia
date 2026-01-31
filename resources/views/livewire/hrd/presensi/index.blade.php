<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Hadir</p>
                <h3 class="text-3xl font-black text-emerald-600">{{ $stats['Hadir'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Terlambat</p>
                <h3 class="text-3xl font-black text-rose-600">{{ $stats['Terlambat'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Dinas Luar</p>
                <h3 class="text-3xl font-black text-amber-600">{{ $stats['Dinas'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-sm font-bold text-slate-600">Tanggal:</span>
            <input type="date" wire:model.live="tanggal" class="rounded-xl border-slate-200 font-bold text-sm">
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm font-bold text-slate-600">Status:</span>
            <select wire:model.live="filterStatus" class="rounded-xl border-slate-200 font-bold text-sm bg-slate-50">
                <option value="">Semua</option>
                <option value="Hadir">Hadir</option>
                <option value="Terlambat">Terlambat</option>
                <option value="Alpa">Alpa</option>
            </select>
        </div>
    </div>

    <!-- List -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-400 font-black uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4">Pegawai</th>
                    <th class="px-6 py-4">Jam Masuk</th>
                    <th class="px-6 py-4">Jam Keluar</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Lokasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($presensis as $p)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-600">
                                {{ substr($p->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $p->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $p->user->pegawai->jabatan ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-mono font-bold text-slate-700">
                        {{ \Carbon\Carbon::parse($p->jam_masuk)->format('H:i') }}
                    </td>
                    <td class="px-6 py-4 font-mono font-bold text-slate-700">
                        {{ $p->jam_keluar ? \Carbon\Carbon::parse($p->jam_keluar)->format('H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-[10px] font-black uppercase tracking-wider
                            {{ $p->status_kehadiran == 'Terlambat' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                            {{ $p->status_kehadiran }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($p->lokasi_masuk)
                        <a href="https://maps.google.com/?q={{ $p->lokasi_masuk }}" target="_blank" class="text-blue-500 hover:underline text-xs font-bold">
                            Lihat Peta
                        </a>
                        @else
                        <span class="text-slate-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-slate-400 font-bold">Tidak ada data presensi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-6 border-t border-slate-100">
            {{ $presensis->links() }}
        </div>
    </div>
</div>
