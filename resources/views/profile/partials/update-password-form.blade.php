<section>
    <header class="mb-6">
        <h2 class="text-xl font-black text-slate-800">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm font-medium text-slate-500">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="group">
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="text-slate-700 font-bold uppercase tracking-wider text-xs mb-2" />
            <div class="relative">
                <input id="update_password_current_password" name="current_password" type="password" class="block w-full py-3.5 px-4 border-slate-200 bg-slate-50 text-slate-800 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all font-medium" autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="group">
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="text-slate-700 font-bold uppercase tracking-wider text-xs mb-2" />
            <div class="relative">
                <input id="update_password_password" name="password" type="password" class="block w-full py-3.5 px-4 border-slate-200 bg-slate-50 text-slate-800 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all font-medium" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="group">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-slate-700 font-bold uppercase tracking-wider text-xs mb-2" />
            <div class="relative">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full py-3.5 px-4 border-slate-200 bg-slate-50 text-slate-800 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all font-medium" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-black hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30 uppercase tracking-widest">
                {{ __('Simpan Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-emerald-600 flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>