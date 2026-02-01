<div class="space-y-6">
    
    <!-- Header Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-blue-200 transition-colors">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kunjungan Hari Ini</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $totalKunjunganHariIni }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition-colors">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">BOR (Okupansi)</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($bor, 1) }}%</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-purple-200 transition-colors">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rata-rata Waktu</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($avgWaktuLayanan, 0) }} <span class="text-sm font-medium text-slate-400">Min</span></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-rose-200 transition-colors">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Bulan Ini</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $totalKunjunganBulanIni }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
        </div>
    </div>

    <!-- Indikator Mutu Nasional (INM) - NEW -->
    <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
            <div class="max-w-md">
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-2 py-1 rounded bg-blue-500 text-[10px] font-black uppercase tracking-wider">INM</span>
                    <span class="text-xs font-bold text-blue-300 uppercase tracking-widest">Indikator Mutu Nasional</span>
                </div>
                <h3 class="text-2xl font-black mb-2">Kualitas Pelayanan Klinis</h3>
                <p class="text-sm text-slate-400 font-medium leading-relaxed">Monitoring standar pelayanan berdasarkan parameter Keputusan Menteri Kesehatan RI.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 w-full lg:w-auto">
                <div class="text-center">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Identifikasi</p>
                    <div class="text-2xl font-black text-emerald-400">{{ $inm['identifikasi_pasien'] }}%</div>
                    <div class="w-16 h-1 bg-slate-800 mx-auto mt-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full" style="width: {{ $inm['identifikasi_pasien'] }}%"></div>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Kebersihan</p>
                    <div class="text-2xl font-black text-blue-400">{{ $inm['kebersihan_tangan'] }}%</div>
                    <div class="w-16 h-1 bg-slate-800 mx-auto mt-2 rounded-full overflow-hidden">
                        <div class="bg-blue-500 h-full" style="width: {{ $inm['kebersihan_tangan'] }}%"></div>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Kepuasan</p>
                    <div class="text-2xl font-black text-amber-400">{{ $inm['kepuasan_pasien'] }}%</div>
                    <div class="w-16 h-1 bg-slate-800 mx-auto mt-2 rounded-full overflow-hidden">
                        <div class="bg-amber-500 h-full" style="width: {{ $inm['kepuasan_pasien'] }}%"></div>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Wkt Tunggu</p>
                    <div class="text-2xl font-black text-rose-400">{{ $inm['waktu_tunggu_rawat_jalan'] }}<span class="text-xs">m</span></div>
                    <div class="w-16 h-1 bg-slate-800 mx-auto mt-2 rounded-full overflow-hidden">
                        <div class="bg-rose-500 h-full" style="width: {{ (45/60)*100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="border-b border-slate-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button wire:click="aturTab('ringkasan')" class="{{ $tabAktif === 'ringkasan' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                Ringkasan Operasional
            </button>
            <button wire:click="aturTab('demografi')" class="{{ $tabAktif === 'demografi' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                Demografi Pasien
            </button>
            <button wire:click="aturTab('klinis')" class="{{ $tabAktif === 'klinis' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                Data Klinis
            </button>
            <button wire:click="aturTab('rawat_inap')" class="{{ $tabAktif === 'rawat_inap' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                Monitoring Rawat Inap
            </button>
        </nav>
    </div>

    <!-- Tab Contents -->
    <div class="mt-6">
        
        <!-- 1. RINGKASAN -->
        @if($tabAktif === 'ringkasan')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in-up">
            <!-- Tren Chart -->
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100" x-data="chartTrenMedis()">
                <h4 class="font-bold text-slate-800 mb-4">Tren Kunjungan 7 Hari Terakhir</h4>
                <div id="chart-tren-medis" class="w-full h-[300px]"></div>
            </div>

            <!-- Aktivitas Poli & Monitor Live -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Monitor Antrean Live -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-bold text-slate-800">Monitor Antrean Live</h4>
                        <span class="px-2 py-1 rounded text-[10px] font-bold bg-green-100 text-green-700 animate-pulse">LIVE</span>
                    </div>
                    <div class="space-y-3 max-h-[400px] overflow-y-auto custom-scrollbar">
                        @forelse($dataTab['antreanLive'] ?? [] as $live)
                        <div class="p-4 rounded-xl border {{ $live['status_poli'] == 'Aktif' ? 'bg-blue-50 border-blue-100' : 'bg-slate-50 border-slate-100 opacity-70' }}">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-sm font-bold text-slate-700">{{ $live['nama_poli'] }}</span>
                                <span class="text-[10px] font-bold uppercase {{ $live['status_poli'] == 'Aktif' ? 'text-blue-600' : 'text-slate-400' }}">{{ $live['status_poli'] }}</span>
                            </div>
                            
                            @if($live['status_poli'] == 'Aktif')
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-[10px] text-slate-500 uppercase">Sedang Dilayani</p>
                                    <p class="text-lg font-black text-slate-800 leading-none mt-1">{{ $live['sedang_dilayani_nomor'] }}</p>
                                    <p class="text-xs font-medium text-slate-600 truncate max-w-[120px]">{{ $live['sedang_dilayani_nama'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-slate-500 uppercase">Menunggu</p>
                                    <p class="text-lg font-black text-orange-500 leading-none mt-1">{{ $live['menunggu'] }}</p>
                                    <p class="text-[10px] text-slate-400">Pasien</p>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-2 text-xs text-slate-400">
                                Tidak ada aktivitas antrean saat ini.
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-8 text-slate-400 text-sm">
                            Belum ada data antrean hari ini.
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Aktivitas Poli Summary (Small) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                     <div class="flex items-center justify-between mb-4">
                        <h4 class="font-bold text-slate-800">Ringkasan Operasional</h4>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Bulan Berjalan</span>
                     </div>
                     <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                            <span class="text-xs font-bold text-slate-600 uppercase">Total Rujukan</span>
                            <span class="font-black text-rose-600">{{ $dataTab['statistikRujukan'] ?? 0 }}</span>
                        </div>
                        <div class="space-y-2">
                            @foreach($dataTab['poliActivity'] ?? [] as $poli)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600 font-medium">{{ $poli->poli->nama_poli ?? 'N/A' }}</span>
                                <span class="font-black text-slate-800">{{ $poli->total }}</span>
                            </div>
                            @endforeach
                        </div>
                     </div>
                </div>
            </div>

            <!-- Dokter Jaga Hari Ini (NEW) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h4 class="font-bold text-slate-800 mb-4">Dokter Bertugas Hari Ini</h4>
                <div class="space-y-3 max-h-[300px] overflow-y-auto custom-scrollbar">
                    @forelse($dataTab['jadwalDokter'] ?? [] as $jadwal)
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-transparent hover:border-blue-100 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-blue-600 font-bold text-xs shadow-sm">
                            {{ substr($jadwal->pegawai->nama ?? 'Dr', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ $jadwal->pegawai->nama ?? '-' }}</p>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span class="bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded-[4px] font-bold text-[10px] uppercase">{{ $jadwal->poli->nama_poli ?? 'Umum' }}</span>
                                <span>{{ $jadwal->shift->nama_shift ?? 'Shift' }} ({{ \Carbon\Carbon::parse($jadwal->shift->jam_masuk ?? '00:00')->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->shift->jam_keluar ?? '00:00')->format('H:i') }})</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-slate-400 text-sm">
                        Tidak ada jadwal dokter hari ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

        <!-- 2. DEMOGRAFI -->
        @if($tabAktif === 'demografi')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-in-up">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h4 class="font-bold text-slate-800 mb-6">Distribusi Pembayaran / Asuransi</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">Jenis Pembayaran</th>
                                <th class="px-4 py-3 text-right rounded-r-lg">Jumlah Pasien</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($dataTab['distribusiPembayaran'] ?? [] as $item)
                            <tr>
                                <td class="px-4 py-3 font-bold text-slate-700">{{ $item->asuransi ?? 'Umum/Mandiri' }}</td>
                                <td class="px-4 py-3 text-right">{{ $item->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100" x-data="chartGender()">
                <h4 class="font-bold text-slate-800 mb-4">Rasio Gender Pasien</h4>
                <div id="chart-gender" class="w-full h-[300px] flex justify-center"></div>
            </div>
        </div>
        @endif

        <!-- 3. KLINIS -->
        @if($tabAktif === 'klinis')
        <div class="space-y-6 animate-fade-in-up">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Top 10 Diagnosa -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-slate-800 mb-6 uppercase tracking-wider text-xs">Top 10 Diagnosa Penyakit (Bulan Ini)</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black">
                                <tr>
                                    <th class="px-6 py-4 rounded-l-lg">No</th>
                                    <th class="px-6 py-4">Diagnosa (ICD-10)</th>
                                    <th class="px-6 py-4 text-right">Kasus</th>
                                    <th class="px-6 py-4 rounded-r-lg text-right">%</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @php $totalKasus = collect($dataTab['topDiagnosa'] ?? [])->sum('total'); @endphp
                                @foreach($dataTab['topDiagnosa'] ?? [] as $index => $diag)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-400">#{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-700">{{ $diag->diagnosa }}</td>
                                    <td class="px-6 py-4 text-right font-black text-slate-800">{{ $diag->total }}</td>
                                    <td class="px-6 py-4 text-right text-slate-500">
                                        {{ $totalKasus > 0 ? round(($diag->total / $totalKasus) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Surveilans P2P -->
                <div class="bg-rose-900 rounded-[2rem] p-8 text-white relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                    <div>
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-2 bg-rose-500/20 rounded-lg text-rose-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <span class="text-xs font-black uppercase tracking-[0.2em] text-rose-300">Surveilans P2P</span>
                        </div>
                        <h3 class="text-2xl font-black mb-2 leading-tight">Penyakit Menular</h3>
                        <p class="text-xs text-rose-200 font-medium opacity-70">Pemantauan kasus penyakit berpotensi wabah di wilayah kerja.</p>
                    </div>
                    
                    <div class="mt-8">
                        <div class="text-5xl font-black text-white mb-2">{{ $dataTab['kasusMenular'] ?? 0 }}</div>
                        <p class="text-[10px] font-bold text-rose-300 uppercase tracking-widest">Kasus Terdeteksi Bulan Ini</p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10">
                        <a href="{{ route('medical.penyakit.index') }}" class="text-xs font-bold text-white flex items-center justify-between group">
                            Analisis Lengkap <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- 4. RAWAT INAP -->
        @if($tabAktif === 'rawat_inap')
        <div class="mb-6 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 animate-fade-in-up">
            <h4 class="font-bold text-slate-800 mb-4">Okupansi Bed per Bangsal (BOR)</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($dataTab['borPerBangsal'] ?? [] as $bangsal)
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold text-slate-700">{{ $bangsal->nama_bangsal ?? 'Umum' }}</span>
                        <span class="text-xs font-bold px-2 py-1 rounded {{ $bangsal->persentase >= 85 ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                            {{ number_format($bangsal->persentase, 1) }}%
                        </span>
                    </div>
                    <div class="w-full bg-white rounded-full h-2 mb-2">
                        <div class="h-2 rounded-full {{ $bangsal->persentase >= 85 ? 'bg-red-500' : 'bg-blue-500' }}" style="width: {{ $bangsal->persentase }}%"></div>
                    </div>
                    <p class="text-xs text-slate-500 text-right">{{ $bangsal->terisi }} / {{ $bangsal->kapasitas }} Bed Terisi</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in-up">
            @foreach($dataTab['kamars'] ?? [] as $kamar)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="font-bold text-lg text-slate-800">{{ $kamar->nama_kamar }}</h4>
                        <p class="text-xs font-bold text-slate-400 uppercase">{{ $kamar->nama_bangsal ?? 'Umum' }} • Kelas {{ $kamar->kelas ?? '-' }}</p>
                    </div>
                    <div class="px-2 py-1 rounded text-xs font-bold {{ $kamar->status == 'Tersedia' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ $kamar->status }}
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Kapasitas</span>
                        <span class="font-bold">{{ $kamar->kapasitas_bed }} Bed</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Terisi</span>
                        <span class="font-bold {{ $kamar->bed_terisi >= $kamar->kapasitas_bed ? 'text-red-600' : 'text-slate-800' }}">{{ $kamar->bed_terisi }} Bed</span>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-100 rounded-full h-2 mt-2">
                        @php $persen = $kamar->kapasitas_bed > 0 ? ($kamar->bed_terisi / $kamar->kapasitas_bed) * 100 : 0; @endphp
                        <div class="h-2 rounded-full {{ $persen >= 100 ? 'bg-red-500' : ($persen >= 80 ? 'bg-orange-500' : 'bg-emerald-500') }}" style="width: {{ $persen }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>

    <!-- Scripts for Charts -->
    @push('scripts')
    <script>
        function chartTrenMedis() {
            return {
                init() {
                    const data = @json($dataTab['trenKunjungan'] ?? ['labels' => [], 'data' => []]);
                    const options = {
                        series: [{ name: 'Kunjungan', data: data.data }],
                        chart: { type: 'area', height: 300, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans' },
                        stroke: { curve: 'smooth', width: 2 },
                        colors: ['#06b6d4'],
                        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.1, stops: [0, 90, 100] } },
                        xaxis: { categories: data.labels, axisBorder: { show: false }, axisTicks: { show: false } },
                        dataLabels: { enabled: false }
                    };
                    new ApexCharts(document.querySelector("#chart-tren-medis"), options).render();
                }
            }
        }

        function chartGender() {
            return {
                init() {
                    const genderData = @json($dataTab['genderStats'] ?? []);
                    const labels = genderData.map(item => item.jenis_kelamin);
                    const series = genderData.map(item => item.total);
                    
                    const options = {
                        series: series,
                        labels: labels,
                        chart: { type: 'donut', height: 300, fontFamily: 'Plus Jakarta Sans' },
                        colors: ['#3b82f6', '#ec4899'], // Blue for Male, Pink for Female usually
                        legend: { position: 'bottom' },
                        dataLabels: { enabled: true }
                    };
                    if(series.length > 0) {
                        new ApexCharts(document.querySelector("#chart-gender"), options).render();
                    } else {
                        document.querySelector("#chart-gender").innerHTML = '<p class="text-center text-slate-400 pt-10">Tidak ada data.</p>';
                    }
                }
            }
        }
    </script>
    @endpush
</div>