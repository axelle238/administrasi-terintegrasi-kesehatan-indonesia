<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SATRIA') }} - Sistem Kesehatan Terintegrasi</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-slate-800 selection:bg-blue-500 selection:text-white overflow-x-hidden">
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <div class="relative flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl shadow-lg shadow-blue-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-2xl font-extrabold text-slate-900 tracking-tight leading-none">SATRIA</span>
                        <span class="block text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em] leading-none mt-0.5">Enterprise</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#fitur" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Fitur Unggulan</a>
                    <a href="#layanan" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Layanan Medis</a>
                    <div class="h-4 w-px bg-slate-200"></div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-full hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-bold rounded-full hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">Masuk Sistem</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-[600px] h-[600px] bg-blue-50 rounded-full blur-3xl opacity-50 -z-10"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-[500px] h-[500px] bg-cyan-50 rounded-full blur-3xl opacity-50 -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold uppercase tracking-wider mb-6 animate-fade-in-up">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Sistem Kesehatan Generasi Baru
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight mb-6 leading-tight max-w-4xl mx-auto">
                Transformasi Digital <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Layanan Kesehatan Paripurna</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform administrasi terintegrasi yang menghubungkan pasien, tenaga medis, dan manajemen fasilitas kesehatan dalam satu ekosistem cerdas.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('antrean.monitor') }}" class="px-8 py-4 bg-slate-900 text-white font-bold rounded-2xl shadow-xl shadow-slate-900/20 hover:bg-slate-800 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Monitor Antrean
                </a>
                <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl shadow-lg border border-slate-100 hover:bg-slate-50 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    Akses Pegawai
                </a>
            </div>

            <!-- Dashboard Preview -->
            <div class="mt-20 relative mx-auto max-w-5xl">
                <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent z-10"></div>
                <div class="rounded-3xl border border-slate-200 shadow-2xl overflow-hidden bg-slate-50">
                    <div class="h-8 bg-white border-b border-slate-100 flex items-center gap-2 px-4">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    </div>
                    <!-- Mockup Content -->
                    <div class="p-8 grid grid-cols-3 gap-6 opacity-80 pointer-events-none">
                        <div class="col-span-1 bg-white h-40 rounded-2xl shadow-sm"></div>
                        <div class="col-span-1 bg-white h-40 rounded-2xl shadow-sm"></div>
                        <div class="col-span-1 bg-white h-40 rounded-2xl shadow-sm"></div>
                        <div class="col-span-2 bg-white h-64 rounded-2xl shadow-sm"></div>
                        <div class="col-span-1 bg-white h-64 rounded-2xl shadow-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold tracking-widest uppercase text-xs">Fitur Utama</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-2">Ekosistem Medis Terpadu</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Rekam Medis Elektronik</h3>
                    <p class="text-slate-500 leading-relaxed">
                        Data pasien terpusat, aman, dan dapat diakses real-time oleh tenaga medis berwenang untuk diagnosa yang akurat.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Farmasi Pintar</h3>
                    <p class="text-slate-500 leading-relaxed">
                        Manajemen stok obat otomatis dengan sistem peringatan dini kedaluwarsa dan integrasi resep digital.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Analitik & Pelaporan</h3>
                    <p class="text-slate-500 leading-relaxed">
                        Dashboard analitik komprehensif untuk memantau kinerja operasional, keuangan, dan layanan secara visual.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-3 mb-4 md:mb-0">
                    <div class="flex items-center justify-center w-8 h-8 bg-slate-900 rounded-lg">
                        <span class="text-white font-bold text-xs">S</span>
                    </div>
                    <span class="font-bold text-slate-900">SATRIA Enterprise</span>
                </div>
                <div class="text-slate-500 text-sm">
                    &copy; {{ date('Y') }} Sistem Administrasi Terintegrasi Kesehatan Indonesia. Hak Cipta Dilindungi.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>