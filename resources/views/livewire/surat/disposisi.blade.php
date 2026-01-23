<div>
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" wire:click="$set('isOpen', false)"></div>
                
                <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Lembar Disposisi
                            </h3>
                            
                            <div class="space-y-4">
                                <!-- Tujuan -->
                                <div>
                                    <x-input-label value="Diteruskan Kepada (Yth)" />
                                    <select wire:model="penerima_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Pilih Pejabat / Staf</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} - {{ ucfirst($user->role) }}</option>
                                        @endforeach
                                    </select>
                                    @error('penerima_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Sifat -->
                                    <div>
                                        <x-input-label value="Sifat Disposisi" />
                                        <select wire:model="sifat_disposisi" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                            <option value="Biasa">Biasa</option>
                                            <option value="Penting">Penting</option>
                                            <option value="Segera">Segera</option>
                                            <option value="Rahasia">Rahasia</option>
                                        </select>
                                    </div>
                                    <!-- Batas Waktu -->
                                    <div>
                                        <x-input-label value="Batas Waktu" />
                                        <x-text-input type="date" wire:model="batas_waktu" class="w-full mt-1" />
                                    </div>
                                </div>

                                <!-- Instruksi -->
                                <div>
                                    <x-input-label value="Instruksi / Pesa" />
                                    <textarea wire:model="instruksi" rows="3" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Tindak lanjuti, Koordinasikan dengan unit terkait..."></textarea>
                                    @error('instruksi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Catatan -->
                                <div>
                                    <x-input-label value="Catatan Tambahan (Opsional)" />
                                    <textarea wire:model="catatan" rows="2" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" placeholder="Catatan khusus..."></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:w-auto sm:text-sm">
                                Kirim Disposisi
                            </button>
                            <button type="button" wire:click="$set('isOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
