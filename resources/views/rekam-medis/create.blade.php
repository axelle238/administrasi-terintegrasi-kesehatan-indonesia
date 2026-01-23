<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pemeriksaan Pasien (Dokter)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('rekam-medis.store') }}" method="POST" x-data="medicalForm()">
                        @csrf

                        <!-- 1. Identitas Pasien -->
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-lg font-bold text-blue-600 mb-4">1. Identitas Pasien</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Pilih Pasien</label>
                                    <select name="pasien_id" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm select2">
                                        <option value="">-- Cari Pasien --</option>
                                        @foreach($pasiens as $pasien)
                                            <option value="{{ $pasien->id }}" {{ (old('pasien_id') == $pasien->id || (isset($selectedPasienId) && $selectedPasienId == $pasien->id)) ? 'selected' : '' }}>
                                                {{ $pasien->nama_lengkap }} ({{ $pasien->nik }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Dokter Pemeriksa</label>
                                    <input type="text" value="{{ Auth::user()->name }}" disabled class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm text-gray-500">
                                </div>
                            </div>
                        </div>

                        <!-- 2. Tanda-Tanda Vital -->
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-lg font-bold text-blue-600 mb-4">2. Tanda-Tanda Vital</h3>
                            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                                <div>
                                    <label class="block text-xs font-medium">Tensi (mmHg)</label>
                                    <input type="text" name="tekanan_darah" placeholder="120/80" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium">Suhu (°C)</label>
                                    <input type="number" step="0.1" name="suhu_tubuh" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium">Berat (Kg)</label>
                                    <input type="number" step="0.1" name="berat_badan" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium">Tinggi (Cm)</label>
                                    <input type="number" name="tinggi_badan" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium">Nadi (bpm)</label>
                                    <input type="number" name="nadi" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium">Napas (x/m)</label>
                                    <input type="number" name="pernapasan" class="w-full text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <!-- 3. Anamnesa & Diagnosa -->
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-lg font-bold text-blue-600 mb-4">3. Hasil Pemeriksaan</h3>
                            <div class="mb-4">
                                <label class="block font-medium text-sm">Keluhan Utama (Anamnesa)</label>
                                <textarea name="keluhan" rows="2" class="w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block font-medium text-sm">Diagnosa Dokter (ICD-10)</label>
                                <textarea name="diagnosa" rows="2" class="w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                            </div>
                        </div>

                        <!-- 4. Tindakan Medis (Checkbox List) -->
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-lg font-bold text-blue-600 mb-4">4. Tindakan Medis</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 max-h-48 overflow-y-auto border p-2 rounded bg-gray-50">
                                @foreach($tindakans as $tindakan)
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="checkbox" name="tindakans[]" value="{{ $tindakan->id }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                        <span class="text-sm text-gray-700">{{ $tindakan->nama_tindakan }} - Rp{{ number_format($tindakan->harga, 0, ',', '.') }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- 5. E-Resep (Dynamic Rows) -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-blue-600">5. Resep Obat (E-Resep)</h3>
                                <button type="button" @click="addObatRow()" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-3 rounded">
                                    + Tambah Obat
                                </button>
                            </div>

                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="px-4 py-2 w-1/2">Nama Obat</th>
                                        <th class="px-4 py-2 w-1/6">Jumlah</th>
                                        <th class="px-4 py-2 w-1/3">Aturan Pakai</th>
                                        <th class="px-4 py-2">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(row, index) in obatRows" :key="index">
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-4 py-2">
                                                <select :name="'obats[' + index + '][id]'" class="w-full border-gray-300 rounded-md text-sm" required>
                                                    <option value="">-- Pilih Obat --</option>
                                                    @foreach($obats as $obat)
                                                        <option value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="number" :name="'obats[' + index + '][jumlah]'" class="w-full border-gray-300 rounded-md text-sm" min="1" required>
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" :name="'obats[' + index + '][aturan]'" placeholder="3x1 Sesudah Makan" class="w-full border-gray-300 rounded-md text-sm" required>
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button" @click="removeObatRow(index)" class="text-red-600 hover:text-red-900 font-bold">X</button>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr x-show="obatRows.length === 0">
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-500 italic">
                                            Belum ada obat yang diresepkan. Klik tombol tambah di atas.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end border-t pt-6">
                            <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-3 px-8 rounded-lg shadow-lg">
                                Simpan Pemeriksaan & Kirim Resep
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function medicalForm() {
            return {
                obatRows: [],
                addObatRow() {
                    this.obatRows.push({ id: '', jumlah: 1, aturan: '' });
                },
                removeObatRow(index) {
                    this.obatRows.splice(index, 1);
                }
            }
        }
    </script>
</x-app-layout>