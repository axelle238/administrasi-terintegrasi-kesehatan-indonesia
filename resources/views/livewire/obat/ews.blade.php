<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Expired Warning -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border-l-4 border-red-500">
        <div class="p-6">
            <h3 class="text-lg font-bold text-red-600 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Peringatan Kadaluarsa (6 Bulan)
            </h3>
            <div class="mt-4 overflow-y-auto max-h-96">
                <table class="min-w-full text-sm">
                    <thead class="bg-red-50">
                        <tr>
                            <th class="p-2 text-left">Obat</th>
                            <th class="p-2 text-left">Batch</th>
                            <th class="p-2 text-left">ED</th>
                            <th class="p-2 text-right">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expiredSoon as $batch)
                            <tr class="border-b">
                                <td class="p-2 font-medium">{{ $batch->obat->nama_obat }}</td>
                                <td class="p-2 text-gray-500">{{ $batch->batch_number }}</td>
                                <td class="p-2 font-bold {{ $batch->tanggal_kedaluwarsa < now() ? 'text-red-700' : 'text-orange-600' }}">
                                    {{ $batch->tanggal_kedaluwarsa->format('d/m/Y') }}
                                </td>
                                <td class="p-2 text-right">{{ $batch->stok }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-4 text-center text-gray-500">Aman. Tidak ada obat mendekati ED.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Stock Warning -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border-l-4 border-yellow-500">
        <div class="p-6">
            <h3 class="text-lg font-bold text-yellow-600 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Stok Kritis / Menipis
            </h3>
            <div class="mt-4 overflow-y-auto max-h-96">
                <table class="min-w-full text-sm">
                    <thead class="bg-yellow-50">
                        <tr>
                            <th class="p-2 text-left">Obat</th>
                            <th class="p-2 text-right">Sisa Stok</th>
                            <th class="p-2 text-right">Min. Stok</th>
                            <th class="p-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($criticalStock as $obat)
                            <tr class="border-b">
                                <td class="p-2 font-medium">{{ $obat->nama_obat }}</td>
                                <td class="p-2 text-right font-bold text-red-600">{{ $obat->stok }}</td>
                                <td class="p-2 text-right">{{ $obat->min_stok }}</td>
                                <td class="p-2 text-center">
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Order</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-4 text-center text-gray-500">Stok aman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
