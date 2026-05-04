<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm font-semibold hover:opacity-70 transition" style="color:#23325b;">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Dashboard
            </a>
            <span class="text-gray-300">/</span>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Formato de Salida (Entrega)
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

        .sheet-header { border-bottom: 2px solid #23325b; padding-bottom: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-end; }
        .sheet-title-area h1 { font-size: 1.3rem; font-weight: 800; color: #16213e; text-transform: uppercase; letter-spacing: .05em; line-height: 1.3; }
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2.5rem; }
        .info-item { border-bottom: 1px solid #e5e7eb; padding-bottom: .5rem; }
        .info-label { font-size: .7rem; font-weight: 800; color: #9ca3af; text-transform: uppercase; display: block; margin-bottom: 2px; }
        .info-value { font-size: .95rem; font-weight: 700; color: #16213e; }

        .tools-table-wrapper { border: 1.5px solid #16213e; border-radius: 8px; overflow: hidden; margin-bottom: 2rem; }
        .tools-table { width: 100%; border-collapse: collapse; }
        .tools-table th { background: #f8fafc; border-bottom: 1.5px solid #16213e; border-right: 1.5px solid #16213e; padding: .8rem; font-size: .75rem; font-weight: 800; text-align: center; color: #16213e; text-transform: uppercase; }
        .tools-table td { border-bottom: 1px solid #cbd5e1; border-right: 1px solid #cbd5e1; padding: .8rem; font-size: .85rem; color: #374151; }
        .tools-table td:last-child { border-right: none; }

        /* CAMERA SECTION */
        .camera-section { margin-bottom: 3rem; }
        .camera-box {
            border: 2px dashed #cbd5e1; border-radius: 16px; background: #f8fafc;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 2.5rem; text-align: center; cursor: pointer; transition: all .2s;
            position: relative; overflow: hidden;
        }
        .camera-box:hover { border-color: #cca75b; background: #fdf8ee; }
        .camera-icon { width: 50px; height: 50px; background: #23325b; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
        .preview-img { width: 100%; max-height: 400px; object-fit: contain; display: none; }

        .signatures { display: flex; justify-content: space-between; gap: 4rem; margin-top: 4rem; }
        .sig-box { flex: 1; text-align: center; }
        .sig-line { border-bottom: 1.5px solid #16213e; height: 40px; margin-bottom: .5rem; }
        .sig-text { font-size: .85rem; font-weight: 700; color: #4b5563; }

        .btn-submit {
            background: linear-gradient(135deg, #cca75b, #a07a2a); color: #16213e; border: none;
            padding: 1rem 3rem; border-radius: 12px; font-weight: 800; font-size: 1rem; cursor: pointer;
            box-shadow: 0 4px 15px rgba(204,167,91,0.3); transition: all .2s;
            display: inline-flex; align-items: center; gap: 10px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(204,167,91,0.4); }

        input[type="file"] { display: none; }

        @media(max-width: 768px) {
            .paper-sheet { padding: 1.25rem 1rem; border-radius: 8px; }
            .sheet-header { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
            .sheet-header img { height: 35px !important; }
            .info-grid { grid-template-columns: 1fr; gap: 1rem; }
            .tools-table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .tools-table { min-width: 480px; }
            .signatures { flex-direction: column; gap: 1.5rem; }
            .camera-box { padding: 1.5rem 1rem; }
            .btn-submit { width: 100%; justify-content: center; padding: .9rem 1rem; }
        }
    </style>

    <div class="sheet-root">
        <div class="sheet-wrap">
            <form action="{{ route('peticiones.procesar-entrega', $peticion) }}" method="POST" enctype="multipart/form-data" id="deliveryForm">
                @csrf
                <div class="paper-sheet">
                    <div class="sheet-header">
                        <div class="sheet-title-area">
                            <h1>Formato de Salida de Herramientas<br><span style="color:#cca75b; font-size:.9rem;">Acta de Entrega - ISTPET Taller Mecánica</span></h1>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=IST+PET&color=23325b&background=ffffff" style="height:45px;">
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Estudiante Solicitante</span>
                            <div class="info-value">{{ $peticion->usuario->nombre }}</div>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Cédula</span>
                            <div class="info-value">{{ $peticion->usuario->cedula }}</div>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Especialidad / Nivel</span>
                            <div class="info-value">{{ $peticion->usuario->nivel_academico ?? 'Taller de Mecánica' }}</div>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Fecha y Hora de Salida</span>
                            <div class="info-value">{{ now()->format('d/m/Y - H:i') }}</div>
                        </div>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Tema de la Práctica</span>
                            <div class="info-value">{{ $peticion->practica }}</div>
                        </div>
                    </div>

                    <div class="tools-table-wrapper">
                        <table class="tools-table">
                            <thead>
                                <tr>
                                    <th style="width:10%">ID QR</th>
                                    <th style="text-align:left">Herramienta / Equipamiento</th>
                                    <th>
                                        <div class="flex items-center justify-between">
                                            <span>Checks de Integridad</span>
                                            <button type="button" onclick="marcarTodosChecks()" style="background-color: #cca75b; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 10px; cursor: pointer; border: none; font-weight: bold; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">MARCAR TODOS</button>
                                        </div>
                                    </th>
                            </thead>
                            <tbody>
                                @foreach($peticion->prestamos as $prestamo)
                                <tr>
                                    <td style="text-align:center; font-family:monospace; font-size:11px;">{{ $prestamo->herramienta->codigo_qr }}</td>
                                    <td>
                                        <div style="font-weight:700;">{{ $prestamo->herramienta->nombre }}</div>
                                        <div style="font-size:11px; color:#6b7280;">{{ $prestamo->herramienta->descripcion ?? 'Accesorio de taller' }}</div>
                                    </td>
                                    <td>
                                        <div class="flex flex-col gap-1">
                                            @if($prestamo->herramienta->es_alto_valor && count($prestamo->herramienta->accesorios_formateados) > 0)
                                                @foreach($prestamo->herramienta->accesorios_formateados as $acc)
                                                    @if($acc['estado'] !== 'disponible') @continue @endif
                                                    <label class="flex items-center gap-2 text-[10px] bg-gray-50 p-1 rounded border border-gray-100">
                                                        <input type="checkbox" required class="chk-integridad rounded text-[#cca75b] focus:ring-[#cca75b] w-3 h-3">
                                                        <span>{{ $acc['nombre'] }} ok</span>
                                                    </label>
                                                @endforeach
                                            @else
                                                <label class="flex items-center gap-2 text-[10px] text-green-600 font-bold uppercase italic justify-center">
                                                    <span class="material-symbols-outlined text-xs">check_circle</span> Buen estado
                                                </label>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="camera-section">
                        <h3 style="font-size:1rem; font-weight:800; color:#16213e; margin-bottom:.8rem; display:flex; align-items:center; gap:8px;">
                            <span class="material-symbols-outlined">photo_camera</span> Evidencia de Salida (Foto del Lote)
                        </h3>
                        <label class="camera-box" id="dropZone">
                            <div id="cameraPrompt">
                                <div class="camera-icon"><span class="material-symbols-outlined">add_a_photo</span></div>
                                <div style="font-weight:700; color:#16213e;">Capturar Imagen de Salida</div>
                                <div style="font-size:.8rem; color:#9ca3af;">Toca aquí para abrir la cámara trasera</div>
                            </div>
                            <img src="" id="preview" class="preview-img">
                            <input type="file" name="foto_entrega" id="foto_entrega" accept="image/*" capture="environment" required>
                        </label>
                    </div>

                    <div class="signatures">
                        <div class="sig-box">
                            <div class="sig-line" style="display: flex; align-items: flex-end; justify-content: center; padding-bottom: 5px;">
                                <span style="font-weight: 800; color: #cca75b; font-style: italic; font-size: 1.1rem;">{{ Auth::user()->nombre }}</span>
                            </div>
                            <div class="sig-text">{{ Auth::user()->nombre }}</div>
                            <div style="font-size:.7rem; color:#9ca3af;">Coordinador de Taller (Salida)</div>
                        </div>
                        <div class="sig-box">
                            <div class="sig-line" style="display: flex; align-items: flex-end; justify-content: center; padding-bottom: 5px;">
                                <span style="font-weight: 800; color: #16213e; font-style: italic; font-size: 1.1rem;">{{ $peticion->usuario->nombre }}</span>
                            </div>
                            <div class="sig-text">{{ $peticion->usuario->nombre }}</div>
                            <div style="font-size:.7rem; color:#9ca3af;">Estudiante Solicitante (Recibí)</div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-10 pt-6 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 text-gray-400 font-bold hover:text-gray-600 transition">Cancelar</a>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <span class="material-symbols-outlined">verified</span>
                            Confirmar Entrega y Salida
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

        const fileInput = document.getElementById('foto_entrega');
        const preview = document.getElementById('preview');
        const prompt = document.getElementById('cameraPrompt');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    prompt.style.display = 'none';
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        document.getElementById('deliveryForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin">refresh</span> Procesando Salida...';
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';
        });
    </script>
</x-app-layout>
