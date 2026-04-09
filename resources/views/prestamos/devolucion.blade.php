<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}"
               style="color:#23325b;"
               class="inline-flex items-center gap-1 text-sm font-semibold hover:opacity-70 transition">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Dashboard
            </a>
            <span class="text-gray-300">/</span>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Check-list de Recepción
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

        .checklist-root { font-family: 'Outfit', sans-serif; background: #f0f3f8; min-height: 100vh; padding-bottom: 3rem; }

        .form-wrap { max-width: 800px; margin: 2rem auto 0; padding: 0 1.5rem; }
        .form-card { background: #fff; border-radius: 22px; box-shadow: 0 8px 40px rgba(0,0,0,.08); overflow: hidden; border: 1.5px solid #e5e7eb; }

        /* ── HEADER TOOL ── */
        .tool-header {
            background: linear-gradient(135deg, #16213e 0%, #23325b 60%, #2a3d6e 100%);
            padding: 2rem; color: #fff; display: flex; gap: 1.5rem; align-items: center; flex-wrap: wrap;
            position: relative; overflow: hidden;
        }
        .tool-header::after {
            content: ''; position: absolute; right: -30px; top: -30px;
            width: 150px; height: 150px; background: rgba(204,167,91,.15); border-radius: 50%;
        }
        .tool-img {
            width: 80px; height: 80px; background: rgba(255,255,255,.1);
            border: 2px solid rgba(204,167,91,.4); border-radius: 16px;
            display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; z-index: 2;
        }
        .tool-img img { width: 100%; height: 100%; object-fit: contain; mix-blend-mode: luminosity; }
        .tool-info { position: relative; z-index: 2; flex: 1; }
        .tool-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 10px; font-weight: 700; background: rgba(204,167,91,.2); border: 1px solid rgba(204,167,91,.4); color: #cca75b; padding: 3px 10px; border-radius: 999px; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .4rem; }
        .tool-title { font-size: 1.4rem; font-weight: 800; line-height: 1.2; margin-bottom: .2rem; }
        .tool-user { font-size: .85rem; color: #a0b0cc; display: flex; align-items: center; gap: 5px; }
        .tool-user .material-symbols-outlined { font-size: 14px; }

        /* ── SECTIONS ── */
        .form-section { padding: 2rem; border-bottom: 1px solid #f1f5f9; }
        .form-section:last-of-type { border-bottom: none; }
        .section-title { font-size: 1rem; font-weight: 800; color: #16213e; display: flex; align-items: center; gap: 8px; margin-bottom: .4rem; }
        .section-title .material-symbols-outlined { color: #cca75b; }
        .section-desc { font-size: .85rem; color: #6b7280; margin-bottom: 1.5rem; }

        /* ── CHECKBOX LIST ── */
        .check-list { display: flex; flex-direction: column; gap: .75rem; }
        .check-item {
            display: flex; align-items: center; gap: 1rem;
            padding: 1rem 1.25rem; background: #f8fafc; border: 1.5px solid #e5e7eb;
            border-radius: 12px; cursor: pointer; transition: all .2s;
        }
        .check-item:hover { border-color: #cca75b; background: #fdf8ee; }
        .check-item input[type="checkbox"] { width: 22px; height: 22px; border: 2px solid #cbd5e1; border-radius: 6px; text-color: #a07a2a; cursor: pointer; }
        .check-item input[type="checkbox"]:checked { border-color: #cca75b; background-color: #cca75b; }
        .check-label { font-size: .95rem; font-weight: 600; color: #374151; flex: 1; user-select: none; }

        /* ── CAMERA ── */
        .camera-area {
            border: 2px dashed #cbd5e1; border-radius: 16px; background: #f8fafc;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 2.5rem 1.5rem; text-align: center; cursor: pointer; transition: all .2s;
            position: relative; overflow: hidden;
        }
        .camera-area:hover { border-color: #cca75b; background: #fdf8ee; }
        .camera-area.has-image { padding: 0; border-style: solid; border-color: #cca75b; }
        .camera-icon { width: 64px; height: 64px; background: #fff; border-radius: 50%; box-shadow: 0 4px 12px rgba(0,0,0,.08); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; color: #23325b; }
        .camera-icon .material-symbols-outlined { font-size: 32px; }
        .camera-text-main { font-size: 1.1rem; font-weight: 700; color: #16213e; margin-bottom: .2rem; }
        .camera-text-sub { font-size: .85rem; color: #6b7280; }
        .img-preview { width: 100%; height: 300px; object-fit: cover; display: none; }
        .btn-change-photo { position: absolute; bottom: 15px; right: 15px; background: rgba(0,0,0,.7); color: #fff; border-radius: 10px; padding: .5rem 1rem; font-size: .8rem; font-weight: 700; display: none; backdrop-filter: blur(4px); }
        input[type="file"]#foto { display: none; }

        /* ── FOOTER ── */
        .form-footer { background: #f8fafc; padding: 1.5rem 2rem; display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid #f1f5f9; }
        .btn-submit { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #cca75b, #a07a2a); color: #16213e; border: none; padding: .8rem 2rem; border-radius: 12px; font-size: .95rem; font-weight: 800; font-family: 'Outfit', sans-serif; cursor: pointer; box-shadow: 0 4px 15px rgba(204,167,91,.4); transition: transform .15s, box-shadow .15s; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(204,167,91,.5); }
        .field-error { font-size: .8rem; color: #b91c1c; margin-top: .5rem; font-weight: 500; background: #fee2e2; padding: .5rem 1rem; border-radius: 8px; border-left: 3px solid #ef4444; }
    </style>

    <div class="checklist-root">
        <div class="form-wrap">
            
            @if(session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-500">error</span>
                        <p class="text-sm font-bold text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('prestamos.procesar-devolucion', $prestamo) }}" method="POST" enctype="multipart/form-data" class="form-card" id="returnForm">
                @csrf

                <div class="tool-header">
                    <div class="tool-img"><img src="{{ $prestamo->herramienta->imagen_url }}" alt="Herramienta"></div>
                    <div class="tool-info">
                        <div class="tool-badge"><span class="material-symbols-outlined">warning</span> Alto Valor</div>
                        <h1 class="tool-title">{{ $prestamo->herramienta->nombre }}</h1>
                        <div class="tool-user">
                            <span class="material-symbols-outlined">person</span>
                            Estudiante: <strong class="text-white ml-1">{{ $prestamo->usuario->nombre }}</strong>
                        </div>
                    </div>
                </div>

                @if(is_array($prestamo->herramienta->accesorios) && count($prestamo->herramienta->accesorios) > 0)
                <div class="form-section">
                    <h3 class="section-title"><span class="material-symbols-outlined">fact_check</span> Validación de Accesorios</h3>
                    <p class="section-desc">Confirma físicamente que los siguientes elementos han sido devueltos. Todos son obligatorios para cerrar el préstamo.</p>
                    
                    <div class="check-list">
                        @foreach($prestamo->herramienta->accesorios as $index => $accesorio)
                            <label class="check-item">
                                <input type="checkbox" name="accesorios[{{ $index }}]" value="{{ $accesorio }}" class="check-input text-[#a07a2a] focus:ring-[#cca75b]">
                                <span class="check-label">{{ $accesorio }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('accesorios')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                @endif

                <div class="form-section">
                    <h3 class="section-title"><span class="material-symbols-outlined">photo_camera</span> Foto de Estado</h3>
                    <p class="section-desc">Toma una fotografía evidenciando que la herramienta y todos sus componentes ingresan en buen estado.</p>
                    
                    <label class="camera-area" id="cameraArea">
                        <div class="camera-ui" id="cameraUI">
                            <div class="camera-icon"><span class="material-symbols-outlined">add_a_photo</span></div>
                            <div class="camera-text-main">Tomar o subir foto</div>
                            <div class="camera-text-sub">Toca aquí para abrir la cámara</div>
                        </div>
                        <img src="" alt="Preview" class="img-preview" id="photoPreview">
                        <div class="btn-change-photo" id="btnChangePhoto"><span class="material-symbols-outlined text-sm inline-block align-middle mr-1">sync</span> Cambiar Foto</div>
                        <!-- capture="environment" abre la cámara trasera en dispositivos móviles -->
                        <input type="file" id="foto" name="foto_devolucion" accept="image/*" capture="environment">
                    </label>
                    @error('foto_devolucion')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-footer">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">Cancelar</a>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="material-symbols-outlined">task_alt</span>
                        Aprobar Devolución
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Photo preview logic
        const fileInput = document.getElementById('foto');
        const cameraArea = document.getElementById('cameraArea');
        const cameraUI = document.getElementById('cameraUI');
        const preview = document.getElementById('photoPreview');
        const btnChange = document.getElementById('btnChangePhoto');

        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    cameraUI.style.display = 'none';
                    btnChange.style.display = 'block';
                    cameraArea.classList.add('has-image');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Validation before submit
        const form = document.getElementById('returnForm');
        form.addEventListener('submit', function(e) {
            // Check checkboxes
            const checkboxes = document.querySelectorAll('.check-input');
            if (checkboxes.length > 0) {
                let allChecked = true;
                checkboxes.forEach(cb => { if(!cb.checked) allChecked = false; });
                if (!allChecked) {
                    e.preventDefault();
                    alert('⚠️ Debes confirmar (marcar) todos los accesorios de la lista para proceder.');
                    return;
                }
            }

            // Check photo
            if (!fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                alert('📸 La fotografía de evidencia es obligatoria.');
                return;
            }

            // Visual feedback
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin">refresh</span> Procesando...';
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';
        });
    </script>
</x-app-layout>
