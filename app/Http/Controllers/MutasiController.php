<?php

namespace App\Http\Controllers;

use App\Models\MutasiBarang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MutasiController extends Controller
{
    public function print(MutasiBarang $mutasi)
    {
        // Load relationships
        $mutasi->load(['barang', 'ruanganAsal', 'ruanganTujuan']);

        // Since we don't have DomPDF installed yet, let's return a simple view
        // In a real scenario, use PDF::loadView(...)->stream()
        return view('print.surat-jalan-mutasi', compact('mutasi'));
    }
}