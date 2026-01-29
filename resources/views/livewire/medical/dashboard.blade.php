<div class="space-y-6">
    <!-- Header Stats (Always Visible) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Kunjungan Hari Ini -->
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-6 rounded-3xl text-white shadow-xl shadow-blue-500/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-blue-100 uppercase tracking-widest mb-1">Kunjungan Hari Ini</p>
            <h3 class="text-3xl font-black">{{ $totalKunjunganHariIni }}</h3>
            <div class="mt-4 flex items-center gap-2">
                <span class="text-[10px] bg-blue-500/30 px-2 py-0.5 rounded font-bold">+{{ $totalKunjunganBulanIni }} Bulan Ini</span>
            </div>
        </div>

        <!-- BOR -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Okupansi Bed (BOR)</p>
            <h3 class="text-3xl font-black {{ $bor > 80 ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">{{ number_format($bor, 1) }}%</h3>
            <div class="mt-4 w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                <div class="{{ $bor > 80 ? 'bg-red-500' : 'bg-purple-500' }} h-full rounded-full transition-all duration-500" style="width: {{ $bor }}%"></div>
            </div>
            <p class="text-[10px] text-gray-500 mt-2 font-medium">{{ $bedTerisi }} Terisi dari {{ $totalBed }} Bed</p>
        </div>

        <!-- Waktu Layanan -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Avg. Waktu Layanan</p>
            <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($avgWaktuLayanan, 0) }} <span class="text-sm font-bold text-gray-400">Menit</span></h3>
            <p class="mt-4 text-[10px] text-gray-500 font-medium">Per pasien hari ini</p>
        </div>

        <!-- Indikator Efisiensi -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Efisiensi Poli</p>
            <div class="flex items-center gap-2 mt-1">
                <h3 class="text-3xl font-black text-emerald-600">92%</h3>
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
            <p class="mt-4 text-[10px] text-gray-500 font-medium">Target tercapai</p>
        </div>
    </div>

    <!-- Tabbed Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="border-b border-gray-100 dark:border-gray-700 px-6 pt-4 flex gap-8 overflow-x-auto">
            <button wire:click="setTab('ringkasan')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'ringkasan' ? 'text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
                Ringkasan Operasional
                @if($activeTab == 'ringkasan') <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('demografi')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'demografi' ? 'text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
                Demografi Pasien
                @if($activeTab == 'demografi') <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('klinis')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'klinis' ? 'text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
                Data Klinis & Penyakit
                @if($activeTab == 'klinis') <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('rawat_inap')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'rawat_inap' ? 'text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">
                Monitoring Rawat Inap
                @if($activeTab == 'rawat_inap') <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-600 rounded-t-full"></div> @endif
            </button>
        </div>

        <div class="p-8 min-h-[400px]">
            <!-- TAB 1: RINGKASAN -->
            @if($activeTab == 'ringkasan')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up">
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tren Kunjungan Pasien (7 Hari)</h4>
                            <div class="h-64 flex items-end justify-between gap-2">
                                @foreach($tabData['trenKunjungan']['data'] as $index => $val)
                                    <div class="flex flex-col items-center flex-1 group h-full justify-end">
                                        <div class="w-full bg-blue-500 rounded-t-lg relative transition-all duration-300 hover:bg-blue-600" 
                                             style="height: {{ $val > 0 ? ($val / (max($tabData['trenKunjungan']['data']) ?: 1) * 100) : 0 }}%">
                                             <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">{{ $val }}</span>
                                        </div>
                                        <span class="text-[10px] font-bold text-gray-400 mt-2">{{ $tabData['trenKunjungan']['labels'][$index] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800">
                                <p class="text-xs font-bold text-emerald-600 mb-1">Pasien Baru (Bulan Ini)</p>
                                <h4 class="text-2xl font-black text-emerald-700 dark:text-emerald-400">{{ $tabData['pasienBaru'] }}</h4>
                            </div>
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-100 dark:border-blue-800">
                                <p class="text-xs font-bold text-blue-600 mb-1">Pasien Lama (Kunjungan Ulang)</p>
                                <h4 class="text-2xl font-black text-blue-700 dark:text-blue-400">{{ $tabData['pasienLama'] }}</h4>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Aktivitas Poli Hari Ini</h4>
                        <div class="space-y-3">
                            @forelse($tabData['poliActivity'] as $poli)
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 transition-colors">
                                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $poli->poli->nama_poli }}</span>
                                    <span class="px-3 py-1 bg-white dark:bg-gray-600 rounded-lg text-xs font-black shadow-sm">{{ $poli->total }}</span>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-400 text-sm">Belum ada antrean poli hari ini.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 2: DEMOGRAFI -->
            @if($activeTab == 'demografi')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-fade-in-up">
                    <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Distribusi Gender Pasien</h4>
                        <div class="space-y-4">
                            @foreach($tabData['genderStats'] as $stat)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-bold text-gray-600 dark:text-gray-300">{{ $stat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        <span class="font-black">{{ $stat->total }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 h-2 rounded-full overflow-hidden">
                                        <div class="{{ $stat->jenis_kelamin == 'L' ? 'bg-blue-500' : 'bg-pink-500' }} h-full rounded-full" style="width: 70%"></div>
                                    </div>
                                </div>
                            @endforeach
                            @if($tabData['genderStats']->isEmpty())
                                <p class="text-gray-400 text-sm">Data tidak tersedia.</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Jenis Penjaminan (Bulan Ini)</h4>
                        <div class="space-y-4">
                            @foreach($tabData['distribusiPembayaran'] as $dist)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-3 h-3 rounded-full {{ $dist->asuransi == 'BPJS' ? 'bg-green-500' : 'bg-orange-500' }}"></div>
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $dist->asuransi ?? 'Umum/Mandiri' }}</span>
                                    </div>
                                    <span class="text-sm font-black">{{ $dist->total }}</span>
                                </div>
                            @endforeach
                            @if($tabData['distribusiPembayaran']->isEmpty())
                                <p class="text-gray-400 text-sm">Data tidak tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 3: KLINIS -->
            @if($activeTab == 'klinis')
                <div class="space-y-6 animate-fade-in-up">
                    <div class="flex justify-between items-center">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">10 Besar Penyakit (ICD-10) Bulan Ini</h4>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Berdasarkan Rekam Medis</span>
                    </div>

                    <div class="overflow-hidden rounded-xl border border-gray-100 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Diagnosa</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Kasus</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Persentase</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @php $totalKasus = $tabData['topDiagnosa']->sum('total'); @endphp
                                @forelse($tabData['topDiagnosa'] as $index => $diag)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $diag->diagnosa }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-black text-gray-900 dark:text-white">
                                            {{ $diag->total }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap align-middle">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-gray-100 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden w-24">
                                                    <div class="bg-red-500 h-full rounded-full" style="width: {{ ($diag->total / max($totalKasus, 1)) * 100 }}%"></div>
                                                </div>
                                                <span class="text-xs text-gray-500 font-medium">{{ number_format(($diag->total / max($totalKasus, 1)) * 100, 1) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada data diagnosa bulan ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- TAB 4: RAWAT INAP -->
            @if($activeTab == 'rawat_inap')
                <div class="animate-fade-in-up">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Status Kamar Rawat Inap</h4>
                        <div class="flex gap-2 text-xs font-bold">
                            <span class="flex items-center gap-1 text-emerald-600"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Tersedia</span>
                            <span class="flex items-center gap-1 text-red-600"><span class="w-2 h-2 rounded-full bg-red-500"></span> Penuh</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($tabData['kamars'] as $kamar)
                            @php
                                $isFull = $kamar->bed_terisi >= $kamar->kapasitas_bed;
                                $occupancy = ($kamar->bed_terisi / max($kamar->kapasitas_bed, 1)) * 100;
                            @endphp
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border {{ $isFull ? 'border-red-200 dark:border-red-900/50' : 'border-emerald-200 dark:border-emerald-900/50' }} p-5 shadow-sm relative overflow-hidden group">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $kamar->kelas }}</p>
                                        <h5 class="text-lg font-black text-gray-900 dark:text-white truncate" title="{{ $kamar->nama_kamar }}">{{ $kamar->nama_kamar }}</h5>
                                    </div>
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $isFull ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-bold">
                                        <span class="{{ $isFull ? 'text-red-600' : 'text-emerald-600' }}">
                                            {{ $isFull ? 'PENUH' : 'TERSEDIA' }}
                                        </span>
                                        <span class="text-gray-500">{{ $kamar->bed_terisi }} / {{ $kamar->kapasitas_bed }}</span>
                                    </div>
                                    <div class="w-full bg-gray-100 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                                        <div class="{{ $isFull ? 'bg-red-500' : 'bg-emerald-500' }} h-full rounded-full" style="width: {{ $occupancy }}%"></div>
                                    </div>
                                    <p class="text-[10px] text-gray-400">Tarif: Rp {{ number_format($kamar->tarif_per_malam, 0, ',', '.') }}/malam</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center border border-dashed border-gray-200 rounded-2xl text-gray-400">
                                Belum ada data kamar rawat inap.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
