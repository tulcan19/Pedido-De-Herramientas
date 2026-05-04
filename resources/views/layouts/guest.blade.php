<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Material Symbols -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Outfit', sans-serif; }
            .bg-corporate-blue { background-color: #23325b; }
            .bg-corporate-gold { background-color: #cca75b; }
            .text-corporate-gold { color: #cca75b; }
        </style>
    </head>
    <body class="font-sans antialiased text-white selection:bg-corporate-gold selection:text-white bg-corporate-blue overflow-x-hidden">
        <div class="min-h-screen flex flex-col lg:flex-row bg-corporate-blue relative overflow-hidden">
            
            <!-- Side A: Form and Branding -->
            <div class="z-20 flex flex-col justify-center w-full lg:w-5/12 p-6 sm:p-10 lg:p-20 bg-corporate-blue shadow-[30px_0_60px_rgba(0,0,0,0.5)] relative min-h-screen shrink-0">
                <div class="mb-12 lg:mb-auto flex justify-center lg:justify-start">
                    <a href="/" class="transition-transform hover:scale-105 inline-block">
                        <x-application-logo class="w-auto h-14 sm:h-16 fill-current text-white" />
                    </a>
                </div>

                <!-- Main Form Slot -->
                <div class="my-auto w-full max-w-sm mx-auto">
                    {{ $slot }}
                </div>

                <!-- Simple Footer -->
                <div class="mt-auto pt-8 border-t border-gray-700/50 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-2 text-[10px] sm:text-xs text-gray-400 font-light italic">
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">enhanced_encryption</span>
                        Acceso Seguro 
                    </div>
                    <span class="hidden sm:inline">•</span>
                    <span>Gestión de Herramientas ISTPET</span>
                </div>
                
                <!-- Accent Sidebar line -->
                <div class="absolute top-0 left-0 w-full lg:w-1.5 h-1.5 lg:h-full bg-corporate-gold"></div>
            </div>

            <!-- Side B: Immersive Image -->
            <div class="hidden lg:block lg:w-7/12 relative min-h-screen overflow-hidden">
                <div class="absolute inset-0 bg-[#23325b] opacity-40 z-10 mix-blend-multiply transition-opacity duration-1000"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-corporate-blue via-transparent to-transparent z-10"></div>
                <img src="{{ asset('img/bg.png') }}" class="absolute inset-0 w-full h-full object-cover object-center scale-[1.05] animate-pulse-slow" alt="Fondo Taller" />
                
                <!-- Floating Decorative element -->
                <div class="absolute bottom-20 right-20 z-20 bg-white/5 backdrop-blur-md border border-white/10 p-6 rounded-2xl max-w-xs shadow-2xl">
                    <span class="text-corporate-gold text-4xl mb-4 block material-symbols-outlined">qr_code_scanner</span>
                    <h4 class="text-xl font-bold mb-2">Control Instantáneo</h4>
                    <p class="text-gray-300 text-sm leading-relaxed">Escanea y gestiona herramientas en tiempo real con nuestra tecnología de códigos QR.</p>
                </div>
            </div>

        </div>

        <style>
            .animate-pulse-slow { animation: pulse-slow 15s infinite alternate; }
            @keyframes pulse-slow {
                from { transform: scale(1.02); }
                to { transform: scale(1.1); }
            }
            
            .animate-fade-in-up {
                animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
            
            @keyframes fade-in-up {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .stagger-1 { animation-delay: 0.1s; }
            .stagger-2 { animation-delay: 0.2s; }
            .stagger-3 { animation-delay: 0.3s; }
            .stagger-4 { animation-delay: 0.4s; }
            .stagger-5 { animation-delay: 0.5s; }
        </style>
    </body>
</html>
