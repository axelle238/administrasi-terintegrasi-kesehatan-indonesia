<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi #{{ $pembayaran->id }} - SIPUJAGA</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 12px; margin: 0; padding: 20px; }
        .container { max-width: 80mm; margin: 0 auto; border: 1px dashed #ccc; padding: 10px; } /* Thermal size approx */
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16px; }
        .meta { margin-bottom: 15px; border-bottom: 1px dashed #000; padding-bottom: 10px; }
        .meta table { width: 100%; }
        .items { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .items th { text-align: left; border-bottom: 1px solid #000; }
        .items td { padding: 4px 0; }
        .total { border-top: 1px dashed #000; padding-top: 10px; text-align: right; font-weight: bold; font-size: 14px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; }
        @media print {
            body { padding: 0; }
            .container { border: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <h2>PUSKESMAS JAGAKARSA</h2>
            <p>Jl. Jagakarsa Raya No. 1<br>Telp: (021) 7890123</p>
        </div>

        <div class="meta">
            <table>
                <tr>
                    <td>No. Kwitansi</td>
                    <td>: #{{ $pembayaran->id }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ date('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td>Pasien</td>
                    <td>: {{ $pembayaran->rekamMedis->pasien->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td>No. RM</td>
                    <td>: {{ $pembayaran->rekam_medis_id }}</td>
                </tr>
                 <tr>
                    <td>Metode</td>
                    <td>: {{ $pembayaran->metode_pembayaran }}</td>
                </tr>
            </table>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align: right;">Biaya</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembayaran->rekamMedis->tindakans as $tindakan)
                <tr>
                    <td>{{ $tindakan->nama_tindakan }}</td>
                    <td style="text-align: right;">{{ number_format($tindakan->pivot->biaya, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                
                @foreach($pembayaran->rekamMedis->obats as $obat)
                <tr>
                    <td>{{ $obat->nama_obat }} (x{{ $obat->pivot->jumlah }})</td>
                    <td style="text-align: right;">{{ number_format($obat->harga_satuan * $obat->pivot->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            TOTAL: Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}
        </div>

        <div class="footer">
            <p>Terima Kasih atas kunjungan Anda.<br>Semoga Lekas Sembuh.</p>
            <p>-- SIPUJAGA SYSTEM --</p>
        </div>
    </div>
</body>
</html>
