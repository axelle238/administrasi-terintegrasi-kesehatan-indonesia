<?php

namespace App\Http\Controllers;

use App\Models\SuratKeterangan;
use Illuminate\Http\Request;

class SuratKeteranganController extends Controller
{
    public function print(SuratKeterangan $surat)
    {
        return view('surat.print-keterangan', compact('surat'));
    }
}