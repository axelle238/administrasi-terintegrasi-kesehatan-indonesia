<?php

namespace App\Services;

use App\Models\User;
use App\Models\Pegawai;

class PayrollService
{
    /**
     * Hitung estimasi gaji berdasarkan data pegawai dan aturan perusahaan.
     */
    public function calculatePayroll(User $user, $bulan, $tahun)
    {
        // 1. Base Salary by Role (Simulasi Standar Gaji)
        $gajiPokok = match($user->role) {
            'dokter' => 7000000,
            'apoteker' => 5000000,
            'perawat' => 4500000,
            'admin' => 4000000,
            default => 3500000
        };

        // 2. Tunjangan
        $tunjanganJabatan = 0;
        if ($user->role == 'dokter') $tunjanganJabatan = 2000000;
        if ($user->role == 'apoteker') $tunjanganJabatan = 1000000;

        $tunjanganFungsional = 500000; // Flat untuk tenaga medis
        $tunjanganUmum = 200000;
        
        // Simulasi Kehadiran (20 Hari Kerja)
        $hariKerja = 20; 
        $uangMakanHarian = 30000;
        $uangTransportHarian = 20000;
        
        $tunjanganMakan = $hariKerja * $uangMakanHarian;
        $tunjanganTransport = $hariKerja * $uangTransportHarian;

        $totalTunjangan = $tunjanganJabatan + $tunjanganFungsional + $tunjanganUmum + $tunjanganMakan + $tunjanganTransport;

        // 3. Potongan (BPJS & Pajak)
        // BPJS Kesehatan (1% Pegawai, 4% Kantor - disini kita hitung yg dipotong dari gaji pegawai)
        $potonganBpjsKes = $gajiPokok * 0.01; 
        
        // BPJS TK (2% JHT)
        $potonganBpjsTk = $gajiPokok * 0.02;

        // PPh 21 (Simulasi 5% dari PKP sebulan - simplifikasi)
        $potonganPph21 = ($gajiPokok + $totalTunjangan) * 0.05;

        // Absensi (Simulasi 0)
        $potonganAbsen = 0;

        $totalPotongan = $potonganBpjsKes + $potonganBpjsTk + $potonganPph21 + $potonganAbsen;

        return [
            'gaji_pokok' => $gajiPokok,
            'tunjangan' => [
                'jabatan' => $tunjanganJabatan,
                'fungsional' => $tunjanganFungsional,
                'umum' => $tunjanganUmum,
                'makan' => $tunjanganMakan,
                'transport' => $tunjanganTransport,
                'total' => $totalTunjangan
            ],
            'potongan' => [
                'bpjs_kesehatan' => $potonganBpjsKes,
                'bpjs_tk' => $potonganBpjsTk,
                'pph21' => $potonganPph21,
                'absen' => $potonganAbsen,
                'total' => $totalPotongan
            ],
            'total_gaji' => ($gajiPokok + $totalTunjangan) - $totalPotongan
        ];
    }
}