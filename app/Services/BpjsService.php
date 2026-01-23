<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BpjsService
{
    /**
     * Simulasi Cek Peserta BPJS (P-Care)
     */
    public function checkPeserta($nomorKartu)
    {
        // Simulasi Response API
        // Dalam implementasi nyata, ini akan hit API BPJS TrustMark
        
        // Logic Simulasi: 
        // Jika nomor kartu genap = Aktif
        // Jika ganjil = Tidak Aktif / Penunggakan
        
        $status = intval($nomorKartu) % 2 == 0 ? 'AKTIF' : 'TIDAK AKTIF';
        
        return [
            'metaData' => [
                'code' => '200',
                'message' => 'OK'
            ],
            'response' => [
                'noKartu' => $nomorKartu,
                'nama' => 'Peserta Simulasi ' . substr($nomorKartu, -4),
                'hubunganKeluarga' => 'Peserta',
                'statusPeserta' => [
                    'kode' => $status == 'AKTIF' ? '0' : '1',
                    'keterangan' => $status
                ],
                'kelasTanggungan' => [
                    'kode' => '3',
                    'keterangan' => 'KELAS III'
                ],
                'providerPelayanan' => [
                    'kode' => '01234567',
                    'nama' => 'PUSKESMAS JAGAKARSA'
                ]
            ]
        ];
    }

    /**
     * Simulasi Bridging Pendaftaran (Kunjungan)
     */
    public function createKunjungan($data)
    {
        return [
            'metaData' => [
                'code' => '201',
                'message' => 'Created'
            ],
            'response' => [
                'noKunjungan' => '01234567' . date('dmY') . rand(1000,9999),
                'date' => date('Y-m-d')
            ]
        ];
    }
}