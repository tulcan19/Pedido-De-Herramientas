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
                                        <button type="button" 
                                                onclick="openEditModal({{ $docente->id }}, '{{ $docente->nombre }}', '{{ $docente->cedula }}', '{{ $docente->asignatura }}')"
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors mr-2" 
                                                title="Editar Docente">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>

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
    <!-- Modal de Edición -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-[#16213e] flex items-center gap-2">
                        <span class="material-symbols-outlined">edit_note</span>
                        Editar Datos del Docente
                    </h3>
                </div>
                
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="px-4 py-5 bg-white sm:p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <input type="text" name="nombre" id="edit_nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#cca75b] focus:border-[#cca75b] sm:text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cédula</label>
                            <input type="text" name="cedula" id="edit_cedula" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#cca75b] focus:border-[#cca75b] sm:text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Asignatura</label>
                            <input type="text" name="asignatura" id="edit_asignatura" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#cca75b] focus:border-[#cca75b] sm:text-sm" required>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-semibold text-white bg-[#23325b] border border-transparent rounded-md shadow-sm hover:bg-[#16213e] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                            Actualizar Datos
                        </button>
                        <button type="button" onclick="closeModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, nombre, cedula, asignatura) {
            document.getElementById('editForm').action = `/docentes/${id}`;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_cedula').value = cedula;
            document.getElementById('edit_asignatura').value = asignatura;
            document.getElementById('editModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Evita scroll
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Cerrar con ESC
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });
    </script>
</x-app-layout>
