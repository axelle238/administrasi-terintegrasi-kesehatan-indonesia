<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBarang;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function print(PeminjamanBarang $peminjaman)
    {
        $peminjaman->load(['barang', 'pegawai.user']);
        return view('print.bukti-peminjaman', compact('peminjaman'));
    }
}