<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
    <!-- Mini Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-indigo-100 uppercase tracking-widest mb-1">Pasien Menunggu</p>
            <h3 class="text-4xl font-black">{{ $totalMenunggu }}</h3>
            <p class="text-[10px] mt-2 opacity-80">Antrean poli saat ini</p>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between group hover:border-emerald-200 transition-colors">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Selesai Hari Ini</p>
                <h3 class="text-3xl font-black text-emerald-600">{{ $totalSelesaiHariIni }}</h3>
            </div>
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $totalMenunggu > 0 ? ($totalSelesaiHariIni / ($totalMenunggu + $totalSelesaiHariIni)) * 100 : 0 }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm group hover:border-purple-200 transition-colors">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Ditangani (Bulan Ini)</p>
            <h3 class="text-3xl font-black text-purple-600">{{ $totalDitanganiBulanIni }}</h3>
            <p class="text-xs text-slate-500 mt-2 font-medium">Akumulasi kinerja Anda</p>
        </div>
    </div>

    <!-- Queue Section -->
    <div class="space-y-4" wire:poll.10s>
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <span class="w-1.5 h-6 bg-indigo-500 rounded-full"></span>
                Antrean Pasien (Realtime)
            </h3>
            <span class="text-xs font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full animate-pulse">● Live Update</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($antreanMenunggu as $antrean)
                <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-all relative overflow-hidden group {{ $antrean->status == 'Diperiksa' ? 'ring-2 ring-indigo-500' : '' }}">
                    @if($antrean->status == 'Diperiksa')
                        <div class="absolute top-0 right-0 bg-indigo-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl">SEDANG DIPERIKSA</div>
                    @endif
                    
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-4xl font-black text-slate-800 tracking-tighter">{{ $antrean->nomor_antrean }}</span>
                        <div class="text-right">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Jam Masuk</span>
                            <span class="text-xs font-mono text-slate-600">{{ \Carbon\Carbon::parse($antrean->created_at)->format('H:i') }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="text-lg font-bold text-gray-900 line-clamp-1">{{ $antrean->pasien->nama_lengkap }}</h4>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-slate-500 bg-slate-100 px-2 py-0.5 rounded">{{ $antrean->pasien->no_rm }}</span>
                            <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($antrean->pasien->tanggal_lahir)->age }} Thn</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-50">
                        @if($antrean->status == 'Diperiksa' && $antrean->dokter_id != Auth::id())
                            <button disabled class="w-full py-2.5 bg-slate-100 text-slate-400 font-bold text-xs rounded-xl cursor-not-allowed">
                                Diperiksa Dokter Lain
                            </button>
                        @else
                            <a href="{{ route('rekam-medis.create', ['antrean_id' => $antrean->id]) }}" wire:navigate class="flex items-center justify-center w-full py-2.5 bg-indigo-600 text-white font-bold text-xs rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20 group-hover:scale-[1.02] transform duration-200">
                                {{ $antrean->status == 'Diperiksa' ? 'Lanjutkan Pemeriksaan' : 'Mulai Periksa' }} &rarr;
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h3 class="text-slate-900 font-bold mb-1">Tidak Ada Antrean</h3>
                    <p class="text-slate-500 text-sm">Belum ada pasien yang menunggu di poli Anda saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- History Section -->
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">Riwayat Pemeriksaan Terakhir</h3>
            <a href="#" class="text-xs font-bold text-indigo-600 hover:underline">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Diagnosa Utama</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 bg-white">
                    @forelse ($history as $rekam)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 font-mono">
                                {{ \Carbon\Carbon::parse($rekam->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $rekam->pasien->nama_lengkap }}</div>
                                <div class="text-xs text-slate-500">{{ $rekam->pasien->no_rm }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 font-medium truncate max-w-xs">
                                {{ $rekam->diagnosa }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-bold">Selesai</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-400 italic">
                                Belum ada riwayat pemeriksaan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $history->links() }}
        </div>
    </div>
</div>
