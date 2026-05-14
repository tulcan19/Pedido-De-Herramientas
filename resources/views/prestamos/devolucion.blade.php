<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm font-semibold hover:opacity-70 transition" style="color:#23325b;">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Dashboard
            </a>
            <span class="text-gray-300">/</span>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Formato de Entrega (Devolución)
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');
        .sheet-root { font-family: 'Outfit', sans-serif; background: #f0f3f8; min-height: 100vh; padding-bottom: 3rem; }
        .sheet-wrap { max-width: 900px; margin: 2rem auto 0; padding: 0 1.5rem; }
        
        .paper-sheet {
            background: #fff; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,.08);
            padding: 3rem 4rem; position: relative; border-top: 10px solid #cca75b;
        }

        /* HEADER */
        .sheet-header { border-bottom: 2px solid #23325b; padding-bottom: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-end; }
        .sheet-title-area h1 { font-size: 1.3rem; font-weight: 800; color: #16213e; text-transform: uppercase; letter-spacing: .05em; line-height: 1.3; max-width: 450px; }
        .sheet-logo-area { text-align: right; }
        .sheet-logo-area span { display: block; font-size: 2rem; font-weight: 900; color: #d1d5db; letter-spacing: -1px; }

        /* FORM GRID */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem 3rem; margin-bottom: 2.5rem; }
        .input-group { display: flex; align-items: flex-end; gap: .5rem; }
        .input-label { font-weight: 700; color: #4b5563; font-size: .95rem; white-space: nowrap; }
        .input-line { flex: 1; border: none; border-bottom: 1.5px solid #9ca3af; padding: .25rem 0; font-family: 'Outfit', sans-serif; font-size: .95rem; color: #1f2937; background: transparent; transition: border-color .2s; }
        
        /* TABLE */
        .tools-table-wrapper { border: 1.5px solid #16213e; border-radius: 8px; overflow: hidden; margin-bottom: 2rem; }
        .tools-table { width: 100%; border-collapse: collapse; }
        .tools-table th { background: #f8fafc; border-bottom: 1.5px solid #16213e; border-right: 1.5px solid #16213e; padding: .8rem; font-size: .75rem; font-weight: 800; text-align: center; color: #16213e; text-transform: uppercase; }
        .tools-table th:last-child { border-right: none; }
        .tools-table td { border-bottom: 1px solid #cbd5e1; border-right: 1px solid #cbd5e1; padding: .8rem; font-size: .85rem; color: #374151; vertical-align: middle; }
        .tools-table td:last-child { border-right: none; }
        
        /* SECTIONS */
        .section-header { 
            background: #f1f5f9; padding: 0.5rem 1rem; font-weight: 800; font-size: 0.8rem; 
            color: #23325b; text-transform: uppercase; margin: 2rem 0 1rem 0; border-radius: 4px;
            clear: both;
        }
        .section-header:first-child { margin-top: 0; }

        /* CAMERA AREA */
        .camera-box {
            display: block;
            border: 2px dashed #cbd5e1; border-radius: 12px; padding: 2rem; text-align: center;
            cursor: pointer; transition: all 0.2s; background: #f8fafc; margin: 1rem 0 2rem;
            width: 100%;
        }
        .camera-box:hover { border-color: #cca75b; background: #fdf8ee; }
        .camera-preview { width: 100%; max-height: 300px; object-fit: contain; display: none; border-radius: 8px; }

        /* SIGNATURE */
        .sig-canvas-wrap { border: 1.5px solid #cbd5e1; border-radius: 8px; background: #fff; position: relative; margin-bottom: 0.5rem; }
        canvas#signature-pad { width: 100%; height: 150px; cursor: crosshair; }
        .btn-clear-sig { position: absolute; top: 10px; right: 10px; font-size: 0.7rem; color: #9ca3af; cursor: pointer; }

        /* FOOTER SIGNATURES */
        .signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; margin-top: 3rem; }
        .sig-box { text-align: center; }
        .sig-line { border-bottom: 1.5px solid #16213e; min-height: 80px; margin-bottom: .5rem; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; }
        .sig-text { font-size: .85rem; font-weight: 700; color: #4b5563; }
        .sig-sub { font-size: .75rem; color: #9ca3af; }

        /* ACTION BUTTON */
        .form-actions { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem; border-top: 2px dashed #e5e7eb; padding-top: 2rem; }
        .btn-submit {
            background: linear-gradient(135deg, #cca75b, #a07a2a); color: #16213e; border: none;
            padding: 1rem 2.5rem; border-radius: 12px; font-weight: 800; font-size: 1rem; cursor: pointer;
            display: inline-flex; align-items: center; gap: .5rem; transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 15px rgba(204,167,91,.3);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(204,167,91,.4); }

        @media(max-width: 768px) {
            .paper-sheet { padding: 1.25rem 1rem; border-radius: 8px; }
            .sheet-header { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
            .form-grid { grid-template-columns: 1fr; gap: 1rem; }
            .signatures { grid-template-columns: 1fr; gap: 1.5rem; }
            .tools-table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .tools-table { min-width: 500px; }
            .camera-box { padding: 1.25rem 1rem; }
            .form-actions { flex-direction: column; }
            .btn-submit { width: 100%; justify-content: center; padding: .9rem 1rem; font-size: .95rem; }
            canvas#signature-pad { height: 120px; }
        }
    </style>

    <div class="sheet-root">
        <div class="sheet-wrap">
            <form action="{{ route('prestamos.procesar-devolucion', $prestamo) }}" method="POST" enctype="multipart/form-data" id="devolucion-form">
                @csrf
                <div class="paper-sheet">
                    
                    <div class="sheet-header">
                        <div class="sheet-title-area">
                            <h1>Formato de Entrega / Devolución<br><span style="color:#cca75b; font-size:1rem;">Taller de Mecánica Automotriz</span></h1>
                        </div>
                        <div class="sheet-logo-area">
                            <img src="https://ui-avatars.com/api/?name=IST+PET&color=cca75b&background=ffffff&font-size=0.4" alt="Logo" style="height:50px; opacity:0.8;">
                        </div>
                    </div>

                    @if ($errors->any())
                        <div style="background-color: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 1rem; margin-bottom: 2rem; border-radius: 4px;">
                            <strong style="display: block; margin-bottom: 0.5rem;">⚠️ Hay errores que requieren tu atención:</strong>
                            <ul style="list-style-type: disc; margin-left: 1.5rem; font-size: 0.9rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="js-error-box" style="display:none; background-color: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 1rem; margin-bottom: 2rem; border-radius: 4px;">
                        <strong style="display: block; margin-bottom: 0.5rem;">⚠️ ATENCIÓN:</strong>
                        <ul id="js-error-list" style="list-style-type: disc; margin-left: 1.5rem; font-size: 0.9rem;"></ul>
                    </div>

                    <div class="form-grid">
                        <div class="input-group">
                            <span class="input-label">Docente:</span>
                            <input type="text" class="input-line" value="{{ $prestamo->peticion->docente ?? 'N/A' }}" disabled>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Asignatura:</span>
                            <input type="text" class="input-line" value="{{ $prestamo->peticion->asignatura ?? 'N/A' }}" disabled>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Estudiante:</span>
                            <input type="text" class="input-line" value="{{ $prestamo->usuario->nombre }}" disabled>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Fecha:</span>
                            <input type="text" class="input-line" value="{{ now()->format('d / m / Y') }}" disabled>
                        </div>
                        
                        {{-- HORA DE SALIDA Y DEVOLUCION --}}
                        <div class="input-group">
                            <span class="input-label">Hora de Salida:</span>
                            <input type="text" class="input-line font-bold" style="color:#1d4ed8;" value="{{ $prestamo->peticion ? $prestamo->peticion->updated_at->format('H:i') : $prestamo->created_at->format('H:i') }}" disabled>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Hora de Devolución:</span>
                            <input type="text" class="input-line font-bold" style="color:#b91c1c;" value="{{ now()->format('H:i') }}" disabled>
                        </div>

                        <div class="input-group" style="grid-column: 1 / -1;">
                            <span class="input-label">Práctica:</span>
                            <input type="text" class="input-line" value="{{ $prestamo->peticion->practica ?? 'N/A' }}" disabled>
                        </div>
                    </div>

                    <div class="section-header">Listado de Herramientas y Accesorios</div>
                    <div class="tools-table-wrapper">
                        <table class="tools-table">
                            <thead>
                                <tr>
                                    <th style="width:5%;">Nº</th>
                                    <th style="text-align:left;">Descripción de Herramienta</th>
                                    <th style="width:10%;">Cant.</th>
                                    <th style="width:40%;">
                                        <div class="flex items-center justify-between">
                                            <span>Check-list Accesorios (Recepción)</span>
                                            <button type="button" onclick="marcarTodosChecks()" style="background-color: #cca75b; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 10px; cursor: pointer; border: none; font-weight: bold; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">MARCAR TODOS</button>
                                        </div>
                                    </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:center; font-weight:700;">1</td>
                                    <td>
                                        <div class="font-bold text-[#16213e]">{{ $prestamo->herramienta->nombre }}</div>
                                        <div class="text-[10px] text-gray-400">ID: {{ $prestamo->herramienta->codigo_qr }}</div>
                                    </td>
                                    <td style="text-align:center;">1</td>
                                    <td>
                                        @if(count($prestamo->herramienta->accesorios_formateados) > 0)
                                            <div class="flex flex-col gap-2">
                                                @foreach($prestamo->herramienta->accesorios_formateados as $index => $acc)
                                                    @if($acc['estado'] !== 'perdido')
                                                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                                                            <input type="checkbox" name="accesorios_recibidos[]" value="{{ $index }}" class="chk-integridad rounded text-[#cca75b] focus:ring-[#cca75b]">
                                                            <span class="text-xs font-medium">{{ $acc['nombre'] }}</span>
                                                        </label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-xs italic text-gray-400">Sin accesorios registrados</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            @if($prestamo->peticion && $prestamo->peticion->foto_entrega)
                                <div class="section-header">Foto de Entrega (Referencia)</div>
                                <div class="mb-4 rounded-lg overflow-hidden border border-gray-200">
                                    <img src="{{ route('archivo.ver', ['path' => $prestamo->peticion->foto_entrega]) }}" alt="Foto entrega" class="w-full h-48 object-cover cursor-zoom-in" onclick="window.open(this.src)">
                                    <div class="bg-gray-50 p-2 text-[10px] text-gray-500 text-center">Estado registrado al inicio del préstamo</div>
                                </div>
                            @endif

                            <div class="section-header">Evidencia Fotográfica (Devolución)</div>
                            <label class="camera-box" id="camera-box">
                                <div id="camera-prompt">
                                    <span class="material-symbols-outlined" style="font-size:3rem; color:#d1d5db;">add_a_photo</span>
                                    <p class="font-bold text-sm text-gray-600">Capturar Estado de Entrega</p>
                                    <p class="text-xs text-gray-400">Toca para abrir cámara</p>
                                </div>
                                <img id="image-preview" class="camera-preview">
                                <input type="file" name="foto_devolucion" id="foto_input" accept="image/*" capture="environment" class="hidden">
                            </label>
                            
                            <div class="section-header">Observaciones de Recepción</div>
                            <textarea name="observaciones" class="w-full border-1.5 border-gray-200 rounded-lg p-3 text-sm focus:border-[#cca75b] focus:ring-0" rows="3" placeholder="Indique si hay daños, piezas faltantes o novedades..."></textarea>
                        </div>

                        <div>
                            <div class="section-header">Estado Final del Equipo</div>
                            <div class="flex flex-col gap-2 mb-6">
                                <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                    <input type="radio" name="estado_final" value="disponible" checked class="text-green-600 focus:ring-green-500">
                                    <div>
                                        <div class="font-bold text-sm">Disponible</div>
                                        <div class="text-[10px] text-gray-500">Operativo y completo</div>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                    <input type="radio" name="estado_final" value="mantenimiento" class="text-red-600 focus:ring-red-500">
                                    <div>
                                        <div class="font-bold text-sm">Mantenimiento</div>
                                        <div class="text-[10px] text-gray-500">Requiere reparación o revisión</div>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:border-gray-800 has-[:checked]:bg-gray-50">
                                    <input type="radio" name="estado_final" value="perdido" class="text-gray-800 focus:ring-gray-800">
                                    <div>
                                        <div class="font-bold text-sm">Perdido / Dado de Baja</div>
                                        <div class="text-[10px] text-gray-500">No recuperado</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                                  <div class="signatures-new" style="display: flex; flex-direction: column; gap: 1.5rem; margin-top: 2rem; border-top: 1.5px solid #16213e; padding-top: 2rem;">
                        <div style="display: flex; align-items: flex-end; gap: 10px; font-size: 0.85rem;">
                            <span style="font-weight: 700;">Entregado por (Estudiante responsable):</span>
                            <div style="flex: 1; border-bottom: 1.5px solid #16213e; min-width: 200px; padding-bottom: 2px;">
                                <span style="font-weight: 800; color: #cca75b; font-style: italic;">{{ $prestamo->usuario->nombre }}</span>
                            </div>
                        </div>

                        <div style="display: flex; align-items: flex-end; gap: 10px; font-size: 0.85rem;">
                            <span style="font-weight: 700;">Recibido por (Encargado de taller):</span>
                            <div style="flex: 1; border-bottom: 1.5px solid #16213e; min-width: 200px; padding-bottom: 2px;">
                                <span style="font-weight: 800; color: #16213e; font-style: italic;">{{ \App\Models\Usuario::where('rol', 'admin')->first()?->nombre ?? 'Javier Tulcán' }}</span>
                            </div>
                        </div>

                        <div style="display: flex; align-items: flex-end; gap: 10px; font-size: 0.85rem;">
                            <span style="font-weight: 700;">Autorizado por (Docente responsable):</span>
                            <div style="flex: 1; border-bottom: 1.5px solid #16213e; min-width: 200px; padding-bottom: 2px;">
                                <span style="font-weight: 800; color: #1e40af; font-style: italic;">{{ $prestamo->peticion->docente ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit" id="submit-btn">
                            <span class="material-symbols-outlined">task_alt</span>
                            Finalizar y Entregar Herramientas
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function marcarTodosChecks() {
            document.querySelectorAll('.chk-integridad').forEach(cb => cb.checked = true);
        }

        // Photo Preview
        document.getElementById('foto_input').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                    document.getElementById('camera-prompt').style.display = 'none';
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        document.getElementById('devolucion-form').addEventListener('submit', function(e) {
            const fotoInput = document.getElementById('foto_input');
            const accesorios = document.querySelectorAll('input[name="accesorios_recibidos[]"]');
            const cameraBox = document.getElementById('camera-box');
            let valid = true;
            let errors = [];

            // Validar Foto
            if (!fotoInput.files || !fotoInput.files[0]) {
                valid = false;
                errors.push("Debe capturar una foto de evidencia del estado de la herramienta.");
                cameraBox.style.borderColor = "#ef4444";
                cameraBox.style.backgroundColor = "#fef2f2";
            }

            const observaciones = document.querySelector('textarea[name="observaciones"]').value.trim();

            // Validar Accesorios (si existen)
            if (accesorios.length > 0) {
                let checkedCount = 0;
                accesorios.forEach(acc => { if(acc.checked) checkedCount++; });
                
                if (checkedCount === 0 && observaciones === '') {
                    valid = false;
                    errors.push("Debe revisar y marcar el check-list de accesorios. Si realmente no se entrega ningún accesorio, es obligatorio explicar el motivo en las Observaciones.");
                }
            }

            if (!valid) {
                e.preventDefault();
                const errorBox = document.getElementById('js-error-box');
                const errorList = document.getElementById('js-error-list');
                errorList.innerHTML = '';
                errors.forEach(err => {
                    let li = document.createElement('li');
                    li.innerText = err;
                    errorList.appendChild(li);
                });
                errorBox.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return false;
            } else {
                document.getElementById('js-error-box').style.display = 'none';
            }

            const btn = document.getElementById('submit-btn');
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin">refresh</span> Procesando Entrega...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';
        });
    </script>
</x-app-layout>
