<div class="space-y-6">
    <!-- Patient Profile Card -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row justify-between gap-6">
                <!-- Avatar & Basic Info -->
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold">
                            {{ substr($pasien->nama_lengkap, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $pasien->nama_lengkap }}</h2>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $pasien->jenis_kelamin }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Gol. Darah: {{ $pasien->golongan_darah ?? '-' }}
                            </span>
                        </div>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-600">
                            <div><span class="font-medium text-gray-900">NIK:</span> {{ $pasien->nik }}</div>
                            <div><span class="font-medium text-gray-900">BPJS:</span> {{ $pasien->no_bpjs ?? '-' }}</div>
                            <div><span class="font-medium text-gray-900">TTL:</span> {{ $pasien->tempat_lahir }}, {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d F Y') }}</div>
                            <div><span class="font-medium text-gray-900">Telp:</span> {{ $pasien->no_telepon }}</div>
                        </div>
                        <div class="mt-2 text-sm text-gray-600">
                            <span class="font-medium text-gray-900">Alamat:</span> {{ $pasien->alamat }}
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-3">
                    <a href="{{ route('pasien.edit', $pasien->id) }}" wire:navigate class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Edit Profil
                    </a>
                    <!-- Button to register to queue could go here -->
                     <a href="{{ route('antrean.index') }}" wire:navigate class="inline-flex justify-center items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700">
                        Daftar Antrean
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical History Section -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Rekam Medis</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli / Dokter</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($riwayatMedis as $rekam)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($rekam->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $rekam->poli->nama_poli ?? 'Umum' }}</div>
                                    <div class="text-xs text-gray-500">{{ $rekam->dokter->user->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    {{ $rekam->diagnosa }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    {{ $rekam->tindakan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    {{-- Link to Detail Rekam Medis if created --}}
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada riwayat pemeriksaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $riwayatMedis->links() }}
            </div>
        </div>
    </div>
</div>