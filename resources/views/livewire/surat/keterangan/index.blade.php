<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Surat Keterangan</h2>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 shadow">
            + Buat Surat Baru
        </button>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari Nama Pasien..." class="w-full md:w-1/3" />
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($surats as $surat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">{{ $surat->nomor_surat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $surat->tanggal_surat->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $surat->pasien->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">{{ $surat->pasien->nik }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $surat->jenis_surat }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $surat->dokter->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('surat.print-keterangan', $surat->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Cetak</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-gray-500">Belum ada surat diterbitkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50">
            {{ $surats->links() }}
        </div>
    </div>

    {{-- Modal --}}
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" wire:click="$set('isOpen', false)"></div>
                <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Buat Surat Keterangan</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-input-label value="Pasien" />
                                    <select wire:model="pasien_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                        <option value="">Pilih Pasien</option>
                                        @foreach($pasiens as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama_lengkap }} - {{ $p->nik }}</option>
                                        @endforeach
                                    </select>
                                    @error('pasien_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <x-input-label value="Jenis Surat" />
                                    <select wire:model.live="jenis_surat" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                        <option value="Sehat">Keterangan Sehat</option>
                                        <option value="Sakit">Keterangan Sakit</option>
                                        <option value="Buta Warna">Keterangan Buta Warna</option>
                                        <option value="Bebas Narkoba">Keterangan Bebas Narkoba</option>
                                    </select>
                                </div>

                                @if($jenis_surat == 'Sehat' || $jenis_surat == 'Buta Warna' || $jenis_surat == 'Bebas Narkoba')
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label value="Tinggi Badan (cm)" />
                                            <x-text-input type="number" wire:model="tinggi_badan" class="w-full mt-1" />
                                            @error('tinggi_badan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <x-input-label value="Berat Badan (kg)" />
                                            <x-text-input type="number" wire:model="berat_badan" class="w-full mt-1" />
                                            @error('berat_badan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <x-input-label value="Tekanan Darah (mmHg)" />
                                            <x-text-input wire:model="tekanan_darah" placeholder="120/80" class="w-full mt-1" />
                                            @error('tekanan_darah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <x-input-label value="Golongan Darah" />
                                            <select wire:model="golongan_darah" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                                <option value="">-</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="AB">AB</option>
                                                <option value="O">O</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    @if($jenis_surat == 'Buta Warna')
                                        <div>
                                            <x-input-label value="Hasil Tes Buta Warna" />
                                            <select wire:model="buta_warna" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                                <option value="Normal">Normal / Tidak Buta Warna</option>
                                                <option value="Buta Warna Parsial">Buta Warna Parsial</option>
                                                <option value="Buta Warna Total">Buta Warna Total</option>
                                            </select>
                                        </div>
                                    @endif

                                    <div>
                                        <x-input-label value="Keperluan" />
                                        <textarea wire:model="keperluan" rows="2" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" placeholder="Contoh: Melamar Pekerjaan"></textarea>
                                        @error('keperluan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                @endif

                                @if($jenis_surat == 'Sakit')
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label value="Lama Istirahat (Hari)" />
                                            <x-text-input type="number" wire:model="lama_istirahat" class="w-full mt-1" />
                                            @error('lama_istirahat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <x-input-label value="Mulai Tanggal" />
                                            <x-text-input type="date" wire:model="mulai_istirahat" class="w-full mt-1" />
                                            @error('mulai_istirahat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                @endif
                                
                                <div>
                                    <x-input-label value="Catatan Tambahan (Opsional)" />
                                    <textarea wire:model="catatan" class="w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan & Cetak
                            </button>
                            <button type="button" wire:click="$set('isOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>