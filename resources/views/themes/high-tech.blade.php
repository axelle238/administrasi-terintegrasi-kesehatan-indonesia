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

    <!-- ALUR PELAYANAN (Redesigned & User Friendly) -->
    <section id="alur" class="py-24 bg-slate-50 relative overflow-hidden" x-data="{ 
        activePoli: {{ $layanan->isNotEmpty() ? $layanan->first()->id : 'null' }}, 
        activeService: null,
        
        init() {
            // Set service pertama dari poli aktif pertama sebagai default jika ada
            @if($layanan->isNotEmpty() && $layanan->first()->jenisPelayanans->isNotEmpty())
                this.activeService = {{ $layanan->first()->jenisPelayanans->first()->id }};
            @endif
        }
    }">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            
            <div class="text-center mb-16">
                <span class="text-blue-600 font-black tracking-widest uppercase text-xs mb-2 block">Prosedur & Tahapan</span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6">Alur Pelayanan Pasien</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg font-medium">Panduan langkah demi langkah untuk setiap layanan kesehatan kami, transparan dan mudah dipahami.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 min-h-[600px]">
                
                <!-- LEFT: Navigation (Unit & Service Selection) -->
                <div class="w-full lg:w-1/3 space-y-6">
                    <!-- Unit Selector -->
                    <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-200/50 border border-slate-100">
                        <h3 class="font-black text-slate-800 mb-4 flex items-center gap-2 text-sm uppercase tracking-wide">
                            <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            Pilih Unit Layanan
                        </h3>
                        <div class="space-y-2 max-h-[400px] overflow-y-auto custom-scrollbar pr-2">
                            @foreach($layanan as $poli)
                            <div class="space-y-2">
                                <!-- Unit Button -->
                                <button @click="activePoli = {{ $poli->id }}" 
                                        class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all flex justify-between items-center group {{ $activePoli === $poli->id ? 'bg-slate-900 text-white shadow-md' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                                    <span>{{ $poli->nama_poli }}</span>
                                    <svg class="w-4 h-4 transition-transform duration-300" :class="activePoli === {{ $poli->id }} ? 'rotate-90 text-white' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </button>

                                <!-- Services List (Sub-menu) -->
                                <div x-show="activePoli === {{ $poli->id }}" x-collapse class="pl-2 space-y-1">
                                    @foreach($poli->jenisPelayanans as $jenis)
                                    <button @click="activeService = {{ $jenis->id }}" 
                                            class="w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold transition-all border-l-2 flex items-center gap-2 {{ $activeService === $jenis->id ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-slate-200 text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
                                        @if($activeService === $jenis->id)
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></div>
                                        @endif
                                        {{ $jenis->nama_layanan }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Flow Visualization -->
                <div class="w-full lg:w-2/3">
                    @foreach($layanan as $poli)
                        @foreach($poli->jenisPelayanans as $jenis)
                        <div x-show="activeService === {{ $jenis->id }}" 
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 translate-x-4"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             style="display: none;">
                            
                            <div class="bg-white rounded-[3rem] p-8 md:p-10 shadow-2xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden min-h-[600px]">
                                <!-- Background Decoration -->
                                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>

                                <!-- Header Content -->
                                <div class="relative z-10 mb-10 pb-8 border-b border-slate-100">
                                    <div class="flex items-center gap-3 mb-4">
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase tracking-wider">{{ $poli->nama_poli }}</span>
                                        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-black uppercase tracking-wider">{{ $jenis->nama_layanan }}</span>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-black text-slate-900 mb-4">{{ $jenis->nama_layanan }}</h3>
                                    <p class="text-slate-500 leading-relaxed">{{ $jenis->deskripsi }}</p>
                                </div>

                                <!-- Flow Steps -->
                                <div class="relative space-y-8 pl-8 md:pl-10 before:absolute before:inset-0 before:ml-3 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                                    @forelse($jenis->alurPelayanans as $alur)
                                    <div class="relative flex items-start group">
                                        <!-- Number Circle -->
                                        <div class="absolute left-0 -ml-8 md:-ml-10 h-10 w-10 md:h-12 md:w-12 rounded-full border-4 border-white {{ $alur->is_critical ? 'bg-rose-500 shadow-rose-200' : 'bg-slate-900 shadow-slate-200' }} shadow-xl flex items-center justify-center text-white font-black text-sm md:text-base z-10 ring-1 ring-slate-100">
                                            {{ $loop->iteration }}
                                        </div>

                                        <div class="flex-1 ml-4 bg-slate-50 hover:bg-white rounded-2xl p-6 border border-slate-100 hover:shadow-lg hover:border-blue-100 transition-all duration-300 group-hover:-translate-y-1">
                                            <div class="flex flex-col md:flex-row gap-6">
                                                @if($alur->gambar)
                                                <div class="w-full md:w-32 h-32 bg-white rounded-xl overflow-hidden shrink-0 shadow-inner">
                                                    <img src="{{ asset('storage/'.$alur->gambar) }}" class="w-full h-full object-cover">
                                                </div>
                                                @endif

                                                <div class="flex-1">
                                                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                        <h4 class="font-bold text-lg text-slate-800">{{ $alur->judul }}</h4>
                                                        <div class="flex gap-2">
                                                            @if($alur->is_critical)
                                                                <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-600 text-[9px] font-black uppercase tracking-wider">Wajib</span>
                                                            @endif
                                                            <span class="px-2 py-0.5 rounded bg-white border border-slate-200 text-slate-500 text-[9px] font-bold uppercase tracking-wider">{{ $alur->waktu_range ?? $alur->estimasi_waktu }}</span>
                                                        </div>
                                                    </div>
                                                    <p class="text-sm text-slate-600 mb-4 leading-relaxed">{{ $alur->deskripsi }}</p>
                                                    
                                                    @if($alur->dokumen_syarat || $alur->output_langkah)
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                                        @if($alur->dokumen_syarat)
                                                        <div class="bg-blue-50/50 p-3 rounded-lg border border-blue-100/50">
                                                            <span class="block font-black text-blue-400 uppercase text-[9px] mb-1">Syarat</span>
                                                            <span class="font-bold text-slate-700">{{ $alur->dokumen_syarat }}</span>
                                                        </div>
                                                        @endif
                                                        @if($alur->output_langkah)
                                                        <div class="bg-emerald-50/50 p-3 rounded-lg border border-emerald-100/50">
                                                            <span class="block font-black text-emerald-400 uppercase text-[9px] mb-1">Output</span>
                                                            <span class="font-bold text-slate-700">{{ $alur->output_langkah }}</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-12 text-slate-400 font-medium italic">Belum ada langkah prosedur untuk layanan ini.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endforeach

                    <!-- Empty State -->
                    <div x-show="!activeService" class="flex flex-col items-center justify-center h-full min-h-[500px] bg-white rounded-[3rem] border-2 border-dashed border-slate-200 text-center p-10 animate-fade-in">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-6">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 mb-2">Pilih Layanan</h3>
                        <p class="text-slate-500 max-w-sm">Silakan pilih unit dan jenis layanan di sebelah kiri untuk melihat detail alur pelayanan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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