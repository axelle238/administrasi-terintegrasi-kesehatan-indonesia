<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pasien & Riwayat Medis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Detail Pasien -->
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="text-center mb-6">
                                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto flex items-center justify-center text-gray-500 text-2xl font-bold mb-2">
                                    {{ substr($pasien->nama_lengkap, 0, 1) }}
                                </div>
                                <h3 class="text-xl font-bold">{{ $pasien->nama_lengkap }}</h3>
                                <p class="text-sm text-gray-500">NIK: {{ $pasien->nik }}</p>
                            </div>

                            <div class="space-y-3 border-t pt-4">
                                <div>
                                    <span class="text-xs text-gray-500 uppercase font-bold">Jenis Kelamin</span>
                                    <p>{{ $pasien->jenis_kelamin }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 uppercase font-bold">TTL</span>
                                    <p>{{ $pasien->tempat_lahir }}, {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                                    <p class="text-xs text-gray-400">Umur: {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 uppercase font-bold">Gol. Darah</span>
                                    <p>{{ $pasien->golongan_darah ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 uppercase font-bold">No. BPJS</span>
                                    <p>{{ $pasien->no_bpjs ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 uppercase font-bold">Telepon</span>
                                    <p>{{ $pasien->no_telepon }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 uppercase font-bold">Alamat</span>
                                    <p class="text-sm">{{ $pasien->alamat }}</p>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-2">
                                <a href="{{ route('pasien.edit', $pasien->id) }}" class="w-full text-center bg-gray-600 hover:bg-gray-700 text-white py-2 rounded text-sm font-bold">Edit Data Pasien</a>
                                <button onclick="window.open('{{ route('pasien.print-card', $pasien->id) }}', '_blank', 'width=600,height=400')" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-2 rounded text-sm font-bold">
                                    Cetak Kartu Berobat
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Medis -->
                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-bold mb-4 border-b pb-2 flex justify-between items-center">
                                <span>Riwayat Kunjungan & Medis</span>
                                <a href="{{ route('rekam-medis.create', ['pasien_id' => $pasien->id]) }}" class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded">
                                    + Periksa Baru
                                </a>
                            </h3>

                            @if($pasien->rekamMedis && $pasien->rekamMedis->count() > 0)
                                <div class="space-y-6">
                                    @foreach($pasien->rekamMedis as $rm)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <span class="text-sm font-bold text-blue-600">{{ \Carbon\Carbon::parse($rm->tanggal_periksa)->translatedFormat('l, d F Y H:i') }}</span>
                                                <p class="text-xs text-gray-500">Dokter: {{ $rm->dokter->name }}</p>
                                            </div>
                                            <a href="{{ route('rekam-medis.show', $rm->id) }}" class="text-xs text-gray-500 underline hover:text-blue-600">Detail</a>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mt-2">
                                            <div class="bg-gray-50 p-2 rounded">
                                                <span class="font-bold block text-xs text-gray-400">KELUHAN</span>
                                                {{ $rm->keluhan }}
                                            </div>
                                            <div class="bg-blue-50 p-2 rounded">
                                                <span class="font-bold block text-xs text-blue-400">DIAGNOSA</span>
                                                {{ $rm->diagnosa }}
                                            </div>
                                        </div>

                                        @if($rm->obats->count() > 0)
                                        <div class="mt-2">
                                            <span class="text-xs font-bold text-gray-400">OBAT:</span>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach($rm->obats as $obat)
                                                <span class="px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded-full">
                                                    {{ $obat->nama_obat }} ({{ $obat->pivot->jumlah }})
                                                </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p>Belum ada riwayat rekam medis untuk pasien ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
