<x-guest-layout>
    <div class="mb-8 text-center animate-fade-in">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white font-display tracking-tight">Registrasi Baru</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 font-medium">
            Daftarkan akun staf baru untuk akses sistem administrasi.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6 animate-fade-in-up">
        @csrf

        <!-- Name -->
        <div class="group">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-bold dark:text-slate-300 uppercase tracking-wider text-xs mb-2" />
            <div class="relative transition-all duration-300 group-focus-within:scale-[1.02]">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input id="name" class="block w-full pl-11 py-3.5 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all font-medium" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap Staf" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" :value="__('Email Instansi')" class="text-slate-700 font-bold dark:text-slate-300 uppercase tracking-wider text-xs mb-2" />
            <div class="relative transition-all duration-300 group-focus-within:scale-[1.02]">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" class="block w-full pl-11 py-3.5 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all font-medium" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@instansi.health" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="group">
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-slate-700 font-bold dark:text-slate-300 uppercase tracking-wider text-xs mb-2" />
            <div class="relative transition-all duration-300 group-focus-within:scale-[1.02]">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" class="block w-full pl-11 py-3.5 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all font-medium" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="group">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-slate-700 font-bold dark:text-slate-300 uppercase tracking-wider text-xs mb-2" />
            <div class="relative transition-all duration-300 group-focus-within:scale-[1.02]">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <input id="password_confirmation" class="block w-full pl-11 py-3.5 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all font-medium" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi Kata Sandi" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4 flex flex-col gap-4">
            <button type="submit" class="w-full flex justify-center items-center gap-2 py-4 px-6 border border-transparent rounded-xl shadow-lg shadow-blue-500/30 text-sm font-black text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-1 uppercase tracking-widest">
                {{ __('Daftar Akun Baru') }}
            </button>

            <div class="flex items-center justify-center">
                <a class="text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" href="{{ route('login') }}">
                    {{ __('Sudah punya akun? Masuk di sini') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>