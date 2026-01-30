<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SATRIA') }} Sistem Kesehatan Terintegrasi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css'])
        @livewireStyles
        
        <style>
            :root {
                --primary-gradient: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
                --secondary-gradient: linear-gradient(135deg, #8b5cf6 0%, #d946ef 100%);
                --success-gradient: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
                --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
                --danger-gradient: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);
            }

            body { 
                font-family: 'Plus Jakarta Sans', sans-serif; 
                /* Background is handled by Tailwind class */
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: 'Outfit', sans-serif;
            }
            
            [x-cloak] { display: none !important; }
            
            /* Glassmorphism Panel - Light Version */
            .glass-panel {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.6);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            }
        </style>
    </head>
    <body class="font-sans antialiased overflow-hidden bg-tech-pattern text-slate-800">
        
        <div class="flex h-screen w-full relative" x-data="{ sidebarOpen: false }">
            
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex flex-col flex-1 min-w-0 overflow-hidden relative bg-slate-50/50">
                
                <!-- Topbar -->
                @include('layouts.topbar')

                <!-- Scrollable Body -->
                <main class="flex-1 overflow-y-auto focus:outline-none relative z-10 p-4 md:p-8 custom-scrollbar">
                    <!-- Background Decoration -->
                    <div class="fixed top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-50/40 to-transparent pointer-events-none -z-10"></div>
                    
                    @if (isset($header))
                        <div class="md:hidden mb-6">
                            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">{{ $header }}</h2>
                        </div>
                    @endif

                    {{ $slot }}

                    <!-- Footer -->
                    <footer class="mt-12 border-t border-dashed border-slate-200 pt-6 pb-8">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-400 font-medium">
                            <div>
                                <span class="font-bold text-slate-600">SATRIA Health System</span> &copy; {{ date('Y') }}. 
                                <span class="hidden md:inline">Keunggulan dalam Pelayanan Kesehatan.</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="px-2.5 py-1 rounded-lg bg-white border border-slate-100 shadow-sm text-slate-500">v2.5.0-Stabil</span>
                            </div>
                        </div>
                    </footer>
                </main>
            </div>
        </div>

        <livewire:components.toast-notification />
        
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        @vite(['resources/js/app.js'])
        @livewireScripts
        @stack('scripts')
    </body>
</html>