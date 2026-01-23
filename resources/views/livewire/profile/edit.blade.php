<div class="max-w-7xl mx-auto space-y-6">
    <!-- Update Profile Information -->
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            <header>
                <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
                <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil akun dan alamat email Anda.</p>
            </header>

            <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
                <div>
                    <x-input-label for="name" value="Nama" />
                    <x-text-input wire:model="name" id="name" class="mt-1 block w-full" type="text" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" class="mt-1 block w-full" type="email" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button wire:loading.attr="disabled">{{ __('Simpan') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            <header>
                <h2 class="text-lg font-medium text-gray-900">Perbarui Password</h2>
                <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
            </header>

            <form wire:submit="updatePassword" class="mt-6 space-y-6">
                <div>
                    <x-input-label for="current_password" value="Password Saat Ini" />
                    <x-text-input wire:model="current_password" id="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="Password Baru" />
                    <x-text-input wire:model="password" id="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button wire:loading.attr="disabled">{{ __('Simpan') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>