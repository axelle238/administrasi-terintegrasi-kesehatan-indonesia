<?php

namespace App\Livewire\Kepegawaian\Upacara;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PresensiUpacara;
use App\Models\JenisUpacara;
use App\Models\LaporanHarian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithFileUploads;

    // Form Properties
    public $jenis_upacara_id;
    public $tanggal;
    public $bukti_foto;
    public $keterangan;
    
    public $confirmingDelete = null;

    public function mount()
    {
        $this->tanggal = Carbon::today()->format('Y-m-d');
    }

    public function rules()
    {
        return [
            'jenis_upacara_id' => 'required|exists:jenis_upacaras,id',
            'tanggal' => 'required|date',
            'bukti_foto' => 'nullable|image|max:2048', // 2MB Max
            'keterangan' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'jenis_upacara_id.required' => 'Pilih jenis upacara.',
            'bukti_foto.image' => 'File harus berupa gambar.',
            'bukti_foto.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            $user = Auth::user();
            $jenis = JenisUpacara::find($this->jenis_upacara_id);
            
            // 1. Simpan Presensi Upacara
            $path = null;
            if ($this->bukti_foto) {
                $path = $this->bukti_foto->store('upacara', 'public');
            }

            $presensi = PresensiUpacara::create([
                'user_id' => $user->id,
                'jenis_upacara_id' => $this->jenis_upacara_id,
                'tanggal' => $this->tanggal,
                'bukti_foto' => $path,
                'keterangan' => $this->keterangan,
                'status' => 'Hadir',
                'is_integrated_lkh' => true,
            ]);

            // 2. Integrasi ke Laporan Aktivitas (LKH)
            // Cari/Buat Header LKH
            $lkh = LaporanHarian::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'tanggal' => $this->tanggal
                ],
                [
                    'status' => 'Draft',
                    'waktu_verifikasi' => null
                ]
            );

            // Tambahkan Detail Kegiatan
            $jamMulai = '07:00';
            $jamSelesai = '08:00'; // Default durasi 1 jam untuk upacara
            
            // Cek jika bentrok dengan kegiatan lain? (Optional, skip for simplicity)
            
            $lkh->details()->create([
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'kegiatan' => 'Mengikuti ' . $jenis->nama_upacara,
                'output' => 'Terlaksana',
                'durasi' => 60,
            ]);
        });

        $this->reset(['jenis_upacara_id', 'bukti_foto', 'keterangan']);
        session()->flash('message', 'Presensi upacara berhasil disimpan dan dicatat ke LKH.');
    }

    public function delete($id)
    {
        $presensi = PresensiUpacara::where('user_id', Auth::id())->find($id);
        if($presensi) {
            // Hapus LKH terkait? 
            // Untuk keamanan data, kita hanya hapus record presensi upacara saja
            // User harus menghapus manual di LKH jika ingin membatalkan laporannya
            // Atau kita bisa implementasi logic hapus LKH Detail jika perlu.
            $presensi->delete();
            session()->flash('message', 'Data berhasil dihapus.');
        }
    }

    public function render()
    {
        $riwayat = PresensiUpacara::with('jenisUpacara')
            ->where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->paginate(5);

        $jenisUpacaraList = JenisUpacara::where('is_active', true)->get();

        return view('livewire.kepegawaian.upacara.index', [
            'riwayat' => $riwayat,
            'jenisUpacaraList' => $jenisUpacaraList
        ])->layout('layouts.app', ['header' => 'Presensi Upacara']);
    }
}