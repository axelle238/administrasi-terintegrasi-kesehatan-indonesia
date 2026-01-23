<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Lembar Disposisi - {{ $surat->nomor_surat }}</title>
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Times New Roman', serif; }
        .table-border { border: 1px solid black; border-collapse: collapse; width: 100%; }
        .table-border td, .table-border th { border: 1px solid black; padding: 5px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="p-8 bg-white text-black">
    <div class="max-w-2xl mx-auto border-2 border-black p-1">
        <div class="border border-black p-4">
            <!-- Header -->
            <div class="text-center border-b-2 border-black pb-4 mb-4">
                <h1 class="font-bold text-xl uppercase">Pemerintah Provinsi DKI Jakarta</h1>
                <h2 class="font-bold text-2xl uppercase">Puskesmas Kecamatan Jagakarsa</h2>
                <p class="text-sm">Jl. Jagakarsa Raya No. 1, Jakarta Selatan</p>
                <h3 class="font-bold text-xl mt-2 underline">LEMBAR DISPOSISI</h3>
            </div>

            <!-- Info Surat -->
            <table class="w-full mb-4">
                <tr>
                    <td class="w-32 font-bold">Surat Dari</td>
                    <td>: {{ $surat->pengirim }}</td>
                    <td class="w-32 font-bold">Diterima Tgl</td>
                    <td>: {{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="font-bold">No. Surat</td>
                    <td>: {{ $surat->nomor_surat }}</td>
                    <td class="font-bold">No. Agenda</td>
                    <td>: -</td>
                </tr>
                <tr>
                    <td class="font-bold">Tanggal Surat</td>
                    <td>: {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</td>
                    <td class="font-bold">Sifat</td>
                    <td>: Penting / Biasa / Rahasia</td>
                </tr>
                <tr>
                    <td class="font-bold align-top">Perihal</td>
                    <td colspan="3" class="align-top">: {{ $surat->perihal }}</td>
                </tr>
            </table>

            <!-- Tabel Disposisi -->
            <div class="mb-4">
                <h4 class="font-bold mb-2">Diteruskan Kepada Sdr:</h4>
                <table class="table-border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="w-1/4">Tujuan</th>
                            <th class="w-1/2">Isi Disposisi / Instruksi</th>
                            <th class="w-1/4">Paraf / Tgl</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($surat->disposisiSurats as $disposisi)
                            <tr>
                                <td>
                                    <strong>{{ $disposisi->penerima->name ?? 'Staf' }}</strong><br>
                                    <span class="text-xs">{{ $disposisi->penerima->pegawai->jabatan ?? '-' }}</span>
                                </td>
                                <td>
                                    <p>{{ $disposisi->isi_disposisi }}</p>
                                    <p class="text-xs italic mt-1 text-gray-500">Sifat: {{ $disposisi->sifat_disposisi }}</p>
                                </td>
                                <td class="text-center">
                                    <br><br>
                                    <span class="text-xs">{{ \Carbon\Carbon::parse($disposisi->tanggal_disposisi)->format('d/m/Y') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 italic">Belum ada disposisi.</td>
                            </tr>
                        @endforelse
                        <!-- Empty rows for manual writing -->
                        @for($i=0; $i<3; $i++)
                            <tr class="h-16">
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end">
                <div class="text-center w-48">
                    <p>Kepala Puskesmas</p>
                    <br><br><br>
                    <p class="font-bold underline">Dr. H. Kepala Puskesmas</p>
                    <p>NIP. 19800101 200001 1 001</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 text-center no-print">
        <button onclick="window.print()" class="px-6 py-2 bg-blue-600 text-white font-bold rounded shadow hover:bg-blue-700">Cetak Disposisi</button>
    </div>
</body>
</html>