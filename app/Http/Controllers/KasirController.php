<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    /**
     * Daftar Tagihan (Belum Lunas & Lunas)
     */
    public function index()
    {
        // Ambil data pembayaran, urutkan yang belum lunas di atas
        $tagihans = Pembayaran::with(['rekamMedis.pasien', 'rekamMedis.dokter'])
            ->orderByRaw("FIELD(status_pembayaran, 'Belum Lunas', 'Lunas')")
            ->latest()
            ->paginate(10);

        return view('kasir.index', compact('tagihans'));
    }

    /**
     * Detail Tagihan & Form Pembayaran
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::with(['rekamMedis.pasien', 'rekamMedis.tindakans', 'rekamMedis.obats'])->findOrFail($id);
        return view('kasir.show', compact('pembayaran'));
    }

    /**
     * Proses Pembayaran
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:Tunai,QRIS,Debit,BPJS',
            'bayar' => 'required_if:metode_pembayaran,Tunai,QRIS,Debit|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $pembayaran = Pembayaran::findOrFail($id);
            
            // Jika BPJS, total bayar dianggap ditanggung (0 untuk pasien, tapi tercatat)
            // Di sini kita asumsikan flow sederhana: Jika BPJS, status lunas, tapi nominal tetap tercatat untuk klaim.
            
            $pembayaran->update([
                'status_pembayaran' => 'Lunas',
                'metode_pembayaran' => $request->metode_pembayaran,
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('kasir.index')->with('success', 'Pembayaran berhasil diproses. Kwitansi siap cetak.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
    
    /**
     * Cetak Kwitansi (Simulasi)
     */
    public function print($id)
    {
        $pembayaran = Pembayaran::with(['rekamMedis.pasien', 'rekamMedis.tindakans', 'rekamMedis.obats'])->findOrFail($id);
        return view('kasir.print', compact('pembayaran'));
    }
}