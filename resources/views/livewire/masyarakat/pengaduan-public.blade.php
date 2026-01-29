<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
            </div>
        </div>
        <h2 class="mt-6 text-center text-3xl font-black text-slate-900 tracking-tight">Layanan Pengaduan</h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Sampaikan aspirasi dan keluhan Anda demi peningkatan kualitas layanan kami.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-xl">
        <div class="bg-white py-8 px-4 shadow-xl shadow-slate-200/50 sm:rounded-2xl sm:px-10 border border-slate-100">
            <form wire:submit.prevent="submit" class="space-y-6">
                <!-- Identitas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_pelapor" class="block text-sm font-bold text-slate-700">Nama Lengkap</label>
                        <div class="mt-1">
                            <input wire:model="nama_pelapor" id="nama_pelapor" type="text" required 
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all">
                        </div>
                        @error('nama_pelapor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="no_telepon_pelapor" class="block text-sm font-bold text-slate-700">No. WhatsApp</label>
                        <div class="mt-1">
                            <input wire:model="no_telepon_pelapor" id="no_telepon_pelapor" type="text" required 
                                class="appearance-none block w-full px-3 py-2.5 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all">
                        </div>
                        @error('no_telepon_pelapor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="email_pelapor" class="block text-sm font-bold text-slate-700">Email (Opsional)</label>
                    <div class="mt-1">
                        <input wire:model="email_pelapor" id="email_pelapor" type="email" 
                            class="appearance-none block w-full px-3 py-2.5 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all">
                    </div>
                    @error('email_pelapor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Isi Pengaduan -->
                <div class="pt-4 border-t border-slate-100">
                    <label for="subjek" class="block text-sm font-bold text-slate-700">Perihal / Subjek</label>
                    <div class="mt-1">
                        <input wire:model="subjek" id="subjek" type="text" required placeholder="Misal: Pelayanan Farmasi Lambat"
                            class="appearance-none block w-full px-3 py-2.5 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all">
                    </div>
                    @error('subjek') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="isi_pengaduan" class="block text-sm font-bold text-slate-700">Detail Pengaduan</label>
                    <div class="mt-1">
                        <textarea wire:model="isi_pengaduan" id="isi_pengaduan" rows="4" required placeholder="Jelaskan kronologi atau detail masalah..."
                            class="appearance-none block w-full px-3 py-2.5 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all"></textarea>
                    </div>
                    @error('isi_pengaduan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700">Bukti Lampiran (Jika Ada)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:border-teal-500 transition-colors cursor-pointer group relative">
                        <input wire:model="file_lampiran" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="space-y-1 text-center">
                            @if($file_lampiran)
                                <svg class="mx-auto h-12 w-12 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm text-teal-600 font-medium">File dipilih: {{ $file_lampiran->getClientOriginalName() }}</p>
                            @else
                                <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-teal-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-slate-600 justify-center">
                                    <span class="relative font-medium text-teal-600 hover:text-teal-500">Upload file</span>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-slate-500">PNG, JPG, PDF up to 5MB</p>
                            @endif
                        </div>
                    </div>
                    @error('file_lampiran') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-teal-500/30 text-sm font-bold text-white bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all transform hover:-translate-y-0.5">
                        <span wire:loading.remove>Kirim Laporan</span>
                        <span wire:loading>Mengirim...</span>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-6 text-center">
            <a href="/" class="font-medium text-teal-600 hover:text-teal-500 flex items-center justify-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</div>