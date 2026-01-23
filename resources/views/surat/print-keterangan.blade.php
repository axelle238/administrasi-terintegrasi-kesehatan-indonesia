<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan - {{ $surat->nomor_surat }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h3, .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 0; font-size: 10pt; }
        .content { margin: 0 40px; }
        .title { text-align: center; margin-bottom: 20px; text-decoration: underline; font-weight: bold; font-size: 14pt; }
        .subtitle { text-align: center; margin-top: -20px; margin-bottom: 30px; font-weight: bold; }
        .row { display: flex; margin-bottom: 5px; }
        .label { width: 180px; }
        .separator { width: 20px; }
        .value { flex: 1; font-weight: bold; }
        .footer { margin-top: 50px; text-align: right; margin-right: 40px; }
        .signature { margin-top: 80px; font-weight: bold; text-decoration: underline; }
        @media print {
            .no-print { display: none; }
            @page { margin: 2cm; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="no-print" style="margin-bottom: 20px; text-align: center;">
    <button onclick="window.print()" style="padding: 10px 20px;">Cetak</button>
    <button onclick="window.close()" style="padding: 10px 20px;">Tutup</button>
</div>

<div class="header">
    <h3>Pemerintah Kota Jakarta Selatan</h3>
    <h2>Puskesmas Kecamatan Jagakarsa</h2>
    <p>Jl. Moh. Kahfi I No.1, RT.1/RW.4, Jagakarsa, Kec. Jagakarsa, Kota Jakarta Selatan</p>
    <p>Telp: (021) 7863777</p>
</div>

<div class="content">
    @php
        $titles = [
            'Sehat' => 'SURAT KETERANGAN SEHAT',
            'Sakit' => 'SURAT KETERANGAN SAKIT',
            'Buta Warna' => 'SURAT KETERANGAN BUTA WARNA',
            'Bebas Narkoba' => 'SURAT KETERANGAN BEBAS NARKOBA',
        ];
        $title = $titles[$surat->jenis_surat] ?? 'SURAT KETERANGAN DOKTER';
    @endphp

    <div class="title">{{ $title }}</div>
    <div class="subtitle">Nomor: {{ $surat->nomor_surat }}</div>

    <p>Yang bertanda tangan di bawah ini, Dokter Pemeriksa Puskesmas Kecamatan Jagakarsa, menerangkan bahwa:</p>

    <div class="row">
        <div class="label">Nama</div>
        <div class="separator">:</div>
        <div class="value">{{ $surat->pasien->nama_lengkap }}</div>
    </div>
    <div class="row">
        <div class="label">NIK</div>
        <div class="separator">:</div>
        <div class="value">{{ $surat->pasien->nik }}</div>
    </div>
    <div class="row">
        <div class="label">Umur</div>
        <div class="separator">:</div>
        <div class="value">{{ \Carbon\Carbon::parse($surat->pasien->tanggal_lahir)->age }} Tahun</div>
    </div>
    <div class="row">
        <div class="label">Jenis Kelamin</div>
        <div class="separator">:</div>
        <div class="value">{{ $surat->pasien->jenis_kelamin }}</div>
    </div>
    <div class="row">
        <div class="label">Alamat</div>
        <div class="separator">:</div>
        <div class="value">{{ $surat->pasien->alamat }}</div>
    </div>

    <p>Telah dilakukan pemeriksaan kesehatan pada tanggal {{ \Carbon\Carbon::parse($surat->tanggal_surat)->isoFormat('D MMMM Y') }} dengan hasil sebagai berikut:</p>

    @if($surat->data_medis)
        <div style="margin-left: 20px; margin-bottom: 20px;">
            @if(isset($surat->data_medis['tinggi_badan']))
                <div class="row">
                    <div class="label">Tinggi Badan</div><div class="separator">:</div><div class="value">{{ $surat->data_medis['tinggi_badan'] }} cm</div>
                </div>
            @endif
            @if(isset($surat->data_medis['berat_badan']))
                <div class="row">
                    <div class="label">Berat Badan</div><div class="separator">:</div><div class="value">{{ $surat->data_medis['berat_badan'] }} kg</div>
                </div>
            @endif
            @if(isset($surat->data_medis['tekanan_darah']))
                <div class="row">
                    <div class="label">Tekanan Darah</div><div class="separator">:</div><div class="value">{{ $surat->data_medis['tekanan_darah'] }} mmHg</div>
                </div>
            @endif
            @if(isset($surat->data_medis['golongan_darah']) && $surat->data_medis['golongan_darah'])
                <div class="row">
                    <div class="label">Golongan Darah</div><div class="separator">:</div><div class="value">{{ $surat->data_medis['golongan_darah'] }}</div>
                </div>
            @endif
            @if(isset($surat->data_medis['buta_warna']))
                <div class="row">
                    <div class="label">Buta Warna</div><div class="separator">:</div><div class="value">{{ $surat->data_medis['buta_warna'] }}</div>
                </div>
            @endif
        </div>
    @endif

    @if($surat->jenis_surat == 'Sehat' || $surat->jenis_surat == 'Bebas Narkoba' || $surat->jenis_surat == 'Buta Warna')
        <p>Berdasarkan pemeriksaan fisik dan penunjang, yang bersangkutan dinyatakan <strong>{{ $surat->jenis_surat == 'Bebas Narkoba' ? 'TIDAK DITEMUKAN tanda-tanda penggunaan Narkoba' : 'SEHAT' }}</strong>.</p>
        @if($surat->keperluan)
            <p>Surat keterangan ini dipergunakan untuk: <strong>{{ $surat->keperluan }}</strong>.</p>
        @endif
    @elseif($surat->jenis_surat == 'Sakit')
        <p>Berdasarkan pemeriksaan, yang bersangkutan dalam keadaan <strong>SAKIT</strong> dan memerlukan istirahat selama <strong>{{ $surat->lama_istirahat }} ({{ ucwords(\NumberFormatter::create('id', \NumberFormatter::SPELLOUT)->format($surat->lama_istirahat)) }}) hari</strong>.</p>
        <p>Terhitung mulai tanggal {{ \Carbon\Carbon::parse($surat->mulai_istirahat)->isoFormat('D MMMM Y') }} sampai dengan {{ \Carbon\Carbon::parse($surat->mulai_istirahat)->addDays($surat->lama_istirahat - 1)->isoFormat('D MMMM Y') }}.</p>
    @endif

    <div class="footer">
        <p>Jakarta, {{ \Carbon\Carbon::parse($surat->tanggal_surat)->isoFormat('D MMMM Y') }}</p>
        <p>Dokter Pemeriksa,</p>
        <div class="signature">
            {{ $surat->dokter->name }}
        </div>
        <p>SIP. ...........................</p>
    </div>
</div>

</body>
</html>