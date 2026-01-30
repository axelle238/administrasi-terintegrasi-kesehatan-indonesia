<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pengaturan['app_name'] ?? 'SATRIA' }} - Layanan Kesehatan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="text-gray-700 antialiased">
    <!-- Simple Classic Header -->
    <nav class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-blue-600">{{ $pengaturan['app_name'] }}</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#layanan" class="text-gray-600 hover:text-blue-600 font-medium">Layanan</a>
                    <a href="#jadwal" class="text-gray-600 hover:text-blue-600 font-medium">Jadwal</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50">Masuk Staf</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="bg-white py-20 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $pengaturan['hero_title'] }}</h1>
            <p class="text-xl text-gray-500 mb-8 max-w-2xl mx-auto">{{ $pengaturan['app_description'] }}</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('antrean.monitor') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold shadow-lg hover:bg-blue-700">Ambil Antrean</a>
                <a href="#layanan" class="px-6 py-3 bg-white text-blue-600 border border-blue-600 rounded-lg font-bold hover:bg-blue-50">Info Layanan</a>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $stats['dokter_total'] }}</div>
                <div class="text-sm text-gray-500 uppercase font-bold">Dokter</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $stats['layanan_total'] }}</div>
                <div class="text-sm text-gray-500 uppercase font-bold">Layanan</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $stats['pasien_total'] }}</div>
                <div class="text-sm text-gray-500 uppercase font-bold">Pasien Terdaftar</div>
            </div>
        </div>
    </div>

    <!-- Layanan -->
    <div id="layanan" class="py-20 max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Layanan Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($layanan as $poli)
            <div class="bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition">
                <h3 class="text-xl font-bold mb-2">{{ $poli->nama_poli }}</h3>
                <p class="text-gray-500 text-sm">{{ $poli->keterangan ?? 'Layanan medis profesional.' }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <footer class="bg-gray-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} {{ $pengaturan['app_name'] }}. {{ $pengaturan['footer_text'] }}</p>
        </div>
    </footer>
</body>
</html>