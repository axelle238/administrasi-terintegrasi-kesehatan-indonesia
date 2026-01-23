<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasiens = Pasien::latest()->paginate(10);
        return view('pasien.index', compact('pasiens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|unique:pasiens,nik|max:16',
            'no_bpjs' => 'nullable|string|max:20',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
        ]);

        Pasien::create($request->all());

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasien $pasien)
    {
        // Load riwayat medis, urutkan dari yang terbaru
        $pasien->load(['rekamMedis.dokter', 'rekamMedis.obats']);
        return view('pasien.show', compact('pasien'));
    }

    /**
     * Cetak Kartu Berobat
     */
    public function printCard(Pasien $pasien)
    {
        return view('pasien.card', compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nik' => 'required|string|max:16|unique:pasiens,nik,' . $pasien->id,
            'no_bpjs' => 'nullable|string|max:20',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
        ]);

        $pasien->update($request->all());

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}
