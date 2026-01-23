<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Berobat - {{ $pasien->nama_lengkap }}</title>
    <style>
        body { font-family: sans-serif; -webkit-print-color-adjust: exact; }
        .card {
            width: 85.6mm;
            height: 53.98mm;
            border: 1px solid #000;
            border-radius: 8px;
            padding: 10px;
            position: relative;
            background: #f0fdf4; /* Green-50 */
            background-image: linear-gradient(to bottom right, #f0fdf4, #bbf7d0);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #166534; /* Green-700 */
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 14px;
            margin: 0;
            color: #166534;
            text-transform: uppercase;
        }
        .header p {
            font-size: 8px;
            margin: 0;
        }
        .content {
            font-size: 10px;
        }
        .row {
            margin-bottom: 4px;
            display: flex;
        }
        .label {
            width: 60px;
            font-weight: bold;
        }
        .value {
            flex: 1;
            font-weight: bold;
            color: #000;
        }
        .footer {
            position: absolute;
            bottom: 10px;
            left: 10px;
            right: 10px;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
        .barcode {
            position: absolute;
            bottom: 10px;
            right: 10px;
            text-align: right;
        }
        @media print {
            body { margin: 0; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="card">
        <div class="header">
            <h1>KARTU BEROBAT</h1>
            <p>PUSKESMAS JAGAKARSA</p>
            <p>Jl. Jagakarsa Raya No. 1, Jakarta Selatan</p>
        </div>
        <div class="content">
            <div class="row">
                <span class="label">No. RM</span>
                <span class="value">: {{ str_pad($pasien->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="row">
                <span class="label">Nama</span>
                <span class="value">: {{ strtoupper($pasien->nama_lengkap) }}</span>
            </div>
            <div class="row">
                <span class="label">Tgl Lahir</span>
                <span class="value">: {{ date('d-m-Y', strtotime($pasien->tanggal_lahir)) }}</span>
            </div>
            <div class="row">
                <span class="label">Alamat</span>
                <span class="value">: {{ substr($pasien->alamat, 0, 30) }}...</span>
            </div>
        </div>
        <div class="footer">
            *Harap dibawa setiap kali berobat
        </div>
    </div>
</body>
</html>
