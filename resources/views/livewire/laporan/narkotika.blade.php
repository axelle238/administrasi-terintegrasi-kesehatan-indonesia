<div class="space-y-6">
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 no-print">
        <div class="flex gap-2 items-center">
            <select wire:model.live="jenis" class="rounded-lg border-gray-300 text-sm font-bold">
                <option value="Narkotika">Narkotika</option>
                <option value="Psikotropika">Psikotropika</option>
            </select>
            <select wire:model.live="bulan" class="rounded-lg border-gray-300 text-sm">
                @for($i=1; $i<=12; $i++)
                    <option value="{{ sprintf('%02d', $i) }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                @endfor
            </select>
            <select wire:model.live="tahun" class="rounded-lg border-gray-300 text-sm">
                @for($i=date('Y'); $i>=date('Y')-5; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">
            Cetak Laporan
        </button>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 print-area">
        <div class="text-center mb-6 border-b-2 border-black pb-4">
            <h2 class="text-xl font-bold uppercase tracking-wide">LAPORAN PENGGUNAAN {{ strtoupper($jenis) }}</h2>
            <p class="text-sm font-medium">PUSKESMAS KECAMATAN JAGAKARSA</p>
            <p class="text-sm">Periode: {{ date('F', mktime(0, 0, 0, $bulan, 10)) }} {{ $tahun }}</p>
        </div>

        <table class="w-full text-sm border-collapse border border-black">
            <thead class="bg-gray-100 font-bold text-center">
                <tr>
                    <th class="border border-black p-2">No</th>
                    <th class="border border-black p-2">Nama Obat</th>
                    <th class="border border-black p-2">Satuan</th>
                    <th class="border border-black p-2">Stok Awal</th>
                    <th class="border border-black p-2">Penerimaan</th>
                    <th class="border border-black p-2">Penggunaan</th>
                    <th class="border border-black p-2">Stok Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $index => $data)
                    <tr class="text-center">
                        <td class="border border-black p-2">{{ $loop->iteration }}</td>
                        <td class="border border-black p-2 text-left">{{ $data['nama_obat'] }}</td>
                        <td class="border border-black p-2">{{ $data['satuan'] }}</td>
                        <td class="border border-black p-2">{{ $data['stok_awal'] }}</td>
                        <td class="border border-black p-2">{{ $data['penerimaan'] }}</td>
                        <td class="border border-black p-2">{{ $data['pemakaian'] }}</td>
                        <td class="border border-black p-2 font-bold">{{ $data['stok_akhir'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border border-black p-4 text-center italic">Tidak ada data untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

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
                <p>Apoteker Penanggung Jawab</p>
                <br><br><br>
                <p class="font-bold underline">{{ Auth::user()->name ?? 'Apoteker' }}</p>
                <p>SIPA. .........................</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        .print-area { border: none !important; shadow: none !important; }
        nav, footer, aside { display: none !important; }
    }
</style>
