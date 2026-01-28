<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Input Penggajian Pegawai</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan gaji, tunjangan, dan potongan karyawan secara menyeluruh.</p>
        </div>
        <a href="{{ route('kepegawaian.gaji.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-xl font-bold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kolom Kiri: Informasi Utama -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Informasi Pegawai & Periode
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <x-input-label for="user_id" value="Pilih Pegawai" class="font-bold" />
                            <select wire:model.live="user_id" id="user_id" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-shadow" required>
                                <option value="">-- Pilih --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="bulan" value="Bulan" />
                            <select wire:model="bulan" id="bulan" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-shadow">
                                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $m)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="tahun" value="Tahun" />
                            <x-text-input wire:model="tahun" id="tahun" type="number" class="mt-1 block w-full" />
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tunjangan -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="text-md font-bold text-emerald-600 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            Tunjangan (+)
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="gaji_pokok" value="Gaji Pokok" class="font-bold text-slate-900 dark:text-white" />
                                <x-text-input wire:model.live="gaji_pokok" id="gaji_pokok" type="number" class="mt-1 block w-full bg-blue-50 dark:bg-blue-900/20 font-bold" />
                            </div>
                            <div>
                                <x-input-label for="tunjangan_jabatan" value="Tunjangan Jabatan" />
                                <x-text-input wire:model.live="tunjangan_jabatan" id="tunjangan_jabatan" type="number" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="tunjangan_fungsional" value="Tunjangan Fungsional" />
                                <x-text-input wire:model.live="tunjangan_fungsional" id="tunjangan_fungsional" type="number" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="tunjangan_makan" value="Tunjangan Makan" />
                                <x-text-input wire:model.live="tunjangan_makan" id="tunjangan_makan" type="number" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="tunjangan_transport" value="Tunjangan Transport" />
                                <x-text-input wire:model.live="tunjangan_transport" id="tunjangan_transport" type="number" class="mt-1 block w-full" />
                            </div>
                        </div>
                    </div>

                    <!-- Potongan -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="text-md font-bold text-red-600 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                            Potongan (-)
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="potongan_bpjs_kesehatan" value="BPJS Kesehatan" />
                                <x-text-input wire:model.live="potongan_bpjs_kesehatan" id="potongan_bpjs_kesehatan" type="number" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="potongan_bpjs_tk" value="BPJS Ketenagakerjaan" />
                                <x-text-input wire:model.live="potongan_bpjs_tk" id="potongan_bpjs_tk" type="number" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="potongan_pph21" value="PPh 21" />
                                <x-text-input wire:model.live="potongan_pph21" id="potongan_pph21" type="number" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="potongan_absen" value="Potongan Absensi" />
                                <x-text-input wire:model.live="potongan_absen" id="potongan_absen" type="number" class="mt-1 block w-full" />
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <x-input-label for="catatan" value="Catatan / Keterangan" />
                            <textarea wire:model="catatan" id="catatan" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Ringkasan & Submit -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-blue-500 p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Ringkasan Gaji</h3>
                    
                    <div class="space-y-4 text-sm font-medium">
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Gaji Pokok</span>
                            <span class="text-slate-900 dark:text-white">Rp {{ number_format($gaji_pokok, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Total Tunjangan (+)</span>
                            <span class="text-emerald-600">Rp {{ number_format($total_tunjangan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Total Potongan (-)</span>
                            <span class="text-red-600">Rp {{ number_format($total_potongan, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="pt-4 flex flex-col items-center justify-center text-center">
                            <span class="text-xs text-slate-400 uppercase font-bold tracking-widest mb-1">Take Home Pay</span>
                            <span class="text-3xl font-black text-blue-600">Rp {{ number_format($take_home_pay, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-8 space-y-3">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition shadow-xl shadow-blue-500/25">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Simpan & Cetak
                        </button>
                        <a href="{{ route('kepegawaian.gaji.index') }}" wire:navigate class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold text-sm uppercase hover:bg-gray-200 transition">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
