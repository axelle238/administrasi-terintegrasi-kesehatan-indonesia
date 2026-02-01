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
    public $bukti_foto; // Akan berisi Base64 String dari kamera
    public $keterangan;
    public $latitude;
    public $longitude;
    
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
            'bukti_foto' => 'required|string', // Base64
            'latitude' => 'required',
            'longitude' => 'required',
            'keterangan' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'jenis_upacara_id.required' => 'Pilih jenis upacara.',
            'bukti_foto.required' => 'Foto kehadiran wajib diambil.',
            'latitude.required' => 'Lokasi GPS tidak terdeteksi. Izinkan akses lokasi.',
        ];
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            $user = Auth::user();
            $jenis = JenisUpacara::find($this->jenis_upacara_id);
            
            // 1. Proses Simpan Foto Base64
            $imagePath = null;
            if ($this->bukti_foto) {
                // Decode Base64
                $image_parts = explode(";base64,", $this->bukti_foto);
                $image_base64 = base64_decode($image_parts[1]);
                
                // Generate Filename
                $fileName = 'upacara_' . uniqid() . '.png';
                $path = 'upacara/' . $fileName;
                
                // Store
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $image_base64);
                $imagePath = $path;
            }

            // 2. Simpan Presensi Upacara
            PresensiUpacara::create([
                'user_id' => $user->id,
                'jenis_upacara_id' => $this->jenis_upacara_id,
                'tanggal' => $this->tanggal,
                'bukti_foto' => $imagePath,
                'keterangan' => $this->keterangan,
                'status' => 'Hadir',
                'is_integrated_lkh' => true,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);

            // 3. Integrasi ke Laporan Aktivitas (LKH)
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
            $lkh->details()->create([
                'jam_mulai' => '07:00',
                'jam_selesai' => '08:00',
                'kegiatan' => 'Mengikuti ' . $jenis->nama_upacara,
                'output' => 'Terlaksana',
                'durasi' => 60,
            ]);
        });

        $this->reset(['jenis_upacara_id', 'bukti_foto', 'keterangan', 'latitude', 'longitude']);
        $this->dispatch('presensi-saved'); // Trigger JS event to reset camera
        session()->flash('message', 'Presensi upacara berhasil disimpan dengan data lokasi.');
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