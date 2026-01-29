<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    @if($isOpen)
        <!-- MODE: FORMULIR INPUT -->
        <div class="space-y-6">
            <!-- Header Form -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <div class="p-2 bg-teal-100 rounded-lg text-teal-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        {{ $templateId ? 'Edit Template Surat' : 'Buat Template Baru' }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 ml-12">
                        Atur format surat otomatis dengan placeholder dinamis.
                    </p>
                </div>
                <button wire:click="$set('isOpen', false)" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali
                </button>
            </div>

            <!-- Card Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Template</label>
                            <input type="text" wire:model="kode_template" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5" placeholder="Contoh: SKS (Surat Keterangan Sehat)">
                            @error('kode_template') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Template</label>
                            <input type="text" wire:model="nama_template" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5" placeholder="Contoh: Surat Keterangan Sehat">
                            @error('nama_template') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-semibold text-gray-700">Konten Surat</label>
                            <span class="text-xs text-teal-600 bg-teal-50 px-2 py-1 rounded border border-teal-100">HTML Supported</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-3 text-xs text-gray-500 flex flex-wrap gap-2">
                            <span class="font-semibold text-gray-700">Placeholder Tersedia:</span>
                            <code class="bg-white px-1 border rounded">{nama}</code>
                            <code class="bg-white px-1 border rounded">{nik}</code>
                            <code class="bg-white px-1 border rounded">{alamat}</code>
                            <code class="bg-white px-1 border rounded">{tanggal}</code>
                            <code class="bg-white px-1 border rounded">{no_surat}</code>
                        </div>
                        <textarea wire:model="konten" rows="15" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 font-mono text-sm leading-relaxed" placeholder="Tulis isi surat di sini..."></textarea>
                        @error('konten') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-5 flex items-center justify-between border-t border-gray-100">
                    <button wire:click="$set('isOpen', false)" class="text-gray-600 font-medium hover:text-gray-900 text-sm">
                        Batalkan
                    </button>
                    <button wire:click="save" class="inline-flex items-center px-6 py-2.5 bg-teal-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Simpan Template
                    </button>
                </div>
            </div>
        </div>
    @else
        <!-- MODE: TABEL LIST -->
        <div class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Daftar Template Surat
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 ml-10">
                        Kelola template untuk pencetakan surat otomatis.
                    </p>
                </div>
                <button wire:click="create" class="inline-flex items-center px-5 py-2.5 bg-teal-600 text-white rounded-xl font-semibold text-sm shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Template Baru
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Template</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($templates as $t)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-teal-600 bg-teal-50/50 w-32">
                                    {{ $t->kode_template }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                    {{ $t->nama_template }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit({{ $t->id }})" class="text-teal-600 hover:text-teal-900 mr-4 font-semibold transition-colors">Edit</button>
                                    <button wire:click="delete({{ $t->id }})" wire:confirm="Apakah Anda yakin ingin menghapus template ini?" class="text-red-500 hover:text-red-700 font-semibold transition-colors">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4 border-t border-gray-100">
                    {{ $templates->links() }}
                </div>
            </div>
        </div>
    @endif
</div>