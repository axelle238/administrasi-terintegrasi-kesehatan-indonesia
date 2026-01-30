<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pengaturan['app_name'] ?? 'SATRIA' }} - Health System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800">
    <!-- Navbar Minimalis -->
    <header class="fixed w-full bg-white/80 backdrop-blur-md border-b border-slate-100 z-50">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="font-black text-2xl tracking-tighter">{{ $pengaturan['app_name'] }}</div>
            <div class="hidden md:flex gap-8 text-sm font-medium text-slate-600">
                <a href="#home" class="hover:text-black">Beranda</a>
                <a href="#stats" class="hover:text-black">Statistik</a>
                <a href="#news" class="hover:text-black">Berita</a>
            </div>
            @auth
                <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-black text-white rounded-full text-sm font-bold hover:bg-slate-800 transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2 bg-slate-100 text-slate-900 rounded-full text-sm font-bold hover:bg-slate-200 transition">Login</a>
            @endauth
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-32 pb-20">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <div class="inline-block px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    {{ $pengaturan['app_tagline'] }}
                </div>
                <h1 class="text-5xl md:text-6xl font-black leading-tight text-slate-900">
                    {{ $pengaturan['hero_title'] }}
                </h1>
                <p class="text-lg text-slate-500 leading-relaxed">
                    {{ $pengaturan['app_description'] }}
                </p>
                <div class="flex gap-4 pt-4">
                    <a href="{{ route('antrean.monitor') }}" class="px-8 py-4 bg-black text-white rounded-full font-bold text-sm hover:bg-slate-800 transition">
                        Daftar Antrean
                    </a>
                    <a href="{{ route('pengaduan.public') }}" class="px-8 py-4 bg-white border-2 border-slate-200 text-slate-900 rounded-full font-bold text-sm hover:border-black transition">
                        Layanan Pengaduan
                    </a>
                </div>
            </div>
            
            <!-- Cards Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-50 p-6 rounded-3xl">
                    <span class="block text-4xl font-black mb-2">{{ $stats['dokter_total'] }}</span>
                    <span class="text-sm font-bold text-slate-500 uppercase">Dokter Ahli</span>
                </div>
                <div class="bg-black text-white p-6 rounded-3xl mt-8">
                    <span class="block text-4xl font-black mb-2">{{ $stats['layanan_total'] }}</span>
                    <span class="text-sm font-bold text-slate-400 uppercase">Pasien</span>
                </div>
                <div class="bg-slate-100 p-6 rounded-3xl">
                    <span class="block text-4xl font-black mb-2">{{ count($layanan) }}</span>
                    <span class="text-sm font-bold text-slate-500 uppercase">Poliklinik</span>
                </div>
                <div class="bg-slate-50 p-6 rounded-3xl mt-8">
                    <span class="block text-4xl font-black mb-2">24h</span>
                    <span class="text-sm font-bold text-slate-500 uppercase">Layanan IGD</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Simple -->
    <footer class="border-t border-slate-100 py-12">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p class="text-slate-400 font-medium text-sm">&copy; {{ date('Y') }} {{ $pengaturan['footer_text'] }}.</p>
        </div>
    </footer>
</body>
</html>