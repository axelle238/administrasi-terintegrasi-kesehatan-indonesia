<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Patient Info Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg sticky top-6">
                <div class="p-6 bg-blue-50 border-b border-blue-100">
                    <h3 class="text-lg font-bold text-gray-900">Data Pasien</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="h-16 w-16 rounded-full bg-blue-200 flex items-center justify-center text-blue-700 text-2xl font-bold">
                            {{ substr($pasien->nama_lengkap, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $pasien->nama_lengkap }}</h2>
                            <p class="text-sm text-gray-600">{{ $pasien->jenis_kelamin }} | {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Thn</p>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">NIK</span>
                            <span class="font-medium">{{ $pasien->nik }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">BPJS</span>
                            <span class="font-medium">{{ $pasien->no_bpjs ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Gol. Darah</span>
                            <span class="font-medium">{{ $pasien->golongan_darah ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Examination Form -->
        <div class="lg:col-span-2">
            <form wire:submit="save">
                <!-- Vitals & Anamnesa -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">1. Anamnesa & Tanda Vital</h3>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <x-input-label for="tekanan_darah" value="TD (mmHg)" />
                                <x-text-input wire:model="tekanan_darah" id="tekanan_darah" class="block mt-1 w-full" placeholder="120/80" />
                            </div>
                            <div>
                                <x-input-label for="suhu_tubuh" value="Suhu (°C)" />
                                <x-text-input wire:model="suhu_tubuh" id="suhu_tubuh" class="block mt-1 w-full" type="number" step="0.1" />
                            </div>
                            <div>
                                <x-input-label for="nadi" value="Nadi (bpm)" />
                                <x-text-input wire:model="nadi" id="nadi" class="block mt-1 w-full" type="number" />
                            </div>
                            <div>
                                <x-input-label for="berat_badan" value="Berat (kg)" />
                                <x-text-input wire:model="berat_badan" id="berat_badan" class="block mt-1 w-full" type="number" step="0.1" />
                            </div>
                            <div>
                                <x-input-label for="tinggi_badan" value="Tinggi (cm)" />
                                <x-text-input wire:model="tinggi_badan" id="tinggi_badan" class="block mt-1 w-full" type="number" />
                            </div>
                            <div>
                                <x-input-label for="pernapasan" value="RR (x/menit)" />
                                <x-text-input wire:model="pernapasan" id="pernapasan" class="block mt-1 w-full" type="number" />
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="keluhan" value="Keluhan Utama (Anamnesa)" />
                                <textarea wire:model="keluhan" id="keluhan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                                <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Odontogram (Hanya jika Poli Gigi) -->
                @if($isPoliGigi)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Odontogram (Pemeriksaan Gigi)</h3>
                            <div class="flex gap-4 text-xs">
                                <span class="flex items-center gap-1"><div class="w-3 h-3 bg-white border border-gray-400"></div> Normal (N)</span>
                                <span class="flex items-center gap-1"><div class="w-3 h-3 bg-red-500"></div> Caries (C)</span>
                                <span class="flex items-center gap-1"><div class="w-3 h-3 bg-gray-800"></div> Missing (M)</span>
                                <span class="flex items-center gap-1"><div class="w-3 h-3 bg-blue-500"></div> Filling (F)</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Klik pada nomor gigi untuk mengubah status (Siklus: N -> C -> M -> F -> N).</p>
                        
                        <div class="flex flex-col items-center gap-4 py-4 overflow-x-auto">
                            <!-- Dewasa Atas -->
                            <div class="flex gap-8">
                                <div class="flex gap-1 border-r-2 border-gray-300 pr-2">
                                    @foreach([18,17,16,15,14,13,12,11] as $t)
                                        @include('components.odontogram-tooth', ['number' => $t])
                                    @endforeach
                                </div>
                                <div class="flex gap-1 pl-2">
                                    @foreach([21,22,23,24,25,26,27,28] as $t)
                                        @include('components.odontogram-tooth', ['number' => $t])
                                    @endforeach
                                </div>
                            </div>

                            <!-- Anak -->
                            <div class="flex gap-8 my-2 bg-gray-50 p-2 rounded">
                                <div class="flex flex-col gap-2 border-r-2 border-gray-300 pr-2 items-end">
                                    <div class="flex gap-1">
                                        @foreach([55,54,53,52,51] as $t)
                                            @include('components.odontogram-tooth', ['number' => $t])
                                        @endforeach
                                    </div>
                                    <div class="flex gap-1">
                                        @foreach([85,84,83,82,81] as $t)
                                            @include('components.odontogram-tooth', ['number' => $t])
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 pl-2">
                                    <div class="flex gap-1">
                                        @foreach([61,62,63,64,65] as $t)
                                            @include('components.odontogram-tooth', ['number' => $t])
                                        @endforeach
                                    </div>
                                    <div class="flex gap-1">
                                        @foreach([71,72,73,74,75] as $t)
                                            @include('components.odontogram-tooth', ['number' => $t])
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Dewasa Bawah -->
                            <div class="flex gap-8">
                                <div class="flex gap-1 border-r-2 border-gray-300 pr-2">
                                    @foreach([48,47,46,45,44,43,42,41] as $t)
                                        @include('components.odontogram-tooth', ['number' => $t])
                                    @endforeach
                                </div>
                                <div class="flex gap-1 pl-2">
                                    @foreach([31,32,33,34,35,36,37,38] as $t)
                                        @include('components.odontogram-tooth', ['number' => $t])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Diagnosa & Tindakan -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">2. Diagnosa & Tindakan</h3>
                        
                        <div class="space-y-4">
                            <div class="relative">
                                <x-input-label for="diagnosa" value="Diagnosa Medis (ICD-10)" />
                                <div class="relative">
                                    <x-text-input wire:model.live.debounce.300ms="icd10Query" placeholder="Ketik kode atau nama penyakit..." class="block mt-1 w-full" />
                                    @if(!empty($icd10Results))
                                        <div class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg mt-1 max-h-60 overflow-y-auto">
                                            <ul>
                                                @foreach($icd10Results as $icd)
                                                    <li wire:click="selectIcd10('{{ $icd->code }}', '{{ $icd->name_id ?? $icd->name_en }}')" class="px-4 py-2 hover:bg-indigo-50 cursor-pointer text-sm">
                                                        <span class="font-bold text-indigo-600">{{ $icd->code }}</span> - {{ $icd->name_id ?? $icd->name_en }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <textarea wire:model="diagnosa" id="diagnosa" rows="2" class="block mt-2 w-full border-gray-300 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" readonly required></textarea>
                                <x-input-error :messages="$errors->get('diagnosa')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label value="Tindakan Medis" />
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2 max-h-40 overflow-y-auto border p-2 rounded-md bg-gray-50">
                                    @foreach($tindakans as $tindakan)
                                        <label class="flex items-center space-x-2 p-2 hover:bg-white rounded cursor-pointer transition">
                                            <input type="checkbox" wire:model="selectedTindakans" value="{{ $tindakan->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="text-sm text-gray-700">{{ $tindakan->nama_tindakan }} - <span class="text-xs text-gray-500">Rp {{ number_format($tindakan->harga, 0, ',', '.') }}</span></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resep Obat -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900">3. Resep Obat</h3>
                            <button type="button" wire:click="addResepRow" class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold">+ Tambah Obat</button>
                        </div>
                        
                        <div class="space-y-3">
                            @foreach($resep as $index => $item)
                                <div class="flex gap-2 items-start" wire:key="resep-{{ $index }}">
                                    <div class="flex-grow">
                                        <select wire:model="resep.{{ $index }}.obat_id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach($obats as $obat)
                                                <option value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-20">
                                        <input type="number" wire:model="resep.{{ $index }}.jumlah" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" placeholder="Jml" min="1">
                                    </div>
                                    <div class="w-1/3">
                                        <input type="text" wire:model="resep.{{ $index }}.aturan_pakai" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" placeholder="Aturan (3x1)">
                                    </div>
                                    <button type="button" wire:click="removeResepRow({{ $index }})" class="text-red-500 hover:text-red-700 p-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- File Uploads (Lab/Rontgen) -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900">4. Upload Hasil Penunjang (Lab/Rontgen)</h3>
                            <button type="button" wire:click="addUploadRow" class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold">+ Upload File</button>
                        </div>
                        
                        <div class="space-y-3">
                            @foreach($uploads as $index => $file)
                                <div class="flex gap-4 items-start border p-3 rounded-md bg-gray-50" wire:key="upload-{{ $index }}">
                                    <div class="w-1/3">
                                        <x-input-label value="File" />
                                        <input type="file" wire:model="uploads.{{ $index }}" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                        @error("uploads.{$index}") <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-1/4">
                                        <x-input-label value="Jenis" />
                                        <select wire:model="uploadTypes.{{ $index }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                            <option value="Lab">Laboratorium</option>
                                            <option value="Rontgen">Rontgen/Radiologi</option>
                                            <option value="EKG">EKG</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="flex-grow">
                                        <x-input-label value="Keterangan" />
                                        <input type="text" wire:model="uploadNotes.{{ $index }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm" placeholder="Keterangan file...">
                                    </div>
                                    <button type="button" wire:click="removeUploadRow({{ $index }})" class="text-red-500 mt-6">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end pb-10">
                    <x-primary-button class="text-lg px-8 py-3" wire:loading.attr="disabled">
                        {{ __('Selesai & Simpan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>