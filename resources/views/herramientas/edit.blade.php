<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Herramienta') }}: {{ $herramienta->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('herramientas.update', $herramienta) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50/50">
                            <div id="image-preview" class="w-24 h-24 rounded-2xl bg-white shadow-sm border border-gray-100 flex items-center justify-center overflow-hidden mb-3">
                                @if($herramienta->imagen)
                                    <img src="{{ $herramienta->imagen_url }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-gray-300 text-4xl">image</span>
                                @endif
                            </div>
                            <x-input-label for="imagen" value="Cambiar Foto Referencial" class="mb-2" />
                            <input id="imagen" name="imagen" type="file" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-corporate-blue file:text-white hover:file:bg-gray-700 cursor-pointer" accept="image/*" onchange="previewImage(this)" />
                            <x-input-error class="mt-2" :messages="$errors->get('imagen')" />
                        </div>

                        <script>
                            function previewImage(input) {
                                const preview = document.getElementById('image-preview');
                                if (input.files && input.files[0]) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                        </script>

                        <!-- Nombre -->
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre de la Herramienta')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $herramienta->nombre)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <!-- Descripción -->
                        <div>
                            <x-input-label for="descripcion" :value="__('Descripción')" />
                            <textarea id="descripcion" name="descripcion" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('descripcion', $herramienta->descripcion) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Código QR -->
                            <div class="relative">
                                <x-input-label for="codigo_qr" :value="__('Código QR / Identificador')" />
                                <div class="flex gap-2 mt-1">
                                    <x-text-input id="codigo_qr" name="codigo_qr" type="text" class="block w-full bg-gray-50 border-corporate-blue/20" :value="old('codigo_qr', $herramienta->codigo_qr)" />
                                    <button type="button" 
                                            onclick="if(confirm('¿ESTÁS SEGURO? Si regeneras el código, tendrás que imprimir y cambiar la etiqueta física.')){ 
                                                document.getElementById('codigo_qr').value = '{{ $nextCode }}'; 
                                                this.innerText = '✅ Generado'; 
                                                this.classList.remove('bg-corporate-blue'); 
                                                this.classList.add('bg-green-600'); 
                                            } " 
                                            class="px-3 py-2 bg-corporate-blue text-white text-xs rounded-lg hover:bg-gray-700 transition-all whitespace-nowrap font-bold">
                                        Regenerar
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-400 italic">Al guardar con el campo vacío, se asignará una nueva identidad única.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('codigo_qr')" />

                                <!-- Historial de QR -->
                                @if($herramienta->historialQr->count() > 0)
                                    <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm">history</span>
                                            Historial de Identidad
                                        </h4>
                                        <div class="space-y-2">
                                            @foreach($herramienta->historialQr as $historial)
                                                <div class="flex items-center justify-between bg-white p-2 rounded-lg border border-gray-100 shadow-sm">
                                                    <div>
                                                        <span class="text-sm font-mono text-gray-600">{{ $historial->codigo_qr }}</span>
                                                        <p class="text-[10px] text-gray-400">Cambiado el {{ $historial->created_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                    <button type="button" 
                                                            onclick="if(confirm('¿Quieres restaurar este código antiguo?')){ document.getElementById('codigo_qr').value = '{{ $historial->codigo_qr }}'; }"
                                                            class="text-[10px] font-bold text-corporate-blue hover:text-indigo-800 uppercase tracking-tighter">
                                                        Restaurar
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Estado -->
                            <div>
                                <x-input-label for="estado" :value="__('Estado Actual')" />
                                <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="disponible" {{ old('estado', $herramienta->estado) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                    <option value="prestado" {{ old('estado', $herramienta->estado) == 'prestado' ? 'selected' : '' }}>Prestado</option>
                                    <option value="mantenimiento" {{ old('estado', $herramienta->estado) == 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('estado')" />
                            </div>
                        </div>

                        <!-- Ubicación -->
                        <div>
                            <x-input-label for="ubicacion" :value="__('Ubicación en el Taller')" />
                            <x-text-input id="ubicacion" name="ubicacion" type="text" class="mt-1 block w-full" :value="old('ubicacion', $herramienta->ubicacion)" placeholder="Ej: Estante A, Casilla 4" />
                            <x-input-error class="mt-2" :messages="$errors->get('ubicacion')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('herramientas.index') }}" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Guardar Cambios') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
