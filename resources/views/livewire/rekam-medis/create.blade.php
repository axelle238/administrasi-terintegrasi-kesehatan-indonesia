<div class="max-w-7xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">
        <a href="{{ route('rekam-medis.index') }}" class="hover:text-blue-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
        <span>/</span>
        <span class="text-slate-800 font-bold">Pemeriksaan Pasien</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Sidebar: Info Pasien (Sticky) -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                <!-- Kartu Pasien -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
                    <div class="h-24 bg-gradient-to-r from-blue-600 to-cyan-500"></div>
                    <div class="px-6 pb-6 relative">
                        <div class="-mt-12 mb-4 flex justify-between items-end">
                            <div class="w-24 h-24 rounded-2xl bg-white p-1 shadow-lg">
                                <div class="w-full h-full bg-slate-100 rounded-xl flex items-center justify-center text-3xl font-bold text-slate-400">
                                    {{ substr($pasien->nama_lengkap, 0, 1) }}
                                </div>
                            </div>
                            <span class="font-mono text-xs font-bold bg-slate-100 px-2 py-1 rounded text-slate-600">{{ str_pad($pasien->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <h2 class="text-xl font-bold text-slate-900 leading-tight">{{ $pasien->nama_lengkap }}</h2>
                        <div class="flex flex-wrap gap-2 mt-3 text-sm">
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 font-bold text-xs">{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold text-xs">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun</span>
                            @if($pasien->no_bpjs)
                                <span class="px-2.5 py-0.5 rounded-full bg-green-50 text-green-700 font-bold text-xs">BPJS</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold text-xs">Umum</span>
                            @endif
                        </div>

                        <div class="mt-6 space-y-3 border-t border-slate-100 pt-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">NIK</span>
                                <span class="font-mono font-medium text-slate-800">{{ $pasien->nik }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Tgl Lahir</span>
                                <span class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Gol. Darah</span>
                                <span class="font-bold text-slate-800">{{ $pasien->golongan_darah ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Singkat (Placeholder) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Riwayat Kunjungan
                    </h3>
                    <div class="text-sm text-slate-500 italic">
                        Belum ada riwayat kunjungan sebelumnya.
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form: SOAP -->
        <div class="lg:col-span-2 space-y-8">
            <form wire:submit="save">
                
                <!-- S: Subjective -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 bg-blue-50 border-b border-blue-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 font-bold">S</div>
                        <h3 class="font-bold text-slate-800">Subjective (Anamnesa)</h3>
                    </div>
                    <div class="p-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Keluhan Utama</label>
                        <textarea wire:model="keluhan" rows="4" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-200" placeholder="Jelaskan keluhan pasien secara rinci..." required></textarea>
                        @error('keluhan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- O: Objective -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mt-6">
                    <div class="px-6 py-4 bg-cyan-50 border-b border-cyan-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center text-cyan-600 font-bold">O</div>
                        <h3 class="font-bold text-slate-800">Objective (Pemeriksaan Fisik)</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">TD (mmHg)</label>
                                <input type="text" wire:model="tekanan_darah" class="w-full mt-1 rounded-xl border-slate-200 text-sm focus:border-cyan-500 focus:ring-cyan-200" placeholder="120/80">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Suhu (°C)</label>
                                <input type="number" step="0.1" wire:model="suhu_tubuh" class="w-full mt-1 rounded-xl border-slate-200 text-sm focus:border-cyan-500 focus:ring-cyan-200">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Nadi (bpm)</label>
                                <input type="number" wire:model="nadi" class="w-full mt-1 rounded-xl border-slate-200 text-sm focus:border-cyan-500 focus:ring-cyan-200">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">RR (x/menit)</label>
                                <input type="number" wire:model="pernapasan" class="w-full mt-1 rounded-xl border-slate-200 text-sm focus:border-cyan-500 focus:ring-cyan-200">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Berat (kg)</label>
                                <input type="number" step="0.1" wire:model="berat_badan" class="w-full mt-1 rounded-xl border-slate-200 text-sm focus:border-cyan-500 focus:ring-cyan-200">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Tinggi (cm)</label>
                                <input type="number" wire:model="tinggi_badan" class="w-full mt-1 rounded-xl border-slate-200 text-sm focus:border-cyan-500 focus:ring-cyan-200">
                            </div>
                        </div>

                        <!-- Odontogram Panel -->
                        @if($isPoliGigi)
                            <div class="border rounded-xl p-4 bg-slate-50">
                                <h4 class="font-bold text-slate-700 mb-2">Odontogram</h4>
                                <p class="text-xs text-slate-500 mb-4">Klik gigi untuk ubah status: N (Normal) -> C (Caries) -> M (Missing) -> F (Filling)</p>
                                
                                <div class="overflow-x-auto pb-2">
                                    <div class="flex flex-col items-center gap-6 min-w-max mx-auto">
                                        <!-- Dewasa Atas -->
                                        <div class="flex gap-8">
                                            <div class="flex gap-1 border-r-2 border-slate-300 pr-4">
                                                @foreach([18,17,16,15,14,13,12,11] as $t) @include('components.odontogram-tooth', ['number' => $t]) @endforeach
                                            </div>
                                            <div class="flex gap-1 pl-4">
                                                @foreach([21,22,23,24,25,26,27,28] as $t) @include('components.odontogram-tooth', ['number' => $t]) @endforeach
                                            </div>
                                        </div>
                                        
                                        <!-- Anak -->
                                        <div class="flex gap-12 bg-white px-6 py-2 rounded-xl border border-slate-200 shadow-sm">
                                            <div class="flex flex-col gap-2 border-r border-slate-200 pr-6 items-end">
                                                <div class="flex gap-1">@foreach([55,54,53,52,51] as $t) @include('components.odontogram-tooth', ['number' => $t]) @endforeach</div>
                                                <div class="flex gap-1">@foreach([85,84,83,82,81] as $t) @include('components.odontogram-tooth', ['number' => $t]) @endforeach</div>
                                            </div>
                                            <div class="flex flex-col gap-2 pl-2">
                                                <div class="flex gap-1">@foreach([61,62,63,64,65] as $t) @include('components.odontogram-tooth', ['number' => $t]) @endforeach</div>
                                                <div class="flex gap-1">@foreach([71,72,73,74,75] as $t) @include('components.odontogram-tooth', ['number' => $t]) @endforeach</div>
                                            </div>
                                        </div>

                                        <!-- Dewasa Bawah -->
                                        <div class="flex gap-8">
                                            <div class="flex gap-1 border-r-2 border-slate-300 pr-4">
                                                @foreach([48,47,46,45,44,43,42,41] as $t) @include('components.odontogram-tooth', ['number' => $t]) @endforeach
                                            </div>
                                            <div class="flex gap-1 pl-4">
                                                @foreach([31,32,33,34,35,36,37,38] as $t) @include('components.odontogram-tooth', ['number' => $t]) @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- A: Assessment -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mt-6">
                    <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 font-bold">A</div>
                        <h3 class="font-bold text-slate-800">Assessment (Diagnosa)</h3>
                    </div>
                    <div class="p-6 overflow-visible"> <!-- Overflow visible for dropdown -->
                        <div class="relative z-20">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Cari Diagnosa ICD-10</label>
                            <input type="text" wire:model.live.debounce.300ms="icd10Query" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-200" placeholder="Ketik kode atau nama penyakit (contoh: A00, Demam)...">
                            
                            @if(!empty($icd10Results))
                                <div class="absolute w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-xl max-h-60 overflow-y-auto z-50">
                                    <ul class="py-1">
                                        @foreach($icd10Results as $icd)
                                            <li wire:click="selectIcd10('{{ $icd->code }}', '{{ $icd->name_id ?? $icd->name_en }}')" class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-0">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-bold text-indigo-600">{{ $icd->code }}</span>
                                                    <span class="text-sm text-slate-700">{{ $icd->name_id ?? $icd->name_en }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Diagnosa Terpilih</label>
                            <textarea wire:model="diagnosa" rows="2" class="w-full rounded-xl border-slate-200 bg-slate-50 font-medium text-slate-800 focus:ring-0" readonly></textarea>
                            @error('diagnosa') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- P: Plan -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mt-6">
                    <div class="px-6 py-4 bg-violet-50 border-b border-violet-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-violet-100 rounded-lg flex items-center justify-center text-violet-600 font-bold">P</div>
                        <h3 class="font-bold text-slate-800">Plan (Tindakan & Terapi)</h3>
                    </div>
                    <div class="p-6 space-y-8">
                        
                        <!-- Tindakan -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-bold text-slate-700 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                    Prosedur & Tindakan
                                </h4>
                                <button type="button" wire:click="toggleTindakanModal" class="text-xs font-bold text-violet-600 bg-violet-50 px-3 py-1.5 rounded-lg hover:bg-violet-100 transition">+ Tambah Tindakan</button>
                            </div>

                            @if(count($selectedTindakans) > 0)
                                <div class="space-y-2">
                                    @foreach($tindakans as $tindakan)
                                        @if(in_array($tindakan->id, $selectedTindakans))
                                            <div class="flex justify-between items-center p-3 bg-white border border-slate-200 rounded-xl shadow-sm">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-violet-50 flex items-center justify-center text-violet-600">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold text-slate-800">{{ $tindakan->nama_tindakan }}</p>
                                                        <p class="text-xs text-slate-500">Rp {{ number_format($tindakan->harga, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                                <button type="button" wire:click="selectTindakan({{ $tindakan->id }})" class="text-red-500 hover:text-red-700 text-xs font-bold px-2 py-1">Hapus</button>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-300 text-slate-400 text-sm">
                                    Belum ada tindakan yang dipilih.
                                </div>
                            @endif
                        </div>

                        <!-- Modal Tindakan -->
                        @if($showTindakanModal)
                        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="toggleTindakanModal"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                <h3 class="text-lg leading-6 font-medium text-slate-900" id="modal-title">Pilih Tindakan Medis</h3>
                                                <div class="mt-4">
                                                    <input type="text" wire:model.live.debounce.300ms="searchTindakan" class="w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-200 text-sm" placeholder="Cari nama tindakan...">
                                                </div>
                                                <div class="mt-4 max-h-60 overflow-y-auto space-y-2">
                                                    @foreach($tindakans as $tindakan)
                                                        <div wire:click="selectTindakan({{ $tindakan->id }})" class="flex justify-between items-center p-3 rounded-lg cursor-pointer transition {{ in_array($tindakan->id, $selectedTindakans) ? 'bg-violet-50 border border-violet-200' : 'bg-white border border-slate-100 hover:bg-slate-50' }}">
                                                            <div>
                                                                <p class="text-sm font-bold {{ in_array($tindakan->id, $selectedTindakans) ? 'text-violet-700' : 'text-slate-700' }}">{{ $tindakan->nama_tindakan }}</p>
                                                                <p class="text-xs text-slate-500">Rp {{ number_format($tindakan->harga, 0, ',', '.') }}</p>
                                                            </div>
                                                            @if(in_array($tindakan->id, $selectedTindakans))
                                                                <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="button" wire:click="toggleTindakanModal" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-violet-600 text-base font-medium text-white hover:bg-violet-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                            Selesai
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <hr class="border-slate-100">

                        <!-- Resep -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-bold text-slate-700 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                    Resep Obat
                                </h4>
                                <button type="button" wire:click="addResepRow" class="text-xs font-bold text-violet-600 bg-violet-50 px-3 py-1.5 rounded-lg hover:bg-violet-100 transition">+ Tambah Item</button>
                            </div>
                            
                            <div class="space-y-3">
                                @foreach($resep as $index => $item)
                                    <div class="flex flex-col md:flex-row gap-3 items-start p-3 bg-slate-50 rounded-xl border border-slate-200" wire:key="resep-{{ $index }}">
                                        <div class="flex-grow w-full">
                                            <select wire:model="resep.{{ $index }}.obat_id" class="w-full rounded-lg border-slate-300 focus:border-violet-500 focus:ring-violet-200 text-sm">
                                                <option value="">-- Pilih Obat --</option>
                                                @foreach($obats as $obat)
                                                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="w-24 flex-shrink-0">
                                            <input type="number" wire:model="resep.{{ $index }}.jumlah" class="w-full rounded-lg border-slate-300 focus:border-violet-500 focus:ring-violet-200 text-sm" placeholder="Jml" min="1">
                                        </div>
                                        <div class="w-full md:w-1/3">
                                            <input type="text" wire:model="resep.{{ $index }}.aturan_pakai" class="w-full rounded-lg border-slate-300 focus:border-violet-500 focus:ring-violet-200 text-sm" placeholder="Aturan (e.g. 3x1 Sesudah Makan)">
                                        </div>
                                        <button type="button" wire:click="removeResepRow({{ $index }})" class="text-red-400 hover:text-red-600 p-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <hr class="border-slate-100">

                        <!-- Uploads -->
                         <div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-bold text-slate-700">Lampiran Penunjang</h4>
                                <button type="button" wire:click="addUploadRow" class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg hover:bg-slate-200 transition">+ Upload</button>
                            </div>
                            <div class="space-y-2">
                                @foreach($uploads as $index => $file)
                                    <div class="flex items-center gap-3" wire:key="upload-{{ $index }}">
                                        <input type="file" wire:model="uploads.{{ $index }}" class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                                        <select wire:model="uploadTypes.{{ $index }}" class="text-xs rounded-lg border-slate-300">
                                            <option value="Lab">Lab</option>
                                            <option value="Rontgen">Rontgen</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        <button type="button" wire:click="removeUploadRow({{ $index }})" class="text-red-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    
                    <!-- Footer Actions -->
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center sticky bottom-0 z-30">
                        <div class="text-xs text-slate-400">
                            Pastikan data medis sudah lengkap sebelum menyimpan.
                        </div>
                        <button 
                            type="submit" 
                            wire:loading.attr="disabled"
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 transition-all transform hover:-translate-y-1 flex items-center gap-2"
                        >
                            <svg wire:loading.remove class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <span wire:loading.remove>Simpan Rekam Medis</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>