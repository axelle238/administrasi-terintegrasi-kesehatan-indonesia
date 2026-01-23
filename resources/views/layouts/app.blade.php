<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SATRIA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css'])
        @livewireStyles
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }
            
            /* Custom Scrollbar for Sidebar */
            .sidebar-scroll::-webkit-scrollbar {
                width: 6px;
            }
            .sidebar-scroll::-webkit-scrollbar-track {
                background: transparent;
            }
            .sidebar-scroll::-webkit-scrollbar-thumb {
                background-color: rgba(156, 163, 175, 0.5);
                border-radius: 20px;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800">
        
        <div class="flex h-screen overflow-hidden bg-slate-50" x-data="{ sidebarOpen: false }">
            
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex flex-col flex-1 w-0 overflow-hidden">
                
                <!-- Topbar (Fixed at top of content area) -->
                @include('layouts.topbar')

                <!-- Scrollable Body -->
                <div class="flex-1 overflow-y-auto focus:outline-none sidebar-scroll">
                    
                    <div class="flex flex-col min-h-full">
                        <!-- Main Content -->
                        <main class="w-full grow p-4 md:p-8">
                            @if (isset($header))
                                <!-- Mobile Header (Visible only on small screens) -->
                                <div class="md:hidden mb-6">
                                    <h2 class="text-xl font-bold text-gray-800">{{ $header }}</h2>
                                </div>
                            @endif

                            {{ $slot }}
                        </main>

                        <!-- Footer -->
                        <footer class="bg-white border-t border-gray-200 p-4 px-8 text-center md:text-left text-xs text-gray-500 flex flex-col md:flex-row justify-between items-center gap-2 mt-auto">
                            <div>
                                &copy; {{ date('Y') }} <span class="font-semibold text-teal-600">SATRIA</span>. 
                                Sistem Administrasi Terintegrasi Kesehatan Indonesia.
                            </div>
                            <div class="flex items-center gap-4">
                                <span>v2.0.0</span>
                                <span class="hidden md:inline text-gray-300">|</span>
                                <span class="font-medium uppercase tracking-wider text-[10px] text-teal-600">Terintegrasi & Paripurna</span>
                            </div>
                        </footer>
                    </div>

                </div>
            </div>
        </div>

        <livewire:components.toast-notification />
        
        <!-- Scripts -->
        @vite(['resources/js/app.js'])
        @livewireScripts
    </body>
</html>