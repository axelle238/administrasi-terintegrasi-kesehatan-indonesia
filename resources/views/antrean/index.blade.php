<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Manajemen Antrean') }}
        </h2>
    </x-slot>

    <!-- Notification -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between animate-fade-in-down">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h4 class="font-bold text-green-800">Berhasil!</h4>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Form Ambil Antrean (Kiri) -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 h-fit">
            <div class="bg-teal-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Ambil Nomor Antrean
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('antrean.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Pasien</label>
                        <select name="pasien_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 py-3" required>
                            <option value="">-- Cari Nama / NIK --</option>
                            @foreach(\App\Models\Pasien::all() as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_lengkap }} ({{ $p->nik }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Poli Tujuan</label>
                        <select name="poli_tujuan" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 py-3" required>
                            <option value="Umum">Poli Umum</option>
                            <option value="Gigi">Poli Gigi</option>
                            <option value="KIA">Poli KIA (Ibu & Anak)</option>
                            <option value="Lansia">Poli Lansia</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                        Cetak Tiket Antrean
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Antrean Hari Ini (Kanan) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="bg-white px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-800">Antrean Hari Ini</h3>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold uppercase">{{ date('d F Y') }}</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-left">Nomor</th>
                                <th class="px-6 py-4 text-left">Pasien</th>
                                <th class="px-6 py-4 text-left">Poli</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($antreans as $antrean)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-2xl font-black text-teal-700 font-mono">{{ $antrean->nomor_antrean }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $antrean->pasien->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500">NIK: {{ $antrean->pasien->nik }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-bold">{{ $antrean->poli_tujuan }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClasses = [
                                            'Menunggu' => 'bg-gray-100 text-gray-600',
                                            'Diperiksa' => 'bg-yellow-100 text-yellow-700 animate-pulse',
                                            'Selesai' => 'bg-green-100 text-green-700',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusClasses[$antrean->status] ?? 'bg-gray-100' }}">
                                        {{ $antrean->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('antrean.update', $antrean) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if($antrean->status == 'Menunggu')
                                            <input type="hidden" name="status" value="Diperiksa">
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-xs font-bold shadow transition-all hover:scale-105">
                                                Panggil
                                            </button>
                                        @elseif($antrean->status == 'Diperiksa')
                                            <input type="hidden" name="status" value="Selesai">
                                            <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-xs font-bold shadow transition-all hover:scale-105">
                                                Selesai
                                            </button>
                                        @else
                                            <span class="text-gray-400 font-mono text-xs">-</span>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-lg font-medium">Belum ada antrean hari ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>