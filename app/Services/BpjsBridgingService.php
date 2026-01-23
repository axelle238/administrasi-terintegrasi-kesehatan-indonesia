<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class BpjsBridgingService
{
    protected $consId;
    protected $secretKey;
    protected $userKey;
    protected $baseUrl;
    protected $serviceName;
    protected $mode;

    public function __construct()
    {
        $settings = Setting::where('group', 'bpjs')->pluck('value', 'key');
        
        $this->consId = $settings['bpjs_cons_id'] ?? '';
        $this->secretKey = $settings['bpjs_secret_key'] ?? '';
        $this->userKey = $settings['bpjs_user_key'] ?? '';
        $this->baseUrl = $settings['bpjs_api_url'] ?? '';
        $this->serviceName = $settings['bpjs_service_name'] ?? 'pcare-rest-dev';
        $this->mode = $settings['bpjs_mode'] ?? 'dev';
    }

    protected function getHeaders()
    {
        $timestamp = time();
        $data = $this->consId . '&' . $timestamp;
        $signature = base64_encode(hash_hmac('sha256', $data, $this->secretKey, true));

        return [
            'X-cons-id' => $this->consId,
            'X-timestamp' => $timestamp,
            'X-signature' => $signature,
            'user_key' => $this->userKey,
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Kirim Data Pendaftaran (Visit) ke BPJS
     */
    public function addPendaftaran($data)
    {
        if ($this->mode === 'dev') {
            // Simulasi Sukses
            return [
                'status' => 'success',
                'data' => [
                    'noUrut' => $data['noUrut'] ?? 'A-001',
                    'noKunjungan' => '0001R00101' . date('ymd') . '0001', // Format No Kunjungan BPJS
                    'tglKunjungan' => date('Y-m-d'),
                    'status' => 'Berhasil Bridging'
                ]
            ];
        }

        // Production: Http::post
        return ['status' => 'error', 'message' => 'Prod not implemented'];
    }

    /**
     * Update Task ID Antrean (Mobile JKN)
     * Task 1: Checkin, 2: Panggil, 3: Dilayani, etc.
     */
    public function updateTaskId($kodebooking, $taskid, $waktu)
    {
        if ($this->mode === 'dev') {
            return [
                'status' => 'success',
                'message' => "Task ID $taskid updated for $kodebooking at $waktu"
            ];
        }
        
        return ['status' => 'error', 'message' => 'Prod not implemented'];
    }

    /**
     * Cari Peserta by NIK / NoKartu
     */
    public function getPeserta($keyword, $type = 'nik')
    {
        if ($this->mode === 'dev') {
            return $this->mockPeserta($keyword);
        }

        // Real API Call Implementation (Simplified for placeholder)
        // In production, this would use Http::withHeaders(...)->get(...)
        // and decrypt the response.
        
        return [
            'status' => 'error',
            'message' => 'Koneksi ke server BPJS (Production) belum dikonfigurasi. Gunakan mode DEV untuk simulasi.'
        ];
    }

    protected function mockPeserta($keyword)
    {
        // Simulate Success Response from BPJS
        return [
            'status' => 'success',
            'data' => [
                'nama' => 'Budi Santoso (BPJS)',
                'nik' => strlen($keyword) == 16 ? $keyword : '3174000000000001',
                'noKartu' => strlen($keyword) != 16 ? $keyword : '0001234567890',
                'tglLahir' => '1990-05-15',
                'sex' => 'L', // L/P
                'kelasTanggungan' => [
                    'kdKelas' => '3',
                    'nmKelas' => 'Kelas 3'
                ],
                'statusPeserta' => [
                    'keterangan' => 'AKTIF'
                ],
                'jenisPeserta' => [
                    'keterangan' => 'PEKERJA MANDIRI'
                ],
                'provUmum' => [
                    'nmProvider' => 'PUSKESMAS JAGAKARSA'
                ]
            ]
        ];
    }

    /**
     * Get Dokter from PCare
     */
    public function getDokter($start = 0, $limit = 10)
    {
        if ($this->mode === 'dev') {
            return [
                'status' => 'success',
                'data' => [
                    [
                        'kdDokter' => 'D001',
                        'nmDokter' => 'Dr. Budi Gunawan (BPJS)',
                    ],
                    [
                        'kdDokter' => 'D002',
                        'nmDokter' => 'Dr. Siti Aminah (BPJS)',
                    ]
                ]
            ];
        }
        
        return ['status' => 'error', 'message' => 'Not implemented in prod'];
    }
}
