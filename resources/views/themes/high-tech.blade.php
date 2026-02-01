<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="description" content="{{ $pengaturan['app_description'] ?? '' }}">
    <meta name="theme-color" content="{{ $pengaturan['primary_color'] ?? '#10b981' }}">
    <title>{{ $pengaturan['app_name'] ?? 'SATRIA' }} - {{ $pengaturan['app_tagline'] ?? 'Health System' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-heading: 'Outfit', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --color-primary: {{ $pengaturan['primary_color'] ?? '#10b981' }};
        }
        
        body { 
            font-family: var(--font-body); 
            background-color: #f8fafc;
            color: #334155; 
            overflow-x: hidden; 
            padding-bottom: 0; 
        }
        
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-heading); }
        
        .text-primary { color: var(--color-primary); }
        .bg-primary { background-color: var(--color-primary); }
        .border-primary { border-color: var(--color-primary); }
        .hover\:text-primary:hover { color: var(--color-primary); }
        .hover\:bg-primary:hover { background-color: var(--color-primary); }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .glass-dark { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        
        .animate-pulse-slow { animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        
        .animate-fade-in-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        
        .blob-bg {
            background-image: radial-gradient(circle at 100% 0%, #ecfdf5 0%, transparent 25%), radial-gradient(circle at 0% 0%, #f0f9ff 0%, transparent 25%);
        }
        
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, var(--color-primary), #0d9488);
        }

        [x-cloak] { display: none !important; }
        @keyframes marquee { 0% { transform: translateX(100%); } 100% { transform: translateX(-100%); } }
        .animate-marquee { animation: marquee 25s linear infinite; }
    </style>
</head>
<body class="antialiased transition-colors duration-300" 
      :class="darkMode ? 'bg-slate-900 text-slate-200' : 'bg-[#f8fafc] text-slate-600'"
      x-data="{
          scrolled: false, 
          activeSection: 'beranda',
          darkMode: localStorage.getItem('theme') === 'dark',
          toggleTheme() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          },
          init() {
              this.onScroll();
              window.addEventListener('scroll', () => this.onScroll());
              if (this.darkMode) document.documentElement.classList.add('dark');
          },
          onScroll() {
              this.scrolled = window.scrollY > 40;
              const sections = ['beranda', 'alur', 'tarif', 'jadwal', 'layanan'];
              for (const id of sections) {
                  const el = document.getElementById(id);
                  if (el) {
                      const rect = el.getBoundingClientRect();
                      if (rect.top <= 150 && rect.bottom >= 150) {
                          this.activeSection = id;
                      }
                  }
              }
          },
          scrollTo(id) {
              const el = document.getElementById(id);
              if (el) {
                  const offset = 100;
                  const bodyRect = document.body.getBoundingClientRect().top;
                  const elementRect = el.getBoundingClientRect().top;
                  const elementPosition = elementRect - bodyRect;
                  const offsetPosition = elementPosition - offset;

                  window.scrollTo({
                      top: offsetPosition,
                      behavior: 'smooth'
                  });
              }
          }
      }">
    <!-- Top Utility Bar -->
    <div class="bg-slate-900 text-slate-400 text-[10px] font-bold uppercase tracking-widest py-3 hidden md:block relative z-50 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-6 md:gap-8">
                <!-- Social Media -->
                <div class="flex items-center gap-3 border-r border-white/10 pr-6 mr-2 hidden lg:flex">
                    <a href="#" class="text-slate-500 hover:text-blue-500 transition-colors transform hover:-translate-y-0.5 duration-300"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <a href="#" class="text-slate-500 hover:text-sky-400 transition-colors transform hover:-translate-y-0.5 duration-300"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.892 3.213 2.251 4.122a4.909 4.92 0 01-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.935 4.935 0 01-2.224.084 4.928 4.928 0 004.6 3.419A9.9 9.9 0 010 21.543a13.94 13.94 0 007.548 2.212c9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="text-slate-500 hover:text-pink-500 transition-colors transform hover:-translate-y-0.5 duration-300"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.269.153 5.023 1.916 5.176 5.194.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.892 5.011-5.122 5.176-1.265.058-1.644.069-4.849.069-3.204 0-3.584-.012-4.849-.069-3.229-.149-5.011-1.892-5.176-5.122-.058-1.265-.069-1.644-.069-4.849 0-3.204.012-3.584.069-4.849.153-3.269 1.916-5.023 5.194-5.176 1.265-.058 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                </div>

                <a href="tel:{{ $pengaturan['app_phone'] ?? '' }}" class="flex items-center gap-2 hover:text-emerald-400 transition-colors">
                    <div class="w-5 h-5 rounded bg-white/10 flex items-center justify-center"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 12.284 3 6V5z" /></svg></div>
                    {{ $pengaturan['app_phone'] ?? '119' }}
                </a>
                <a href="mailto:{{ $pengaturan['app_email'] ?? '' }}" class="flex items-center gap-2 hover:text-emerald-400 transition-colors">
                    <div class="w-5 h-5 rounded bg-white/10 flex items-center justify-center"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></div>
                    {{ $pengaturan['app_email'] ?? 'info@satria.id' }}
                </a>
            </div>
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span></span>
                    <span class="text-emerald-400">Layanan Gawat Darurat 24/7</span>
                </span>
                <div class="h-3 w-px bg-white/10"></div>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Announcement Bar -->
    @if(($pengaturan['announcement_active'] ?? '0') == '1')
    <div x-data="{ showAnnouncement: true }" x-show="showAnnouncement" class="bg-gradient-to-r from-rose-600 to-orange-600 text-white text-xs font-bold py-2.5 relative z-[45] border-b border-white/10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center gap-4">
            <div class="flex items-center gap-2 shrink-0 animate-pulse">
                <div class="p-1 bg-white/20 rounded-full"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg></div>
                <span class="uppercase tracking-widest hidden sm:inline">Info Penting:</span>
            </div>
            <div class="flex-1 overflow-hidden relative h-4">
                <div class="absolute whitespace-nowrap animate-marquee w-full">
                    {{ $pengaturan['announcement_text'] ?? 'Layanan Gawat Darurat tersedia 24 Jam. Harap membawa identitas diri saat berobat.' }} &nbsp;&nbsp;&bull;&nbsp;&nbsp; {{ $pengaturan['announcement_text'] ?? 'Layanan Gawat Darurat tersedia 24 Jam. Harap membawa identitas diri saat berobat.' }}
                </div>
            </div>
            <button @click="showAnnouncement = false" class="shrink-0 hover:bg-white/20 rounded-full p-1 transition-colors"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
    </div>
    @endif

    <!-- Navbar -->
    <nav :class="{ 'py-3 shadow-lg top-0': scrolled, 'py-5 bg-transparent border-transparent top-0 md:top-10': !scrolled, 'bg-white/80 border-slate-200/50': !darkMode && scrolled, 'bg-slate-900/80 border-slate-700/50': darkMode && scrolled }" 
         class="fixed left-0 right-0 z-[100] transition-all duration-500 hidden md:block backdrop-blur-xl border-b">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Logo Area -->
                <a href="#" class="flex items-center gap-3 group shrink-0">
                    <div class="relative w-11 h-11 animate-float" style="animation-duration: 3s;">
                        <div class="absolute inset-0 bg-primary/20 rounded-xl rotate-6 transition-transform group-hover:rotate-12 duration-500"></div>
                        <div class="relative w-full h-full rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-xl shadow-emerald-500/30 transition-transform group-hover:-translate-y-1 duration-500">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                    </div>
                    <div>
                        <h1 class="font-black text-xl text-slate-800 tracking-tight leading-none group-hover:text-primary transition-colors">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</h1>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest group-hover:text-slate-500 transition-colors">{{ $pengaturan['app_tagline'] }}</p>
                    </div>
                </a>

                <!-- Navigation Links -->
                <div class="flex items-center gap-1 bg-white/60 dark:bg-slate-800/60 p-1.5 rounded-full border border-white/60 dark:border-slate-700 backdrop-blur-md shadow-sm ring-1 ring-slate-100 dark:ring-slate-800 relative z-50">
                    <a href="#beranda" 
                       @click.prevent="scrollTo('beranda')"
                       class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 relative group overflow-hidden decoration-0 cursor-pointer"
                       :class="activeSection === 'beranda' ? 'text-primary bg-white dark:bg-slate-700 shadow-md ring-1 ring-slate-100 dark:ring-slate-600' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60'">
                        <span class="relative z-10">Beranda</span>
                    </a>

                    <a href="{{ route('alur-pelayanan.index') }}" 
                       class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 relative group overflow-hidden decoration-0 text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60 cursor-pointer">
                        <span class="relative z-10">Alur</span>
                    </a>

                    <a href="#tarif" 
                       @click.prevent="scrollTo('tarif')"
                       class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 relative group overflow-hidden decoration-0 cursor-pointer"
                       :class="activeSection === 'tarif' ? 'text-primary bg-white dark:bg-slate-700 shadow-md ring-1 ring-slate-100 dark:ring-slate-600' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60'">
                        <span class="relative z-10">Tarif</span>
                    </a>

                    <a href="#jadwal" 
                       @click.prevent="scrollTo('jadwal')"
                       class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 relative group overflow-hidden decoration-0 cursor-pointer"
                       :class="activeSection === 'jadwal' ? 'text-primary bg-white dark:bg-slate-700 shadow-md ring-1 ring-slate-100 dark:ring-slate-600' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60'">
                        <span class="relative z-10">Jadwal</span>
                    </a>

                    <a href="#layanan" 
                       @click.prevent="scrollTo('layanan')"
                       class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 relative group overflow-hidden decoration-0 cursor-pointer"
                       :class="activeSection === 'layanan' ? 'text-primary bg-white dark:bg-slate-700 shadow-md ring-1 ring-slate-100 dark:ring-slate-600' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60'">
                        <span class="relative z-10">Layanan</span>
                    </a>

                    <a href="#berita" 
                       @click.prevent="scrollTo('berita')"
                       class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 relative group overflow-hidden decoration-0 cursor-pointer"
                       :class="activeSection === 'berita' ? 'text-primary bg-white dark:bg-slate-700 shadow-md ring-1 ring-slate-100 dark:ring-slate-600' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60'">
                        <span class="relative z-10">Berita</span>
                    </a>
                </div>

                <!-- Simplified Action Center -->
                <div class="flex items-center gap-3">
                    @auth


                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center gap-3 pl-1 pr-3 py-1 bg-white/60 hover:bg-white backdrop-blur-md border border-white/60 rounded-full transition-all duration-300 shadow-sm hover:shadow-md group">
                                <div class="relative">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white text-xs font-black ring-2 ring-white">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-700 group-hover:text-slate-900 hidden md:block max-w-[80px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-3 h-3 text-slate-400 group-hover:text-slate-600 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 class="absolute top-full right-0 mt-3 w-64 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-white/50 p-2 z-50 transform origin-top-right"
                                 style="display: none;">
                                 
                                <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700 mb-1" x-data="{ greeting: '' }" x-init="
                                    const hour = new Date().getHours();
                                    if (hour < 11) greeting = 'Selamat Pagi,';
                                    else if (hour < 15) greeting = 'Selamat Siang,';
                                    else if (hour < 19) greeting = 'Selamat Sore,';
                                    else greeting = 'Selamat Malam,';
                                ">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest" x-text="greeting"></p>
                                    <p class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors text-xs font-bold text-slate-600 hover:text-primary">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                    Dashboard Utama
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-rose-50 transition-colors text-xs font-bold text-slate-600 hover:text-rose-600">
                                        <svg class="w-4 h-4 text-slate-400 hover:text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4-4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Keluar Aplikasi
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest Actions -->
                        <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white px-5 py-2.5 hover:bg-white dark:hover:bg-slate-800 hover:shadow-md rounded-full transition-all border border-transparent hover:border-slate-100 dark:hover:border-slate-700">Login Staf</a>
                        
                        <!-- Quick Access Dropdown -->
                        <div class="relative z-50" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="group relative z-10 px-6 py-2.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-0.5 transition-all overflow-hidden flex items-center gap-2">
                                <span class="relative z-10">Layanan Pasien</span>
                                <svg class="w-4 h-4 relative z-10 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                            </button>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 class="absolute top-full right-0 mt-3 w-56 bg-white dark:bg-slate-800 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 p-2 z-50 overflow-hidden">
                                
                                <div class="px-3 py-2 border-b border-slate-100 dark:border-slate-700 mb-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Akses Cepat</p>
                                </div>

                                <a href="{{ route('antrean.monitor') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-50 dark:hover:bg-slate-700 transition-colors group">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400">Ambil Antrean</p>
                                        <p class="text-[9px] text-slate-400">Daftar berobat online</p>
                                    </div>
                                </a>

                                <a href="{{ route('antrean.monitor') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-blue-50 dark:hover:bg-slate-700 transition-colors group">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400">Cek Status</p>
                                        <p class="text-[9px] text-slate-400">Pantau nomor antrean</p>
                                    </div>
                                </a>

                                <a href="#jadwal" @click="scrollTo('jadwal')" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-purple-50 dark:hover:bg-slate-700 transition-colors group">
                                    <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center text-purple-600 dark:text-purple-400 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-purple-600 dark:group-hover:text-purple-400">Jadwal Dokter</p>
                                        <p class="text-[9px] text-slate-400">Lihat praktik hari ini</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Top Bar & Drawer -->
    <div x-data="{ mobileMenuOpen: false }">
        <!-- Mobile Header -->
        <div class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-xl border-b border-slate-200/50 px-5 py-4 flex justify-between items-center md:hidden shadow-sm transition-all duration-300" :class="{ 'bg-white shadow-md': scrolled }" @scroll.window="scrolled = (window.pageYOffset > 20)">
            <a href="#" class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </div>
                <div>
                    <h1 class="font-black text-lg text-slate-800 leading-none">{{ $pengaturan['app_name'] }}</h1>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $pengaturan['app_tagline'] }}</p>
                </div>
            </a>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 active:scale-95 transition-transform"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></a>
                @endauth
                <button @click="mobileMenuOpen = true" class="p-2 -mr-2 text-slate-600 hover:text-slate-900">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenuOpen" class="fixed inset-0 z-[60] md:hidden" style="display: none;">
            <!-- Backdrop -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" 
                 @click="mobileMenuOpen = false"></div>

            <!-- Panel -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="fixed inset-y-0 right-0 w-full max-w-xs bg-white dark:bg-slate-900 shadow-2xl flex flex-col h-full overflow-hidden border-l border-slate-200 dark:border-slate-800">
                
                <!-- Drawer Header -->
                <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/50">
                    <h2 class="font-black text-lg text-slate-800 dark:text-white">Menu Utama</h2>
                    <button @click="mobileMenuOpen = false" class="p-2 -mr-2 text-slate-400 hover:text-rose-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="flex-1 overflow-y-auto p-6 space-y-8">
                    
                    <!-- Mobile Search -->
                    <div class="relative">
                        <input type="text" placeholder="Cari layanan atau dokter..." class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 border-none text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 placeholder:text-slate-400">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>

                    <!-- Main Links -->
                    <div class="space-y-2">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Navigasi</p>
                        @foreach(['Beranda' => '#beranda', 'Keunggulan' => '#keunggulan', 'Alur Pelayanan' => '#alur', 'Jadwal Dokter' => '#jadwal', 'Berita Terkini' => '#berita'] as $label => $link)
                            <a href="{{ $link }}" @click="mobileMenuOpen = false" class="block py-2 text-base font-bold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:translate-x-1 transition-all border-b border-dashed border-slate-100 dark:border-slate-800 last:border-0">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Layanan Accordion -->
                    <div x-data="{ layananOpen: false }">
                        <button @click="layananOpen = !layananOpen" class="flex items-center justify-between w-full text-xs font-black text-slate-400 uppercase tracking-widest mb-3 hover:text-slate-600 dark:hover:text-slate-300">
                            <span>Layanan Medis</span>
                            <svg class="w-4 h-4 transition-transform" :class="layananOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="layananOpen" x-collapse class="space-y-2 pl-2 border-l-2 border-slate-100 dark:border-slate-800" style="display: none;">
                            @foreach($layanan as $poli)
                                <a href="#layanan" @click="mobileMenuOpen = false" class="block py-1.5 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                                    {{ $poli->nama_poli }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Settings (Dark Mode) -->
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4 border border-slate-100 dark:border-slate-700 flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200">Mode Gelap</span>
                        <button @click="toggleTheme()" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" :class="darkMode ? 'bg-emerald-600' : 'bg-slate-200'">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform" :class="darkMode ? 'translate-x-6' : 'translate-x-1'"></span>
                        </button>
                    </div>

                    <!-- Auth Actions -->
                    <div>
                        @auth
                            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4 border border-slate-100 dark:border-slate-700">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold text-lg">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <a href="{{ url('/dashboard') }}" class="py-2.5 text-center bg-slate-900 dark:bg-white dark:text-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:opacity-90 transition-all shadow-md">
                                        Dashboard
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full py-2.5 text-center bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-800/50 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-rose-100 dark:hover:bg-rose-900/50 transition-all">
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Akses Cepat</p>
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <a href="{{ route('antrean.monitor') }}" class="flex flex-col items-center justify-center py-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/50 rounded-2xl hover:bg-emerald-100 dark:hover:bg-emerald-900/40 transition-all group">
                                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400 mb-1 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                    <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-300 uppercase">Cek Antrean</span>
                                </a>
                                <a href="#jadwal" class="flex flex-col items-center justify-center py-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 rounded-2xl hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-all group">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mb-1 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <span class="text-[10px] font-bold text-blue-700 dark:text-blue-300 uppercase">Jadwal</span>
                                </a>
                            </div>
                            <a href="{{ route('antrean.monitor') }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-2xl text-sm font-bold uppercase tracking-wider shadow-lg shadow-emerald-500/30 hover:-translate-y-1 transition-all mb-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Ambil Nomor Antrean
                            </a>
                            <a href="{{ route('login') }}" class="flex items-center justify-center w-full py-3.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 rounded-2xl text-sm font-bold uppercase tracking-wider hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                                Login Petugas
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="p-6 bg-slate-50 dark:bg-slate-800 border-t border-slate-100 dark:border-slate-700 text-center">
                    <div class="flex justify-center gap-4 mb-4">
                        <a href="#" class="w-8 h-8 rounded-full bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 flex items-center justify-center text-slate-400 hover:text-blue-500 hover:border-blue-200 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 flex items-center justify-center text-slate-400 hover:text-sky-400 hover:border-sky-200 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.892 3.213 2.251 4.122a4.909 4.92 0 01-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.935 4.935 0 01-2.224.084 4.928 4.928 0 004.6 3.419A9.9 9.9 0 010 21.543a13.94 13.94 0 007.548 2.212c9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 flex items-center justify-center text-slate-400 hover:text-pink-500 hover:border-pink-200 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.269.153 5.023 1.916 5.176 5.194.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.892 5.011-5.122 5.176-1.265.058-1.644.069-4.849.069-3.204 0-3.584-.012-4.849-.069-3.229-.149-5.011-1.892-5.176-5.122-.058-1.265-.069-1.644-.069-4.849 0-3.204.012-3.584.069-4.849.153-3.269 1.916-5.023 5.194-5.176 1.265-.058 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                    <p class="text-[10px] font-bold text-slate-400">
                        &copy; {{ date('Y') }} {{ $pengaturan['app_name'] }}<br>
                        {{ $pengaturan['app_tagline'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- HERO SECTION -->
    @if($cmsSections['hero']->is_active ?? false)
    <header id="beranda" class="relative pt-32 pb-24 md:pt-48 md:pb-32 overflow-hidden blob-bg">
        <!-- Animated Background Elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-200/30 rounded-full blur-3xl animate-float pointer-events-none" style="animation-delay: 0s;"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-200/30 rounded-full blur-3xl animate-float pointer-events-none" style="animation-delay: 2s;"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="flex-1 text-center lg:text-left space-y-8">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 backdrop-blur-md border border-white shadow-sm animate-fade-in-up">
                        <span class="relative flex h-2.5 w-2.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-primary"></span></span>
                        <span class="text-xs font-bold text-slate-600 uppercase tracking-wide">{{ $cmsSections['hero']->subtitle ?? 'Layanan Kesehatan Terdepan' }}</span>
                    </div>
                    
                    <!-- Headline -->
                    <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] tracking-tight animate-fade-in-up" style="animation-delay: 0.1s">
                        <span class="text-gradient">{{ $cmsSections['hero']->title ?? 'Judul Hero' }}</span>
                        <br>Untuk Indonesia.
                    </h1>
                    
                    <!-- Description -->
                    <p class="text-slate-500 text-lg md:text-xl leading-relaxed max-w-xl mx-auto lg:mx-0 animate-fade-in-up font-medium" style="animation-delay: 0.2s">
                        {{ $cmsSections['hero']->content ?? '' }}
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start animate-fade-in-up" style="animation-delay: 0.3s">
                        <a href="{{ route('antrean.monitor') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-slate-900 text-white font-bold text-sm uppercase tracking-wider shadow-xl shadow-slate-900/20 hover:shadow-slate-900/40 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 group">
                            <div class="p-1 bg-white/20 rounded-full group-hover:rotate-12 transition-transform"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg></div>
                            {{ $cmsSections['hero']->metadata['cta_primary_text'] ?? 'Daftar Berobat' }}
                        </a>
                        <a href="{{ $cmsSections['hero']->metadata['cta_secondary_url'] ?? '#jadwal' }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white border border-white shadow-lg text-slate-700 font-bold text-sm uppercase tracking-wider hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                            <span>{{ $cmsSections['hero']->metadata['cta_secondary_text'] ?? 'Jadwal Dokter' }}</span>
                        </a>
                    </div>

                    <!-- Trust Markers -->
                    <div class="pt-8 flex items-center justify-center lg:justify-start gap-8 opacity-80 animate-fade-in-up" style="animation-delay: 0.4s">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center text-blue-600 shadow-sm"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                            <div class="text-left">
                                <p class="text-xs font-black text-slate-800 uppercase">Terakreditasi</p>
                                <p class="text-[10px] font-bold text-slate-400">Paripurna Kemenkes</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shadow-sm"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg></div>
                            <div class="text-left">
                                <p class="text-xs font-black text-slate-800 uppercase">Data Aman</p>
                                <p class="text-[10px] font-bold text-slate-400">Enkripsi 256-bit</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Illustration -->
                <div class="flex-1 w-full relative animate-float hidden lg:block">
                    <div class="relative z-10 p-2 bg-white/40 backdrop-blur-sm rounded-[3rem] border border-white/60 shadow-2xl">
                        @if($cmsSections['hero']->image)
                            <img src="{{ Storage::url($cmsSections['hero']->image) }}" class="w-full h-auto rounded-[2.5rem] object-cover aspect-[4/5] shadow-inner">
                        @else
                            <img src="https://images.unsplash.com/photo-1638202993928-7267aad84c31?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="w-full h-auto rounded-[2.5rem] object-cover aspect-[4/5] shadow-inner">
                        @endif
                        
                        <!-- Floating Card 1 -->
                        <div class="absolute top-10 -left-10 glass p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-float" style="animation-delay: 1s;">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 uppercase">Respon Cepat</p>
                                <p class="text-lg font-black text-slate-800">24 Jam</p>
                            </div>
                        </div>

                        <!-- Floating Card 2 -->
                        <div class="absolute bottom-10 -right-10 glass p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-float" style="animation-delay: 2.5s;">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 uppercase">Dokter Ahli</p>
                                <p class="text-lg font-black text-slate-800">Profesional</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @endif

    <!-- KEUNGGULAN (Why Us) - NEW SECTION -->
    @if($cmsSections['why_us']->is_active ?? true) 
    <!-- Fallback true for demo if not in DB yet -->
    <section id="layanan" class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="text-emerald-600 font-black tracking-widest uppercase text-xs mb-2 block">Kenapa Memilih Kami?</span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6">Standar Kesehatan <br>Masa Depan</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">Kombinasi teknologi medis mutakhir dan pelayanan humanis untuk pengalaman berobat terbaik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="group bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 hover:bg-slate-900 hover:text-white transition-all duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-colors"></div>
                    <div class="w-16 h-16 rounded-2xl bg-white text-emerald-600 flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:bg-white/10 group-hover:text-emerald-400 transition-colors">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white transition-colors">Teknologi Mutakhir</h3>
                    <p class="text-slate-500 group-hover:text-slate-400 transition-colors leading-relaxed">Peralatan medis diagnostik terbaru dengan akurasi tinggi untuk penanganan presisi.</p>
                </div>

                <!-- Card 2 -->
                <div class="group bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 hover:bg-slate-900 hover:text-white transition-all duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl group-hover:bg-blue-500/20 transition-colors"></div>
                    <div class="w-16 h-16 rounded-2xl bg-white text-blue-600 flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:bg-white/10 group-hover:text-blue-400 transition-colors">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white transition-colors">Tim Dokter Ahli</h3>
                    <p class="text-slate-500 group-hover:text-slate-400 transition-colors leading-relaxed">Didukung oleh dokter spesialis berpengalaman dengan sertifikasi nasional.</p>
                </div>

                <!-- Card 3 -->
                <div class="group bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 hover:bg-slate-900 hover:text-white transition-all duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl group-hover:bg-purple-500/20 transition-colors"></div>
                    <div class="w-16 h-16 rounded-2xl bg-white text-purple-600 flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:bg-white/10 group-hover:text-purple-400 transition-colors">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white transition-colors">Pelayanan Cepat</h3>
                    <p class="text-slate-500 group-hover:text-slate-400 transition-colors leading-relaxed">Sistem antrean digital dan rekam medis elektronik untuk efisiensi waktu Anda.</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ALUR PELAYANAN (Interactive Explorer) -->
    <section id="alur" class="py-24 bg-slate-50 relative overflow-hidden" x-data="{ activePoli: {{ $layanan->first()->id ?? 'null' }}, activeService: null }">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            
            <div class="text-center mb-12">
                <span class="text-primary font-black tracking-widest uppercase text-xs mb-2 block">Panduan Prosedur</span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-4">Eksplorasi Alur Layanan</h2>
                <p class="text-slate-500 text-lg max-w-2xl mx-auto">Pilih unit layanan di bawah ini untuk melihat prosedur dan tahapan pelayanan secara detail.</p>
            </div>

            <!-- 1. Poli Tabs (Horizontal Scroll) -->
            <div class="flex justify-center mb-10">
                <div class="inline-flex gap-2 p-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-x-auto max-w-full custom-scrollbar">
                    @foreach($layanan as $poli)
                    <button @click="activePoli = {{ $poli->id }}; activeService = null" 
                            :class="activePoli === {{ $poli->id }} ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all whitespace-nowrap">
                        {{ $poli->nama_poli }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- 2. Services Grid (Dynamic Content) -->
            <div class="min-h-[400px]">
                @foreach($layanan as $poli)
                <div x-show="activePoli === {{ $poli->id }}" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="display: none;">
                    
                    @if($poli->jenisPelayanans->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                            @foreach($poli->jenisPelayanans as $jenis)
                            <button @click="activeService = activeService === {{ $jenis->id }} ? null : {{ $jenis->id }}" 
                                    :class="activeService === {{ $jenis->id }} ? 'ring-2 ring-primary border-primary bg-slate-50' : 'border-slate-100 hover:border-slate-300 bg-white'"
                                    class="group text-left p-6 rounded-[2rem] border shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden h-full flex flex-col">
                                
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-colors"
                                         :class="activeService === {{ $jenis->id }} ? 'bg-primary text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-primary group-hover:text-white'">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400" x-show="activeService !== {{ $jenis->id }}">Klik Detail</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-primary" x-show="activeService === {{ $jenis->id }}">Sedang Aktif</span>
                                </div>
                                
                                <h3 class="text-lg font-black text-slate-800 mb-2 leading-tight group-hover:text-primary transition-colors">{{ $jenis->nama_layanan }}</h3>
                                <p class="text-sm text-slate-500 line-clamp-2 mb-4">{{ $jenis->deskripsi }}</p>
                                
                                <div class="mt-auto pt-4 border-t border-slate-50 flex items-center gap-2 text-xs font-bold text-slate-400 group-hover:text-primary transition-colors">
                                    <span>Lihat Tahapan</span>
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </div>
                            </button>
                            @endforeach
                        </div>

                        <!-- 3. Detail Flow Timeline (Expandable) -->
                        @foreach($poli->jenisPelayanans as $jenis)
                        <div x-show="activeService === {{ $jenis->id }}" 
                             x-collapse
                             class="bg-white rounded-[3rem] border border-slate-200 shadow-xl overflow-hidden relative">
                            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary via-emerald-400 to-teal-500"></div>
                            
                            <div class="p-8 md:p-12">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                                    <div>
                                        <h3 class="text-2xl font-black text-slate-900 mb-1">Alur: {{ $jenis->nama_layanan }}</h3>
                                        <p class="text-slate-500">{{ $jenis->deskripsi }}</p>
                                    </div>
                                    <a href="{{ route('alur-pelayanan.index') }}" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 transition-colors flex items-center gap-2">
                                        Mode Layar Penuh
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 01-2 2v10a2 2 0 012 2h10a2 2 0 012-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                    </a>
                                </div>

                                <!-- Horizontal Steps Scroll -->
                                <div class="relative">
                                    <div class="flex gap-8 overflow-x-auto pb-8 custom-scrollbar snap-x">
                                        @forelse($jenis->alurPelayanans as $index => $alur)
                                        <div class="flex-shrink-0 w-80 snap-start relative group">
                                            <!-- Step Number -->
                                            <div class="absolute -top-3 -left-3 w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-lg shadow-lg z-10 group-hover:scale-110 transition-transform {{ $alur->is_critical ? 'bg-rose-600' : '' }}">
                                                {{ $loop->iteration }}
                                            </div>
                                            
                                            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 h-full hover:bg-white hover:shadow-lg hover:border-primary/30 transition-all duration-300">
                                                <div class="pl-4 mb-4">
                                                    <h4 class="font-bold text-lg text-slate-800 mb-1 leading-tight">{{ $alur->judul }}</h4>
                                                    <div class="flex gap-2">
                                                        <span class="text-[10px] font-bold uppercase tracking-wider bg-white px-2 py-1 rounded border border-slate-200 text-slate-500">{{ $alur->waktu_range ?? $alur->estimasi_waktu }}</span>
                                                        @if($alur->is_critical)
                                                        <span class="text-[10px] font-bold uppercase tracking-wider bg-rose-100 px-2 py-1 rounded text-rose-600">Wajib</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                @if($alur->gambar)
                                                <div class="mb-4 rounded-xl overflow-hidden h-32 bg-slate-200">
                                                    <img src="{{ asset('storage/'.$alur->gambar) }}" class="w-full h-full object-cover">
                                                </div>
                                                @endif

                                                <p class="text-sm text-slate-600 leading-relaxed mb-4 text-justify">{{ $alur->deskripsi }}</p>
                                                
                                                @if($alur->dokumen_syarat)
                                                <div class="bg-indigo-50 p-3 rounded-xl border border-indigo-100">
                                                    <p class="text-[9px] font-black uppercase tracking-widest text-indigo-400 mb-1">Syarat</p>
                                                    <p class="text-xs font-bold text-indigo-900">{{ $alur->dokumen_syarat }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Connector Line (except last) -->
                                            @if(!$loop->last)
                                            <div class="hidden md:block absolute top-1/2 -right-6 w-8 h-0.5 bg-slate-200"></div>
                                            <div class="hidden md:block absolute top-1/2 -right-2 w-2 h-2 bg-slate-300 rounded-full"></div>
                                            @endif
                                        </div>
                                        @empty
                                        <div class="w-full text-center py-12 text-slate-400">Belum ada langkah prosedur yang diinputkan.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    @else
                        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-[3rem] border border-dashed border-slate-200">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            </div>
                            <p class="text-slate-500 font-bold">Belum ada jenis pelayanan terdaftar di unit ini.</p>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ALUR PELAYANAN (Legacy/Backup Hidden) -->
    <!-- Removed old section to prevent conflict -->

    <!-- JADWAL DOKTER -->
    @if(isset($hargaLayanan) && count($hargaLayanan) > 0)
    <section id="tarif" class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-black tracking-widest uppercase text-xs mb-2 block">Transparansi Biaya</span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6">Tarif Layanan Unggulan</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg font-medium">Informasi estimasi biaya layanan untuk kenyamanan perencanaan kesehatan Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($hargaLayanan as $tarif)
                <div class="group p-8 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:border-blue-200 transition-all duration-500">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-blue-600 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors duration-500">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        </div>
                        <span class="px-3 py-1 bg-white text-slate-400 text-[10px] font-black uppercase rounded-lg border border-slate-100">Estimasi</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">{{ $tarif->nama_tindakan }}</h3>
                    <div class="text-3xl font-black text-slate-900 mt-4">
                        <span class="text-sm font-bold text-slate-400">Rp</span> {{ number_format($tarif->harga, 0, ',', '.') }}
                    </div>
                    <p class="text-xs text-slate-400 font-bold uppercase mt-6 tracking-widest">{{ $tarif->poli->nama_poli ?? 'Layanan Umum' }}</p>
                </div>
                @endforeach
            </div>
            
            <div class="mt-16 text-center">
                <p class="text-sm text-slate-400 font-medium">* Tarif dapat berubah sewaktu-waktu sesuai dengan kebijakan dan kondisi medis pasien.</p>
            </div>
        </div>
    </section>
    @endif

    <!-- JADWAL DOKTER -->
    @if(($pengaturan['show_jadwal_dokter'] ?? '1') == '1')
    <section id="jadwal" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-emerald-600 font-black tracking-widest uppercase text-xs mb-2 block">Tim Medis</span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900">Jadwal Praktik Hari Ini</h2>
            </div>

            @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="group bg-white p-6 rounded-[2rem] border border-slate-100 shadow-lg hover:shadow-2xl hover:border-emerald-200 transition-all duration-500 flex items-center gap-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative w-20 h-20 rounded-2xl bg-slate-100 overflow-hidden shrink-0 shadow-inner">
                            @if($jadwal->pegawai->foto_profil ?? false)
                                <img src="{{ Storage::url($jadwal->pegawai->foto_profil) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 font-black text-2xl bg-slate-50">
                                    {{ substr($jadwal->pegawai->user->name ?? 'D', 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1 relative">
                            <h4 class="font-black text-lg text-slate-900 truncate mb-1">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wide mb-3">{{ $jadwal->pegawai->poli->nama_poli ?? 'Umum' }}</p>
                            <span class="inline-block px-3 py-1 rounded-lg bg-slate-900 text-white text-[10px] font-black uppercase tracking-wider group-hover:bg-emerald-600 transition-colors">
                                {{ $jadwal->shift->jam_masuk ?? '00:00' }} - {{ $jadwal->shift->jam_keluar ?? '00:00' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-slate-50 p-16 text-center rounded-[3rem] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm text-slate-300">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <p class="text-slate-400 font-bold text-lg">Tidak ada jadwal dokter untuk hari ini.</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- BERITA TERKINI (New Design) -->
    <section id="berita" class="py-24 bg-slate-900 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="flex justify-between items-end mb-16">
                <div>
                    <span class="text-emerald-400 font-black tracking-widest uppercase text-xs mb-2 block">Wawasan</span>
                    <h2 class="text-3xl md:text-5xl font-black text-white">Berita & Artikel</h2>
                </div>
                <a href="#" class="hidden md:flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-white transition-colors">
                    Lihat Semua <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>

            @if(isset($beritaTerbaru) && count($beritaTerbaru) > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($beritaTerbaru as $news)
                <article class="group bg-white/5 border border-white/10 rounded-[2rem] overflow-hidden hover:bg-white/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="h-48 bg-slate-800 relative overflow-hidden">
                        @if($news->thumbnail)
                            <img src="{{ Storage::url($news->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-700 bg-slate-800">
                                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-emerald-500 text-white text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-wider">
                            {{ $news->kategori ?? 'Umum' }}
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center gap-3 text-xs text-slate-400 mb-4">
                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg> {{ $news->created_at->format('d M Y') }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4 leading-tight group-hover:text-emerald-400 transition-colors">{{ $news->judul }}</h3>
                        <a href="#" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-500 hover:text-emerald-400">
                            Baca Selengkapnya <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 border border-white/10 rounded-[2rem] bg-white/5">
                <p class="text-slate-400">Belum ada berita terbaru.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- FAQ SECTION (Interactive Accordion) -->
    <section id="faq" class="py-24 bg-white" x-data="{ activeAccordion: null }">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-emerald-600 font-black tracking-widest uppercase text-xs mb-2 block">Bantuan</span>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900">Pertanyaan Umum</h2>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="border border-slate-200 rounded-3xl overflow-hidden transition-all duration-300" :class="activeAccordion === 1 ? 'border-emerald-500 ring-4 ring-emerald-500/10' : 'hover:border-slate-300'">
                    <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full flex items-center justify-between p-6 text-left bg-white">
                        <span class="font-bold text-lg text-slate-800">Bagaimana cara mendaftar antrean online?</span>
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center transition-transform duration-300" :class="activeAccordion === 1 ? 'rotate-180 bg-emerald-100 text-emerald-600' : 'text-slate-400'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </button>
                    <div x-show="activeAccordion === 1" x-collapse>
                        <div class="p-6 pt-0 text-slate-500 leading-relaxed border-t border-slate-100">
                            Anda dapat mendaftar melalui menu "Ambil Antrean" di halaman ini atau melalui aplikasi mobile kami. Pastikan Anda memiliki nomor KTP/BPJS yang valid.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-slate-200 rounded-3xl overflow-hidden transition-all duration-300" :class="activeAccordion === 2 ? 'border-emerald-500 ring-4 ring-emerald-500/10' : 'hover:border-slate-300'">
                    <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full flex items-center justify-between p-6 text-left bg-white">
                        <span class="font-bold text-lg text-slate-800">Apakah menerima pasien BPJS?</span>
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center transition-transform duration-300" :class="activeAccordion === 2 ? 'rotate-180 bg-emerald-100 text-emerald-600' : 'text-slate-400'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </button>
                    <div x-show="activeAccordion === 2" x-collapse>
                        <div class="p-6 pt-0 text-slate-500 leading-relaxed border-t border-slate-100">
                            Ya, kami melayani pasien BPJS Kesehatan untuk semua poli yang tersedia. Mohon membawa kartu BPJS dan surat rujukan (jika diperlukan) saat berkunjung.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-slate-200 rounded-3xl overflow-hidden transition-all duration-300" :class="activeAccordion === 3 ? 'border-emerald-500 ring-4 ring-emerald-500/10' : 'hover:border-slate-300'">
                    <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full flex items-center justify-between p-6 text-left bg-white">
                        <span class="font-bold text-lg text-slate-800">Berapa biaya konsultasi dokter umum?</span>
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center transition-transform duration-300" :class="activeAccordion === 3 ? 'rotate-180 bg-emerald-100 text-emerald-600' : 'text-slate-400'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </button>
                    <div x-show="activeAccordion === 3" x-collapse>
                        <div class="p-6 pt-0 text-slate-500 leading-relaxed border-t border-slate-100">
                            Biaya konsultasi bervariasi tergantung jenis layanan. Silakan cek menu "Harga Layanan" di halaman depan untuk informasi tarif terbaru.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CALL TO ACTION (CTA) -->
    <section class="py-24 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-[3rem] p-12 md:p-24 text-center relative overflow-hidden shadow-2xl">
                <!-- Decorative Blobs -->
                <div class="absolute top-0 left-0 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl -ml-20 -mt-20"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl -mr-20 -mb-20"></div>
                
                <div class="relative z-10 max-w-3xl mx-auto">
                    <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tight">Kesehatan Anda Adalah <span class="text-emerald-400">Prioritas Kami</span></h2>
                    <p class="text-slate-400 text-lg md:text-xl mb-12 font-medium">Bergabunglah dengan ribuan pasien yang telah mempercayakan kesehatan mereka kepada tim profesional kami.</p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                        <a href="{{ route('antrean.monitor') }}" class="w-full sm:w-auto px-10 py-5 bg-emerald-500 hover:bg-emerald-400 text-white rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-emerald-500/30 transition-all hover:-translate-y-1">
                            Daftar Sekarang
                        </a>
                        <a href="tel:{{ $pengaturan['app_phone'] ?? '' }}" class="w-full sm:w-auto px-10 py-5 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-2xl font-black uppercase tracking-widest text-sm backdrop-blur-md transition-all">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER (Dynamic) -->
    @if($cmsSections['footer']->is_active ?? true)
    <footer class="bg-white pt-24 pb-12 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                        <h4 class="font-black text-2xl text-slate-900">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</h4>
                    </div>
                    <p class="text-sm text-slate-500 leading-relaxed font-medium">{{ $cmsSections['footer']->content ?? 'Sistem pelayanan kesehatan terpadu yang mengutamakan kecepatan, ketepatan, dan kenyamanan pasien.' }}</p>
                </div>
                
                <div>
                    <h4 class="font-black text-slate-900 mb-6 text-lg">Layanan Utama</h4>
                    <ul class="space-y-4 text-sm text-slate-500 font-medium">
                        @foreach($layanan->take(4) as $poli)
                        <li><a href="#" class="hover:text-emerald-600 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span> {{ $poli->nama_poli }}</a></li>
                        @endforeach
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-black text-slate-900 mb-6 text-lg">Tautan Cepat</h4>
                    <ul class="space-y-4 text-sm text-slate-500 font-medium">
                        <li><a href="#jadwal" class="hover:text-emerald-600 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span> Jadwal Dokter</a></li>
                        <li><a href="#alur" class="hover:text-emerald-600 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span> Alur Pendaftaran</a></li>
                        <li><a href="#faq" class="hover:text-emerald-600 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span> Bantuan (FAQ)</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-600 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span> Login Staf</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-black text-slate-900 mb-6 text-lg">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm text-slate-500 font-medium">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span>{{ $pengaturan['app_address'] ?? 'Jl. Kesehatan No. 1, Jakarta' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 12.284 3 6V5z" /></svg>
                            <span>{{ $pengaturan['app_phone'] ?? '(021) 123-4567' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span>{{ $pengaturan['app_email'] ?? 'info@satria.id' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                    &copy; {{ date('Y') }} {{ $pengaturan['footer_text'] ?? 'System' }}. All rights reserved.
                </p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-slate-400 hover:text-emerald-600 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="text-slate-400 hover:text-emerald-600 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.269.153 5.023 1.916 5.176 5.194.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.892 5.011-5.122 5.176-1.265.058-1.644.069-4.849.069-3.204 0-3.584-.012-4.849-.069-3.229-.149-5.011-1.892-5.176-5.122-.058-1.265-.069-1.644-.069-4.849 0-3.204.012-3.584.069-4.849.153-3.269 1.916-5.023 5.194-5.176 1.265-.058 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>
    @endif

    <!-- Scroll to Top Button -->
    <button x-data="{ show: false }" 
            @scroll.window="show = window.pageYOffset > 500" 
            x-show="show" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-10"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
            class="fixed bottom-6 right-6 z-40 p-3 bg-emerald-600 text-white rounded-full shadow-xl hover:bg-emerald-500 hover:-translate-y-1 transition-all duration-300 group">
        <svg class="w-6 h-6 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
    </button>

</body>
</html>