<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Peminjaman - {{ $peminjaman->no_transaksi }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; font-size: 12px; }
        .receipt { border: 1px dashed #333; padding: 20px; max-width: 80mm; margin: 0 auto; }
        .header { text-align: center; border-bottom: 1px solid #000; padding-bottom: 10px; margin-bottom: 15px; }
        .header h3 { margin: 0; }
        .item { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .label { font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; }
        .sign-area { margin-top: 30px; display: flex; justify-content: space-between; }
        .sign-box { text-align: center; width: 45%; }
    </style>
</head>
<body onload="window.print()">

    <div class="receipt">
        <div class="header">
            <h3>BUKTI PEMINJAMAN</h3>
            <p>Puskesmas Jagakarsa</p>
        </div>

        <div class="item">
            <span class="label">No Transaksi:</span>
            <span>{{ $peminjaman->no_transaksi }}</span>
        </div>
        <div class="item">
            <span class="label">Tanggal:</span>
            <span>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</span>
        </div>
        <div class="item">
            <span class="label">Peminjam:</span>
            <span>{{ $peminjaman->pegawai->user->name ?? 'Guest' }}</span>
        </div>
        <div class="item">
            <span class="label">Unit/Bagian:</span>
            <span>{{ $peminjaman->pegawai->unit_kerja ?? '-' }}</span>
        </div>

        <div style="border-top: 1px dashed #000; margin: 10px 0;"></div>

        <div style="margin-bottom: 10px;">
            <strong>{{ $peminjaman->barang->nama_barang }}</strong><br>
            <span style="font-size: 10px;">{{ $peminjaman->barang->kode_barang }}</span>
        </div>

        <div class="item">
            <span class="label">Kondisi Awal:</span>
            <span>{{ $peminjaman->kondisi_keluar }}</span>
        </div>
        <div class="item">
            <span class="label">Rencana Kembali:</span>
            <span>{{ $peminjaman->tanggal_kembali_rencana ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d/m/Y') : '-' }}</span>
        </div>

        <div class="sign-area">
            <div class="sign-box">
                <br><br><br>
                (Petugas)
            </div>
            <div class="sign-box">
                <br><br><br>
                (Peminjam)
            </div>
        </div>

        <div class="footer">
            * Harap simpan struk ini sebagai bukti.<br>
            * Denda berlaku jika barang hilang/rusak.
        </div>
    </div>

</body>
</html>
