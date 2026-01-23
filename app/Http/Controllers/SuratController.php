<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    // ... (Previous methods can remain or be replaced by Livewire mostly, but printDisposition is key here)

    public function printDisposition(Surat $surat)
    {
        // Load relation
        $surat->load(['disposisiSurats.pengirim', 'disposisiSurats.penerima']);
        
        return view('surat.print-disposisi', compact('surat'));
    }
}