<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles de la Herramienta') }}
            </h2>
            <a href="{{ route('herramientas.index') }}" class="text-xs font-bold text-corporate-blue hover:underline">
                &larr; Volver al Catálogo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <!-- Lado Izquierdo: Imagen y QR -->
                        <div class="space-y-8">
                            <div class="relative group">
                                <div class="w-full aspect-square rounded-3xl overflow-hidden bg-gray-50 border border-gray-100 shadow-inner">
                                    <img src="{{ $herramienta->imagen_url }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $herramienta->nombre }}">
                                </div>
                                <div class="absolute -bottom-6 -right-6 bg-white p-3 rounded-2xl shadow-xl border border-gray-50 flex flex-col items-center justify-center group/qr" style="width: 140px; height: 140px;">
                                    <div class="mb-1">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(90)->margin(0)->color(35, 50, 91)->generate(route('peticiones.qr-add', $herramienta)) !!}
                                    </div>
                                    <span class="text-[9px] font-mono text-gray-400 mb-1" style="line-height:1;">{{ $herramienta->codigo_qr }}</span>
                                    <span class="opacity-0 group-hover/qr:opacity-100 transition-opacity text-[8px] text-corporate-gold font-bold uppercase tracking-tighter text-center" style="line-height:1;">Escanea para pedir</span>
                                </div>
                            </div>

                        <!-- Lado Derecho: Información -->
                        <div class="flex flex-col h-full">
                            <div class="flex-grow">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full 
                                        {{ $herramienta->estado == 'disponible' ? 'bg-green-100 text-green-700' : 
                                           ($herramienta->estado == 'prestado' ? 'bg-amber-100 text-amber-700' : 
                                           ($herramienta->estado == 'mantenimiento' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) }}">
                                        {{ ucfirst($herramienta->estado) }}
                                    </span>
                                    @if($herramienta->es_alto_valor)
                                        <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full bg-corporate-gold/10 text-corporate-gold border border-corporate-gold/20 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[12px]">stars</span> Alto Valor
                                        </span>
                                    @endif
                                </div>
                                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $herramienta->nombre }}</h1>
                                
                                <div class="flex items-center gap-2 text-gray-500 mb-6 pb-6 border-b border-gray-100 font-medium">
                                    <span class="material-symbols-outlined text-sm">location_on</span>
                                    {{ $herramienta->ubicacion ?? 'Ubicación no especificada' }}
                                </div>

                                <div class="prose prose-sm text-gray-600 mb-8">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Descripción Técnica</h3>
                                    <p class="text-lg leading-relaxed">{{ $herramienta->descripcion ?? 'Sin descripción adicional para esta herramienta.' }}</p>
                                </div>

                                @if($herramienta->es_alto_valor && count($herramienta->accesorios_formateados) > 0)
                                    <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm text-corporate-gold">inventory_2</span>
                                            Accesorios Incluidos
                                        </h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            @foreach($herramienta->accesorios_formateados as $accesorio)
                                                <div class="flex items-center justify-between gap-2 text-xs text-gray-700 bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                                    <div class="flex items-center gap-2 overflow-hidden">
                                                        <span class="material-symbols-outlined text-base 
                                                            {{ $accesorio['estado'] == 'disponible' ? 'text-green-500' : 
                                                               ($accesorio['estado'] == 'perdido' ? 'text-gray-400' : 'text-amber-500') }}">
                                                            {{ $accesorio['estado'] == 'disponible' ? 'check_circle' : 
                                                               ($accesorio['estado'] == 'perdido' ? 'search_off' : 'build_circle') }}
                                                        </span>
                                                        <span class="truncate font-medium">{{ $accesorio['nombre'] }}</span>
                                                    </div>
                                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter
                                                        {{ $accesorio['estado'] == 'disponible' ? 'bg-green-50 text-green-700' : 
                                                           ($accesorio['estado'] == 'perdido' ? 'bg-gray-100 text-gray-500' : 'bg-amber-50 text-amber-700') }}">
                                                        {{ $accesorio['estado'] }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if(Auth::user()->esAdmin())
                                <div class="pt-8 border-t border-gray-100">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Panel de Administración</h3>
                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ route('herramientas.edit', $herramienta) }}" class="flex-1 min-w-[150px] inline-flex justify-center items-center px-6 py-3 bg-corporate-blue text-white rounded-xl font-bold text-sm hover:bg-gray-700 transition-all shadow-lg shadow-corporate-blue/20">
                                            <span class="material-symbols-outlined text-sm mr-2">edit</span>
                                            Editar Datos
                                        </a>

                                        @if($herramienta->estado == 'disponible')
                                            <form action="{{ route('herramientas.status-update', $herramienta) }}" method="POST" class="flex-1 min-w-[150px]">
                                                @csrf
                                                <input type="hidden" name="estado" value="mantenimiento">
                                                <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-red-50 text-red-700 border border-red-100 rounded-xl font-bold text-sm hover:bg-red-100 transition-all">
                                                    <span class="material-symbols-outlined text-sm mr-2">build_circle</span>
                                                    Enviar a Mantenimiento
                                                </button>
                                            </form>
                                        @elseif($herramienta->estado == 'mantenimiento')
                                            <form action="{{ route('herramientas.status-update', $herramienta) }}" method="POST" class="flex-1 min-w-[150px]">
                                                @csrf
                                                <input type="hidden" name="estado" value="disponible">
                                                <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-green-50 text-green-700 border border-green-100 rounded-xl font-bold text-sm hover:bg-green-100 transition-all">
                                                    <span class="material-symbols-outlined text-sm mr-2">check_circle</span>
                                                    Marcar como Disponible
                                                </button>
                                            </form>
                                        @endif

                                        @if($herramienta->estado == 'perdido')
                                            <div class="flex-1 min-w-[300px] p-4 bg-corporate-blue/5 border border-corporate-blue/10 rounded-2xl">
                                                <h4 class="text-[10px] font-bold text-corporate-blue uppercase tracking-widest mb-3 flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">settings_backup_restore</span>
                                                    Reincorporar al taller
                                                </h4>
                                                <div class="flex gap-2">
                                                    <form action="{{ route('herramientas.status-update', $herramienta) }}" method="POST" class="flex-1">
                                                        @csrf
                                                        <input type="hidden" name="estado" value="disponible">
                                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-100 text-green-700 rounded-xl font-bold text-[11px] hover:bg-green-200 transition-all">
                                                            <span class="material-symbols-outlined text-sm mr-1">check_circle</span>
                                                            Disponible
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('herramientas.status-update', $herramienta) }}" method="POST" class="flex-1">
                                                        @csrf
                                                        <input type="hidden" name="estado" value="mantenimiento">
                                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-amber-100 text-amber-700 rounded-xl font-bold text-[11px] hover:bg-amber-200 transition-all">
                                                            <span class="material-symbols-outlined text-sm mr-1">build_circle</span>
                                                            Mantenimiento
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif

                                        @if($herramienta->estado !== 'perdido')
                                            <form action="{{ route('herramientas.status-update', $herramienta) }}" method="POST" class="flex-1 min-w-[150px]" onsubmit="return confirm('¿Estás seguro de marcar esta herramienta como PERDIDA? Esto la ocultará del catálogo de estudiantes.')">
                                                @csrf
                                                <input type="hidden" name="estado" value="perdido">
                                                <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-gray-100 text-gray-700 border border-gray-200 rounded-xl font-bold text-sm hover:bg-gray-200 transition-all">
                                                    <span class="material-symbols-outlined text-sm mr-2">search_off</span>
                                                    Marcar como Perdida
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
