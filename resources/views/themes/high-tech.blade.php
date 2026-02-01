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
              const sections = ['beranda', 'jadwal-pelayanan', 'berita'];
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
                    {{ $pengaturan['announcement_text'] ?? 'Layanan Gawat Darurat tersedia 24 Jam. Harap membawa identitas diri saat berobat.' }}
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

                    <a href="#jadwal-pelayanan" 
                       @click.prevent="scrollTo('jadwal-pelayanan')"
                       class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 relative group overflow-hidden decoration-0 cursor-pointer"
                       :class="activeSection === 'jadwal-pelayanan' ? 'text-primary bg-white dark:bg-slate-700 shadow-md ring-1 ring-slate-100 dark:ring-slate-600' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60'">
                        <span class="relative z-10">Jadwal</span>
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
                    
                    <!-- Main Links -->
                    <div class="space-y-2">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Navigasi</p>
                        @foreach(['Beranda' => '#beranda', 'Alur Pelayanan' => route('alur-pelayanan.index'), 'Jadwal' => '#jadwal-pelayanan', 'Berita' => '#berita'] as $label => $link)
                            <a href="{{ $link }}" @click="mobileMenuOpen = false" class="block py-2 text-base font-bold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:translate-x-1 transition-all border-b border-dashed border-slate-100 dark:border-slate-800 last:border-0">
                                {{ $label }}
                            </a>
                        @endforeach
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
                            <a href="{{ route('login') }}" class="flex items-center justify-center w-full py-3.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 rounded-2xl text-sm font-bold uppercase tracking-wider hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                                Login Petugas
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="p-6 bg-slate-50 dark:bg-slate-800 border-t border-slate-100 dark:border-slate-700 text-center">
                    <p class="text-[10px] font-bold text-slate-400">
                        &copy; {{ date('Y') }} {{ $pengaturan['app_name'] }}
                    </p>
                </div>
            </div>
        </div>
    </nav>

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
                    </div>
                </div>
            </div>
        </div>
    </header>
    @endif

    <!-- KEUNGGULAN (Why Us) -->
    @if($cmsSections['why_us']->is_active ?? true) 
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

    <!-- JADWAL PELAYANAN (NEW REPLACEMENT) -->
    <section id="jadwal-pelayanan" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-emerald-600 font-black tracking-widest uppercase text-xs mb-2 block">Jam Operasional</span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900">Jadwal Pelayanan Poli</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($jadwalPelayanan as $poli)
                <div class="group bg-white p-6 rounded-[2rem] border border-slate-100 shadow-lg hover:shadow-2xl hover:border-emerald-200 transition-all duration-500 flex flex-col relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="flex items-center gap-4 mb-4 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-emerald-600 font-black text-xl shadow-inner group-hover:bg-white transition-colors">
                            {{ substr($poli->nama_poli, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-black text-lg text-slate-900">{{ $poli->nama_poli }}</h4>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wide">{{ $poli->kode_poli ?? 'UMUM' }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-auto space-y-2 relative z-10">
                        <div class="flex justify-between items-center text-sm border-t border-slate-100 pt-3">
                            <span class="text-slate-500 font-medium">Hari</span>
                            <span class="font-bold text-slate-800">{{ $poli->hari_buka ?? 'Senin - Sabtu' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Jam</span>
                            <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">{{ $poli->jam_operasional ?? '08:00 - 14:00' }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-slate-400">Belum ada data jadwal pelayanan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- BERITA TERKINI -->
    <section id="berita" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="flex justify-between items-end mb-16">
                <div>
                    <span class="text-emerald-400 font-black tracking-widest uppercase text-xs mb-2 block">Wawasan</span>
                    <h2 class="text-3xl md:text-5xl font-black text-slate-900">Berita & Artikel</h2>
                </div>
                <a href="#" class="hidden md:flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-emerald-600 transition-colors">
                    Lihat Semua <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>

            @if(isset($beritaTerbaru) && count($beritaTerbaru) > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($beritaTerbaru as $news)
                <article class="group bg-white/5 border border-white/10 rounded-[2rem] overflow-hidden hover:bg-white/10 transition-all duration-500 hover:-translate-y-2 cursor-pointer shadow-lg hover:shadow-xl">
                    <div class="h-48 bg-slate-800 relative overflow-hidden">
                        @if($news->thumbnail)
                            <img src="{{ Storage::url($news->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-700 bg-slate-100">
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
                        <h3 class="text-xl font-bold text-slate-900 mb-4 leading-tight group-hover:text-emerald-600 transition-colors">{{ $news->judul }}</h3>
                        <span class="inline-flex items-center gap-2 text-sm font-bold text-emerald-500 hover:text-emerald-400">
                            Baca Selengkapnya <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </span>
                    </div>
                </article>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 border border-slate-200 rounded-[2rem] bg-slate-50">
                <p class="text-slate-400">Belum ada berita terbaru.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- FOOTER (Dynamic) -->
    @if($cmsSections['footer']->is_active ?? true)
    <footer class="bg-slate-900 text-white pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                        <h4 class="font-black text-2xl text-white">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</h4>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed font-medium">{{ $cmsSections['footer']->content ?? 'Sistem pelayanan kesehatan terpadu yang mengutamakan kecepatan, ketepatan, dan kenyamanan pasien.' }}</p>
                </div>
                
                <div>
                    <h4 class="font-black text-white mb-6 text-lg">Layanan Utama</h4>
                    <ul class="space-y-4 text-sm text-slate-400 font-medium">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Poli Umum</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Poli Gigi</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Poli KIA</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Laboratorium</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-black text-white mb-6 text-lg">Tautan Cepat</h4>
                    <ul class="space-y-4 text-sm text-slate-400 font-medium">
                        <li><a href="#jadwal-pelayanan" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Jadwal Pelayanan</a></li>
                        <li><a href="{{ route('alur-pelayanan.index') }}" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Alur Pendaftaran</a></li>
                        <li><a href="#faq" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Bantuan (FAQ)</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Login Staf</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-black text-white mb-6 text-lg">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm text-slate-400 font-medium">
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
            
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">
                    &copy; {{ date('Y') }} {{ $pengaturan['footer_text'] ?? 'System' }}. All rights reserved.
                </p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-slate-500 hover:text-emerald-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="text-slate-500 hover:text-emerald-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.269.153 5.023 1.916 5.176 5.194.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.892 5.011-5.122 5.176-1.265.058-1.644.069-4.849.069-3.204 0-3.584-.012-4.849-.069-3.229-.149-5.011-1.892-5.176-5.122-.058-1.265-.069-1.644-.069-4.849 0-3.204.012-3.584.069-4.849.153-3.269 1.916-5.023 5.194-5.176 1.265-.058 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
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
