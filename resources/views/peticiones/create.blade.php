<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('herramientas.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold hover:opacity-70 transition" style="color:#23325b;">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Catálogo
            </a>
            <span class="text-gray-300">/</span>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Formato de Petición de Herramientas
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');
        .sheet-root { font-family: 'Outfit', sans-serif; background: #f0f3f8; min-height: 100vh; padding-bottom: 3rem; }
        .sheet-wrap { max-width: 900px; margin: 2rem auto 0; padding: 0 1.5rem; }
        
        .paper-sheet {
            background: #fff; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,.08);
            padding: 3rem 4rem; position: relative; border-top: 10px solid #23325b;
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
        .input-line:focus { outline: none; border-bottom-color: #cca75b; }
        .input-line::placeholder { color: #d1d5db; font-style: italic; }
        
        /* TABLE */
        .tools-table-wrapper { border: 1.5px solid #16213e; border-radius: 8px; overflow: hidden; margin-bottom: 2rem; }
        .tools-table { width: 100%; border-collapse: collapse; }
        .tools-table th { background: #f8fafc; border-bottom: 1.5px solid #16213e; border-right: 1.5px solid #16213e; padding: .8rem; font-size: .75rem; font-weight: 800; text-align: center; color: #16213e; text-transform: uppercase; }
        .tools-table th:last-child { border-right: none; }
        .tools-table td { border-bottom: 1px solid #cbd5e1; border-right: 1px solid #cbd5e1; padding: .8rem; font-size: .85rem; color: #374151; vertical-align: middle; }
        .tools-table td:last-child { border-right: none; }
        .tools-table tbody tr:last-child td { border-bottom: none; }
        .cell-center { text-align: center; }

        /* OBS */
        .obs-area { margin-bottom: 3rem; }
        .obs-label { font-weight: 800; color: #16213e; font-size: 1rem; margin-bottom: .5rem; display: block; }
        .obs-input { width: 100%; min-height: 80px; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 1rem; font-family: 'Outfit', sans-serif; font-size: .9rem; resize: vertical; }
        .obs-input:focus { outline: none; border-color: #cca75b; }

        /* FOOTER SIGNATURES */
        .signatures { display: flex; justify-content: space-between; gap: 4rem; margin-top: 4rem; }
        .sig-box { flex: 1; text-align: center; }
        .sig-line { border-bottom: 1.5px solid #16213e; height: 40px; margin-bottom: .5rem; }
        .sig-text { font-size: .85rem; font-weight: 700; color: #4b5563; }
        .sig-sub { font-size: .75rem; color: #9ca3af; }

        /* ACTION BUTTON */
        .form-actions { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem; border-top: 2px dashed #e5e7eb; padding-top: 2rem; }
        .btn-submit {
            background: linear-gradient(135deg, #23325b, #16213e); color: white; border: none;
            padding: 1rem 2.5rem; border-radius: 12px; font-weight: 800; font-size: 1rem; cursor: pointer;
            display: inline-flex; align-items: center; gap: .5rem; transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 15px rgba(22,33,62,.3);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(22,33,62,.4); }

        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; display: block; }

        @media(max-width: 768px) {
            .paper-sheet { padding: 2rem 1.5rem; }
            .form-grid { grid-template-columns: 1fr; gap: 1rem; }
            .signatures { flex-direction: column; gap: 2rem; }
            .tools-table-wrapper { overflow-x: auto; }
        }
    </style>

    <div class="sheet-root">
        <div class="sheet-wrap">
            <form action="{{ route('peticiones.store') }}" method="POST" id="peticion-form">
                @csrf
                <div class="paper-sheet">
                    
                    <div class="sheet-header">
                        <div class="sheet-title-area">
                            <h1>Formato de Petición de Herramientas<br><span style="color:#cca75b; font-size:1rem;">Taller de Mecánica Automotriz</span></h1>
                        </div>
                        <div class="sheet-logo-area">
                            <img src="https://ui-avatars.com/api/?name=IST+PET&color=cca75b&background=ffffff&font-size=0.4" alt="Logo" style="height:50px; opacity:0.8;">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="input-group">
                            <span class="input-label">Docente:</span>
                            <select name="docente_id" id="docente_id" class="input-line" required onchange="updateTeacherSignature(this)">
                                <option value="" disabled selected>Seleccione un docente</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>{{ $docente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Asignatura:</span>
                            <input type="text" name="asignatura" class="input-line" placeholder="Ej. Sistemas de Inyección" value="{{ old('asignatura') }}" required>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Fecha:</span>
                            <input type="text" class="input-line" value="{{ now()->format('d / m / Y') }}" disabled>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Semestre / Paralelo:</span>
                            <input type="text" class="input-line" value="{{ Auth::user()->semestre ?? 'N/A' }}" disabled>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Tiempo de uso:</span>
                            <div class="flex items-end gap-2" style="flex:1;">
                                <input type="number" name="horas" class="input-line text-center" style="width:60px;" placeholder="H" min="0" max="24" value="{{ old('horas', 1) }}" required>
                                <span class="text-xs text-gray-400 pb-1">hrs</span>
                                <input type="number" name="minutos" class="input-line text-center" style="width:60px;" placeholder="M" min="0" max="59" value="{{ old('minutos', 0) }}" required>
                                <span class="text-xs text-gray-400 pb-1">min</span>
                            </div>
                        </div>
                        <div class="input-group" style="grid-column: 1 / -1;">
                            <span class="input-label">Práctica a realizar:</span>
                            <input type="text" name="practica" class="input-line" placeholder="Título o tema de la práctica" value="{{ old('practica') }}" required>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                            Corrige los errores en el formulario para continuar.
                        </div>
                    @endif

                    <div class="tools-table-wrapper">
                        <table class="tools-table">
                            <thead>
                                <tr>
                                    <th style="width:5%;">Nº</th>
                                    <th style="text-align:left;">Nombre de la Herramienta</th>
                                    <th style="width:10%;">Cant.</th>
                                    <th style="width:15%">ID / QR</th>
                                    <th style="width:20%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($herramientas as $index => $h)
                                <tr>
                                    <td class="cell-center font-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <div style="font-weight:700; color:#16213e;">{{ $h->nombre }}</div>
                                        <div style="font-size:11px; color:#9ca3af; margin-bottom: 5px;">{{ Str::limit($h->descripcion, 50) }}</div>
                                        
                                        @if(is_array($h->accesorios) && count($h->accesorios) > 0)
                                            <div style="display:flex; flex-wrap:wrap; gap:4px;">
                                                @foreach($h->accesorios as $acc)
                                                    <span style="font-size:9px; background:#f1f5f9; color:#475569; padding:1px 6px; border-radius:4px; border:1px solid #e2e8f0;">{{ $acc }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="cell-center">1</td>
                                    <td class="cell-center font-mono text-xs">{{ $h->codigo_qr }}</td>
                                    <td class="cell-center">
                                        <button type="button" onclick="removeTool({{ $h->id }})" class="text-red-500 hover:text-red-700 hover:underline text-xs flex items-center justify-center gap-1 mx-auto">
                                            <span class="material-symbols-outlined" style="font-size:14px;">delete</span> Quitar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="obs-area">
                        <label class="obs-label">Observaciones:</label>
                        <textarea name="observaciones" class="obs-input" placeholder="Agrega cualquier comentario relevante sobre el estado de la entrega o requerimientos especiales.">{{ old('observaciones') }}</textarea>
                    </div>

                    <div class="signatures">
                        <div class="sig-box">
                            <div class="sig-line" style="display:flex; align-items:flex-end; justify-content:center; padding-bottom:5px;">
                                <span id="teacher-sig-name" style="font-family: 'Outfit', sans-serif; font-size:1.1rem; font-weight:700; color:#16213e; font-style:italic;"></span>
                            </div>
                            <div class="sig-text">Entregado por (Encargado de taller)</div>
                            <div class="sig-sub">Firma digital - Aprobación en sistema</div>
                        </div>
                        <div class="sig-box">
                            <div class="sig-line" style="display:flex; align-items:flex-end; justify-content:center; padding-bottom:5px;">
                                <span style="font-family: 'Outfit', sans-serif; font-size:1.5rem; font-weight:800; color:#cca75b; font-style:italic;">{{ Auth::user()->nombre }}</span>
                            </div>
                            <div class="sig-text">Recibido por (Estudiante Solicitante)</div>
                            <div class="sig-sub">Validado con credenciales de usuario</div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit" id="btn-submit">
                            <span class="material-symbols-outlined">send</span>
                            Enviar Solicitud a Ventanilla
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function removeTool(id) {
            fetch(`/peticion/remove/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                window.location.reload();
            });
        }

        function updateTeacherSignature(select) {
            const name = select.options[select.selectedIndex].text;
            document.getElementById('teacher-sig-name').innerText = name;
        }

        document.getElementById('peticion-form').addEventListener('submit', function() {
            let btn = document.getElementById('btn-submit');
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin">refresh</span> Procesando...';
            btn.style.pointerEvents = 'none';
            btn.style.opacity = '0.8';
        });
    </script>
</x-app-layout>
