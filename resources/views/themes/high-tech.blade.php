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
                    <a href="#beranda" @click.prevent="scrollTo('beranda')" class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 decoration-0 cursor-pointer" :class="activeSection === 'beranda' ? 'text-primary bg-white dark:bg-slate-700 shadow-md ring-1 ring-slate-100 dark:ring-slate-600' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60'">Beranda</a>
                    <a href="{{ route('alur-pelayanan.index') }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60 cursor-pointer">Alur</a>
                    <a href="#tarif" @click.prevent="scrollTo('tarif')" class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 decoration-0 cursor-pointer" :class="activeSection === 'tarif' ? 'text-primary bg-white dark:bg-slate-700 shadow-md ring-1 ring-slate-100 dark:ring-slate-600' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60'">Tarif</a>
                    <a href="#jadwal" @click.prevent="scrollTo('jadwal')" class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 decoration-0 cursor-pointer" :class="activeSection === 'jadwal' ? 'text-primary bg-white dark:bg-slate-700 shadow-md ring-1 ring-slate-100 dark:ring-slate-600' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60'">Jadwal</a>
                    <a href="#layanan" @click.prevent="scrollTo('layanan')" class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 decoration-0 cursor-pointer" :class="activeSection === 'layanan' ? 'text-primary bg-white dark:bg-slate-700 shadow-md ring-1 ring-slate-100 dark:ring-slate-600' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-white/60'">Layanan</a>
                </div>

                <!-- User Center -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-slate-700 hover:text-primary transition-colors">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-bold text-rose-600 hover:text-rose-800 transition-colors">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white px-5 py-2.5 hover:bg-white dark:hover:bg-slate-800 hover:shadow-md rounded-full transition-all">Login</a>
                        <a href="{{ route('antrean.monitor') }}" class="px-6 py-2.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-0.5 transition-all">Layanan Pasien</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    @if($cmsSections['hero']->is_active ?? false)
    <header id="beranda" class="relative pt-32 pb-24 md:pt-48 md:pb-32 overflow-hidden blob-bg">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="flex-1 text-center lg:text-left space-y-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 backdrop-blur-md border border-white shadow-sm animate-fade-in-up">
                        <span class="text-xs font-bold text-slate-600 uppercase tracking-wide">{{ $cmsSections['hero']->subtitle ?? 'Layanan Kesehatan Terdepan' }}</span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] tracking-tight animate-fade-in-up">
                        <span class="text-gradient">{{ $cmsSections['hero']->title ?? 'Judul Hero' }}</span>
                    </h1>
                    <p class="text-slate-500 text-lg md:text-xl leading-relaxed max-w-xl mx-auto lg:mx-0 animate-fade-in-up font-medium">
                        {{ $cmsSections['hero']->content ?? '' }}
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start animate-fade-in-up">
                        <a href="{{ route('antrean.monitor') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-slate-900 text-white font-bold text-sm uppercase tracking-wider shadow-xl shadow-slate-900/20 hover:shadow-slate-900/40 transition-all flex items-center justify-center gap-3">Daftar Berobat</a>
                        <a href="#jadwal" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white border border-white shadow-lg text-slate-700 font-bold text-sm uppercase tracking-wider hover:bg-slate-50 transition-all flex items-center justify-center gap-2">Jadwal Dokter</a>
                    </div>
                </div>
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

    <!-- KEUNGGULAN SECTION -->
    @if($cmsSections['why_us']->is_active ?? true)
    <section id="layanan" class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="text-emerald-600 font-black tracking-widest uppercase text-xs mb-2 block">Kenapa Memilih Kami?</span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6">Standar Kesehatan Masa Depan</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 hover:bg-slate-900 hover:text-white transition-all duration-500">
                    <h3 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white transition-colors">Teknologi Mutakhir</h3>
                    <p class="text-slate-500 group-hover:text-slate-400 transition-colors">Peralatan medis diagnostik terbaru dengan akurasi tinggi.</p>
                </div>
                <div class="group bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 hover:bg-slate-900 hover:text-white transition-all duration-500">
                    <h3 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white transition-colors">Tim Dokter Ahli</h3>
                    <p class="text-slate-500 group-hover:text-slate-400 transition-colors">Didukung oleh dokter spesialis berpengalaman.</p>
                </div>
                <div class="group bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 hover:bg-slate-900 hover:text-white transition-all duration-500">
                    <h3 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white transition-colors">Pelayanan Cepat</h3>
                    <p class="text-slate-500 group-hover:text-slate-400 transition-colors">Sistem antrean digital dan rekam medis elektronik.</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ALUR PELAYANAN SECTION -->
    <section id="alur" class="py-24 bg-slate-50 relative overflow-hidden" x-data="{ 
        activePoli: {{ $layanan->isNotEmpty() ? $layanan->first()->id : 'null' }}, 
        activeService: null,
        init() {
            @if($layanan->isNotEmpty() && $layanan->first()->jenisPelayanans->isNotEmpty())
                this.activeService = {{ $layanan->first()->jenisPelayanans->first()->id }};
            @endif
        }
    }">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-black tracking-widest uppercase text-xs mb-2 block">Prosedur & Tahapan</span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6">Alur Pelayanan Pasien</h2>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 min-h-[600px]">
                <div class="w-full lg:w-1/3 space-y-6">
                    <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100">
                        <h3 class="font-black text-slate-800 mb-4 text-sm uppercase tracking-wide">Pilih Unit Layanan</h3>
                        <div class="space-y-2">
                            @foreach($layanan as $poli)
                            <div class="space-y-2">
                                <button @click="activePoli = {{ $poli->id }}" 
                                        :class="activePoli === {{ $poli->id }} ? 'bg-slate-900 text-white shadow-md' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
                                        class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all flex justify-between items-center group">
                                    <span>{{ $poli->nama_poli }}</span>
                                    <svg class="w-4 h-4 transition-transform duration-300" :class="activePoli === {{ $poli->id }} ? 'rotate-90 text-white' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </button>
                                <div x-show="activePoli === {{ $poli->id }}" x-collapse class="pl-2 space-y-1">
                                    @foreach($poli->jenisPelayanans as $jenis)
                                    <button @click="activeService = {{ $jenis->id }}" 
                                            :class="activeService === {{ $jenis->id }} ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-slate-200 text-slate-500 hover:border-slate-300'"
                                            class="w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold transition-all border-l-2">
                                        {{ $jenis->nama_layanan }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-2/3">
                    @foreach($layanan as $poli)
                        @foreach($poli->jenisPelayanans as $jenis)
                        <div x-show="activeService === {{ $jenis->id }}" x-transition style="display: none;">
                            <div class="bg-white rounded-[3rem] p-8 md:p-10 shadow-2xl border border-slate-100 relative min-h-[600px]">
                                <h3 class="text-2xl md:text-3xl font-black text-slate-900 mb-4">{{ $jenis->nama_layanan }}</h3>
                                <p class="text-slate-500 mb-8">{{ $jenis->deskripsi }}</p>
                                <div class="relative space-y-8 pl-8 md:pl-10">
                                    @forelse($jenis->alurPelayanans as $alur)
                                    <div class="relative flex items-start group">
                                        <div class="absolute left-0 -ml-8 md:-ml-10 h-10 w-10 md:h-12 md:w-12 rounded-full bg-slate-900 flex items-center justify-center text-white font-black text-sm md:text-base z-10">{{ $loop->iteration }}</div>
                                        <div class="flex-1 ml-4 bg-slate-50 rounded-2xl p-6 border border-slate-100 hover:shadow-lg transition-all duration-300">
                                            <h4 class="font-bold text-lg text-slate-800 mb-2">{{ $alur->judul }}</h4>
                                            <p class="text-sm text-slate-600">{{ $alur->deskripsi }}</p>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-12 text-slate-400">Belum ada langkah prosedur.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- TARIF SECTION -->
    @if(isset($hargaLayanan) && count($hargaLayanan) > 0)
    <section id="tarif" class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6">Tarif Layanan Unggulan</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($hargaLayanan as $tarif)
                <div class="group p-8 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <h3 class="text-lg font-black text-slate-800 mb-2">{{ $tarif->nama_tindakan }}</h3>
                    <div class="text-3xl font-black text-slate-900 mt-4">Rp {{ number_format($tarif->harga, 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- JADWAL DOKTER SECTION -->
    @if(($pengaturan['show_jadwal_dokter'] ?? '1') == '1')
    <section id="jadwal" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black text-slate-900">Jadwal Praktik Hari Ini</h2>
            </div>
            @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="group bg-white p-6 rounded-[2rem] border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 flex items-center gap-6">
                        <div>
                            <h4 class="font-black text-lg text-slate-900 mb-1">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wide">{{ $jadwal->pegawai->poli->nama_poli ?? 'Umum' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- FOOTER -->
    @if($cmsSections['footer']->is_active ?? true)
    <footer class="bg-white pt-24 pb-12 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <h4 class="font-black text-2xl text-slate-900 mb-4">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</h4>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">&copy; {{ date('Y') }} SATRIA. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @endif

    <!-- Scroll to Top -->
    <button x-data="{ show: false }" @scroll.window="show = window.pageYOffset > 500" x-show="show" @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="fixed bottom-6 right-6 z-40 p-3 bg-emerald-600 text-white rounded-full shadow-xl hover:bg-emerald-500 transition-all">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
    </button>

</body>
</html>