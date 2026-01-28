<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-3xl">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Survei Kepuasan Masyarakat</h2>
            <p class="mt-2 text-sm text-slate-600">Partisipasi Anda meningkatkan kualitas pelayanan kami.</p>
        </div>

        <div class="bg-white py-8 px-4 shadow-xl sm:rounded-[2.5rem] sm:px-10 border border-slate-100 relative overflow-hidden">
            <!-- Progress Bar -->
            <div class="absolute top-0 left-0 w-full h-2 bg-slate-100">
                <div class="h-full bg-blue-600 transition-all duration-500 ease-out" style="width: {{ $isSubmitted ? '100%' : ($step == 1 ? '50%' : '100%') }}"></div>
            </div>

            @if($isSubmitted)
                <div class="text-center py-12 animate-fade-in-up">
                    <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
                        <svg class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-2">Terima Kasih!</h3>
                    <p class="text-slate-500 max-w-md mx-auto">Masukan Anda sangat berharga bagi kami untuk terus meningkatkan kualitas pelayanan publik.</p>
                    <div class="mt-8">
                        <a href="/" class="text-blue-600 hover:text-blue-800 font-bold text-sm uppercase tracking-widest">Kembali ke Beranda</a>
                    </div>
                </div>
            @else
                <form wire:submit.prevent="save">
                    <!-- Step 1: Profil -->
                    <div class="{{ $step == 1 ? 'block' : 'hidden' }} animate-fade-in">
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <span class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 text-sm">1</span>
                                Data Responden
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="poli_id" value="Unit Layanan Dikunjungi" />
                                    <select wire:model="poli_id" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all" required>
                                        <option value="">-- Pilih Layanan --</option>
                                        @foreach($polis as $poli)
                                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('poli_id')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="umur" value="Umur (Tahun)" />
                                    <x-text-input wire:model="umur" type="number" class="mt-1 block w-full rounded-xl" placeholder="Contoh: 35" required />
                                    <x-input-error :messages="$errors->get('umur')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                                    <select wire:model="jenis_kelamin" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="pendidikan" value="Pendidikan Terakhir" />
                                    <select wire:model="pendidikan" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="SD">SD / Sederajat</option>
                                        <option value="SMP">SMP / Sederajat</option>
                                        <option value="SMA">SMA / Sederajat</option>
                                        <option value="D3">D3</option>
                                        <option value="S1">S1 / D4</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('pendidikan')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="pekerjaan" value="Pekerjaan Utama" />
                                    <select wire:model="pekerjaan" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="PNS">PNS / TNI / Polri</option>
                                        <option value="Pegawai Swasta">Pegawai Swasta</option>
                                        <option value="Wiraswasta">Wiraswasta / Usaha Sendiri</option>
                                        <option value="Pelajar/Mahasiswa">Pelajar / Mahasiswa</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('pekerjaan')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" wire:click="nextStep" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                Lanjut ke Penilaian
                                <svg class="ml-2 -mr-1 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Penilaian (9 Unsur) -->
                    <div class="{{ $step == 2 ? 'block' : 'hidden' }} animate-fade-in">
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <span class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 text-sm">2</span>
                                Penilaian Pelayanan
                            </h3>
                            
                            <div class="space-y-8">
                                @php
                                    $questions = [
                                        'u1_persyaratan' => 'Bagaimana pendapat Anda tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya?',
                                        'u2_prosedur' => 'Bagaimana kemudahan prosedur pelayanan di unit ini?',
                                        'u3_waktu' => 'Bagaimana kecepatan waktu dalam memberikan pelayanan?',
                                        'u4_biaya' => 'Bagaimana kewajaran biaya/tarif dalam pelayanan? (Gratis jika BPJS/Sesuai Ketentuan)',
                                        'u5_produk' => 'Bagaimana kesesuaian produk pelayanan antara yang tercantum dalam standar pelayanan dengan hasil yang diberikan?',
                                        'u6_kompetensi' => 'Bagaimana kompetensi/kemampuan petugas dalam pelayanan?',
                                        'u7_perilaku' => 'Bagaimana perilaku petugas dalam pelayanan terkait kesopanan dan keramahan?',
                                        'u8_maklumat' => 'Bagaimana kualitas sarana dan prasarana?', // U8 di permenpanrb sebenarnya penanganan pengaduan, U9 sarana. Tapi nama kolom di DB u8_maklumat. Saya sesuaikan konteks umum: maklumat/sarana.
                                        'u9_penanganan' => 'Bagaimana penanganan pengaduan, saran, dan masukan?',
                                    ];
                                @endphp

                                @foreach($questions as $field => $label)
                                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                                        <label class="block text-sm font-bold text-slate-800 mb-4">{{ $loop->iteration }}. {{ $label }}</label>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                            @foreach([1 => 'Tidak Baik', 2 => 'Kurang Baik', 3 => 'Baik', 4 => 'Sangat Baik'] as $val => $text)
                                                <label class="relative cursor-pointer group">
                                                    <input type="radio" wire:model="{{ $field }}" value="{{ $val }}" class="peer sr-only">
                                                    <div class="p-3 text-center rounded-xl border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-blue-300">
                                                        <div class="text-2xl mb-1 group-hover:scale-110 transition-transform">
                                                            @if($val == 1) 😠 @elseif($val == 2) 😐 @elseif($val == 3) 🙂 @else 😍 @endif
                                                        </div>
                                                        <span class="text-xs font-bold text-slate-500 peer-checked:text-blue-700">{{ $text }}</span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                        <x-input-error :messages="$errors->get($field)" class="mt-2" />
                                    </div>
                                @endforeach

                                <div>
                                    <x-input-label for="kritik_saran" value="Kritik & Saran Membangun" />
                                    <textarea wire:model="kritik_saran" rows="4" class="mt-1 block w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all text-sm" placeholder="Tuliskan pengalaman Anda..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-6 border-t border-slate-100">
                            <button type="button" wire:click="prevStep" class="text-slate-500 font-bold text-sm hover:text-slate-800 transition-colors">
                                &larr; Kembali
                            </button>
                            <button type="submit" class="inline-flex items-center px-8 py-3 border border-transparent text-sm font-bold rounded-xl shadow-xl shadow-blue-500/20 text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-1">
                                Kirim Survei
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>