<section>
    <header class="mb-6">
        <h2 class="text-xl font-black text-slate-800">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm font-medium text-slate-500">
            {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="group">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-bold uppercase tracking-wider text-xs mb-2" />
            <div class="relative">
                <input id="name" name="name" type="text" class="block w-full py-3.5 px-4 border-slate-200 bg-slate-50 text-slate-800 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all font-medium" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="group">
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-bold uppercase tracking-wider text-xs mb-2" />
            <div class="relative">
                <input id="email" name="email" type="email" class="block w-full py-3.5 px-4 border-slate-200 bg-slate-50 text-slate-800 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all font-medium" :value="old('email', $user->email)" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 rounded-xl border border-amber-100">
                    <p class="text-sm text-amber-800 font-medium">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-amber-600 hover:text-amber-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 font-bold ml-1">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-sm text-emerald-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl text-sm font-black hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 uppercase tracking-widest">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
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