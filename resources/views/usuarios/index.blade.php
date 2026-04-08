<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Estudiantes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Nombre</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Cédula</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Semestre</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Última Promoción</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($estudiantes as $estudiante)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $estudiante->nombre }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $estudiante->cedula }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-corporate-blue text-white">
                                                {{ $estudiante->semestre }}° Semestre
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $estudiante->ultimo_cambio_semestre ? $estudiante->ultimo_cambio_semestre->format('d/m/Y H:i') : 'Sin cambios' }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($estudiante->semestre < 6)
                                                <form action="{{ route('usuarios.promover', $estudiante) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            onclick="return confirm('¿Estás seguro de promover a {{ $estudiante->nombre }} al siguiente semestre?')"
                                                            class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm transition-colors flex items-center gap-1 ml-auto">
                                                        <span class="material-symbols-outlined text-sm">trending_up</span>
                                                        Promover
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Graduado/Último Semestre</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No hay estudiantes registrados todavía.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
