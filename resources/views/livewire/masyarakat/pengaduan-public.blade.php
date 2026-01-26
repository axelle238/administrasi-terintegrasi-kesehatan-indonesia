<div class="space-y-6">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Formulir Pengaduan Masyarakat</h2>
        <p class="text-sm text-gray-500">Sampaikan keluhan, aspirasi, atau pengaduan Anda terkait layanan kesehatan kami.</p>
    </div>

    <form wire:submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="nama_pelapor" value="Nama Lengkap" />
                <x-text-input wire:model="nama_pelapor" id="nama_pelapor" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('nama_pelapor')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="no_telepon_pelapor" value="Nomor Telepon/WA" />
                <x-text-input wire:model="no_telepon_pelapor" id="no_telepon_pelapor" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('no_telepon_pelapor')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="email_pelapor" value="Email (Opsional)" />
            <x-text-input wire:model="email_pelapor" id="email_pelapor" class="block mt-1 w-full" type="email" />
            <x-input-error :messages="$errors->get('email_pelapor')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="subjek" value="Subjek / Perihal" />
            <x-text-input wire:model="subjek" id="subjek" class="block mt-1 w-full" type="text" required placeholder="Contoh: Keluhan Antrean, Fasilitas Rusak, dll" />
            <x-input-error :messages="$errors->get('subjek')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="isi_pengaduan" value="Isi Pengaduan" />
            <textarea wire:model="isi_pengaduan" id="isi_pengaduan" class="border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm block mt-1 w-full" rows="5" required></textarea>
            <x-input-error :messages="$errors->get('isi_pengaduan')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="file_lampiran" value="Lampiran Pendukung (Opsional)" />
            <input type="file" wire:model="file_lampiran" id="file_lampiran" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
            <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG, PDF. Maksimal 5MB.</p>
            <x-input-error :messages="$errors->get('file_lampiran')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition duration-150 ease-in-out uppercase tracking-wider">
                Kirim Pengaduan
            </button>
        </div>
    </form>

    <div class="text-center mt-6">
        <a href="/" class="text-sm text-teal-600 hover:underline">Kembali ke Beranda</a>
    </div>
</div>
