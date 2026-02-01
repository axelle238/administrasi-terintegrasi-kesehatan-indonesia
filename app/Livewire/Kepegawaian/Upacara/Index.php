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
    public $bukti_foto; // Base64 String dari kamera
    public $keterangan;
    public $latitude;
    public $longitude;
    public $jarak_meter = 0;
    
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
            'keterangan' => 'nullable|string|max:255',
            'bukti_foto' => 'required|string', // Base64
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'jenis_upacara_id.required' => 'Pilih jenis upacara.',
            'bukti_foto.required' => 'Foto kehadiran wajib diambil.',
            'latitude.required' => 'Lokasi GPS wajib aktif.',
        ];
    }

    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            $user = Auth::user();
            $jenis = JenisUpacara::find($this->jenis_upacara_id);
            
            // 1. Validasi Radius (Geofencing)
            if ($jenis->target_latitude && $jenis->target_longitude) {
                $distance = $this->calculateDistance(
                    $this->latitude, 
                    $this->longitude, 
                    $jenis->target_latitude, 
                    $jenis->target_longitude
                );
                
                if ($distance > $jenis->radius_meter) {
                    $this->addError('latitude', "Lokasi Anda terlalu jauh ($distance m). Max radius: {$jenis->radius_meter} m.");
                    throw new \Illuminate\Validation\ValidationException($this->validator);
                }
            }

            // 2. Simpan Foto Base64
            $imagePath = null;
            if ($this->bukti_foto) {
                $image_parts = explode(";base64,", $this->bukti_foto);
                $image_base64 = base64_decode($image_parts[1] ?? $this->bukti_foto);
                $fileName = 'upacara_hadir_' . uniqid() . '.png';
                $path = 'upacara/' . $fileName;
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $image_base64);
                $imagePath = $path;
            }

            // 3. Simpan Presensi Upacara
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

            // 4. Integrasi ke LKH
            $lkh = LaporanHarian::firstOrCreate(
                ['user_id' => $user->id, 'tanggal' => $this->tanggal],
                ['status' => 'Draft']
            );

            $lkh->details()->create([
                'jam_mulai' => '07:00',
                'jam_selesai' => '08:00',
                'kegiatan' => 'Mengikuti ' . $jenis->nama_upacara,
                'output' => 'Terlaksana',
                'durasi' => 60,
            ]);
        });

        $this->reset(['jenis_upacara_id', 'bukti_foto', 'keterangan', 'latitude', 'longitude']);
        $this->dispatch('presensi-saved'); 
        session()->flash('message', 'Presensi upacara berhasil disimpan.');
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