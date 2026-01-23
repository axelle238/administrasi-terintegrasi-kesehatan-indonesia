<div class="space-y-6">
    <!-- Queue Section -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg" wire:poll.10s>
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Tunggu Pasien Hari Ini</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($antreanMenunggu as $antrean)
                    <div class="border rounded-lg p-4 flex flex-col justify-between hover:shadow-md transition-shadow {{ $antrean->status == 'Diperiksa' ? 'bg-blue-50 border-blue-200' : 'bg-white' }}">
                        <div>
                            <div class="flex justify-between items-start">
                                <span class="text-2xl font-bold text-gray-800">{{ $antrean->nomor_antrean }}</span>
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $antrean->status == 'Diperiksa' ? 'bg-blue-200 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $antrean->status }}
                                </span>
                            </div>
                            <h4 class="text-lg font-semibold mt-2">{{ $antrean->pasien->nama_lengkap }}</h4>
                            <p class="text-sm text-gray-500">{{ $antrean->poli->nama_poli ?? 'Umum' }}</p>
                        </div>
                        <div class="mt-4">
                            @if($antrean->status == 'Diperiksa' && $antrean->dokter_id != Auth::id())
                                <button disabled class="block w-full text-center px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
                                    Sedang diperiksa {{ $antrean->dokter->name ?? 'Dokter Lain' }}
                                </button>
                            @else
                                <a href="{{ route('rekam-medis.create', ['antrean_id' => $antrean->id]) }}" wire:navigate class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                    {{ $antrean->status == 'Diperiksa' ? 'Lanjutkan Periksa' : 'Mulai Periksa' }}
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                        Tidak ada pasien menunggu saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- History Section -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Pemeriksaan Terakhir Anda</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diagnosa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($history as $rekam)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($rekam->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $rekam->pasien->nama_lengkap }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">
                                    {{ $rekam->diagnosa }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">
                                    {{-- Need to implement Tindakan relation display logic properly --}}
                                    {{ count($rekam->tindakans) }} Tindakan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada riwayat pemeriksaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $history->links() }}
            </div>
        </div>
    </div>
</div>