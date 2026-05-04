<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Docentes') }}
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

        .doc-root { font-family: 'Outfit', sans-serif; background: #f0f3f8; min-height: 100vh; }

        /* ── HERO ── */
        .doc-hero {
            background: linear-gradient(135deg, #16213e 0%, #23325b 60%, #2a3d6e 100%);
            padding: 2.5rem 1.5rem 5rem;
            position: relative; overflow: hidden;
        }
        .doc-hero::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(204,167,91,.12) 0%, transparent 70%);
            border-radius: 50%;
        }
        .doc-hero-inner { max-width: 1100px; margin: 0 auto; position: relative; z-index: 1; }
        .doc-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(204,167,91,.15); border: 1px solid rgba(204,167,91,.35);
            color: #cca75b; font-size: 11px; font-weight: 700; padding: 4px 14px;
            border-radius: 999px; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 1rem;
        }
        .doc-hero-title { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 800; color: #fff; margin-bottom: .3rem; }
        .doc-hero-title span { color: #cca75b; }
        .doc-hero-sub { color: #a0b0cc; font-size: .9rem; }

        /* ── MAIN ── */
        .doc-main { max-width: 1100px; margin: -3rem auto 0; padding: 0 1.5rem 3rem; position: relative; z-index: 10; }

        /* ── CARD ── */
        .doc-card {
            background: #fff; border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0,0,0,.10);
            overflow: hidden; margin-bottom: 1.5rem;
        }
        .doc-card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1.5px solid #f1f5f9;
            display: flex; align-items: center; gap: .75rem;
        }
        .doc-card-header-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #23325b, #16213e);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
        }
        .doc-card-header-icon .material-symbols-outlined { color: #cca75b; font-size: 20px; }
        .doc-card-header h3 { font-size: 1rem; font-weight: 800; color: #16213e; margin: 0; }
        .doc-card-header span.sub { font-size: .78rem; color: #9ca3af; display: block; margin-top: 1px; }

        /* ── FORM GRID ── */
        .form-grid { display: grid; grid-template-columns: 2fr 1fr 2fr; gap: 1.25rem; padding: 1.75rem 2rem; }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }

        .field-group { display: flex; flex-direction: column; gap: .4rem; }
        .field-label { font-size: .75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .05em; }
        .field-input {
            border: 1.5px solid #e5e7eb; border-radius: 12px;
            padding: .7rem 1rem; font-family: 'Outfit', sans-serif; font-size: .9rem;
            color: #16213e; background: #fff; transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .field-input:focus { border-color: #cca75b; box-shadow: 0 0 0 3px rgba(204,167,91,.12); }
        .field-input::placeholder { color: #d1d5db; }

        .form-actions { padding: 0 2rem 1.75rem; display: flex; justify-content: flex-end; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #23325b, #16213e);
            color: #cca75b; border: none; padding: .75rem 1.75rem;
            border-radius: 12px; font-family: 'Outfit', sans-serif;
            font-weight: 700; font-size: .88rem; cursor: pointer;
            transition: transform .15s, box-shadow .15s;
            box-shadow: 0 4px 14px rgba(22,33,62,.25);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(22,33,62,.3); }
        .btn-primary .material-symbols-outlined { font-size: 18px; }

        /* ── FLASH ── */
        .flash-ok { background: #d1fae5; border-left: 4px solid #10b981; color: #065f46; padding: .85rem 1.25rem; border-radius: 12px; margin-bottom: 1.25rem; font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: .5rem; }
        .flash-err { background: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: .85rem 1.25rem; border-radius: 12px; margin-bottom: 1.25rem; font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: .5rem; }

        /* ── TABLE ── */
        .doc-table-wrap { overflow-x: auto; }
        .doc-table { width: 100%; border-collapse: collapse; }
        .doc-table thead tr { background: #f8fafc; border-bottom: 2px solid #e5e7eb; }
        .doc-table thead th { padding: 1rem 1.5rem; font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #6b7280; text-align: left; white-space: nowrap; }
        .doc-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
        .doc-table tbody tr:last-child { border-bottom: none; }
        .doc-table tbody tr:hover { background: #f8f9fd; }
        .doc-table td { padding: 1rem 1.5rem; vertical-align: middle; }

        .docente-avatar {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, #23325b, #16213e);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .docente-avatar .material-symbols-outlined { color: #cca75b; font-size: 19px; }
        .docente-name { font-weight: 700; font-size: .92rem; color: #16213e; }

        .subject-pill {
            display: inline-flex; align-items: center;
            background: rgba(22,33,62,.08); color: #23325b;
            border: 1px solid rgba(22,33,62,.12);
            padding: 3px 10px; border-radius: 999px;
            font-size: .72rem; font-weight: 700; letter-spacing: .03em;
            margin: 2px;
        }

        .action-btn {
            width: 34px; height: 34px; border-radius: 10px; border: none;
            display: inline-flex; align-items: center; justify-content: center;
            cursor: pointer; transition: background .15s, transform .15s;
        }
        .action-btn:hover { transform: translateY(-1px); }
        .action-btn.edit { background: #fdf8ee; color: #a07a2a; }
        .action-btn.edit:hover { background: #fdf0d0; }
        .action-btn.delete { background: #fee2e2; color: #b91c1c; }
        .action-btn.delete:hover { background: #fecaca; }
        .action-btn .material-symbols-outlined { font-size: 16px; }

        .empty-row { text-align: center; padding: 3rem; color: #9ca3af; font-style: italic; }
        .badge-count {
            background: rgba(204,167,91,.15); border: 1px solid rgba(204,167,91,.3);
            color: #a07a2a; font-size: .72rem; font-weight: 700;
            padding: 3px 10px; border-radius: 999px;
        }

        /* ── MODAL PREMIUM ── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 999;
            background: rgba(15,20,40,.6); backdrop-filter: blur(6px);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity .25s ease;
        }
        .modal-overlay.active { opacity: 1; pointer-events: all; }
        .modal-box {
            background: #fff; border-radius: 24px; width: 100%; max-width: 480px;
            box-shadow: 0 30px 80px rgba(0,0,0,.25);
            transform: translateY(20px) scale(.97);
            transition: transform .3s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
        }
        .modal-overlay.active .modal-box { transform: translateY(0) scale(1); }
        .modal-top {
            background: linear-gradient(135deg, #16213e, #23325b);
            padding: 1.75rem 2rem; display: flex; align-items: center; gap: 1rem;
        }
        .modal-icon { width: 44px; height: 44px; background: rgba(204,167,91,.2); border-radius: 14px; display: flex; align-items: center; justify-content: center; }
        .modal-icon .material-symbols-outlined { color: #cca75b; font-size: 22px; }
        .modal-top h3 { color: #fff; font-size: 1.1rem; font-weight: 800; margin: 0; }
        .modal-top p { color: #a0b0cc; font-size: .8rem; margin: 0; }
        .modal-close {
            margin-left: auto; background: rgba(255,255,255,.1); border: none;
            width: 32px; height: 32px; border-radius: 8px; color: #fff;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: background .15s;
        }
        .modal-close:hover { background: rgba(255,255,255,.2); }
        .modal-close .material-symbols-outlined { font-size: 18px; }

        .modal-body { padding: 1.75rem 2rem; display: flex; flex-direction: column; gap: 1.1rem; }
        .modal-footer { padding: 1rem 2rem 1.75rem; display: flex; gap: .75rem; justify-content: flex-end; }
        .btn-cancel {
            background: #f3f4f6; color: #6b7280; border: none; padding: .7rem 1.4rem;
            border-radius: 10px; font-family: 'Outfit', sans-serif; font-weight: 700;
            font-size: .85rem; cursor: pointer; transition: background .15s;
        }
        .btn-cancel:hover { background: #e5e7eb; }
        .btn-save {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #cca75b, #a07a2a);
            color: #16213e; border: none; padding: .7rem 1.6rem;
            border-radius: 10px; font-family: 'Outfit', sans-serif;
            font-weight: 800; font-size: .85rem; cursor: pointer;
            transition: transform .15s, box-shadow .15s;
            box-shadow: 0 4px 14px rgba(204,167,91,.35);
        }
        .btn-save:hover { transform: translateY(-1px); box-shadow: 0 7px 18px rgba(204,167,91,.4); }
        .btn-save .material-symbols-outlined { font-size: 17px; }
    </style>

    <div class="doc-root">

        {{-- HERO --}}
        <div class="doc-hero">
            <div class="doc-hero-inner">
                <div class="doc-badge">
                    <span class="material-symbols-outlined" style="font-size:13px;">school</span>
                    Panel de Coordinación
                </div>
                <h1 class="doc-hero-title">Personal <span>Docente</span></h1>
                <p class="doc-hero-sub">Registra y gestiona el cuerpo docente del taller mecánico.</p>
            </div>
        </div>

        <div class="doc-main">

            {{-- FLASH --}}
            @if (session('success'))
                <div class="flash-ok"><span class="material-symbols-outlined">check_circle</span>{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash-err"><span class="material-symbols-outlined">error</span>{{ session('error') }}</div>
            @endif

            {{-- FORMULARIO --}}
            <div class="doc-card">
                <div class="doc-card-header">
                    <div class="doc-card-header-icon"><span class="material-symbols-outlined">person_add</span></div>
                    <div>
                        <h3>Registrar Nuevo Docente</h3>
                        <span class="sub">Los datos de cédula se usarán como credenciales de acceso</span>
                    </div>
                </div>
                <form action="{{ route('docentes.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="field-group">
                            <label class="field-label">Nombre Completo</label>
                            <input type="text" name="nombre" class="field-input" placeholder="Ej. Ing. Juan Pérez" value="{{ old('nombre') }}" required>
                            @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="field-group">
                            <label class="field-label">Cédula (Usuario)</label>
                            <input type="text" name="cedula" class="field-input" placeholder="10 dígitos" value="{{ old('cedula') }}" maxlength="10" required>
                            @error('cedula') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="field-group">
                            <label class="field-label">Asignaturas (separadas por comas)</label>
                            <input type="text" name="asignatura" class="field-input" placeholder="Ej. Autotrónica, Sistemas, Dibujo" value="{{ old('asignatura') }}" required>
                            @error('asignatura') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <span class="material-symbols-outlined">save</span>
                            Guardar Docente
                        </button>
                    </div>
                </form>
            </div>

            {{-- LISTA --}}
            <div class="doc-card">
                <div class="doc-card-header">
                    <div class="doc-card-header-icon"><span class="material-symbols-outlined">group</span></div>
                    <div>
                        <h3>Docentes Registrados</h3>
                        <span class="sub">Cuerpo docente activo del taller</span>
                    </div>
                    <span class="badge-count" style="margin-left:auto;">{{ $docentes->count() }} docentes</span>
                </div>
                <div class="doc-table-wrap">
                    <table class="doc-table">
                        <thead>
                            <tr>
                                <th>Docente</th>
                                <th>Cédula</th>
                                <th>Asignaturas</th>
                                <th style="text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($docentes as $docente)
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:.75rem;">
                                        <div class="docente-avatar">
                                            <span class="material-symbols-outlined">school</span>
                                        </div>
                                        <span class="docente-name">{{ $docente->nombre }}</span>
                                    </div>
                                </td>
                                <td style="font-family:monospace; font-size:.85rem; color:#6b7280;">{{ $docente->cedula }}</td>
                                <td>
                                    @foreach(explode(',', $docente->asignatura) as $mat)
                                        <span class="subject-pill">{{ trim($mat) }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <div style="display:flex; align-items:center; justify-content:center; gap:.5rem;">
                                        <button type="button"
                                            onclick="openEditModal({{ $docente->id }}, '{{ $docente->nombre }}', '{{ $docente->cedula }}', '{{ $docente->asignatura }}')"
                                            class="action-btn edit" title="Editar Docente">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                        <form action="{{ route('docentes.destroy', $docente) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar a {{ $docente->nombre }}?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Eliminar Docente">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-row">
                                    <span class="material-symbols-outlined" style="font-size:2.5rem; display:block; margin-bottom:.5rem; color:#e5e7eb;">school</span>
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

    {{-- MODAL PREMIUM --}}
    <div id="editModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-top">
                <div class="modal-icon"><span class="material-symbols-outlined">edit_note</span></div>
                <div>
                    <h3>Editar Docente</h3>
                    <p>Actualiza los datos del personal docente</p>
                </div>
                <button class="modal-close" onclick="closeModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="field-group">
                        <label class="field-label">Nombre Completo</label>
                        <input type="text" name="nombre" id="edit_nombre" class="field-input" required>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Cédula</label>
                        <input type="text" name="cedula" id="edit_cedula" class="field-input" maxlength="10" required>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Asignaturas (separadas por comas)</label>
                        <input type="text" name="asignatura" id="edit_asignatura" class="field-input" placeholder="Ej. Autotrónica, Sistemas" required>
                        <span style="font-size:.72rem; color:#9ca3af;">Puedes ingresar una o varias materias separadas por comas.</span>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Nueva Contraseña (Opcional)</label>
                        <input type="password" name="password" id="edit_password" class="field-input" placeholder="Dejar en blanco para no cambiarla">
                        <span style="font-size:.72rem; color:#9ca3af;">Si dejas este campo vacío, se mantendrá la contraseña actual.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn-save">
                        <span class="material-symbols-outlined">save</span>
                        Actualizar Datos
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, nombre, cedula, asignatura) {
            document.getElementById('editForm').action = `/docentes/${id}`;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_cedula').value = cedula;
            document.getElementById('edit_asignatura').value = asignatura;
            document.getElementById('editModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('editModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Cerrar al hacer clic fuera del modal
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        // Cerrar con ESC
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });
    </script>
</x-app-layout>
