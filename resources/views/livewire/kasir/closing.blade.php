<div class="max-w-5xl mx-auto space-y-6">
    <!-- Filter -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center no-print">
        <div class="flex items-center gap-4">
            <x-input-label value="Tanggal Laporan" />
            <input type="date" wire:model.live="tanggal" class="rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <button onclick="window.print()" class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Laporan Closing
        </button>
    </div>

    <!-- Report Card -->
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 print-area">
        <div class="text-center border-b-2 border-gray-800 pb-6 mb-6">
            <h2 class="text-2xl font-bold uppercase tracking-wide text-gray-900">LAPORAN PENERIMAAN KASIR</h2>
            <p class="text-gray-600">Puskesmas Kecamatan Jagakarsa</p>
            <p class="text-sm font-medium mt-2">Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</p>
        </div>

        <div class="grid grid-cols-3 gap-6 mb-8 text-center">
            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                <p class="text-xs text-green-600 font-bold uppercase">Total Tunai</p>
                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($totalTunai, 0, ',', '.') }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <p class="text-xs text-blue-600 font-bold uppercase">Total Non-Tunai / BPJS</p>
                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($totalNonTunai, 0, ',', '.') }}</p>
            </div>
            <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                <p class="text-xs text-indigo-600 font-bold uppercase">Grand Total</p>
                <p class="text-2xl font-black text-gray-900">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
            </div>
        </div>

        <table class="w-full text-sm border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 p-2 text-left">No. Transaksi</th>
                    <th class="border border-gray-300 p-2 text-left">Pasien</th>
                    <th class="border border-gray-300 p-2 text-left">Metode</th>
                    <th class="border border-gray-300 p-2 text-right">Tagihan</th>
                    <th class="border border-gray-300 p-2 text-right">Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td class="border border-gray-300 p-2 font-mono text-xs">{{ $trx->no_transaksi }}</td>
                        <td class="border border-gray-300 p-2">{{ $trx->pasien->nama_lengkap }}</td>
                        <td class="border border-gray-300 p-2">{{ $trx->metode_pembayaran }}</td>
                        <td class="border border-gray-300 p-2 text-right">{{ number_format($trx->total_tagihan, 0, ',', '.') }}</td>
                        <td class="border border-gray-300 p-2 text-right font-bold">{{ number_format($trx->jumlah_bayar, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border border-gray-300 p-8 text-center text-gray-500 italic">Belum ada transaksi pada tanggal ini.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50 font-bold">
                <tr>
                    <td colspan="4" class="border border-gray-300 p-2 text-right">TOTAL PENDAPATAN</td>
                    <td class="border border-gray-300 p-2 text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-12 flex justify-between px-12 text-center text-sm">
            <div>
                <p>Mengetahui,</p>
                <p>Kepala Tata Usaha</p>
                <br><br><br>
                <p class="font-bold underline">.........................</p>
            </div>
            <div>
                <p>Jakarta, {{ date('d F Y') }}</p>
                <p>Petugas Kasir</p>
                <br><br><br>
                <p class="font-bold underline">{{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        @page { size: portrait; margin: 10mm; }
        .no-print { display: none !important; }
        .print-area { border: none !important; shadow: none !important; padding: 0 !important; }
        body { background: white !important; }
        nav, footer, aside { display: none !important; }
    }
</style>
