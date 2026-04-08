<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->esAdmin() ? __('Gestión de Herramientas') : __('Catálogo de Herramientas') }}
            </h2>
            @if(Auth::user()->esAdmin())
                <a href="{{ route('herramientas.create') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-3 sm:py-2 bg-corporate-blue border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150 shadow-lg">
                    <span class="material-symbols-outlined text-sm mr-2">add_circle</span>
                    {{ __('Nueva Herramienta') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 font-medium text-green-700 bg-green-100 border border-green-200 p-4 rounded-xl shadow-sm text-center">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 font-medium text-red-700 bg-red-100 border border-red-200 p-4 rounded-xl shadow-sm text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if(Auth::user()->esAdmin())
                <!-- VISTA ADMINISTRADOR (Tabla) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código QR</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($herramientas as $herramienta)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-xl overflow-hidden border border-gray-100 flex-shrink-0">
                                                        <img src="{{ $herramienta->imagen_url }}" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="text-sm font-bold text-gray-900">{{ $herramienta->nombre }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $herramienta->estado == 'disponible' ? 'bg-green-100 text-green-800' : ($herramienta->estado == 'prestado' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($herramienta->estado) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-mono">
                                                {{ $herramienta->codigo_qr }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
                                                <a href="{{ route('herramientas.edit', $herramienta) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay herramientas.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @else
                <!-- VISTA ESTUDIANTE (Catálogo Premium en Tarjetas) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($herramientas as $herramienta)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col transition hover:shadow-md hover:-translate-y-1">
                            <!-- Imagen Superior -->
                            <div class="w-full h-48 max-h-48 overflow-hidden bg-gray-50 relative border-b border-gray-100 flex items-center justify-center p-4" style="max-height: 192px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ $herramienta->imagen_url }}" alt="{{ $herramienta->nombre }}" class="max-w-full max-h-full object-contain mix-blend-multiply" style="max-height: 180px; width: auto; object-fit: contain;">
                                <span class="absolute top-3 right-3 bg-white px-2 py-1 rounded-md text-[10px] font-bold text-gray-600 border border-gray-200 shadow-sm z-10" style="position: absolute; top: 10px; right: 10px; background: white; border-radius: 4px; padding: 2px 6px;">
                                    {{ $herramienta->codigo_qr }}
                                </span>
                            </div>
                            
                            <!-- Información -->
                            <div class="p-5 flex flex-col flex-1">
                                <h4 class="text-lg font-bold text-gray-800 leading-tight mb-1">{{ $herramienta->nombre }}</h4>
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2" title="{{ $herramienta->descripcion }}">{{ $herramienta->descripcion ?? 'Sin descripción específica.' }}</p>
                                
                                <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <!-- Punto de estado -->
                                        <div class="w-2.5 h-2.5 rounded-full mr-2 
                                            {{ $herramienta->estado == 'disponible' ? 'bg-green-500' : ($herramienta->estado == 'prestado' ? 'bg-blue-500' : 'bg-red-500') }}">
                                        </div>
                                        <span class="text-xs font-bold uppercase tracking-wider
                                            {{ $herramienta->estado == 'disponible' ? 'text-green-600' : ($herramienta->estado == 'prestado' ? 'text-blue-600' : 'text-red-600') }}">
                                            {{ $herramienta->estado }}
                                        </span>
                                    </div>
                                    
                                    <!-- Botón de Reservar -->
                                    @if($herramienta->estado == 'disponible')
                                        <form action="{{ route('prestamos.store') }}" method="POST" onsubmit="return confirm('¿Seguro quieres separar (reservar) esta herramienta por 1 hora?');">
                                            @csrf
                                            <input type="hidden" name="herramienta_id" value="{{ $herramienta->id }}">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase rounded-lg shadow-sm transition-colors cursor-pointer" style="background-color: #4f46e5; color: white; padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer;">
                                                Separar
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-400 border border-gray-200 text-xs font-bold uppercase rounded-lg cursor-not-allowed" style="background-color: #f3f4f6; color: #9ca3af; padding: 8px 16px; border-radius: 8px; border: 1px solid #e5e7eb;">
                                            No disp.
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-gray-500 font-medium">
                            <div class="text-4xl mb-4">🧰</div>
                            No hay herramientas registradas en el catálogo.
                        </div>
                    @endforelse
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
