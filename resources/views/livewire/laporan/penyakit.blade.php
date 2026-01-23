<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="font-bold text-gray-800">Periode Laporan</h2>
        <div class="flex gap-2">
            <input type="date" wire:model.live="startDate" class="rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
            <span class="self-center text-gray-500">s/d</span>
            <input type="date" wire:model.live="endDate" class="rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <button onclick="window.print()" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm hover:bg-gray-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak PDF
        </button>
    </div>

    <!-- Chart Visualization -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Top 10 Penyakit Terbanyak</h3>
        
        @if($topDiseases->isEmpty())
            <div class="text-center py-10 text-gray-500 italic">Belum ada data kunjungan pada periode ini.</div>
        @else
            <div class="space-y-4">
                @php $max = $topDiseases->first()->total; @endphp
                @foreach($topDiseases as $index => $disease)
                    @php $percent = ($disease->total / $max) * 100; @endphp
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-teal-600 bg-teal-200">
                                    #{{ $index + 1 }}
                                </span>
                                <span class="font-bold text-gray-800 ml-2 text-sm">{{ $disease->diagnosa }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-teal-600">
                                    {{ $disease->total }} Pasien
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-teal-50">
                            <div style="width:{{ $percent }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-teal-500 transition-all duration-1000"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Detailed Table -->
    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
        <div class="p-4 bg-gray-50 border-b border-gray-200">
            <h3 class="font-bold text-gray-700">Rincian Data</h3>
        </div>
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Kode ICD-10</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Nama Penyakit</th>
                    <th class="px-6 py-3 text-right font-medium text-gray-500 uppercase">Jumlah Kasus</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($topDiseases as $disease)
                    @php 
                        // Split Code and Name if format is "CODE - NAME"
                        $parts = explode('-', $disease->diagnosa, 2);
                        $code = trim($parts[0]);
                        $name = isset($parts[1]) ? trim($parts[1]) : '';
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-indigo-600 font-bold">{{ $code }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $name ?: $code }}</td>
                        <td class="px-6 py-4 text-right font-bold">{{ $disease->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
