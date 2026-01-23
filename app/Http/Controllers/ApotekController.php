<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Setting;
use Illuminate\Http\Request;

class ApotekController extends Controller
{
    public function printEtiket(RekamMedis $rekamMedis)
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('apotek.print-etiket', compact('rekamMedis', 'settings'));
    }
}