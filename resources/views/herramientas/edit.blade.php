<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('herramientas.index') }}"
               style="color:#23325b;"
               class="inline-flex items-center gap-1 text-sm font-semibold hover:opacity-70 transition">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Volver
            </a>
            <span class="text-gray-300">/</span>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar: <span style="color:#23325b;">{{ $herramienta->nombre }}</span>
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

        .edit-root { font-family: 'Outfit', sans-serif; background: #f0f3f8; min-height: 100vh; }

        /* ── HERO ── */
        .edit-hero {
            background: linear-gradient(135deg, #16213e 0%, #23325b 60%, #2a3d6e 100%);
            padding: 2rem 1.5rem 4.5rem;
            position: relative; overflow: hidden;
        }
        .edit-hero::before {
            content: ''; position: absolute; top: -50px; right: -40px;
            width: 240px; height: 240px;
            background: radial-gradient(circle, rgba(204,167,91,.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .edit-hero-inner { max-width: 900px; margin: 0 auto; position: relative; z-index: 1; display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; }
        .edit-tool-thumb {
            width: 80px; height: 80px;
            background: rgba(255,255,255,.1);
            border: 2px solid rgba(204,167,91,.3);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; flex-shrink: 0;
        }
        .edit-tool-thumb img { width: 100%; height: 100%; object-fit: contain; mix-blend-mode: luminosity; }
        .edit-hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(204,167,91,.15); border: 1px solid rgba(204,167,91,.35);
            color: #cca75b; font-size: 11px; font-weight: 700; padding: 3px 12px;
            border-radius: 999px; letter-spacing: .06em; text-transform: uppercase; margin-bottom: .5rem;
        }
        .edit-hero-title { font-size: 1.5rem; font-weight: 800; color: #fff; }
        .edit-hero-title span { color: #cca75b; }
        .edit-hero-sub { color: #a0b0cc; font-size: .85rem; margin-top: .2rem; }

        /* ── FORM CARD ── */
        .form-wrap { max-width: 900px; margin: -3rem auto 0; padding: 0 1.5rem 3rem; position: relative; z-index: 10; }
        .form-card { background: #fff; border-radius: 22px; box-shadow: 0 8px 40px rgba(0,0,0,.10); overflow: hidden; }

        /* ── SECTIONS ── */
        .form-section {
            padding: 2rem 2rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .form-section:last-of-type { border-bottom: none; }
        .section-label {
            display: flex; align-items: center; gap: 8px;
            font-size: .72rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .08em; color: #9ca3af; margin-bottom: 1.25rem;
        }
        .section-label .material-symbols-outlined { font-size: 16px; color: #cca75b; }

        /* ── IMAGE UPLOAD ── */
        .img-upload-area {
            border: 2px dashed #e5e7eb;
            border-radius: 16px;
            background: #f8fafc;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            transition: border-color .2s;
        }
        .img-upload-area:hover { border-color: #cca75b; }
        .img-preview-box {
            width: 90px; height: 90px;
            border-radius: 14px;
            border: 2px solid #e5e7eb;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; flex-shrink: 0;
        }
        .img-preview-box img { width: 100%; height: 100%; object-fit: contain; }
        .img-upload-info { flex: 1; min-width: 200px; }
        .img-upload-info .upload-title { font-size: .9rem; font-weight: 600; color: #16213e; margin-bottom: .3rem; }
        .img-upload-info .upload-hint { font-size: .78rem; color: #9ca3af; }
        .btn-file-pick {
            display: inline-flex; align-items: center; gap: 6px;
            padding: .55rem 1.1rem; border-radius: 10px; font-size: .82rem; font-weight: 700;
            background: #fdf8ee; border: 1.5px solid #cca75b; color: #a07a2a;
            cursor: pointer; transition: background .15s;
            font-family: 'Outfit', sans-serif; margin-top: .5rem;
        }
        .btn-file-pick:hover { background: #fdf0d0; }
        .btn-file-pick .material-symbols-outlined { font-size: 16px; }
        input[type="file"]#imagen { display: none; }

        /* ── FORM FIELDS ── */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        @media(max-width:640px){ .form-grid { grid-template-columns: 1fr; } }

        .field-group { display: flex; flex-direction: column; gap: .4rem; }
        .field-group.full { grid-column: 1 / -1; }

        .field-label {
            font-size: .78rem; font-weight: 700; color: #374151; letter-spacing: .02em;
        }
        .field-input {
            border: 1.5px solid #e5e7eb; border-radius: 12px;
            padding: .65rem 1rem; font-size: .9rem;
            outline: none; transition: border-color .2s, box-shadow .2s;
            font-family: 'Outfit', sans-serif; color: #16213e;
            background: #fff; width: 100%;
        }
        .field-input:focus { border-color: #cca75b; box-shadow: 0 0 0 3px rgba(204,167,91,.15); }
        .field-input.mono { font-family: monospace; font-size: .85rem; }
        textarea.field-input { resize: vertical; min-height: 90px; }

        /* ── SELECT ── */
        .field-select {
            border: 1.5px solid #e5e7eb; border-radius: 12px;
            padding: .65rem 1rem; font-size: .9rem;
            outline: none; transition: border-color .2s, box-shadow .2s;
            font-family: 'Outfit', sans-serif; color: #16213e;
            background: #fff; width: 100%; cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
        }
        .field-select:focus { border-color: #cca75b; box-shadow: 0 0 0 3px rgba(204,167,91,.15); }

        /* ── QR INPUT GROUP ── */
        .qr-input-group { display: flex; gap: .5rem; }
        .qr-input-group .field-input { flex: 1; }
        .btn-regenerar {
            display: inline-flex; align-items: center; gap: 5px;
            padding: .6rem 1rem; border-radius: 12px; font-size: .8rem; font-weight: 700;
            background: #23325b; color: #cca75b; border: 1.5px solid #23325b; cursor: pointer;
            white-space: nowrap; transition: background .15s;
            font-family: 'Outfit', sans-serif;
        }
        .btn-regenerar:hover { background: #16213e; }
        .btn-regenerar .material-symbols-outlined { font-size: 16px; }
        .field-hint { font-size: .74rem; color: #9ca3af; font-style: italic; margin-top: .2rem; }

        /* ── QR HISTORY ── */
        .qr-history {
            margin-top: 1rem; padding: 1rem 1.1rem;
            background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9;
        }
        .qr-history-title {
            font-size: .68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .08em; color: #9ca3af;
            display: flex; align-items: center; gap: 5px; margin-bottom: .75rem;
        }
        .qr-history-title .material-symbols-outlined { font-size: 14px; color: #cca75b; }
        .qr-history-item {
            display: flex; align-items: center; justify-content: space-between;
            background: #fff; border: 1px solid #f1f5f9; border-radius: 10px;
            padding: .5rem .75rem; margin-bottom: .4rem;
        }
        .qr-history-item:last-child { margin-bottom: 0; }
        .qr-code-text { font-family: monospace; font-size: .82rem; color: #374151; }
        .qr-date { font-size: .7rem; color: #9ca3af; margin-top: 1px; }
        .btn-restore {
            font-size: .7rem; font-weight: 700; color: #a07a2a;
            background: #fdf8ee; border: 1px solid #cca75b;
            padding: 2px 9px; border-radius: 7px;
            cursor: pointer; font-family: 'Outfit', sans-serif;
            transition: background .15s;
        }
        .btn-restore:hover { background: #fdf0d0; }

        /* ── FORM FOOTER ── */
        .form-footer {
            padding: 1.5rem 2rem;
            display: flex; align-items: center; justify-content: flex-end; gap: 1rem;
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
        }
        .btn-cancel {
            font-size: .88rem; font-weight: 600; color: #6b7280;
            text-decoration: none; padding: .6rem 1.25rem;
            border-radius: 10px; transition: background .15s;
        }
        .btn-cancel:hover { background: #f3f4f6; color: #374151; }
        .btn-save {
            display: inline-flex; align-items: center; gap: 7px;
            padding: .7rem 1.75rem; border-radius: 12px; font-size: .9rem; font-weight: 800;
            background: linear-gradient(135deg, #cca75b, #a07a2a); color: #16213e;
            border: none; cursor: pointer;
            box-shadow: 0 4px 16px rgba(204,167,91,.35);
            transition: transform .15s, box-shadow .15s;
            font-family: 'Outfit', sans-serif;
        }
        .btn-save:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(204,167,91,.45); }
        .btn-save .material-symbols-outlined { font-size: 18px; }

        /* ── ERROR ── */
        .field-error { font-size: .75rem; color: #b91c1c; margin-top: .25rem; }

        @media(max-width: 768px) {
            .edit-hero { padding: 1.5rem 1rem 4rem; }
            .edit-hero-inner { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .edit-hero-title { font-size: 1.2rem; }
            .form-wrap { padding: 0 0.75rem 2rem; margin-top: -2rem; }
            .form-section { padding: 1.25rem 1rem; }
            .form-footer { padding: 1rem; flex-direction: column; gap: 0.75rem; }
            .btn-cancel { order: 2; }
            .btn-save { width: 100%; justify-content: center; order: 1; }
            .qr-input-group { flex-direction: column; }
            .btn-regenerar { width: 100%; justify-content: center; }
            .img-upload-area { flex-direction: column; align-items: center; text-align: center; }
            .img-upload-info { min-width: 0; }
            .qr-history-item { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        }
    </style>

    <div class="edit-root">

        {{-- HERO --}}
        <div class="edit-hero">
            <div class="edit-hero-inner">
                <div class="edit-tool-thumb">
                    <img src="{{ $herramienta->imagen_url }}" alt="{{ $herramienta->nombre }}">
                </div>
                <div>
                    <div class="edit-hero-badge">
                        <span class="material-symbols-outlined" style="font-size:12px;">edit</span>
                        Editando herramienta
                    </div>
                    <h1 class="edit-hero-title"><span>{{ $herramienta->nombre }}</span></h1>
                    <p class="edit-hero-sub">
                        Código: <span style="font-family:monospace;color:#e2c97a;">{{ $herramienta->codigo_qr }}</span>
                        &nbsp;·&nbsp;
                        Estado actual:
                        <span style="color:{{ $herramienta->estado == 'disponible' ? '#4ade80' : ($herramienta->estado == 'prestado' ? '#93c5fd' : '#fca5a5') }}">
                            {{ ucfirst($herramienta->estado) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <div class="form-wrap">
            <div class="form-card">
                <form method="POST" action="{{ route('herramientas.update', $herramienta) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    {{-- 1. Imagen --}}
                    <div class="form-section">
                        <div class="section-label">
                            <span class="material-symbols-outlined">image</span>
                            Foto Referencial
                        </div>
                        <div class="img-upload-area">
                            <div class="img-preview-box" id="image-preview">
                                @if($herramienta->imagen)
                                    <img src="{{ $herramienta->imagen_url }}" alt="{{ $herramienta->nombre }}">
                                @else
                                    <span class="material-symbols-outlined" style="font-size:2rem;color:#d1d5db;">image</span>
                                @endif
                            </div>
                            <div class="img-upload-info">
                                <div class="upload-title">Imagen de la herramienta</div>
                                <div class="upload-hint">PNG, JPG o WEBP. Se mostrará en el catálogo de estudiantes.</div>
                                <label for="imagen" class="btn-file-pick">
                                    <span class="material-symbols-outlined">upload</span>
                                    Seleccionar imagen
                                </label>
                                <input id="imagen" name="imagen" type="file" accept="image/*" onchange="previewImage(this)">
                                @error('imagen')<div class="field-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- 2. Datos generales --}}
                    <div class="form-section">
                        <div class="section-label">
                            <span class="material-symbols-outlined">info</span>
                            Datos Generales
                        </div>
                        <div class="form-grid">
                            <div class="field-group full">
                                <label class="field-label" for="nombre">Nombre de la Herramienta</label>
                                <input id="nombre" name="nombre" type="text" class="field-input"
                                       value="{{ old('nombre', $herramienta->nombre) }}" required autofocus>
                                @error('nombre')<div class="field-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="field-group full">
                                <label class="field-label" for="descripcion">Descripción</label>
                                <textarea id="descripcion" name="descripcion" class="field-input">{{ old('descripcion', $herramienta->descripcion) }}</textarea>
                                @error('descripcion')<div class="field-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="field-group">
                                <label class="field-label" for="ubicacion">Ubicación en el Taller</label>
                                <input id="ubicacion" name="ubicacion" type="text" class="field-input"
                                       value="{{ old('ubicacion', $herramienta->ubicacion) }}"
                                       placeholder="Ej: Estante A, Casilla 4">
                                @error('ubicacion')<div class="field-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="field-group">
                                <label class="field-label" for="estado">Estado Actual</label>
                                <select id="estado" name="estado" class="field-select">
                                    <option value="disponible" {{ old('estado', $herramienta->estado) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                    <option value="prestado"   {{ old('estado', $herramienta->estado) == 'prestado'   ? 'selected' : '' }}>Prestado</option>
                                    <option value="mantenimiento" {{ old('estado', $herramienta->estado) == 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                                    <option value="perdido"    {{ old('estado', $herramienta->estado) == 'perdido'       ? 'selected' : '' }}>Perdido / Fuera de Servicio</option>
                                </select>
                                @error('estado')<div class="field-error">{{ $message }}</div>@enderror
                            </div>

                            {{-- Checklist Alto Valor --}}
                            <div class="field-group full mt-2" style="background:#fdf8ee; border: 1.5px solid #cca75b; border-radius: 12px; padding: 1.25rem;">
                                <label class="inline-flex items-center cursor-pointer mb-3">
                                    <input type="checkbox" name="es_alto_valor" value="1" class="rounded border-gray-300 text-[#a07a2a] shadow-sm focus:border-[#cca75b] focus:ring focus:ring-[#cca75b] focus:ring-opacity-50" {{ old('es_alto_valor', $herramienta->es_alto_valor) ? 'checked' : '' }}>
                                    <span class="ml-2 font-bold" style="color:#16213e;">Herramienta de Alto Valor (Requiere foto y check-list al devolver)</span>
                                </label>

                                <div class="mt-4">
                                    <label class="field-label">Accesorios a verificar (Ingreso uno por uno)</label>
                                    <div id="accesorios-container" class="space-y-2 mt-2">
                                        <!-- Los campos se añadirán aquí dinámicamente -->
                                    </div>
                                    <button type="button" onclick="addAccesorio()" class="mt-3 inline-flex items-center gap-1 text-[11px] font-bold text-gray-500 hover:text-blue-700 transition-colors">
                                        <span class="material-symbols-outlined text-sm">add_circle</span>
                                        Añadir accesorio
                                    </button>
                                    <p class="field-hint mt-2">Cada accesorio ingresado será validado individualmente al momento de la devolución.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Código QR --}}
                    <div class="form-section">
                        <div class="section-label">
                            <span class="material-symbols-outlined">qr_code</span>
                            Código QR / Identificador
                        </div>
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <div class="flex-1 w-full">
                                <div class="qr-input-group">
                                    <div class="flex w-full rounded-xl overflow-hidden border-[1.5px] border-gray-200 focus-within:border-[#cca75b] focus-within:ring-[3px] focus-within:ring-[#cca75b]/15 transition-all">
                                        <span class="inline-flex items-center px-3 text-sm text-gray-600 bg-gray-100 font-bold border-r border-gray-200">
                                            HTA-
                                        </span>
                                        <input id="codigo_qr_input" type="text" class="flex-1 outline-none px-3 py-2 text-[0.9rem] text-[#16213e] font-mono w-full"
                                               value="{{ str_replace('HTA-', '', old('codigo_qr', $herramienta->codigo_qr)) }}" required
                                               oninput="document.getElementById('codigo_qr').value = 'HTA-' + this.value;">
                                        <input type="hidden" id="codigo_qr" name="codigo_qr" value="{{ old('codigo_qr', $herramienta->codigo_qr) }}">
                                    </div>
                                    <button type="button" id="btn-regenerar" class="btn-regenerar"
                                        onclick="if(confirm('¿ESTÁS SEGURO? Si regeneras el código, tendrás que imprimir y cambiar la etiqueta física.')){
                                            let nextNum = '{{ str_replace('HTA-', '', $nextCode) }}';
                                            document.getElementById('codigo_qr_input').value = nextNum;
                                            document.getElementById('codigo_qr').value = 'HTA-' + nextNum;
                                            this.innerHTML = '<span class=\'material-symbols-outlined\'>check_circle</span> ¡Generado!';
                                            this.style.background = '#d1fae5'; this.style.color='#065f46'; this.style.borderColor='#10b981';
                                        }">
                                        <span class="material-symbols-outlined">refresh</span>
                                        Regenerar
                                    </button>
                                </div>
                                @error('codigo_qr')<div class="field-error">{{ $message }}</div>@enderror

                                {{-- Historial QR --}}
                                @if($herramienta->historialQr->count() > 0)
                                <div class="qr-history">
                                    <div class="qr-history-title">
                                        <span class="material-symbols-outlined">history</span>
                                        Historial de Identidad
                                    </div>
                                    @foreach($herramienta->historialQr as $historial)
                                        <div class="qr-history-item">
                                            <div>
                                                <div class="qr-code-text">{{ $historial->codigo_qr }}</div>
                                                <div class="qr-date">Cambiado el {{ $historial->created_at->format('d/m/Y H:i') }}</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button type="button" class="btn-restore"
                                                    onclick="if(confirm('¿Restaurar el código «{{ $historial->codigo_qr }}»?')){
                                                        document.getElementById('codigo_qr_input').value = '{{ str_replace('HTA-', '', $historial->codigo_qr) }}';
                                                        document.getElementById('codigo_qr').value = '{{ $historial->codigo_qr }}';
                                                    }">
                                                    Restaurar
                                                </button>
                                                <button type="button" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1 rounded transition-colors"
                                                    onclick="if(confirm('¿Estás seguro de que quieres eliminar este registro del historial?')){
                                                        document.getElementById('form-delete-historial-{{ $historial->id }}').submit();
                                                    }">
                                                    <span class="material-symbols-outlined text-base">delete</span>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>

                            {{-- Visual QR Code (Scannable) --}}
                            <div class="bg-white border-2 border-gray-100 rounded-2xl p-5 flex flex-col items-center shadow-sm w-full md:w-auto shrink-0 transition hover:border-[#cca75b]">
                                <span class="text-[11px] font-extrabold text-[#16213e] uppercase tracking-widest mb-3 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-[#cca75b]">qr_code_scanner</span>
                                    Link de Petición
                                </span>
                                <div id="qr-container" class="p-2 bg-white rounded-xl shadow-inner border border-gray-100 mb-3" style="min-width: 136px; min-height: 136px;">
                                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(120)->margin(0)->color(22, 33, 62)->generate(route('peticiones.qr-add', $herramienta)) !!}
                                </div>
                                <button type="button" onclick="descargarQR()" class="mt-1 mb-3 bg-[#fdf8ee] text-[#a07a2a] border border-[#cca75b] px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1 hover:bg-[#fdf0d0] transition shadow-sm">
                                    <span class="material-symbols-outlined text-[14px]">download</span> Descargar QR
                                </button>
                                <span class="text-[10px] text-gray-400 text-center max-w-[150px] leading-tight">Imprime y pega este código en la herramienta.</span>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="form-footer">
                        <a href="{{ route('herramientas.index') }}" class="btn-cancel">Cancelar</a>
                        <button type="submit" class="btn-save">
                            <span class="material-symbols-outlined">save</span>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
            
            {{-- Formularios de eliminación de historial (deben estar fuera del form principal) --}}
            @foreach($herramienta->historialQr as $historial)
                <form id="form-delete-historial-{{ $historial->id }}" action="{{ route('herramientas.historial.destroy', $historial->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
            
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:contain;">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function descargarQR() {
            const svg = document.querySelector('#qr-container svg');
            if(!svg) return;
            const svgData = new XMLSerializer().serializeToString(svg);
            const canvas = document.createElement("canvas");
            const ctx = canvas.getContext("2d");
            const img = new Image();
            
            // Tamaño escalado para mejor calidad (5x = 600x600px)
            const scale = 5;
            canvas.width = 120 * scale;
            canvas.height = 120 * scale;
            
            img.onload = function() {
                // Fondo blanco
                ctx.fillStyle = "#ffffff";
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                
                const a = document.createElement("a");
                a.download = "QR_{{ $herramienta->codigo_qr }}.png";
                a.href = canvas.toDataURL("image/png");
                a.click();
            };
            
            img.src = "data:image/svg+xml;base64," + btoa(unescape(encodeURIComponent(svgData)));
        }

        function addAccesorio(value = '', estado = 'disponible') {
            const container = document.getElementById('accesorios-container');
            const index = container.children.length;
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 animate-in fade-in slide-in-from-left-2 duration-200 bg-gray-50/50 p-2 rounded-xl border border-dashed border-gray-200';
            div.innerHTML = `
                <div class="flex-grow flex items-center gap-2">
                    <input type="text" name="accesorios[${index}][nombre]" value="${value}" 
                        class="field-input flex-1" style="padding: .5rem .75rem; font-size: .85rem;"
                        placeholder="Nombre del accesorio">
                    
                    <select name="accesorios[${index}][estado]" class="text-[10px] font-bold uppercase tracking-wider py-1 px-3 pr-8 rounded-lg border-gray-300 focus:ring-0 cursor-pointer bg-white">
                        <option value="disponible" ${estado === 'disponible' ? 'selected' : ''}>Disponible</option>
                        <option value="mantenimiento" ${estado === 'mantenimiento' ? 'selected' : ''}>Mantenimiento</option>
                        <option value="perdido" ${estado === 'perdido' ? 'selected' : ''}>Perdido</option>
                    </select>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-gray-400 hover:text-red-500 transition-colors">
                    <span class="material-symbols-outlined text-lg">cancel</span>
                </button>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }

        // Cargar accesorios existentes
        window.addEventListener('load', () => {
            @php
                $accs = old('accesorios', $herramienta->accesorios_formateados ?? []);
            @endphp
            @if(is_array($accs))
                @foreach($accs as $acc)
                    addAccesorio('{{ $acc["nombre"] ?? "" }}', '{{ $acc["estado"] ?? "disponible" }}');
                @endforeach
            @endif
        });
    </script>
</x-app-layout>
