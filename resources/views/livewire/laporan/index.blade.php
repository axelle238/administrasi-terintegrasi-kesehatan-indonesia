<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                @foreach(['kunjungan' => 'Kunjungan Pasien', 'keuangan' => 'Pendapatan', 'obat' => 'Stok Obat', 'penyakit' => '10 Besar Penyakit'] as $key => $label)
                    <button wire:click="$set('tab', '{{ $key }}')"
                        class="{{ $tab == $key ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </div>

        <div class="p-6">
            <!-- Filter Date -->
            @if($tab != 'obat')
                <div class="flex flex-col md:flex-row gap-4 mb-6 items-end no-print">
                    <div>
                        <x-input-label value="Dari Tanggal" />
                        <x-text-input type="date" wire:model.live="startDate" class="block mt-1 w-full" />
                    </div>
                    <div>
                        <x-input-label value="Sampai Tanggal" />
                        <x-text-input type="date" wire:model.live="endDate" class="block mt-1 w-full" />
                    </div>
                    <button onclick="window.print()" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 h-10">
                        Cetak Laporan
                    </button>
                </div>
            @endif

            <!-- Content -->
            @if($tab == 'kunjungan')
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diagnosa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row->tanggal_periksa->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $row->pasien->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500">{{ $row->pasien->no_bpjs ? 'BPJS' : 'Umum' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row->dokter->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $row->diagnosa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @elseif($tab == 'keuangan')
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Transaksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Tagihan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $grandTotal = 0; @endphp
                            @foreach($data as $row)
                                @php $grandTotal += $row->total_tagihan; @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">{{ $row->no_transaksi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row->rekamMedis->pasien->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900">
                                        Rp {{ number_format($row->total_tagihan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="3" class="px-6 py-4 text-right">TOTAL PENDAPATAN</td>
                                <td class="px-6 py-4 text-right text-indigo-700">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            @elseif($tab == 'obat')
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Obat</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Sisa Stok</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">{{ $row->kode_obat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row->nama_obat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">{{ $row->stok }} {{ $row->satuan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($row->stok <= $row->min_stok)
                                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full font-bold">Menipis</span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aman</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @elseif($tab == 'penyakit')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diagnosa (ICD-10)</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Kasus</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($data as $row)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row->diagnosa }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-indigo-600">{{ $row->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Placeholder for Chart if needed -->
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 flex items-center justify-center">
                        <p class="text-gray-500 italic">Grafik Visualisasi Data Penyakit</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
