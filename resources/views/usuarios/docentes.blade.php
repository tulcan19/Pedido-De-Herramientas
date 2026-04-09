<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Docentes') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f0f3f8] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Formulario de Registro Rápido -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border-t-4 border-[#23325b]">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-[#16213e] mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">person_add</span>
                        Registrar Nuevo Docente
                    </h3>
                    <form action="{{ route('docentes.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                                <input type="text" name="nombre" class="mt-1 block w-auto border-gray-300 rounded-md shadow-sm focus:ring-[#cca75b] focus:border-[#cca75b] sm:text-sm" placeholder="Ej. Ing. Juan Pérez" value="{{ old('nombre') }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cédula (Usuario/Password)</label>
                                <input type="text" name="cedula" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#cca75b] focus:border-[#cca75b] sm:text-sm" placeholder="10 dígitos" value="{{ old('cedula') }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Asignatura</label>
                                <input type="text" name="asignatura" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#cca75b] focus:border-[#cca75b] sm:text-sm" placeholder="Ej. Autotrónica" value="{{ old('asignatura') }}" required>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#23325b] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#16213e] transition ease-in-out duration-150">
                                Guardar Docente
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Docentes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-[#16213e]">Docentes Registrados</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $docentes->count() }} Personal Docente</span>
                    </div>

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-white uppercase bg-[#23325b]">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Docente</th>
                                    <th scope="col" class="py-3 px-6">Identificación</th>
                                    <th scope="col" class="py-3 px-6">Asignatura Principal</th>
                                    <th scope="col" class="py-3 px-6 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($docentes as $docente)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="py-4 px-6 font-bold text-gray-900 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#cca75b]/20 flex items-center justify-center text-[#cca75b]">
                                                <span class="material-symbols-outlined text-sm">school</span>
                                            </div>
                                            {{ $docente->nombre }}
                                        </div>
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ $docente->cedula }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-semibold">
                                            {{ $docente->asignatura }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <form action="{{ route('docentes.destroy', $docente) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar a este docente?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar Docente">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500 italic">
                                        No hay docentes registrados todavía.
                                    </td>
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
