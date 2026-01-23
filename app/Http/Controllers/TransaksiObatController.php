<?php

namespace App\Http\Controllers;

use App\Models\TransaksiObat;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = TransaksiObat::with('obat')->latest()->paginate(10);
        return view('transaksi-obat.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $obats = Obat::all();
        return view('transaksi-obat.create', compact('obats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'jenis_transaksi' => 'required|in:Masuk,Keluar',
            'jumlah' => 'required|integer|min:1',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $obat = Obat::findOrFail($request->obat_id);

        // Validasi stok jika keluar
        if ($request->jenis_transaksi == 'Keluar' && $obat->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk transaksi keluar. Stok saat ini: ' . $obat->stok)->withInput();
        }

        try {
            DB::beginTransaction();

            // 1. Catat Transaksi
            TransaksiObat::create([
                'obat_id' => $request->obat_id,
                'jenis_transaksi' => $request->jenis_transaksi,
                'jumlah' => $request->jumlah,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'keterangan' => $request->keterangan,
                'pencatat' => auth()->user()->name ?? 'Sistem',
            ]);

            // 2. Update Stok Obat
            if ($request->jenis_transaksi == 'Masuk') {
                $obat->increment('stok', $request->jumlah);
            } else {
                $obat->decrement('stok', $request->jumlah);
            }

            DB::commit();
            return redirect()->route('transaksi-obat.index')->with('success', 'Transaksi berhasil dicatat dan stok diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Fitur edit/delete transaksi dimatikan untuk menjaga integritas stok, 
    // atau harus implementasi logika rollback stok yang kompleks.
    // Untuk prototipe ini, kita hanya izinkan Create & Read.
}