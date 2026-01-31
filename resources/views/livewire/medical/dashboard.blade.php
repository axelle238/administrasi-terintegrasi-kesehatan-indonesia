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

            <!-- Aktivitas Poli -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h4 class="font-bold text-slate-800 mb-4">Aktivitas Poliklinik</h4>
                <div class="space-y-4 max-h-[300px] overflow-y-auto custom-scrollbar">
                    @foreach($dataTab['poliActivity'] ?? [] as $poli)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <span class="text-sm font-medium text-slate-700">{{ $poli->poli->nama_poli ?? 'N/A' }}</span>
                        <span class="text-xs font-black bg-white px-2 py-1 rounded shadow-sm text-slate-800">{{ $poli->total }}</span>
                    </div>
                    @endforeach
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
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 animate-fade-in-up">
            <h4 class="font-bold text-slate-800 mb-6">Top 10 Diagnosa Penyakit (Bulan Ini)</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4 rounded-l-lg">No</th>
                            <th class="px-6 py-4">Kode ICD-10 / Diagnosa</th>
                            <th class="px-6 py-4 text-right">Frekuensi Kasus</th>
                            <th class="px-6 py-4 rounded-r-lg text-right">Persentase</th>
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
        @endif

        <!-- 4. RAWAT INAP -->
        @if($tabAktif === 'rawat_inap')
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