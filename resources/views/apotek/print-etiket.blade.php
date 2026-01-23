<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Etiket Obat</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; margin: 0; padding: 0; }
        .etiket { 
            width: 7cm; 
            height: 4cm; 
            border: 1px solid black; 
            padding: 5px; 
            margin-bottom: 10px; 
            page-break-inside: avoid;
        }
        .header { text-align: center; border-bottom: 1px solid black; padding-bottom: 2px; margin-bottom: 5px; }
        .title { font-weight: bold; font-size: 9pt; }
        .subtitle { font-size: 7pt; }
        .content { font-size: 9pt; }
        .footer { font-size: 7pt; text-align: center; margin-top: 5px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    @foreach($rekamMedis->obats as $obat)
    <div class="etiket">
        <div class="header">
            <div class="title">{{ $settings['app_name'] ?? 'Puskesmas Jagakarsa' }}</div>
            <div class="subtitle">{{ $settings['app_address'] ?? 'Jakarta Selatan' }}</div>
            <div class="subtitle">SIP: {{ $settings['sip_dokter_penanggung_jawab'] ?? '-' }}</div>
        </div>
        <div class="content">
            <table width="100%">
                <tr>
                    <td>Tgl: {{ date('d/m/Y') }}</td>
                    <td align="right">No: {{ $rekamMedis->id }}/{{ $loop->iteration }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-weight: bold; text-align: center; padding: 5px 0;">
                        {{ $obat->pivot->aturan_pakai }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 2px 0;">
                        {{ $obat->pivot->jumlah }} {{ $obat->satuan }} - {{ $obat->nama_obat }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-transform: uppercase;">
                        Pasien: {{ $rekamMedis->pasien->nama_lengkap }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer">
            SEMOGA LEKAS SEMBUH
        </div>
    </div>
    @endforeach

    <div class="no-print" style="margin-top: 20px;">
        <button onclick="window.print()">Cetak Etiket</button>
    </div>
</body>
</html>
