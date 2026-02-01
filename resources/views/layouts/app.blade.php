<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SATRIA Health') }} - Enterprise System</title>

        <!-- Fonts: Plus Jakarta Sans (Main) & Outfit (Headings) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <style>
            :root {
                --font-sans: 'Plus Jakarta Sans', sans-serif;
                --font-display: 'Outfit', sans-serif;
            }
            body {
                font-family: var(--font-sans);
                background-color: #f8fafc; /* Slate-50 */
                background-image: 
                    radial-gradient(at 0% 0%, rgba(56, 189, 248, 0.03) 0px, transparent 50%), 
                    radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.03) 0px, transparent 50%);
                background-attachment: fixed;
            }
            h1, h2, h3, h4, h5, h6, .font-display {
                font-family: var(--font-display);
            }
            
            /* High-Tech Scrollbar */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

            /* Glassmorphism Utilities */
            .glass {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.5);
            }
            .glass-dark {
                background: rgba(15, 23, 42, 0.8);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }

            /* Animations */
            .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
            
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-600 bg-slate-50 selection:bg-indigo-500 selection:text-white">
        <div class="h-screen flex bg-slate-50/50 overflow-hidden" x-data="{ sidebarOpen: false }">
            
            <!-- Sidebar Navigation (High Tech Style) -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden transition-all duration-300">
                
                <!-- Topbar -->
                @include('layouts.topbar')

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 scroll-smooth relative">
                    <!-- Notification Toast Overlay -->
                    <livewire:components.toast-notification />
                    
                    {{ $slot }}
                    
                    <!-- Footer Info -->
                    <div class="mt-12 py-6 border-t border-dashed border-slate-200 flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            {{ config('app.name') }} © {{ date('Y') }} • Enterprise Health System v2.1 (Stable)
                        </p>
                        <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            System Operational
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
