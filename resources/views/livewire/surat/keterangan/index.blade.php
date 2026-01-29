<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Surat Keterangan</h2>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 shadow">
            + Buat Surat Baru
        </button>
    </div>

    {{-- Inline Form Section --}}
    @if($isOpen)
        <div class="mb-8 bg-white overflow-hidden shadow-xl sm:rounded-lg border border-indigo-100 animate-fade-in-down">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Form Surat Keterangan</h3>
                <button wire:click="$set('isOpen', false)" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Tutup</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form wire:submit.prevent="save" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="col-span-1 md:col-span-2">
                        <x-input-label value="Pilih Pasien" />
                        <select wire:model="pasien_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Cari Pasien --</option>
                            @foreach($pasiens as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_lengkap }} ({{ $p->nik }})</option>
                            @endforeach
                        </select>
                        @error('pasien_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <x-input-label value="Jenis Surat Keterangan" />
                        <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach(['Sehat' => 'Sehat', 'Sakit' => 'Sakit', 'Buta Warna' => 'Buta Warna', 'Bebas Narkoba' => 'Bebas Narkoba'] as $val => $label)
                                <label class="flex items-center space-x-3 border p-3 rounded-lg cursor-pointer hover:bg-indigo-50 {{ $jenis_surat == $val ? 'bg-indigo-50 border-indigo-500 ring-1 ring-indigo-500' : 'border-gray-200' }}">
                                    <input type="radio" wire:model.live="jenis_surat" value="{{ $val }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Detail Form Area --}}
                <div class="border-t border-gray-100 pt-6">
                    @if($jenis_surat == 'Sehat' || $jenis_surat == 'Buta Warna' || $jenis_surat == 'Bebas Narkoba')
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                            <div>
                                <x-input-label value="Tinggi Badan (cm)" />
                                <x-text-input type="number" wire:model="tinggi_badan" class="w-full mt-1" placeholder="Contoh: 170" />
                                @error('tinggi_badan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-input-label value="Berat Badan (kg)" />
                                <x-text-input type="number" wire:model="berat_badan" class="w-full mt-1" placeholder="Contoh: 65" />
                                @error('berat_badan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-input-label value="Tekanan Darah (mmHg)" />
                                <x-text-input wire:model="tekanan_darah" placeholder="120/80" class="w-full mt-1" />
                                @error('tekanan_darah') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-input-label value="Golongan Darah" />
                                <select wire:model="golongan_darah" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <option value="">- Pilih -</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>
                        
                        @if($jenis_surat == 'Buta Warna')
                            <div class="mb-6">
                                <x-input-label value="Hasil Tes Buta Warna" />
                                <select wire:model="buta_warna" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <option value="Normal">Normal / Tidak Buta Warna</option>
                                    <option value="Buta Warna Parsial">Buta Warna Parsial</option>
                                    <option value="Buta Warna Total">Buta Warna Total</option>
                                </select>
                            </div>
                        @endif

                        <div class="mb-6">
                            <x-input-label value="Keperluan Surat" />
                            <textarea wire:model="keperluan" rows="2" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Persyaratan Melamar Pekerjaan"></textarea>
                            @error('keperluan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    @if($jenis_surat == 'Sakit')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label value="Lama Istirahat (Hari)" />
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <x-text-input type="number" wire:model="lama_istirahat" class="w-full pr-12" placeholder="3" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Hari</span>
                                    </div>
                                </div>
                                @error('lama_istirahat') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-input-label value="Mulai Tanggal" />
                                <x-text-input type="date" wire:model="mulai_istirahat" class="w-full mt-1" />
                                @error('mulai_istirahat') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif
                    
                    <div>
                        <x-input-label value="Catatan Tambahan (Opsional)" />
                        <textarea wire:model="catatan" rows="2" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-3">
                    <button type="button" wire:click="$set('isOpen', false)" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                        Simpan & Cetak
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">