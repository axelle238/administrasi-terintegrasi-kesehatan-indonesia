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
        body { font-family: var(--font-body); background-color: #f8fafc; color: #334155; overflow-x: hidden; }
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-heading); }
        .text-gradient { background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-image: linear-gradient(to right, var(--color-primary), #0d9488); }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navbar -->
    <nav :class="{ 'py-3 shadow-lg bg-white/90 backdrop-blur-xl': scrolled, 'py-6 bg-transparent': !scrolled }" 
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </div>
                <div>
                    <h1 class="font-black text-xl text-slate-800 tracking-tight leading-none">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $pengaturan['app_tagline'] }}</p>
                </div>
            </a>
            
            <div class="hidden md:flex items-center gap-1 bg-white/50 p-1 rounded-full border border-white/60 backdrop-blur-md shadow-sm">
                @foreach($sections as $navSection)
                    @if(in_array($navSection->section_key, ['hero', 'footer'])) @continue @endif
                    <a href="#{{ $navSection->section_key }}" class="px-4 py-2 rounded-full text-xs font-bold text-slate-600 hover:bg-white hover:text-indigo-600 transition-all">{{ $navSection->title }}</a>
                @endforeach
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/20">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-50 transition-all">Login</a>
                    <a href="{{ route('antrean.monitor') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20">Antrean</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- DYNAMIC SECTION RENDERER -->
    @foreach($sections as $section)
        
        <!-- 1. HERO SECTION -->
        @if($section->section_key === 'hero')
        <header id="hero" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-indigo-50 via-white to-purple-50 -z-10"></div>
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-purple-200/30 rounded-full blur-3xl animate-float"></div>
            <div class="absolute top-40 -left-20 w-72 h-72 bg-indigo-200/30 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="flex-1 text-center lg:text-left space-y-8">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-indigo-100 shadow-sm text-indigo-600 text-xs font-bold uppercase tracking-wide">
                            <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span></span>
                            {{ $section->subtitle }}
                        </div>
                        <h1 class="text-5xl lg:text-7xl font-black text-slate-900 leading-[1.1] tracking-tight">
                            {!! nl2br(e($section->title)) !!}
                        </h1>
                        <p class="text-lg text-slate-500 max-w-xl mx-auto lg:mx-0 leading-relaxed">{{ $section->content }}</p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            @if(!empty($section->metadata['cta_primary_text']))
                            <a href="{{ $section->metadata['cta_primary_url'] ?? '#' }}" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl text-sm font-bold uppercase tracking-wider shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                                {{ $section->metadata['cta_primary_text'] }} <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex-1 w-full lg:max-w-lg relative">
                        <div class="relative z-10 bg-white p-2 rounded-[2.5rem] shadow-2xl shadow-indigo-200/50 border border-white/50 rotate-3 hover:rotate-0 transition-transform duration-500">
                            @if($section->image)
                                <img src="{{ Storage::url($section->image) }}" class="w-full h-auto rounded-[2rem] object-cover aspect-[4/5]">
                            @else
                                <div class="w-full h-[500px] bg-indigo-50 rounded-[2rem] flex items-center justify-center text-indigo-200">
                                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            
                            <!-- Floating Card -->
                            <div class="absolute bottom-8 -left-8 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-float">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Status Layanan</p>
                                    <p class="text-sm font-black text-slate-800">24 Jam Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        @endif

        <!-- 2. SERVICES / WHY US -->
        @if($section->section_key === 'why_us')
        <section id="why_us" class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-indigo-600 font-black tracking-widest uppercase text-xs mb-2 block">{{ $section->subtitle }}</span>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-6">{{ $section->title }}</h2>
                    <p class="text-slate-500 max-w-2xl mx-auto">{{ $section->content }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Dynamic Cards hardcoded for structure but could be loop -->
                    <div class="group p-8 bg-slate-50 rounded-[2.5rem] hover:bg-indigo-600 transition-all duration-500">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-indigo-600 mb-6 shadow-sm group-hover:bg-white/20 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white">Dokter Spesialis</h3>
                        <p class="text-slate-500 group-hover:text-indigo-100">Tim medis berpengalaman siap melayani dengan standar tertinggi.</p>
                    </div>
                    <div class="group p-8 bg-slate-50 rounded-[2.5rem] hover:bg-purple-600 transition-all duration-500">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-purple-600 mb-6 shadow-sm group-hover:bg-white/20 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white">Teknologi Modern</h3>
                        <p class="text-slate-500 group-hover:text-purple-100">Peralatan diagnostik terkini untuk hasil yang akurat dan cepat.</p>
                    </div>
                    <div class="group p-8 bg-slate-50 rounded-[2.5rem] hover:bg-emerald-600 transition-all duration-500">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-emerald-600 mb-6 shadow-sm group-hover:bg-white/20 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-3 group-hover:text-white">Layanan 24/7</h3>
                        <p class="text-slate-500 group-hover:text-emerald-100">IGD dan Farmasi siap melayani kebutuhan darurat Anda kapan saja.</p>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- 3. ALUR PELAYANAN (The Star Feature) -->
        @if($section->section_key === 'alur')
        <section id="alur" class="py-24 bg-slate-900 relative overflow-hidden" x-data="{ activePoli: {{ $layanan->first()->id ?? 'null' }}, activeService: null }">
            <!-- Dynamic Background -->
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 opacity-90"></div>
            
            <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <span class="text-indigo-400 font-black tracking-widest uppercase text-xs mb-2 block">{{ $section->subtitle }}</span>
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-6">{{ $section->title }}</h2>
                    <p class="text-slate-400 max-w-2xl mx-auto text-lg">{{ $section->content }}</p>
                </div>

                <!-- Livewire Alur Component Injection (Reusing Logic but Custom UI) -->
                @livewire('public.alur-pelayanan') 
                <!-- Note: We use the dedicated component for complexity -->
            </div>
        </section>
        @endif

        <!-- 4. BERITA -->
        @if($section->section_key === 'berita')
        <section id="berita" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex justify-between items-end mb-12">
                    <div>
                        <span class="text-indigo-600 font-black tracking-widest uppercase text-xs mb-2 block">{{ $section->subtitle }}</span>
                        <h2 class="text-3xl md:text-4xl font-black text-slate-900">{{ $section->title }}</h2>
                    </div>
                    <a href="#" class="hidden md:flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">Lihat Semua <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg></a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($beritaTerbaru as $news)
                    <article class="group cursor-pointer">
                        <div class="relative h-64 rounded-[2rem] overflow-hidden mb-6">
                            <div class="absolute inset-0 bg-slate-900/20 group-hover:bg-slate-900/10 transition-colors z-10"></div>
                            @if($news->thumbnail)
                                <img src="{{ Storage::url($news->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 z-20">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-md rounded-lg text-[10px] font-black uppercase tracking-wider text-slate-800">{{ $news->kategori ?? 'Umum' }}</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors leading-tight">{{ $news->judul }}</h3>
                        <p class="text-sm text-slate-500 line-clamp-2">{{ Str::limit(strip_tags($news->isi), 100) }}</p>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- 5. FOOTER -->
        @if($section->section_key === 'footer')
        <footer class="bg-slate-900 text-white pt-24 pb-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-white/10 pb-16 mb-12">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            </div>
                            <h2 class="text-2xl font-black">{{ $pengaturan['app_name'] }}</h2>
                        </div>
                        <p class="text-slate-400 max-w-sm leading-relaxed">{{ $section->content }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-lg mb-6">Kontak</h4>
                        <ul class="space-y-4 text-sm text-slate-400">
                            <li>{{ $pengaturan['app_address'] }}</li>
                            <li>{{ $pengaturan['app_phone'] }}</li>
                            <li>{{ $pengaturan['app_email'] }}</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-lg mb-6">Menu</h4>
                        <ul class="space-y-4 text-sm text-slate-400">
                            <li><a href="#" class="hover:text-white transition-colors">Beranda</a></li>
                            <li><a href="#alur" class="hover:text-white transition-colors">Alur Layanan</a></li>
                            <li><a href="#berita" class="hover:text-white transition-colors">Berita</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Login Staf</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500 font-bold uppercase tracking-wider">
                    <p>&copy; {{ date('Y') }} {{ $pengaturan['app_name'] }}. {{ $pengaturan['footer_text'] }}</p>
                    <p>Designed with ❤️ by Tim IT</p>
                </div>
            </div>
        </footer>
        @endif

    @endforeach

</body>
</html>
