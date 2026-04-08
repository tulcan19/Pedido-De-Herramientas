<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ Auth::user()->esAdmin() ? __('Panel General del Taller') : __('Panel del Estudiante') }}
            </h2>
            @if(!Auth::user()->esAdmin())
                <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-500 text-lg">school</span>
                    <span class="font-bold text-indigo-600 truncate max-w-[200px]">{{ Auth::user()->nombre }}</span>
                </div>
            @endif
        </div>
    </x-slot>

    <!-- Wrapper principal modo claro / limpio -->
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Cards de Resumen -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Herramientas Activas -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm relative overflow-hidden transition-all hover:shadow-md">
                    <div class="absolute top-0 right-0 p-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-500">
                            <span class="material-symbols-outlined">build</span>
                        </div>
                    </div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Herramientas en uso</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-blue-600">{{ $prestamos->count() }}</span>
                        <span class="text-gray-400 text-sm">prestadas</span>
                    </div>
                </div>

                <!-- Card 2: Alertas -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm relative overflow-hidden transition-all hover:shadow-md">
                    <div class="absolute top-0 right-0 p-4">
                        <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-500">
                            <span class="material-symbols-outlined">warning</span>
                        </div>
                    </div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Próximas a Vencer</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-red-500">{{ $alertas }}</span>
                        <span class="text-gray-400 text-sm">requieren atención</span>
                    </div>
                </div>

                <!-- Card 3: Historial -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm relative overflow-hidden transition-all hover:shadow-md">
                    <div class="absolute top-0 right-0 p-4">
                        <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-green-500">
                            <span class="material-symbols-outlined">history</span>
                        </div>
                    </div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Total Préstamos</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-gray-800">{{ $prestamosTotales }}</span>
                        <span class="text-green-500 text-sm ml-2 font-medium bg-green-50 px-2 py-0.5 rounded-full">
                            Registrados
                        </span>
                    </div>
                </div>
            </div>

            <!-- Call to Action Principal / Navegar al catálogo -->
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-400">
                    <span class="material-symbols-outlined text-3xl">qr_code_scanner</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">¿Necesitas una herramienta?</h3>
                <p class="text-gray-500 mb-6 max-w-md">Ve a nuestro nuevo catálogo para buscar la herramienta ideal o escanear su código para uso inmediato en el taller.</p>
                <a href="{{ route('herramientas.index') }}" class="flex items-center gap-2 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-lg rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-1">
                    <span class="material-symbols-outlined">storefront</span>
                    Ir al Catálogo de Herramientas
                </a>
            </div>

            <!-- Sección de Herramientas Activas -->
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">{{ Auth::user()->esAdmin() ? 'Herramientas Prestadas (General)' : 'Mis Herramientas Activas' }}</h3>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition">Ver todo el historial &rarr;</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    @forelse($prestamos as $prestamo)
                        @php
                            $minsRestantes = max(0, now()->diffInMinutes($prestamo->fecha_devolucion_esperada, false));
                            $porcentaje = max(0, min(100, ($minsRestantes / 60) * 100)); // asumiendo 1 hora max
                            
                            $isAlert = $minsRestantes <= 15 || $prestamo->estado == 'atrasado';
                        @endphp
                        
                        <div class="bg-white rounded-2xl border {{ $isAlert ? 'border-red-200 shadow-md ring-1 ring-red-500 ring-opacity-20' : 'border-gray-100 shadow-sm hover:shadow-md' }} overflow-hidden flex flex-col transition">
                            <!-- Header de Imagen -->
                            <div class="h-32 {{ $isAlert ? 'bg-red-50/50' : 'bg-gray-50' }} relative border-b border-gray-100 flex items-center justify-center p-2">
                                <img src="{{ $prestamo->herramienta->imagen_url }}" class="h-full object-contain mix-blend-multiply">
                                <span class="absolute top-3 right-3 bg-white px-2 py-1 rounded text-[10px] font-bold text-gray-800 border {{ $isAlert ? 'border-red-200 text-red-700' : 'border-gray-200' }}">
                                    {{ $prestamo->herramienta->codigo_qr }}
                                </span>
                            </div>
                            
                            <!-- Body Info -->
                            <div class="p-5 flex flex-col flex-1">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-lg font-bold text-gray-800 truncate">{{ $prestamo->herramienta->nombre }}</h4>
                                    <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full {{ $prestamo->estado == 'reservado' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $prestamo->estado }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mb-6 truncate" title="{{ $prestamo->herramienta->descripcion }}">{{ $prestamo->herramienta->descripcion ?? 'Herramienta de taller' }}</p>
                                
                                <div class="mt-auto">
                                    <div class="flex justify-between items-center text-sm mb-2">
                                        <span class="text-gray-500 font-medium">Vence en</span>
                                        <span class="font-bold rounded-full px-2 py-0.5 {{ $isAlert ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">
                                            {{ $minsRestantes > 0 ? $minsRestantes . ' min' : 'Expirado' }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="h-2 rounded-full {{ $isAlert ? 'bg-red-500' : 'bg-green-500' }}" style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-10 bg-white rounded-2xl border border-gray-100 text-center flex flex-col items-center shadow-sm">
                            <span class="material-symbols-outlined text-4xl text-gray-300 mb-3">sentiment_calm</span>
                            <h4 class="text-lg font-medium text-gray-600">Nada por aquí</h4>
                            <p class="text-sm text-gray-400">No tienes herramientas prestadas o reservadas en este momento.</p>
                        </div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
