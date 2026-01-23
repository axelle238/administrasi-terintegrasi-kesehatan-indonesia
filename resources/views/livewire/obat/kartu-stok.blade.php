<div class="space-y-6">
    <!-- Header & Filter -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-800">{{ $obat->nama_obat }} ({{ $obat->satuan }})</h2>
            <p class="text-sm text-gray-500">Kode: {{ $obat->kode_obat }} | Stok Saat Ini: <span class="font-bold text-teal-600">{{ $obat->stok }}</span></p>
        </div>
        
        <div class="flex gap-2">
            <select wire:model.live="bulan" class="rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
                @for($i=1; $i<=12; $i++)
                    <option value="{{ sprintf('%02d', $i) }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                @endfor
            </select>
            <select wire:model.live="tahun" class="rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
                @for($i=date('Y'); $i>=date('Y')-5; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <a href="{{ route('obat.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition">
                Kembali
            </a>
        </div>
    </div>

    <!-- Tabel Kartu Stok -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 bg-teal-50">
            <h3 class="font-bold text-teal-800">Kartu Stok: {{ date('F', mktime(0, 0, 0, $bulan, 10)) }} {{ $tahun }}</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-700 font-semibold uppercase">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">No. Bukti / Ket</th>
                        <th class="px-6 py-3 text-right text-green-600">Masuk</th>
                        <th class="px-6 py-3 text-right text-red-600">Keluar</th>
                        <th class="px-6 py-3 text-right">Sisa</th>
                        <th class="px-6 py-3">Paraf</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Saldo Awal -->
                    <tr class="bg-gray-50/50">
                        <td class="px-6 py-3 italic text-gray-500">{{ $tahun }}-{{ $bulan }}-01</td>
                        <td class="px-6 py-3 italic font-bold">SALDO AWAL</td>
                        <td class="px-6 py-3 text-right">-</td>
                        <td class="px-6 py-3 text-right">-</td>
                        <td class="px-6 py-3 text-right font-bold">{{ $saldoAwal }}</td>
                        <td class="px-6 py-3">-</td>
                    </tr>

                    @php $saldo = $saldoAwal; @endphp
                    @forelse($transaksi as $log)
                        @php
                            if($log->jenis_transaksi == 'Masuk') $saldo += $log->jumlah;
                            else $saldo -= $log->jumlah;
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($log->tanggal_transaksi)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">
                                <span class="block truncate max-w-xs" title="{{ $log->keterangan }}">{{ $log->keterangan }}</span>
                            </td>
                            <td class="px-6 py-3 text-right font-medium text-green-600">
                                {{ $log->jenis_transaksi == 'Masuk' ? $log->jumlah : '-' }}
                            </td>
                            <td class="px-6 py-3 text-right font-medium text-red-600">
                                {{ $log->jenis_transaksi == 'Keluar' ? $log->jumlah : '-' }}
                            </td>
                            <td class="px-6 py-3 text-right font-bold text-gray-800">{{ $saldo }}</td>
                            <td class="px-6 py-3 text-xs text-gray-500">{{ $log->pencatat }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">
                                Tidak ada transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
