<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.
        </p>
    </header>

    <div x-data="{ confirming: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">
        {{-- Tombol Awal --}}
        <x-danger-button
            x-show="!confirming"
            x-on:click="confirming = true"
        >
            Hapus Akun
        </x-danger-button>

        {{-- Form Konfirmasi Inline (Pengganti Modal) --}}
        <div x-show="confirming" class="mt-4 p-4 border border-red-200 bg-red-50 rounded-lg dark:bg-red-900/20 dark:border-red-800 transition-all duration-300" x-transition>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Apakah Anda yakin ingin menghapus akun Anda?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="Kata Sandi" class="sr-only" />

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full sm:w-3/4"
                        placeholder="Kata Sandi"
                    />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="confirming = false">
                        Batal
                    </x-secondary-button>

                    <x-danger-button>
                        Hapus Akun
                    </x-danger-button>
                </div>
            </form>
        </div>
    </div>
</section>