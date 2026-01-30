<x-guest-layout>
    <div class="mb-8 text-center animate-fade-in">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white font-display tracking-tight">Portal Masuk</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 font-medium">
            Sistem Administrasi Terintegrasi Kesehatan Indonesia
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6 animate-fade-in-up">
        @csrf

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" :value="__('Email Instansi')" class="text-slate-700 font-bold dark:text-slate-300 uppercase tracking-wider text-xs mb-2" />
            <div class="relative transition-all duration-300 group-focus-within:scale-[1.02]">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" class="block w-full pl-11 py-3.5 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all font-medium placeholder:text-slate-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@instansi.health.id" />
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
                <input id="password" class="block w-full pl-11 py-3.5 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all font-medium placeholder:text-slate-400" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <div class="relative flex items-center">
                    <input id="remember_me" type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-slate-300 shadow transition-all checked:border-blue-500 checked:bg-blue-500 hover:shadow-md" name="remember">
                    <svg class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 peer-checked:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <span class="ml-2 text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-blue-600 transition-colors">{{ __('Ingat Perangkat Ini') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa Akses?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center items-center gap-2 py-4 px-6 border border-transparent rounded-xl shadow-lg shadow-blue-500/30 text-sm font-black text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-1 uppercase tracking-widest">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                {{ __('Masuk ke Dashboard') }}
            </button>
        </div>
    </form>
</x-guest-layout>