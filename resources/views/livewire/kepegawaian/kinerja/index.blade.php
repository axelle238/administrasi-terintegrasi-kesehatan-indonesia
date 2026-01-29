<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    @if($isOpen)
        <!-- MODE: FORM INPUT -->
        <div class="space-y-6">
            <!-- Header Form -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <div class="p-2 bg-teal-100 rounded-lg text-teal-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        Formulir Penilaian Kinerja
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 ml-12">
                        Input skor penilaian bulanan pegawai secara objektif.
                    </p>
                </div>
                <button wire:click="$set('isOpen', false)" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali
                </button>
            </div>

            <!-- Card Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 space-y-8">
                    <!-- Section: Pegawai -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="col-span-2">
                            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Data Pegawai</h3>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Pegawai</label>
                            <select wire:model="pegawai_id" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5">
                                <option value="">-- Pilih Nama Pegawai --</option>
                                @foreach($pegawais as $p)
                                    <option value="{{ $p->id }}">{{ $p->user->name }} - {{ $p->nip }}</option>
                                @endforeach
                            </select>
                            @error('pegawai_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Section: Indikator -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Indikator Penilaian (Skala 0-100)</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Orientasi Pelayanan</label>
                                <input type="number" wire:model="orientasi_pelayanan" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5" placeholder="0-100">
                                @error('orientasi_pelayanan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Integritas</label>
                                <input type="number" wire:model="integritas" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5" placeholder="0-100">
                                @error('integritas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Komitmen</label>
                                <input type="number" wire:model="komitmen" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5" placeholder="0-100">
                                @error('komitmen') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Disiplin</label>
                                <input type="number" wire:model="disiplin" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5" placeholder="0-100">
                                @error('disiplin') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kerjasama</label>
                                <input type="number" wire:model="kerjasama" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5" placeholder="0-100">
                                @error('kerjasama') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section: Catatan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan / Umpan Balik Atasan</label>
                        <textarea wire:model="catatan_atasan" rows="3" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Berikan catatan evaluasi untuk pegawai ini..."></textarea>
                        @error('catatan_atasan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-5 flex items-center justify-between border-t border-gray-100">
                    <button wire:click="$set('isOpen', false)" class="text-gray-600 font-medium hover:text-gray-900 text-sm">
                        Batalkan
                    </button>
                    <button wire:click="save" class="inline-flex items-center px-6 py-2.5 bg-teal-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Simpan Penilaian
                    </button>
                </div>
            </div>
        </div>
    @else
        <!-- MODE: TABEL LIST -->
        <div class="space-y-6">
            <!-- Filter & Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Penilaian Kinerja Pegawai
                    </h2>
                    <div class="flex items-center gap-3 mt-2">
                        <select wire:model.live="bulan" class="rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
                            @php
                                $bulans = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            @foreach($bulans as $index => $nama_bulan)
                                <option value="{{ $index + 1 }}">{{ $nama_bulan }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="tahun" class="rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
                            @for($i=date('Y'); $i>=date('Y')-2; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <button wire:click="create" class="inline-flex items-center px-5 py-2.5 bg-teal-600 text-white rounded-xl font-semibold text-sm shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Input Penilaian Baru
                </button>
            </div>

            <!-- Tabel Data -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pegawai</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Pelayanan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Integritas</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Disiplin</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Rata-rata</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($kinerjas as $k)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $k->pegawai->user->name }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $k->pegawai->nip }}</div>
                                </td>
                                <td class="px-6 py-4 text-center text-sm font-medium text-gray-600">{{ $k->orientasi_pelayanan }}</td>
                                <td class="px-6 py-4 text-center text-sm font-medium text-gray-600">{{ $k->integritas }}</td>
                                <td class="px-6 py-4 text-center text-sm font-medium text-gray-600">{{ $k->disiplin }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-sm font-bold text-gray-800">
                                        {{ number_format($k->nilai_rata_rata, 1) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $color = match($k->predikat) {
                                            'Sangat Baik' => 'bg-green-100 text-green-800',
                                            'Baik' => 'bg-teal-100 text-teal-800',
                                            'Cukup' => 'bg-yellow-100 text-yellow-800',
                                            'Kurang' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $color }}">
                                        {{ $k->predikat }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada data penilaian untuk periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>