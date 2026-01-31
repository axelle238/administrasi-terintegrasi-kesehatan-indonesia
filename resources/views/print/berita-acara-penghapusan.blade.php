<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Penghapusan - {{ $penghapusan->nomor_dokumen }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; line-height: 1.6; padding: 40px; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 0; font-size: 12px; }
        .title { text-align: center; font-weight: bold; text-decoration: underline; margin: 30px 0; font-size: 14px; text-transform: uppercase; }
        .content { font-size: 12px; text-align: justify; }
        .table-data { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table-data th, .table-data td { border: 1px solid #000; padding: 6px; font-size: 11px; }
        .table-data th { background-color: #f0f0f0; text-align: center; }
        .signature { width: 100%; margin-top: 50px; display: table; }
        .sign-col { display: table-cell; width: 33%; text-align: center; vertical-align: top; }
        .sign-col p { margin-bottom: 70px; font-weight: bold; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>Pemerintah Kota Jakarta Selatan</h2>
        <h2>Puskesmas Kecamatan Jagakarsa</h2>
        <p>Jl. Moh. Kahfi I No.17, RT.10/RW.1, Ciganjur, Kec. Jagakarsa, Kota Jakarta Selatan, DKI Jakarta 12630</p>
    </div>

    <div class="title">Berita Acara Penghapusan Barang Inventaris</div>

    <div class="content">
        <p>Pada hari ini, <strong>{{ \Carbon\Carbon::parse($penghapusan->tanggal_disetujui ?? now())->isoFormat('dddd, D MMMM Y') }}</strong>, kami yang bertanda tangan di bawah ini:</p>
    </div>

    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Barang</th>
                <th width="15%">Kode Barang</th>
                <th width="10%">Tahun</th>
                <th width="10%">Kondisi</th>
                <th width="10%">Jml</th>
                <th width="20%">Alasan Penghapusan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penghapusan->details as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->barang->nama_barang }}</td>
                <td>{{ $item->barang->kode_barang }}</td>
                <td style="text-align: center;">{{ $item->barang->tanggal_pengadaan ? \Carbon\Carbon::parse($item->barang->tanggal_pengadaan)->year : '-' }}</td>
                <td style="text-align: center;">{{ $item->kondisi_terakhir }}</td>
                <td style="text-align: center;">{{ $item->jumlah }}</td>
                <td>{{ $item->alasan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="content">
        <p>Demikian Berita Acara ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <div class="sign-col">
            <p>Pengurus Barang</p>
            <br><br><br>
            (______________________)
        </div>
        <div class="sign-col">
            <p>Mengetahui,<br>Kepala Bagian Tata Usaha</p>
            <br><br><br>
            (______________________)
        </div>
        <div class="sign-col">
            <p>Pemohon</p>
            <br>
            <span style="text-decoration: underline; font-weight: bold;">{{ $penghapusan->pemohon->name ?? '......................' }}</span><br>
            NIP. {{ $penghapusan->pemohon->nip ?? '......................' }}
        </div>
    </div>

</body>
</html>
