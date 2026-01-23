<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Surat & Disposisi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kolom Kiri: Detail Surat -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold">Detail Surat {{ $surat->jenis_surat }}</h3>
                            <span class="px-2 py-1 text-sm font-semibold rounded-full {{ $surat->jenis_surat == 'Masuk' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $surat->jenis_surat }}
                            </span>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4 border-b pb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Nomor Surat</p>
                                    <p class="font-medium">{{ $surat->nomor_surat }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Surat</p>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') }}</p>
                                </div>
                            </div>

                            <div class="border-b pb-4">
                                <p class="text-sm text-gray-500">Perihal</p>
                                <p class="font-medium text-lg">{{ $surat->perihal }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 border-b pb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Pengirim</p>
                                    <p class="font-medium">{{ $surat->pengirim }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Penerima</p>
                                    <p class="font-medium">{{ $surat->penerima }}</p>
                                </div>
                            </div>

                            @if($surat->file_path)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    <span class="text-sm">File Lampiran Tersedia</span>
                                </div>
                                <a href="{{ Storage::url($surat->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-bold">Lihat / Download</a>
                            </div>
                            @else
                            <div class="text-sm text-gray-500 italic">Tidak ada file lampiran.</div>
                            @endif

                        </div>
                        
                        <div class="mt-8 flex justify-between">
                            <a href="{{ route('surat.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali</a>
                            <form action="{{ route('surat.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus arsip ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus Arsip</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Lembar Disposisi (Khusus Surat Masuk) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-fit">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Lembar Disposisi</h3>

                        @if($surat->jenis_surat == 'Masuk')
                            
                            @if($surat->disposisi)
                                <div class="bg-yellow-50 dark:bg-yellow-900/30 p-4 rounded-lg border border-yellow-200 dark:border-yellow-700 mb-6">
                                    <div class="text-xs text-yellow-600 dark:text-yellow-400 font-bold uppercase mb-1">Status: {{ $surat->status_disposisi }}</div>
                                    <p class="text-sm text-gray-800 dark:text-gray-200 font-medium mb-2">Instruksi: "{{ $surat->disposisi }}"</p>
                                    <p class="text-xs text-gray-500">Diteruskan ke: {{ $surat->tujuan_disposisi }}</p>
                                </div>
                            @endif

                            <form action="{{ route('surat.update', $surat->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <x-input-label for="disposisi" :value="__('Isi Disposisi / Instruksi')" />
                                    <textarea name="disposisi" rows="3" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm text-sm" required>{{ $surat->disposisi }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="tujuan_disposisi" :value="__('Diteruskan Kepada')" />
                                    <input type="text" name="tujuan_disposisi" value="{{ $surat->tujuan_disposisi }}" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm text-sm" placeholder="Contoh: Poli Umum, Bag. Keuangan" required>
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="status_disposisi" :value="__('Status')" />
                                    <select name="status_disposisi" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm text-sm">
                                        <option value="Pending" {{ $surat->status_disposisi == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Diteruskan" {{ $surat->status_disposisi == 'Diteruskan' ? 'selected' : '' }}>Diteruskan</option>
                                        <option value="Selesai" {{ $surat->status_disposisi == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>

                                <button type="submit" class="w-full bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    Update Disposisi
                                </button>
                            </form>

                        @else
                            <p class="text-sm text-gray-500 italic text-center">Disposisi hanya berlaku untuk Surat Masuk.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
