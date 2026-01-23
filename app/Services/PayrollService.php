<?php

namespace App\Services;

use App\Models\JadwalJaga;
use App\Models\Pegawai;
use Carbon\Carbon;

class PayrollService
{
    /**
     * Hitung Potongan berdasarkan Kehadiran
     */
    public function calculateDeductions($userId, $month, $year)
    {
        $pegawai = Pegawai::where('user_id', $userId)->first();
        if (!$pegawai) return 0;

        // Convert month name to number
        $monthNum = Carbon::parse($month)->month;

        $alphas = JadwalJaga::where('pegawai_id', $pegawai->id)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $monthNum)
            ->where('status_kehadiran', 'Alpha')
            ->count();

        // Policy: Potongan 100k per alpha
        $dendaAlpha = $alphas * 100000;

        return $dendaAlpha;
    }
}