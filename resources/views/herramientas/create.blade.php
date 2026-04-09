<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar Nueva Herramienta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('herramientas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-6 flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50/50">
                            <div id="image-preview" class="w-24 h-24 rounded-2xl bg-white shadow-sm border border-gray-100 flex items-center justify-center overflow-hidden mb-3">
                                <span class="material-symbols-outlined text-gray-300 text-4xl">image</span>
                            </div>
                            <x-input-label for="imagen" value="Foto Referencial" class="mb-2" />
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
                                <x-input-label for="nombre" value="Nombre de la Herramienta" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                            </div>

                            <!-- Código QR -->
                            <div>
                                <x-input-label for="codigo_qr" :value="__('Código QR / Identificador (Opcional)')" />
                                <div class="flex gap-2 mt-1">
                                    <x-text-input id="codigo_qr" name="codigo_qr" type="text" class="block w-full border-corporate-blue/20" :value="old('codigo_qr')" placeholder="HTA-XXXXXX" />
                                    <button type="button" 
                                            onclick="document.getElementById('codigo_qr').value = '{{ $nextCode }}'; this.innerText = '✅'; this.classList.add('bg-green-600');" 
                                            class="px-4 py-2 bg-corporate-blue text-white text-xs rounded-lg hover:bg-gray-700 transition-all font-bold">
                                        Generar
                                    </button>
                                </div>
                                <p class="mt-1 text-[10px] text-gray-400 italic">Si se deja vacío, el servidor lo generará al guardar.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('codigo_qr')" />
                            </div>

                            <!-- Estado -->
                            <div>
                                <x-input-label for="estado" value="Estado" />
                                <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="disponible" {{ old('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                    <option value="prestado" {{ old('estado') == 'prestado' ? 'selected' : '' }}>Prestado</option>
                                    <option value="mantenimiento" {{ old('estado') == 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('estado')" />
                            </div>

                            <!-- Ubicación -->
                            <div>
                                <x-input-label for="ubicacion" value="Ubicación en el Taller" />
                                <x-text-input id="ubicacion" name="ubicacion" type="text" class="mt-1 block w-full" :value="old('ubicacion')" placeholder="Estantería A-1, etc." />
                                <x-input-error class="mt-2" :messages="$errors->get('ubicacion')" />
                            </div>

                            <!-- Checklist de Alto Valor -->
                            <div class="col-span-1 sm:col-span-2 mt-4 p-4 border border-corporate-gold/30" style="background:#fdf8ee; border-radius:12px; border-color:#cca75b;">
                                <label class="inline-flex items-center cursor-pointer mb-2">
                                    <input type="checkbox" name="es_alto_valor" value="1" class="rounded text-[#a07a2a] shadow-sm focus:ring-[#cca75b]" {{ old('es_alto_valor') ? 'checked' : '' }}>
                                    <span class="ml-2 font-bold text-[#16213e]">Herramienta de Alto Valor (Requiere fotos y check-list al devolver)</span>
                                </label>

                                <div class="mt-2">
                                    <x-input-label for="accesorios" value="Accesorios a verificar (Opcional)" />
                                    <x-text-input id="accesorios" name="accesorios" type="text" class="mt-1 block w-full text-sm" :value="old('accesorios')" placeholder="Ej: Cargador, Manual de uso, Puntas, Estuche..." />
                                    <p class="mt-1 text-[11px] text-gray-500">Separa cada ítem con una coma (,). Estos serán validados al momento de la devolución.</p>
                                    <x-input-error class="mt-2" :messages="$errors->get('accesorios')" />
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-span-1 sm:col-span-2">
                                <x-input-label for="descripcion" value="Descripción (Opcional)" />
                                <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">{{ old('descripcion') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col-reverse sm:flex-row items-center justify-end gap-4">
                            <a href="{{ route('herramientas.index') }}" class="w-full sm:w-auto text-center text-sm text-gray-600 hover:text-gray-900 py-2 transition-colors">Cancelar</a>
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-corporate-blue border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150 shadow-md">
                                <span class="material-symbols-outlined text-sm mr-2 font-normal">save</span>
                                Guardar Herramienta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
