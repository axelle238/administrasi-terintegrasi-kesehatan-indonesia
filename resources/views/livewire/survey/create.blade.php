<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-teal-600 p-6 text-center text-white">
            <h2 class="text-2xl font-bold">Survey Kepuasan</h2>
            <p class="text-teal-100">Puskesmas Kecamatan Jagakarsa</p>
        </div>

        <div class="p-6">
            @if($isSubmitted)
                <div class="text-center py-10">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Terima Kasih!</h3>
                    <p class="text-gray-600 mt-2">Masukan Anda sangat berarti bagi kami.</p>
                    <a href="/" class="inline-block mt-6 text-teal-600 font-semibold hover:underline">Kembali ke Halaman Utama</a>
                </div>
            @else
                <form wire:submit="save" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Poli / Layanan yang dikunjungi</label>
                        <select wire:model="poli_id" class="w-full rounded-lg border-gray-300 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($polis as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                        @error('poli_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bagaimana pelayanan kami?</label>
                        <div class="flex justify-center gap-2">
                            @for($i=1; $i<=5; $i++)
                                <button type="button" wire:click="$set('nilai', {{ $i }})" class="p-2 transition transform hover:scale-110 focus:outline-none">
                                    <svg class="w-10 h-10 {{ $nilai >= $i ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                </button>
                            @endfor
                        </div>
                        <p class="text-center text-sm font-bold text-gray-500 mt-1">
                            @if($nilai == 5) Sangat Puas
                            @elseif($nilai == 4) Puas
                            @elseif($nilai == 3) Cukup
                            @elseif($nilai == 2) Kurang
                            @else Sangat Buruk @endif
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kritik & Saran</label>
                        <textarea wire:model="kritik_saran" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-teal-500 focus:border-teal-500" placeholder="Tulis masukan Anda disini..."></textarea>
                        @error('kritik_saran') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-3 bg-teal-600 text-white font-bold rounded-lg shadow hover:bg-teal-700 transition">
                        Kirim Survey
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
