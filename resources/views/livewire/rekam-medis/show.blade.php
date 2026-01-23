<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-8 print:shadow-none">
        <!-- Header for Print -->
        <div class="text-center border-b-2 border-gray-800 pb-4 mb-6">
            <h1 class="text-2xl font-bold uppercase tracking-widest text-gray-900">{{ config('app.name') }}</h1>
            <p class="text-sm text-gray-600">Jl. Jagakarsa Raya No. 1, Jakarta Selatan | Telp: (021) 7890123</p>
            <h2 class="text-xl font-bold mt-4 underline">RESUME MEDIS RAWAT JALAN</h2>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <table class="w-full text-sm">
                    <tr><td class="w-32 text-gray-600">No. RM</td><td class="font-bold">: {{ $rekamMedis->pasien->id }}</td></tr>
                    <tr><td class="text-gray-600">Nama Pasien</td><td class="font-bold">: {{ $rekamMedis->pasien->nama_lengkap }}</td></tr>
                    <tr><td class="text-gray-600">Tanggal Lahir</td><td>: {{ \Carbon\Carbon::parse($rekamMedis->pasien->tanggal_lahir)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($rekamMedis->pasien->tanggal_lahir)->age }} Thn)</td></tr>
                    <tr><td class="text-gray-600">Jenis Kelamin</td><td>: {{ $rekamMedis->pasien->jenis_kelamin }}</td></tr>
                </table>
            </div>
            <div>
                <table class="w-full text-sm">
                    <tr><td class="w-32 text-gray-600">Tanggal Periksa</td><td class="font-bold">: {{ \Carbon\Carbon::parse($rekamMedis->tanggal_periksa)->format('d F Y, H:i') }}</td></tr>
                    <tr><td class="text-gray-600">Dokter Pemeriksa</td><td class="font-bold">: {{ $rekamMedis->dokter->user->name ?? '-' }}</td></tr>
                    <tr><td class="text-gray-600">Poli</td><td>: {{ $rekamMedis->poli->nama_poli ?? 'Umum' }}</td></tr>
                </table>
            </div>
        </div>

        <!-- SOAP Content -->
        <div class="space-y-6">
            <div>
                <h3 class="text-md font-bold bg-gray-100 p-2 rounded border border-gray-200">ANAMNESA (S)</h3>
                <p class="mt-2 text-gray-800 whitespace-pre-line px-2">{{ $rekamMedis->keluhan }}</p>
            </div>

            <div>
                <h3 class="text-md font-bold bg-gray-100 p-2 rounded border border-gray-200">PEMERIKSAAN FISIK (O)</h3>
                <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4 px-2 text-sm">
                    <div><span class="text-gray-500">TD:</span> {{ $rekamMedis->tekanan_darah ?? '-' }} mmHg</div>
                    <div><span class="text-gray-500">Nadi:</span> {{ $rekamMedis->nadi ?? '-' }} x/mnt</div>
                    <div><span class="text-gray-500">Suhu:</span> {{ $rekamMedis->suhu_tubuh ?? '-' }} °C</div>
                    <div><span class="text-gray-500">RR:</span> {{ $rekamMedis->pernapasan ?? '-' }} x/mnt</div>
                    <div><span class="text-gray-500">BB:</span> {{ $rekamMedis->berat_badan ?? '-' }} kg</div>
                    <div><span class="text-gray-500">TB:</span> {{ $rekamMedis->tinggi_badan ?? '-' }} cm</div>
                </div>
            </div>

            <div>
                <h3 class="text-md font-bold bg-gray-100 p-2 rounded border border-gray-200">HASIL PENUNJANG (LABORATORIUM)</h3>
                @if($rekamMedis->laboratoriums->count() > 0)
                    <div class="mt-2 px-2 space-y-4">
                        @foreach($rekamMedis->laboratoriums as $lab)
                            <div class="border rounded p-3 text-sm">
                                <p class="font-bold border-b pb-1 mb-2">{{ $lab->jenis_pemeriksaan }} ({{ $lab->waktu_selesai->format('H:i') }})</p>
                                <table class="w-full">
                                    @foreach($lab->hasil as $key => $val)
                                        <tr>
                                            <td class="w-1/2 text-gray-600">{{ $key }}</td>
                                            <td class="font-medium">{{ $val }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                <p class="text-xs text-right mt-2 text-gray-400">Petugas: {{ $lab->petugas_lab }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mt-2 text-sm text-gray-500 italic px-2">Tidak ada pemeriksaan laboratorium.</p>
                @endif
            </div>

            <div>
                <h3 class="text-md font-bold bg-gray-100 p-2 rounded border border-gray-200">DIAGNOSA (A)</h3>
                <p class="mt-2 text-gray-800 font-semibold px-2">{{ $rekamMedis->diagnosa }}</p>
            </div>

            <div>
                <h3 class="text-md font-bold bg-gray-100 p-2 rounded border border-gray-200">TERAPI & TINDAKAN (P)</h3>
                <div class="mt-2 px-2">
                    @if($rekamMedis->tindakans->count() > 0)
                        <p class="font-semibold text-sm text-gray-700 underline">Tindakan:</p>
                        <ul class="list-disc list-inside text-sm text-gray-800 mb-2">
                            @foreach($rekamMedis->tindakans as $tindakan)
                                <li>{{ $tindakan->nama_tindakan }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if($rekamMedis->obats->count() > 0)
                        <p class="font-semibold text-sm text-gray-700 underline">Resep Obat:</p>
                        <ul class="list-disc list-inside text-sm text-gray-800">
                            @foreach($rekamMedis->obats as $obat)
                                <li>{{ $obat->nama_obat }} ({{ $obat->pivot->jumlah }} {{ $obat->satuan }}) - {{ $obat->pivot->aturan_pakai }}</li>
                            @endforeach
                        </ul>
                    @endif
                    
                    @if($rekamMedis->catatan_tambahan)
                        <div class="mt-2 text-sm italic text-gray-600">Catatan: {{ $rekamMedis->catatan_tambahan }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-12 flex justify-end">
            <div class="text-center w-48">
                <p class="text-sm mb-16">Jakarta, {{ \Carbon\Carbon::parse($rekamMedis->tanggal_periksa)->format('d F Y') }}</p>
                <p class="font-bold underline">{{ $rekamMedis->dokter->user->name ?? 'Dokter Pemeriksa' }}</p>
            </div>
        </div>

        <!-- No Print Buttons -->
        <div class="mt-8 flex justify-center gap-4 print:hidden">
            <button onclick="window.print()" class="px-6 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700">
                Cetak Resume
            </button>
            <a href="{{ route('rekam-medis.index') }}" wire:navigate class="px-6 py-2 bg-gray-200 text-gray-700 rounded shadow hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </div>
</div>