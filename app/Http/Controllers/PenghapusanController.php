<?php

namespace App\Http\Controllers;

use App\Models\PenghapusanBarang;
use Illuminate\Http\Request;

class PenghapusanController extends Controller
{
    public function print(PenghapusanBarang $penghapusan)
    {
        $penghapusan->load(['details.barang', 'pemohon', 'approver']);
        return view('print.berita-acara-penghapusan', compact('penghapusan'));
    }
}