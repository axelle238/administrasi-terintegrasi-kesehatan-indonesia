<div class="space-y-8">
    <!-- Header Controls -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-end md:items-center gap-4">
        
        <!-- Tabs Navigasi Laporan -->
        <div class="flex flex-wrap gap-2 w-full md:w-auto">
            @foreach(['kunjungan' => 'Kunjungan', 'keuangan' => 'Keuangan', 'obat' => 'Farmasi', 'penyakit' => 'Penyakit', 'sdm' => 'Kinerja SDM', 'aset' => 'Aset', 'layanan' => 'Layanan'] as $key => $label)
                <button 
                    wire:click="$set('tab', '{{ $key }}')"
                    class="px-4 py-2 text-sm font-bold rounded-xl transition-all {{ $tab === $key ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-300' }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <!-- Date Filter -->
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <div class="flex items-center gap-2 bg-slate-50 dark:bg-slate-700 p-2 rounded-xl border border-slate-200 dark:border-gray-600">
                <input type="date" wire:model.live="startDate" class="bg-transparent border-none text-sm font-bold text-slate-700 dark:text-white focus:ring-0 p-0">
                <span class="text-slate-400">-</span>
                <input type="date" wire:model.live="endDate" class="bg-transparent border-none text-sm font-bold text-slate-700 dark:text-white focus:ring-0 p-0">
            </div>
            <button class="px-4 py-2 bg-emerald-600 text-white font-bold text-sm rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Export
            </button>
        </div>
    </div>

    <!-- Summary Cards (Dynamic) -->
    @if(!empty($summary))
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($summary as $key => $val)
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">{{ str_replace('_', ' ', $key) }}</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white">
                    {{ is_numeric($val) && $val > 1000 && strpos($key, 'rata') === false && strpos($key, 'skor') === false ? number_format($val, 0, ',', '.') : $val }}
                    @if(strpos($key, 'pendapatan') !== false || strpos($key, 'nilai') !== false)
                        <span class="text-xs text-slate-400 font-normal">IDR</span>
                    @endif
                </h3>
            </div>
        @endforeach
    </div>
    @endif

    <!-- Data Table Area -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 overflow-hidden">
        
        <!-- Tabel Kunjungan -->
        @if($tab == 'kunjungan')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-gray-700">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Poli</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Diagnosa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Dokter</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                        @forelse($data as $row)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($row->tanggal_periksa)->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                    <div class="font-bold">{{ $row->pasien->nama_lengkap }}</div>
                                    <div class="text-xs">{{ $row->pasien->no_rm }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $row->poli->nama_poli ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300 truncate max-w-xs">{{ $row->diagnosa }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $row->dokter->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">Tidak ada data kunjungan pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        
        <!-- Tabel Keuangan -->
        @elseif($tab == 'keuangan')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-gray-700">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No. Transaksi</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Metode</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                        @forelse($data as $row)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $row->no_transaksi }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-slate-800 dark:text-white">{{ $row->rekamMedis->pasien->nama_lengkap ?? 'Umum' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <span class="px-2 py-1 rounded text-xs font-bold {{ $row->metode_pembayaran == 'BPJS' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $row->metode_pembayaran }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-black text-right text-slate-800 dark:text-white">Rp {{ number_format($row->jumlah_bayar, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">Tidak ada data transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        <!-- Tabel Obat -->
        @elseif($tab == 'obat')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 lg:gap-px bg-slate-200">
                <div class="bg-white dark:bg-gray-800">
                    <div class="p-4 bg-slate-50 font-bold text-slate-700 border-b">Stok Menipis / Habis</div>
                    <table class="min-w-full">
                        <tbody class="divide-y divide-slate-100">
                            @foreach($data['stok']->where('stok', '<=', 10)->take(10) as $obat)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $obat->nama_obat }}</td>
                                    <td class="px-4 py-3 text-sm font-black text-red-600 text-right">{{ $obat->stok }} {{ $obat->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-white dark:bg-gray-800">
                    <div class="p-4 bg-slate-50 font-bold text-slate-700 border-b">Segera Kedaluwarsa</div>
                    <table class="min-w-full">
                        <tbody class="divide-y divide-slate-100">
                            @foreach($data['expired']->take(10) as $obat)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $obat->nama_obat }}</td>
                                    <td class="px-4 py-3 text-sm font-bold text-orange-600 text-right">{{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        <!-- Tabel Penyakit -->
        @elseif($tab == 'penyakit')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-gray-700">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Diagnosa (ICD-10)</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah Kasus</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                        @php $total = $data->sum('total'); @endphp
                        @forelse($data as $row)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                <td class="px-6 py-4 text-sm font-bold text-slate-800 dark:text-white">{{ $row->diagnosa }}</td>
                                <td class="px-6 py-4 text-sm font-mono text-right text-slate-600">{{ $row->total }}</td>
                                <td class="px-6 py-4 text-sm text-right text-slate-600">
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="w-24 bg-slate-100 rounded-full h-1.5">
                                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ ($row->total / $total) * 100 }}%"></div>
                                        </div>
                                        <span>{{ number_format(($row->total / $total) * 100, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-12 text-center text-slate-400">Tidak ada data penyakit.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        <!-- Tabel SDM -->
        @elseif($tab == 'sdm')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-gray-700">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pegawai</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Skor Kinerja</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                        @forelse($data as $row)
                            @php $totalSkor = $row->orientasi_pelayanan + $row->integritas + $row->komitmen + $row->disiplin + $row->kerjasama; @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                <td class="px-6 py-4 text-sm font-bold text-slate-800 dark:text-white">{{ $row->pegawai->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ \Carbon\Carbon::create()->month($row->bulan)->format('F') }} {{ $row->tahun }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="px-2 py-1 rounded text-xs font-black {{ $totalSkor >= 90 ? 'bg-green-100 text-green-700' : ($totalSkor >= 70 ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $totalSkor }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-12 text-center text-slate-400">Tidak ada data kinerja.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        <!-- Tabel Layanan -->
        @elseif($tab == 'layanan')
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-gray-700">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Poli</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Masuk Antrian</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Selesai</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Durasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                        @forelse($data as $row)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                <td class="px-6 py-4 text-sm font-bold text-slate-800 dark:text-white">{{ $row->pasien->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $row->poli->nama_poli }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $row->created_at->format('H:i') }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $row->updated_at->format('H:i') }}</td>
                                <td class="px-6 py-4 text-right text-sm font-mono font-bold text-blue-600">{{ $row->durasi_layanan }} Menit</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">Tidak ada data layanan selesai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>