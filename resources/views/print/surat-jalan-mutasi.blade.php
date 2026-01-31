<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan Mutasi - {{ $mutasi->id }}</title>
    <style>
        body { font-family: sans-serif; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 0; font-size: 12px; }
        .meta-table { width: 100%; margin-bottom: 20px; font-size: 14px; }
        .content-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .content-table th, .content-table td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
        .content-table th { background-color: #f0f0f0; }
        .signature { display: flex; justify-content: space-between; margin-top: 50px; }
        .sign-box { text-align: center; width: 30%; }
        .sign-box p { margin-bottom: 60px; font-weight: bold; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h1>Surat Jalan Perpindahan Aset (Mutasi)</h1>
        <p>Puskesmas Jagakarsa - Sistem Administrasi Terintegrasi</p>
    </div>

    <table class="meta-table">
        <tr>
            <td width="15%">No. Dokumen</td>
            <td width="35%">: <strong>MUT/{{ $mutasi->created_at->format('Y') }}/{{ str_pad($mutasi->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
            <td width="15%">Tanggal</td>
            <td width="35%">: {{ \Carbon\Carbon::parse($mutasi->tanggal_mutasi)->isoFormat('d MMMM Y') }}</td>
        </tr>
        <tr>
            <td>Penanggung Jawab</td>
            <td>: {{ $mutasi->penanggung_jawab }}</td>
            <td>Keterangan</td>
            <td>: {{ $mutasi->keterangan ?? '-' }}</td>
        </tr>
    </table>

    <table class="content-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Barang / Aset</th>
                <th width="15%">Kode Barang</th>
                <th width="20%">Lokasi Asal</th>
                <th width="20%">Lokasi Tujuan</th>
                <th width="5%">Qty</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $mutasi->barang->nama_barang }}</td>
                <td>{{ $mutasi->barang->kode_barang }}</td>
                <td>{{ $mutasi->ruanganAsal->nama_ruangan ?? $mutasi->lokasi_asal }}</td>
                <td>{{ $mutasi->ruanganTujuan->nama_ruangan ?? $mutasi->lokasi_tujuan }}</td>
                <td>{{ $mutasi->jumlah }} {{ $mutasi->barang->satuan }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <div class="sign-box">
            <p>Pengirim (Asal)</p>
            <br>___________________
        </div>
        <div class="sign-box">
            <p>Pengangkut / Kurir</p>
            <br>___________________
        </div>
        <div class="sign-box">
            <p>Penerima (Tujuan)</p>
            <br>___________________
        </div>
    </div>

</body>
</html>
