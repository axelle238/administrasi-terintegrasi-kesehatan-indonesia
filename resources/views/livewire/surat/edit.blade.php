<div class="max-w-4xl mx-auto">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form wire:submit="update">
                <div class="space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="nomor_surat" value="Nomor Surat" />
                            <x-text-input wire:model="nomor_surat" id="nomor_surat" class="block mt-1 w-full" type="text" required />
                            <x-input-error :messages="$errors->get('nomor_surat')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_surat" value="Tanggal Surat" />
                            <x-text-input wire:model="tanggal_surat" id="tanggal_surat" class="block mt-1 w-full" type="date" required />
                            <x-input-error :messages="$errors->get('tanggal_surat')" class="mt-2" />
                        </div>
                    </div>

                    @if($jenis_surat == 'Masuk')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="pengirim" value="Pengirim" />
                                <x-text-input wire:model="pengirim" id="pengirim" class="block mt-1 w-full" type="text" required />
                            </div>
                            <div>
                                <x-input-label for="tanggal_diterima" value="Tanggal Diterima" />
                                <x-text-input wire:model="tanggal_diterima" id="tanggal_diterima" class="block mt-1 w-full" type="date" />
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="penerima" value="Tujuan / Penerima" />
                                <x-text-input wire:model="penerima" id="penerima" class="block mt-1 w-full" type="text" required />
                            </div>
                        </div>
                    @endif

                    <div>
                        <x-input-label for="perihal" value="Perihal" />
                        <textarea wire:model="perihal" id="perihal" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                        <x-input-error :messages="$errors->get('perihal')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="file_surat" value="Update File Lampiran (Opsional)" />
                        @if($existingFile)
                            <div class="text-sm text-green-600 mb-2">File saat ini: <a href="{{ asset('storage/'.$existingFile) }}" target="_blank" class="underline">Lihat</a></div>
                        @endif
                        <input type="file" wire:model="file_surat" id="file_surat" class="block mt-1 w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('file_surat')" class="mt-2" />
                    </div>

                    @if($jenis_surat == 'Masuk')
                        <div class="bg-yellow-50 p-4 rounded-md border border-yellow-200 mt-4">
                            <h4 class="font-bold text-gray-700 mb-2">Disposisi</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="tujuan_disposisi" value="Diteruskan Kepada" />
                                    <x-text-input wire:model="tujuan_disposisi" id="tujuan_disposisi" class="block mt-1 w-full" type="text" />
                                </div>
                                <div>
                                    <x-input-label for="isi_disposisi" value="Isi Disposisi" />
                                    <x-text-input wire:model="disposisi" id="isi_disposisi" class="block mt-1 w-full" type="text" />
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('surat.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 underline text-sm mr-4">Batal</a>
                        <x-primary-button wire:loading.attr="disabled">
                            {{ __('Perbarui Surat') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>