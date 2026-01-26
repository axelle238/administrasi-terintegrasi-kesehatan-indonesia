<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Navigasi -->
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
        <a href="{{ route('kasir.index') }}" class="hover:text-blue-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke Daftar
        </a>
        <span>/</span>
        <span class="text-slate-800 font-bold">Proses Pembayaran</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri: Detail Transaksi -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Info Pasien -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-32 h-32 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">{{ $pasien->nama_lengkap }}</h2>
                        <div class="flex items-center gap-3 mt-1 text-slate-500 text-sm">
                            <span class="font-mono bg-slate-100 px-2 py-0.5 rounded text-slate-600">{{ $pasien->nik }}</span>
                            <span>•</span>
                            <span>{{ $pasien->jenis_kelamin }}</span>
                            <span>•</span>
                            <span>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-xs text-slate-400 uppercase tracking-wider">No. Rekam Medis</span>
                        <span class="block text-xl font-mono font-bold text-slate-700">{{ str_pad($pasien->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>

            <!-- Tabel Rincian -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Rincian Layanan & Obat</h3>
                    <span class="text-xs font-mono text-slate-400">{{ $rekamMedis->id }}</span>
                </div>
                
                <div class="divide-y divide-slate-100">
                    <!-- Tindakan -->
                    @if(count($detailsTindakan) > 0)
                        <div class="bg-slate-50/50 px-6 py-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Jasa Medis & Tindakan</div>
                        @foreach($detailsTindakan as $item)
                            <div class="px-6 py-3 flex justify-between items-center hover:bg-slate-50 transition">
                                <span class="text-slate-700 font-medium">{{ $item['nama'] }}</span>
                                <span class="font-mono text-slate-600">Rp {{ number_format($item['biaya'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    @endif

                    <!-- Obat -->
                    @if(count($detailsObat) > 0)
                        <div class="bg-slate-50/50 px-6 py-2 text-xs font-bold text-slate-500 uppercase tracking-wider border-t border-slate-100">Farmasi</div>
                        @foreach($detailsObat as $item)
                            <div class="px-6 py-3 flex justify-between items-center hover:bg-slate-50 transition">
                                <div class="flex flex-col">
                                    <span class="text-slate-700 font-medium">{{ $item['nama'] }}</span>
                                    <span class="text-xs text-slate-400">{{ $item['jumlah'] }} x @ Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                </div>
                                <span class="font-mono text-slate-600">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    @endif
                    
                    @if(count($detailsTindakan) == 0 && count($detailsObat) == 0)
                        <div class="p-8 text-center text-slate-400 italic">
                            Tidak ada item tagihan yang tercatat.
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Catatan -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Catatan Tambahan (Opsional)</label>
                <textarea wire:model="catatan" rows="2" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-200 text-sm" placeholder="Contoh: Pasien meminta kuitansi terpisah..."></textarea>
            </div>
        </div>

        <!-- Kolom Kanan: Billing Sticky -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- Toggle BPJS -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 flex items-center justify-between">
                    <div>
                        <span class="block font-bold text-slate-800">Gunakan BPJS?</span>
                        <span class="text-xs text-slate-500">Biaya akan ditanggung penuh.</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="useBpjs" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <!-- Kalkulator Billing -->
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <div class="p-6 bg-slate-900 text-white text-center relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-600/20 to-transparent pointer-events-none"></div>
                        <span class="block text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Total Tagihan</span>
                        <h1 class="text-4xl font-extrabold tracking-tight">
                            <span class="text-lg align-top opacity-50 font-normal mr-1">Rp</span>{{ number_format($grandTotal, 0, ',', '.') }}
                        </h1>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        @if(!$useBpjs)
                            <!-- Biaya Tambahan & Diskon Inputs -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase">Biaya Lain</label>
                                    <input type="number" wire:model.live.debounce.500ms="biayaTambahan" class="w-full mt-1 text-sm border-slate-200 rounded-lg focus:ring-blue-200 focus:border-blue-500 text-right" placeholder="0">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase">Diskon</label>
                                    <input type="number" wire:model.live.debounce.500ms="diskon" class="w-full mt-1 text-sm border-slate-200 rounded-lg focus:ring-blue-200 focus:border-blue-500 text-right text-red-500" placeholder="0">
                                </div>
                            </div>

                            <hr class="border-slate-100">
                            
                            <!-- Metode Pembayaran -->
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase block mb-2">Metode Pembayaran</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" @click="$wire.set('metode_pembayaran', 'Tunai')" class="px-3 py-2 text-sm rounded-lg border {{ $metode_pembayaran === 'Tunai' ? 'bg-blue-50 border-blue-500 text-blue-700 font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                        Tunai
                                    </button>
                                    <button type="button" @click="$wire.set('metode_pembayaran', 'Transfer')" class="px-3 py-2 text-sm rounded-lg border {{ $metode_pembayaran === 'Transfer' ? 'bg-blue-50 border-blue-500 text-blue-700 font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                        Transfer
                                    </button>
                                    <button type="button" @click="$wire.set('metode_pembayaran', 'QRIS')" class="px-3 py-2 text-sm rounded-lg border {{ $metode_pembayaran === 'QRIS' ? 'bg-blue-50 border-blue-500 text-blue-700 font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                        QRIS
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Input Bayar -->
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase block mb-2">Diterima (Bayar)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-slate-400 font-bold">Rp</span>
                                    <input type="number" wire:model.live="jumlah_bayar" class="w-full pl-10 pr-4 py-2 text-lg font-bold text-slate-800 border-slate-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            
                            <!-- Quick Amounts -->
                            <div class="grid grid-cols-4 gap-2">
                                <button type="button" wire:click="setQuickAmount('pas')" class="col-span-1 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-200">Uang Pas</button>
                                <button type="button" wire:click="setQuickAmount(10000)" class="col-span-1 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-200">10k</button>
                                <button type="button" wire:click="setQuickAmount(20000)" class="col-span-1 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-200">20k</button>
                                <button type="button" wire:click="setQuickAmount(50000)" class="col-span-1 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-200">50k</button>
                                <button type="button" wire:click="setQuickAmount(100000)" class="col-span-1 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-200">100k</button>
                            </div>

                            <!-- Kembalian -->
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-sm font-bold text-slate-500">Kembalian</span>
                                <span class="text-xl font-mono font-bold {{ $kembalian < 0 ? 'text-red-500' : 'text-emerald-600' }}">
                                    Rp {{ number_format($kembalian, 0, ',', '.') }}
                                </span>
                            </div>
                        @else
                            <div class="p-4 bg-green-50 rounded-xl border border-green-100 text-center">
                                <svg class="w-12 h-12 text-green-500 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <h4 class="font-bold text-green-800">Ditanggung BPJS</h4>
                                <p class="text-xs text-green-600 mt-1">Tidak ada tagihan ke pasien.</p>
                            </div>
                        @endif

                        <!-- Tombol Aksi -->
                        <button 
                            wire:click="processPayment" 
                            wire:loading.attr="disabled"
                            class="w-full py-4 mt-4 bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2"
                        >
                            <span wire:loading.remove>
                                @if($useBpjs) Selesaikan Transaksi @else Bayar & Cetak Invoice @endif
                            </span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>