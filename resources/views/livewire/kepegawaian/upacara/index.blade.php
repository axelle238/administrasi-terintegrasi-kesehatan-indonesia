<div class="space-y-8 animate-fade-in" x-data="cameraApp()">
    
    <!-- Header Info -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl">
        <div class="absolute right-0 top-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-3 py-1 rounded-full bg-white/10 border border-white/20 text-[10px] font-bold uppercase tracking-widest text-blue-200">Live Presence</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                </div>
                <h2 class="text-3xl font-black tracking-tight">Presensi Upacara</h2>
                <p class="text-slate-400 text-sm mt-1 max-w-lg">
                    Ambil foto kehadiran Anda secara langsung di lokasi upacara. Sistem akan mencatat waktu dan koordinat lokasi secara otomatis.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- CAMERA & FORM SECTION -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm sticky top-24">
                
                <!-- GPS Status & Distance -->
                <div class="mb-6 p-4 rounded-xl border flex items-center justify-between" :class="gpsLocked ? 'bg-emerald-50 border-emerald-100' : 'bg-amber-50 border-amber-100'">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-full" :class="gpsLocked ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600 animate-pulse'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider" x-text="gpsLocked ? 'Lokasi Terkunci' : 'Mencari Lokasi...'"></p>
                            <p class="text-[10px] font-mono mt-0.5" x-text="coordsText"></p>
                        </div>
                    </div>
                    <div x-show="distance !== null" class="text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Jarak ke Lokasi</p>
                        <p class="text-lg font-black text-slate-800" :class="distance > 200 ? 'text-red-500' : 'text-emerald-600'" x-text="Math.round(distance) + ' m'"></p>
                    </div>
                </div>

                <form wire:submit.prevent="save" class="space-y-5">
                    
                    <!-- Status Kehadiran Toggle -->
                    <div class="flex bg-slate-100 p-1 rounded-xl">
                        <button type="button" @click="$wire.set('status_kehadiran', 'Hadir')" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all" :class="$wire.status_kehadiran === 'Hadir' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'">Hadir</button>
                        <button type="button" @click="$wire.set('status_kehadiran', 'Izin')" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all" :class="$wire.status_kehadiran === 'Izin' ? 'bg-white text-amber-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'">Izin</button>
                        <button type="button" @click="$wire.set('status_kehadiran', 'Sakit')" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all" :class="$wire.status_kehadiran === 'Sakit' ? 'bg-white text-red-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'">Sakit</button>
                    </div>

                    <!-- Jenis Upacara -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Jenis Upacara</label>
                        <div class="relative">
                            <select wire:model="jenis_upacara_id" x-model="selectedJenisId" class="w-full rounded-xl border-slate-200 text-sm font-bold text-slate-700 focus:border-blue-500 focus:ring-blue-500 py-3 pl-4 pr-10 appearance-none bg-slate-50 hover:bg-white transition-colors cursor-pointer">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($jenisUpacaraList as $jenis)
                                    <option value="{{ $jenis->id }}" data-lat="{{ $jenis->target_latitude }}" data-long="{{ $jenis->target_longitude }}">{{ $jenis->nama_upacara }} ({{ $jenis->kategori }})</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                        @error('jenis_upacara_id') <span class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- MODE HADIR: KAMERA -->
                    <div x-show="$wire.status_kehadiran === 'Hadir'" x-transition>
                        <div class="relative rounded-2xl overflow-hidden bg-black aspect-[3/4] shadow-inner group">
                            <!-- Video Feed -->
                            <video x-ref="video" class="absolute inset-0 w-full h-full object-cover" autoplay playsinline muted x-show="!photoTaken"></video>
                            
                            <!-- Captured Photo Preview -->
                            <img x-ref="photoPreview" class="absolute inset-0 w-full h-full object-cover" x-show="photoTaken">

                            <!-- Overlay Info -->
                            <div class="absolute bottom-0 inset-x-0 p-4 bg-gradient-to-t from-black/80 to-transparent text-white">
                                <p class="text-xl font-black font-mono tracking-tight" x-text="clock"></p>
                                <p class="text-[10px] font-mono opacity-80 truncate" x-text="coordsText"></p>
                            </div>

                            <!-- Loading Camera -->
                            <div class="absolute inset-0 flex items-center justify-center bg-slate-900 text-white z-20" x-show="loadingCamera">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-8 h-8 animate-spin text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span class="text-xs font-bold uppercase tracking-widest">Memuat Kamera</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <button type="button" @click="takePhoto" x-show="!photoTaken" :disabled="!gpsLocked" class="col-span-2 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold uppercase tracking-wider shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                Ambil Presensi
                            </button>

                            <button type="button" @click="resetCamera" x-show="photoTaken" class="py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                                Ulangi Foto
                            </button>

                            <button type="submit" x-show="photoTaken" class="py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="save">Kirim Data</span>
                                <span wire:loading wire:target="save">Mengirim...</span>
                            </button>
                        </div>
                    </div>

                    <!-- MODE IZIN/SAKIT: UPLOAD FILE -->
                    <div x-show="$wire.status_kehadiran !== 'Hadir'" x-transition>
                        <div class="flex items-center justify-center w-full">
                            <label for="file-upload" class="flex flex-col items-center justify-center w-full h-48 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-blue-50 transition-all group">
                                @if ($bukti_foto && !is_string($bukti_foto))
                                    <div class="text-center p-4">
                                        <p class="text-sm font-bold text-emerald-600">File Terpilih:</p>
                                        <p class="text-xs text-slate-500 truncate max-w-[200px]">{{ $bukti_foto->getClientOriginalName() }}</p>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-slate-400 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        <p class="text-xs text-slate-500"><span class="font-bold">Upload Surat Keterangan</span></p>
                                        <p class="text-[10px] text-slate-400 mt-1">PDF / JPG (Max 2MB)</p>
                                    </div>
                                @endif
                                <input id="file-upload" type="file" wire:model="bukti_foto" class="hidden" accept=".pdf,image/*" />
                            </label>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold uppercase tracking-wider shadow-lg shadow-blue-600/20 transition-all">
                                Ajukan Izin / Sakit
                            </button>
                        </div>
                    </div>
                    
                    @error('bukti_foto') <span class="text-[10px] text-red-500 font-bold mt-1 block text-center">{{ $message }}</span> @enderror
                    @error('latitude') <span class="text-[10px] text-red-500 font-bold mt-1 block text-center">{{ $message }}</span> @enderror

                    <!-- Keterangan -->
                    <div>
                        <textarea wire:model="keterangan" rows="2" placeholder="Catatan tambahan (opsional)..." class="w-full rounded-xl border-slate-200 text-sm font-medium text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50 hover:bg-white transition-colors"></textarea>
                    </div>
                </form>
            </div>
        </div>

        <!-- HISTORY SECTION -->
        <div class="lg:col-span-2">
            <h3 class="font-black text-slate-800 text-lg mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Riwayat Upacara
            </h3>

            <div class="space-y-4">
                @forelse($riwayat as $item)
                <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 hover:border-blue-200 hover:shadow-md transition-all group relative">
                    <div class="flex items-start gap-5">
                        <div class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 shrink-0 overflow-hidden relative group-hover:scale-105 transition-transform">
                            @if($item->bukti_foto)
                                <img src="{{ Storage::url($item->bukti_foto) }}" class="w-full h-full object-cover cursor-pointer" onclick="window.open(this.src)">
                            @else
                                <span class="text-[10px] font-bold uppercase">{{ $item->tanggal->translatedFormat('M') }}</span>
                                <span class="text-xl font-black">{{ $item->tanggal->format('d') }}</span>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-lg">{{ $item->jenisUpacara->nama_upacara }}</h4>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-0.5">{{ $item->jenisUpacara->kategori }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-wide">
                                        {{ $item->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-3 flex flex-wrap items-center gap-4 text-xs text-slate-500">
                                @if($item->latitude && $item->longitude)
                                    <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" target="_blank" class="flex items-center gap-1 text-blue-500 hover:underline">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        Lokasi Terpantau
                                    </a>
                                @endif
                                
                                @if($item->is_integrated_lkh)
                                    <span class="flex items-center gap-1 text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-md">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        LKH Sync
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 bg-slate-50 rounded-[2rem] border border-dashed border-slate-200">
                    <p class="text-slate-400 font-medium">Belum ada riwayat upacara.</p>
                </div>
                @endforelse

                {{ $riwayat->links() }}
            </div>
        </div>
    </div>

    <!-- Hidden Canvas for Processing -->
    <canvas id="canvas" class="hidden"></canvas>

    @script
    <script>
        Alpine.data('cameraApp', () => ({
            stream: null,
            photoTaken: false,
            loadingCamera: true,
            gpsLocked: false,
            coordsText: 'Mencari satelit...',
            clock: '00:00:00',
            latitude: null,
            longitude: null,
            selectedJenisId: '',
            targetLat: null,
            targetLong: null,
            distance: null,

            init() {
                this.startCamera();
                this.startGps();
                this.startClock();
                
                Livewire.on('presensi-saved', () => {
                    this.resetCamera();
                });

                // Watch Selection Change for Target Coords
                this.$watch('selectedJenisId', value => {
                    const option = document.querySelector(`option[value="${value}"]`);
                    if(option && option.dataset.lat) {
                        this.targetLat = parseFloat(option.dataset.lat);
                        this.targetLong = parseFloat(option.dataset.long);
                        this.calculateDistance();
                    } else {
                        this.targetLat = null;
                        this.targetLong = null;
                        this.distance = null;
                    }
                });
            },

            async startCamera() {
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({ 
                        video: { facingMode: 'user', width: { ideal: 720 }, height: { ideal: 960 } }, 
                        audio: false 
                    });
                    this.$refs.video.srcObject = this.stream;
                    this.loadingCamera = false;
                } catch (error) {
                    console.error("Camera Error:", error);
                    // Silent fail if needed, or show UI placeholder
                    this.loadingCamera = false;
                }
            },

            startGps() {
                if ("geolocation" in navigator) {
                    navigator.geolocation.watchPosition((position) => {
                        this.latitude = position.coords.latitude;
                        this.longitude = position.coords.longitude;
                        this.gpsLocked = true;
                        this.coordsText = `${this.latitude.toFixed(6)}, ${this.longitude.toFixed(6)}`;
                        
                        // Sync to Livewire
                        @this.set('latitude', this.latitude);
                        @this.set('longitude', this.longitude);
                        
                        this.calculateDistance();
                    }, (error) => {
                        this.coordsText = "Gagal mendapatkan lokasi.";
                        console.error("GPS Error:", error);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    });
                } else {
                    this.coordsText = "GPS tidak didukung.";
                }
            },

            calculateDistance() {
                if (this.latitude && this.longitude && this.targetLat && this.targetLong) {
                    const R = 6371e3; // metres
                    const φ1 = this.latitude * Math.PI/180; // φ, λ in radians
                    const φ2 = this.targetLat * Math.PI/180;
                    const Δφ = (this.targetLat - this.latitude) * Math.PI/180;
                    const Δλ = (this.targetLong - this.longitude) * Math.PI/180;

                    const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                            Math.cos(φ1) * Math.cos(φ2) *
                            Math.sin(Δλ/2) * Math.sin(Δλ/2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

                    this.distance = R * c; // in metres
                }
            },

            startClock() {
                setInterval(() => {
                    const now = new Date();
                    this.clock = now.toLocaleTimeString('id-ID', { hour12: false });
                }, 1000);
            },

            takePhoto() {
                if (!this.gpsLocked) {
                    alert("Tunggu hingga lokasi terkunci!");
                    return;
                }

                const video = this.$refs.video;
                const canvas = document.getElementById('canvas');
                const context = canvas.getContext('2d');

                // Set Canvas Size matches Video
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                // Draw Video Frame
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // --- ADD WATERMARK ---
                const now = new Date();
                const dateStr = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                const timeStr = now.toLocaleTimeString('id-ID');
                
                // Gradient Background for Text
                const gradient = context.createLinearGradient(0, canvas.height - 150, 0, canvas.height);
                gradient.addColorStop(0, "transparent");
                gradient.addColorStop(1, "rgba(0,0,0,0.8)");
                context.fillStyle = gradient;
                context.fillRect(0, canvas.height - 150, canvas.width, 150);

                // Draw Text
                context.fillStyle = "white";
                context.font = "bold 30px monospace";
                context.fillText(timeStr, 20, canvas.height - 80);
                
                context.font = "20px sans-serif";
                context.fillText(dateStr, 20, canvas.height - 50);
                
                context.font = "16px monospace";
                context.fillText(`${this.latitude}, ${this.longitude}`, 20, canvas.height - 25);

                // Export to Base64
                const dataUrl = canvas.toDataURL('image/png');
                
                // Set Preview & Livewire
                this.$refs.photoPreview.src = dataUrl;
                @this.set('bukti_foto', dataUrl);
                
                this.photoTaken = true;
            },

            resetCamera() {
                this.photoTaken = false;
                @this.set('bukti_foto', null);
            }
        }))
    </script>
    @endscript
</div>