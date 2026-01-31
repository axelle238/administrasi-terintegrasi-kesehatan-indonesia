<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji->bulan }} {{ $gaji->tahun }}</title>
    <style>
        body { font-family: sans-serif; line-height: 1.5; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .rincian-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .rincian-table th, .rincian-table td { border: 1px solid #ddd; padding: 10px; }
        .rincian-table th { background-color: #f9f9f9; text-align: left; }
        .total-row { font-weight: bold; background-color: #eee; }
        .footer { margin-top: 50px; text-align: right; }
        .signature { margin-top: 60px; border-top: 1px solid #333; display: inline-block; width: 200px; text-align: center; }
        
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <h1>SLIP GAJI PEGAWAI</h1>
            <p>{{ config('app.name', 'Instansi Kesehatan') }}</p>
            <p>Periode: {{ $gaji->bulan }} {{ $gaji->tahun }}</p>
        </div>

        <table class="info-table">
            <tr>
                <td width="150"><strong>Nama Pegawai</strong></td>
                <td>: {{ $gaji->user->name }}</td>
                <td width="150"><strong>Jabatan</strong></td>
                <td>: {{ $gaji->user->pegawai->jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>NIP</strong></td>
                <td>: {{ $gaji->user->pegawai->nip ?? '-' }}</td>
                <td><strong>Status</strong></td>
                <td>: {{ $gaji->user->pegawai->status_kepegawaian ?? '-' }}</td>
            </tr>
        </table>

        <h3>Rincian Penerimaan</h3>
        <table class="rincian-table">
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th width="30%" style="text-align: right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gaji Pokok</td>
                    <td style="text-align: right">{{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Tunjangan Kinerja & Lainnya</td>
                    <td style="text-align: right">{{ number_format($gaji->tunjangan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="color: #dc2626;">Potongan (Absensi/Lainnya)</td>
                    <td style="text-align: right; color: #dc2626;">- {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td>TOTAL DITERIMA</td>
                    <td style="text-align: right">{{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>{{ config('app.address_city', 'Jakarta') }}, {{ now()->translatedFormat('d F Y') }}</p>
            <br>
            <div class="signature">
                Bagian Keuangan
            </div>
        </div>
    </div>
</body>
</html>