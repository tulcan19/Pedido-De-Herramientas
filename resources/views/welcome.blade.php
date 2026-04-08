<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Herramientas | ISTPET Traversari</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .bg-corporate-blue { background-color: #23325b; }
        .text-corporate-gold { color: #cca75b; }
        .border-corporate-gold { border-color: #cca75b; }
        .bg-corporate-gold { background-color: #cca75b; }
        .hover-corporate-gold:hover { background-color: #b5924a; color: white; }
    </style>
</head>
<body class="antialiased bg-corporate-blue text-white min-h-screen flex items-center justify-center selection:bg-corporate-gold selection:text-white">
    
    <div class="relative flex flex-col lg:flex-row w-full h-screen overflow-hidden">
        
        <!-- Contenido Izquierdo (Logo, Título, Login) -->
        <div class="z-10 flex flex-col justify-center w-full lg:w-1/2 p-10 lg:p-24 bg-corporate-blue relative h-full shrink-0 shadow-[20px_0_30px_rgba(0,0,0,0.5)]">
            <!-- Decorative Accent -->
            <div class="absolute top-0 left-0 w-2 h-full bg-corporate-gold"></div>

            <div class="flex flex-col gap-6 max-w-lg mx-auto w-full h-full justify-center">
                
                <!-- Branding -->
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-[52px] text-corporate-gold">handyman</span>
                    <div>
                        <h2 class="text-xl font-bold tracking-[0.2em] text-corporate-gold uppercase">ISTPET Tecnológico</h2>
                        <h1 class="text-3xl font-black uppercase tracking-wider text-white">Traversari</h1>
                    </div>
                </div>

                <h3 class="text-4xl lg:text-5xl font-bold leading-[1.1] mb-2">
                    Sistema Web de <br/>
                    <span class="text-corporate-gold">Gestión de Herramientas</span>
                </h3>
                
                <p class="text-gray-300 text-lg mb-8 font-light leading-relaxed">
                    Plataforma inteligente para el control, inventario y asignación de activos del Taller de Mecánica Automotriz mediante escaneo rápido de <strong class="text-white font-semibold">códigos QR</strong>.
                </p>

                <!-- Acciones -->
                <div class="flex flex-col sm:flex-row gap-4 mt-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="group flex items-center justify-center gap-2 bg-corporate-gold text-[#16213e] font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 w-full sm:w-auto">
                            <span class="material-symbols-outlined">dashboard</span>
                            Ir al Panel Principal
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="group flex items-center justify-center gap-2 bg-corporate-gold text-[#16213e] font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-2xl hover-corporate-gold transition-all duration-300 hover:-translate-y-1 w-full sm:w-auto text-lg">
                            <span class="material-symbols-outlined">login</span>
                            Ingresar
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 border-2 border-corporate-gold text-corporate-gold hover:bg-corporate-gold hover:text-[#16213e] font-bold py-4 px-8 rounded-lg transition-all duration-300 w-full sm:w-auto text-lg">
                                <span class="material-symbols-outlined">person_add</span>
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Footer info -->
                <div class="mt-auto flex items-center gap-2 text-sm text-gray-400 font-light pt-8 border-t border-gray-700/50">
                    <span class="material-symbols-outlined text-base">qr_code_scanner</span>
                    Inventario seguro, actualizado y listo para operar.
                </div>
            </div>
        </div>

        <!-- Imagen Fondo Derecha -->
        <div class="hidden lg:block lg:w-1/2 relative h-full">
            <div class="absolute inset-0 bg-[#23325b] opacity-30 z-10 mix-blend-multiply pointer-events-none"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-corporate-blue via-[#23325b]/40 to-transparent z-10"></div>
            <img src="{{ asset('img/bg.png') }}" class="absolute inset-0 w-full h-full object-cover object-center scale-[1.03]" alt="Taller Mecánico Moderno" />
        </div>
        
    </div>

</body>
</html>
