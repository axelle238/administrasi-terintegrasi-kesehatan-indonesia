<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header Informasi -->
                    <div class="flex justify-between items-start mb-8 border-b pb-4">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $rekamMedis->pasien->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-500">NIK: {{ $rekamMedis->pasien->nik }} | Tgl Lahir: {{ $rekamMedis->pasien->tanggal_lahir }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold">Tanggal Periksa</p>
                            <p class="text-lg">{{ \Carbon\Carbon::parse($rekamMedis->tanggal_periksa)->format('d F Y, H:i') }}</p>
                            <p class="text-sm text-gray-500 mt-1">Dokter: {{ $rekamMedis->dokter->name }}</p>
                            <span class="inline-block mt-2 px-3 py-1 text-xs font-bold rounded-full {{ $rekamMedis->status_resep == 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                Status Resep: {{ $rekamMedis->status_resep }}
                            </span>
                        </div>
                    </div>

                    <!-- Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <!-- Kolom Kiri: Vital Signs -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg h-fit">
                            <h4 class="font-semibold text-blue-600 mb-3 border-b border-gray-200 pb-2">Tanda-Tanda Vital</h4>
                            <ul class="space-y-3 text-sm">
                                <li class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-300">Tekanan Darah:</span>
                                    <span class="font-medium">{{ $rekamMedis->tekanan_darah ?? '-' }} mmHg</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-300">Suhu Tubuh:</span>
                                    <span class="font-medium">{{ $rekamMedis->suhu_tubuh ?? '-' }} °C</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-300">Berat Badan:</span>
                                    <span class="font-medium">{{ $rekamMedis->berat_badan ?? '-' }} Kg</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-300">Tinggi Badan:</span>
                                    <span class="font-medium">{{ $rekamMedis->tinggi_badan ?? '-' }} Cm</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-300">Nadi:</span>
                                    <span class="font-medium">{{ $rekamMedis->nadi ?? '-' }} bpm</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-300">Pernapasan:</span>
                                    <span class="font-medium">{{ $rekamMedis->pernapasan ?? '-' }} x/menit</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Kolom Tengah & Kanan: Hasil Medis -->
                        <div class="md:col-span-2 space-y-6">
                            
                            <!-- Diagnosa -->
                            <div>
                                <h4 class="font-semibold text-lg mb-2">Diagnosa & Keluhan</h4>
                                <div class="bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 p-4 rounded text-gray-800 dark:text-gray-200">
                                    <p class="font-bold text-blue-800 dark:text-blue-300 mb-1">Diagnosa:</p>
                                    <p class="text-lg mb-3">{{ $rekamMedis->diagnosa }}</p>
                                    <p class="font-bold text-gray-600 dark:text-gray-400 text-sm mb-1">Keluhan:</p>
                                    <p class="text-sm">{{ $rekamMedis->keluhan }}</p>
                                </div>
                            </div>

                            <!-- Tindakan -->
                            <div>
                                <h4 class="font-semibold text-lg mb-2">Tindakan Medis</h4>
                                @if($rekamMedis->tindakans->count() > 0)
                                    <ul class="list-disc list-inside bg-gray-50 dark:bg-gray-700 p-4 rounded text-gray-800 dark:text-gray-200">
                                        @foreach($rekamMedis->tindakans as $tindakan)
                                            <li>{{ $tindakan->nama_tindakan }} (Rp{{ number_format($tindakan->pivot->biaya, 0, ',', '.') }})</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500 italic">Tidak ada tindakan medis.</p>
                                @endif
                            </div>

                            <!-- Resep Obat -->
                            <div>
                                <h4 class="font-semibold text-lg mb-2">Resep Obat</h4>
                                @if($rekamMedis->obats->count() > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 border rounded-lg">
                                            <thead class="text-xs text-gray-700 uppercase bg-yellow-50 dark:bg-yellow-900/30">
                                                <tr>
                                                    <th class="px-4 py-2">Nama Obat</th>
                                                    <th class="px-4 py-2">Jumlah</th>
                                                    <th class="px-4 py-2">Aturan Pakai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($rekamMedis->obats as $obat)
                                                <tr class="bg-white border-b dark:bg-gray-800">
                                                    <td class="px-4 py-2 font-medium">{{ $obat->nama_obat }}</td>
                                                    <td class="px-4 py-2">{{ $obat->pivot->jumlah }} {{ $obat->satuan }}</td>
                                                    <td class="px-4 py-2">{{ $obat->pivot->aturan_pakai }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-gray-500 italic">Tidak ada resep obat.</p>
                                @endif
                            </div>
                            
                            <!-- Estimasi Biaya (Hidden for Patient usually, shown for admin/cashier) -->
                            @if($rekamMedis->pembayaran)
                            <div class="mt-6 border-t pt-4 text-right">
                                <p class="text-sm text-gray-500">Estimasi Total Biaya</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp{{ number_format($rekamMedis->pembayaran->total_bayar, 0, ',', '.') }}</p>
                                <p class="text-xs {{ $rekamMedis->pembayaran->status_pembayaran == 'Lunas' ? 'text-green-600' : 'text-red-600' }} font-bold uppercase">
                                    {{ $rekamMedis->pembayaran->status_pembayaran }}
                                </p>
                            </div>
                            @endif

                        </div>
                    </div>

                    <div class="mt-8 border-t pt-4 flex justify-between">
                        <a href="{{ route('rekam-medis.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                            &larr; Kembali ke Daftar
                        </a>
                        <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cetak
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>