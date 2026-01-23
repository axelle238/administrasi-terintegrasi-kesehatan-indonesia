<div class="space-y-6">
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 no-print">
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
        </div>
        <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak LPLPO
        </button>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 print-area">
        <!-- Kop Laporan -->
        <div class="text-center mb-6 border-b-2 border-black pb-4">
            <h2 class="text-xl font-bold uppercase tracking-wide">Laporan Pemakaian dan Lembar Permintaan Obat (LPLPO)</h2>
            <p class="text-sm font-medium">PUSKESMAS KECAMATAN JAGAKARSA</p>
            <p class="text-sm">Periode: {{ date('F', mktime(0, 0, 0, $bulan, 10)) }} {{ $tahun }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs border-collapse border border-black">
                <thead class="bg-gray-100 text-center font-bold">
                    <tr>
                        <th class="border border-black p-2" rowspan="2">No</th>
                        <th class="border border-black p-2" rowspan="2">Nama Obat</th>
                        <th class="border border-black p-2" rowspan="2">Satuan</th>
                        <th class="border border-black p-2" rowspan="2">Stok Awal</th>
                        <th class="border border-black p-2" rowspan="2">Penerimaan</th>
                        <th class="border border-black p-2" rowspan="2">Persediaan</th>
                        <th class="border border-black p-2" rowspan="2">Pemakaian</th>
                        <th class="border border-black p-2" rowspan="2">Stok Akhir</th>
                        <th class="border border-black p-2" rowspan="2">Permintaan</th>
                        <th class="border border-black p-2" rowspan="2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $index => $item)
                        <tr class="text-center">
                            <td class="border border-black p-1">{{ $loop->iteration }}</td>
                            <td class="border border-black p-1 text-left px-2">{{ $item['nama_obat'] }}</td>
                            <td class="border border-black p-1">{{ $item['satuan'] }}</td>
                            <td class="border border-black p-1">{{ $item['stok_awal'] }}</td>
                            <td class="border border-black p-1">{{ $item['penerimaan'] }}</td>
                            <td class="border border-black p-1">{{ $item['persediaan'] }}</td>
                            <td class="border border-black p-1">{{ $item['pemakaian'] }}</td>
                            <td class="border border-black p-1 font-bold">{{ $item['stok_akhir'] }}</td>
                            <td class="border border-black p-1">{{ $item['permintaan'] }}</td>
                            <td class="border border-black p-1"></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="border border-black p-4 text-center italic">Data obat belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tanda Tangan -->
        <div class="mt-12 flex justify-between px-8 text-center text-sm">
            <div>
                <p>Mengetahui,</p>
                <p>Kepala Puskesmas</p>
                <br><br><br>
                <p class="font-bold underline">Dr. Kepala Puskesmas</p>
                <p>NIP. .........................</p>
            </div>
            <div>
                <p>Jakarta, {{ date('t', mktime(0, 0, 0, $bulan, 10)) }} {{ date('F Y', mktime(0, 0, 0, $bulan, 10)) }}</p>
                <p>Pengelola Obat / Apoteker</p>
                <br><br><br>
                <p class="font-bold underline">{{ Auth::user()->name ?? 'Apoteker' }}</p>
                <p>NIP. .........................</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        @page { size: landscape; margin: 10mm; }
        body { -webkit-print-color-adjust: exact; }
        .no-print { display: none !important; }
        .print-area { border: none !important; shadow: none !important; width: 100%; }
        /* Layout reset for printing */
        nav, footer, aside, .fixed { display: none !important; }
        main { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .bg-slate-50 { background-color: white !important; }
    }
</style>