<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Estudiantes') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

        .est-root { font-family: 'Outfit', sans-serif; background: #f0f3f8; min-height: 100vh; }

        /* ── HERO ── */
        .est-hero {
            background: linear-gradient(135deg, #16213e 0%, #23325b 60%, #2a3d6e 100%);
            padding: 2.5rem 1.5rem 5rem;
            position: relative;
            overflow: hidden;
        }
        .est-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -40px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(204,167,91,.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .est-hero-inner { max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; }
        .est-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(204,167,91,.15);
            border: 1px solid rgba(204,167,91,.35);
            color: #cca75b;
            font-size: 11px; font-weight: 700; padding: 4px 14px;
            border-radius: 999px; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 1rem;
        }
        .est-hero-title { font-size: clamp(1.5rem, 3.5vw, 2rem); font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: .4rem; }
        .est-hero-title span { color: #cca75b; }
        .est-hero-sub { color: #a0b0cc; font-size: .9rem; }

        /* ── STAT CHIPS ── */
        .stat-chips { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1.5rem; }
        .stat-chip {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(204,167,91,.2);
            border-radius: 14px; padding: .8rem 1.2rem;
            display: flex; align-items: center; gap: .6rem;
        }
        .stat-chip .chip-icon {
            width: 36px; height: 36px;
            background: rgba(204,167,91,.18);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .stat-chip .chip-icon .material-symbols-outlined { color: #cca75b; font-size: 18px; }
        .stat-chip .chip-val { font-size: 1.4rem; font-weight: 800; color: #fff; line-height: 1; }
        .stat-chip .chip-lbl { font-size: .7rem; color: #a0b0cc; font-weight: 500; margin-top: 2px; }

        /* ── MAIN ── */
        .main-content {
            max-width: 1200px;
            margin: -3rem auto 0;
            padding: 0 1.5rem 3rem;
            position: relative;
            z-index: 10;
        }
        .table-card { background: #fff; border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,.10); overflow: hidden; }

        /* ── FLASH ── */
        .flash-ok { background: #d1fae5; border-left: 4px solid #10b981; color: #065f46; padding: .9rem 1.25rem; border-radius: 12px; margin-bottom: 1.25rem; font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: .5rem; }
        .flash-err { background: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: .9rem 1.25rem; border-radius: 12px; margin-bottom: 1.25rem; font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: .5rem; }

        /* ── TABLE ── */
        .students-table { width: 100%; border-collapse: collapse; }
        .students-table thead tr { background: #f5f7fb; border-bottom: 2px solid #e5e7eb; }
        .students-table thead th { padding: 1rem 1.25rem; font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #6b7280; text-align: left; white-space: nowrap; }
        .students-table thead th.right { text-align: right; }
        .students-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
        .students-table tbody tr:last-child { border-bottom: none; }
        .students-table tbody tr:hover { background: #f8f9fd; }
        .students-table td { padding: 1rem 1.25rem; vertical-align: middle; }

        /* ── AVATAR ── */
        .student-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, #23325b, #16213e);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .85rem; color: #cca75b; flex-shrink: 0;
        }
        .student-name-cell { display: flex; align-items: center; gap: .75rem; }
        .student-name { font-weight: 600; color: #16213e; font-size: .9rem; }

        /* ── SEMESTRE BADGE ── */
        .sem-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 999px; font-size: .72rem; font-weight: 700; letter-spacing: .04em; }
        .sem-1 { background: #e0f2fe; color: #0369a1; }
        .sem-2 { background: #d1fae5; color: #065f46; }
        .sem-3 { background: #fef3c7; color: #92400e; }
        .sem-4 { background: #ede9fe; color: #5b21b6; }
        .sem-5 { background: #fce7f3; color: #9d174d; }
        .sem-6 { background: linear-gradient(90deg,#cca75b,#a07a2a); color: #fff; }

        .date-cell { font-size: .8rem; color: #9ca3af; display: flex; align-items: center; gap: 4px; }
        .date-cell .material-symbols-outlined { font-size: 14px; color: #d1d5db; }

        /* ── BUTTONS ── */
        .btn-promote {
            display: inline-flex; align-items: center; gap: 5px;
            background: linear-gradient(135deg, #cca75b, #a07a2a);
            color: #16213e; font-size: .78rem; font-weight: 800;
            padding: .45rem 1rem; border-radius: 10px; border: none; cursor: pointer;
            transition: transform .15s, box-shadow .15s;
            box-shadow: 0 2px 8px rgba(204,167,91,.35);
        }
        .btn-promote:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(204,167,91,.45); }
        .btn-promote .material-symbols-outlined { font-size: 15px; }

        .action-btn {
            width: 34px; height: 34px; border-radius: 10px; border: none;
            display: inline-flex; align-items: center; justify-content: center;
            cursor: pointer; transition: background .15s, transform .15s;
        }
        .action-btn:hover { transform: translateY(-1px); }
        .action-btn.edit { background: #fdf8ee; color: #a07a2a; }
        .action-btn.edit:hover { background: #fdf0d0; }
        .action-btn.demote { background: #fef2f2; color: #ef4444; }
        .action-btn.demote:hover { background: #fee2e2; }

        .graduated-tag { font-size: .75rem; color: #cca75b; font-weight: 700; display: flex; align-items: center; gap: 4px; justify-content: flex-end; }
        .graduated-tag .material-symbols-outlined { font-size: 15px; }

        /* ── MODAL PREMIUM ── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 999;
            background: rgba(10,14,30,.72); backdrop-filter: blur(8px);
            display: flex; align-items: flex-start; justify-content: center;
            padding: 1.5rem 1rem;
            overflow-y: auto;
            opacity: 0; pointer-events: none;
            transition: opacity .3s ease;
        }
        .modal-overlay.active { opacity: 1; pointer-events: all; }
        .modal-box {
            background: #fff; border-radius: 28px; width: 100%; max-width: 520px;
            box-shadow: 0 40px 100px rgba(0,0,0,.35), 0 0 0 1px rgba(255,255,255,.05);
            transform: translateY(28px) scale(.96);
            transition: transform .35s cubic-bezier(0.34, 1.56, 0.64, 1), opacity .3s ease;
            overflow: hidden; display: flex; flex-direction: column;
            margin: auto;
        }
        .modal-overlay.active .modal-box { transform: translateY(0) scale(1); }

        /* Header */
        .modal-top {
            background: linear-gradient(135deg, #0f1629 0%, #16213e 50%, #1e2d52 100%);
            padding: 1.6rem 1.75rem;
            display: flex; align-items: center; gap: .9rem;
            flex-shrink: 0;
            border-bottom: 1px solid rgba(204,167,91,.15);
        }
        .modal-icon {
            width: 48px; height: 48px; flex-shrink: 0;
            background: linear-gradient(135deg, rgba(204,167,91,.25), rgba(204,167,91,.1));
            border: 1px solid rgba(204,167,91,.3);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
        }
        .modal-icon .material-symbols-outlined { color: #cca75b; font-size: 24px; }
        .modal-top-text { flex: 1; min-width: 0; }
        .modal-top h3 { color: #fff; font-size: 1.1rem; font-weight: 800; margin: 0; letter-spacing: -.01em; }
        .modal-top p { color: #7a92b8; font-size: .78rem; margin: .2rem 0 0; }
        .modal-close {
            flex-shrink: 0; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
            width: 34px; height: 34px; border-radius: 10px; color: #a0b0cc;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: background .2s, color .2s;
        }
        .modal-close:hover { background: rgba(255,255,255,.16); color: #fff; }
        .modal-close .material-symbols-outlined { font-size: 18px; }

        /* Body */
        .modal-body {
            padding: 1.5rem 1.75rem; display: flex; flex-direction: column; gap: .85rem;
            overflow-y: auto;
            flex: 1;
            max-height: calc(100vh - 280px);
        }
        .modal-section-title {
            font-size: .68rem; font-weight: 700; color: #9ca3af;
            text-transform: uppercase; letter-spacing: .1em;
            display: flex; align-items: center; gap: .4rem;
            padding-bottom: .5rem; border-bottom: 1px solid #f1f5f9;
            margin-bottom: .25rem;
        }
        .modal-section-title .material-symbols-outlined { font-size: 14px; color: #cca75b; }
        .modal-row { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; }
        @media (max-width: 480px) { .modal-row { grid-template-columns: 1fr; } }

        /* Fields */
        .field-group { display: flex; flex-direction: column; gap: .35rem; }
        .field-label {
            font-size: .72rem; font-weight: 700; color: #374151;
            text-transform: uppercase; letter-spacing: .06em;
            display: flex; align-items: center; gap: .3rem;
        }
        .field-label .material-symbols-outlined { font-size: 13px; color: #cca75b; }
        .field-input {
            border: 1.5px solid #e5e7eb; border-radius: 12px;
            padding: .75rem 1rem; font-family: 'Outfit', sans-serif; font-size: .9rem;
            color: #111827; background: #fafafa; transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none; width: 100%;
        }
        .field-input:focus {
            border-color: #cca75b; box-shadow: 0 0 0 3px rgba(204,167,91,.15);
            background: #fff;
        }
        .field-input::placeholder { color: #c4cdd9; }
        .field-hint { font-size: .71rem; color: #9ca3af; line-height: 1.4; margin-top: .15rem; }
        .field-hint.warning { color: #d97706; }

        /* Password toggle */
        .input-wrapper { position: relative; }
        .input-wrapper .field-input { padding-right: 2.8rem; }
        .pass-toggle {
            position: absolute; right: .8rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #9ca3af;
            display: flex; align-items: center; transition: color .15s;
            padding: 0;
        }
        .pass-toggle:hover { color: #cca75b; }
        .pass-toggle .material-symbols-outlined { font-size: 18px; }

        /* Footer */
        .modal-footer {
            padding: 1rem 1.75rem 1.5rem;
            display: flex; gap: .75rem; justify-content: flex-end;
            border-top: 1px solid #f1f5f9; flex-shrink: 0;
            background: #fafbfc;
        }
        .btn-cancel {
            background: #f3f4f6; color: #6b7280; border: 1.5px solid #e5e7eb;
            padding: .65rem 1.4rem; border-radius: 10px;
            font-family: 'Outfit', sans-serif; font-weight: 700; font-size: .85rem;
            cursor: pointer; transition: background .15s, border-color .15s;
        }
        .btn-cancel:hover { background: #e5e7eb; border-color: #d1d5db; }
        .btn-save {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #cca75b, #a07a2a);
            color: #0f1629; border: none; padding: .65rem 1.6rem;
            border-radius: 10px; font-family: 'Outfit', sans-serif;
            font-weight: 800; font-size: .85rem; cursor: pointer;
            transition: transform .15s, box-shadow .15s;
            box-shadow: 0 4px 16px rgba(204,167,91,.4);
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(204,167,91,.5); }
        .btn-save:active { transform: translateY(0); }
        .btn-save .material-symbols-outlined { font-size: 17px; }
    </style>

    <div class="est-root">

        {{-- HERO --}}
        <div class="est-hero">
            <div class="est-hero-inner">
                <div class="est-badge">
                    <span class="material-symbols-outlined" style="font-size:13px;">manage_accounts</span>
                    Panel de Coordinación
                </div>
                <h1 class="est-hero-title">Gestión de <span>Estudiantes</span></h1>
                <p class="est-hero-sub">Consulta el semestre actual de cada estudiante y promuévelo cuando corresponda.</p>

                <div class="stat-chips">
                    <div class="stat-chip">
                        <div class="chip-icon"><span class="material-symbols-outlined">groups</span></div>
                        <div>
                            <div class="chip-val">{{ $allEstudiantes->count() }}</div>
                            <div class="chip-lbl">Estudiantes totales</div>
                        </div>
                    </div>
                    <div class="stat-chip">
                        <div class="chip-icon"><span class="material-symbols-outlined">workspace_premium</span></div>
                        <div>
                            @php $maxSemestre = $allEstudiantes->max('semestre') ?? 1; @endphp
                            <div class="chip-val">{{ $allEstudiantes->where('semestre', $maxSemestre)->count() }}</div>
                            <div class="chip-lbl">En último semestre ({{ $maxSemestre }}°)</div>
                        </div>
                    </div>
                    <div class="stat-chip">
                        <div class="chip-icon"><span class="material-symbols-outlined">trending_up</span></div>
                        <div>
                            <div class="chip-val">{{ $allEstudiantes->whereNotNull('ultimo_cambio_semestre')->count() }}</div>
                            <div class="chip-lbl">Promovidos alguna vez</div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <h3 style="font-weight: 700; color: #ffffff; font-size: 1.1rem; margin: 0;">Lista de Estudiantes Registrados</h3>
                    
                    <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                        <form method="POST" action="{{ route('usuarios.promover_todos') }}">
                            @csrf
                            @if(request('semestre'))
                                <input type="hidden" name="semestre" value="{{ request('semestre') }}">
                            @endif
                            <button type="submit" 
                                    onclick="return confirm('¿Promover a TODOS los estudiantes listados al siguiente semestre?')"
                                    style="display: flex; align-items: center; gap: 0.5rem; background-color: #10b981; color: white; padding: 0.4rem 1.25rem; border-radius: 9999px; font-weight: 600; font-size: 0.85rem; box-shadow: 0 1px 3px rgba(0,0,0,0.2); transition: all 0.2s; border: none; cursor: pointer;"
                                    onmouseover="this.style.backgroundColor='#059669'" 
                                    onmouseout="this.style.backgroundColor='#10b981'"
                                    title="Avanzar de semestre a todos los estudiantes de esta lista">
                                <span class="material-symbols-outlined" style="font-size: 1.1rem;">upgrade</span>
                                Promover Todos
                            </button>
                        </form>

                        <form method="POST" action="{{ route('usuarios.retroceder_todos') }}">
                            @csrf
                            @if(request('semestre'))
                                <input type="hidden" name="semestre" value="{{ request('semestre') }}">
                            @endif
                            <button type="submit" 
                                    onclick="return confirm('ATENCIÓN: ¿Estás seguro de que deseas RETROCEDER a todos los estudiantes listados al semestre anterior?')"
                                    style="display: flex; align-items: center; gap: 0.5rem; background-color: #ef4444; color: white; padding: 0.4rem 1.25rem; border-radius: 9999px; font-weight: 600; font-size: 0.85rem; box-shadow: 0 1px 3px rgba(0,0,0,0.2); transition: all 0.2s; border: none; cursor: pointer;"
                                    onmouseover="this.style.backgroundColor='#dc2626'" 
                                    onmouseout="this.style.backgroundColor='#ef4444'"
                                    title="Retroceder de semestre a todos los estudiantes de esta lista (deshacer promoción)">
                                <span class="material-symbols-outlined" style="font-size: 1.1rem;">history</span>
                                Retroceder Todos
                            </button>
                        </form>

                        <form method="GET" action="{{ route('usuarios.index') }}" style="display: flex; gap: 0.75rem; align-items: center; background: rgba(255,255,255,0.1); padding: 0.25rem 0.25rem 0.25rem 1rem; border-radius: 9999px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);">
                            <span class="material-symbols-outlined" style="font-size: 1.2rem; color: #d1d5db;">filter_list</span>
                            <label for="filtro_semestre" style="font-size: 0.85rem; color: #f3f4f6; font-weight: 600; white-space: nowrap;">Filtrar:</label>
                            <select name="semestre" id="filtro_semestre" onchange="this.form.submit()" style="padding: 0.4rem 2.5rem 0.4rem 1rem; border-radius: 9999px; border: none; background-color: white; font-size: 0.9rem; color: #1f2937; outline: none; cursor: pointer; transition: all 0.2s;">
                                <option value="">Todos los Semestres</option>
                                @foreach($semestresDisponibles as $sem)
                                    <option value="{{ $sem }}" {{ request('semestre') == $sem ? 'selected' : '' }}>{{ $sem }}° Semestre</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="main-content">

            @if (session('success'))
                <div class="flash-ok">
                    <span class="material-symbols-outlined">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="flash-err">
                    <span class="material-symbols-outlined">error</span>
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-card">
                <div class="overflow-x-auto">
                    <table class="students-table">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>Cédula</th>
                                <th>Semestre</th>
                                <th>Última Promoción</th>
                                <th class="right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($estudiantes as $estudiante)
                                @php
                                    $semClasses = ['','sem-1','sem-2','sem-3','sem-4','sem-5','sem-6'];
                                    // Si es mayor a 6, recicla los colores usando módulo
                                    $semClass   = $semClasses[$estudiante->semestre > 6 ? (($estudiante->semestre - 1) % 6) + 1 : $estudiante->semestre] ?? 'sem-1';
                                    $initials   = collect(explode(' ', $estudiante->nombre))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->join('');
                                @endphp
                                <tr>
                                    <td>
                                        <div class="student-name-cell">
                                            <div class="student-avatar">{{ $initials }}</div>
                                            <span class="student-name">{{ $estudiante->nombre }}</span>
                                        </div>
                                    </td>
                                    <td><span style="font-size:.85rem;color:#6b7280;font-family:monospace;">{{ $estudiante->cedula }}</span></td>
                                    <td>
                                        <span class="sem-badge {{ $semClass }}">
                                            <span class="material-symbols-outlined" style="font-size:13px;">school</span>
                                            {{ $estudiante->semestre }}° Semestre
                                        </span>
                                    </td>
                                    <td>
                                        <div class="date-cell">
                                            <span class="material-symbols-outlined">calendar_today</span>
                                            {{ $estudiante->ultimo_cambio_semestre ? $estudiante->ultimo_cambio_semestre->format('d/m/Y H:i') : 'Sin cambios aún' }}
                                        </div>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:.5rem;">
                                            <button type="button" 
                                                onclick="openEditModal({{ $estudiante->id }}, '{{ $estudiante->nombre }}', '{{ $estudiante->cedula }}', {{ $estudiante->semestre }}, '{{ $estudiante->email }}')"
                                                class="action-btn edit" title="Editar Estudiante">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                            
                                            <form action="{{ route('usuarios.retroceder', $estudiante) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                    onclick="return confirm('ATENCIÓN: ¿Retroceder a {{ $estudiante->nombre }} al semestre anterior?')"
                                                    class="action-btn demote" title="Retroceder Estudiante">
                                                    <span class="material-symbols-outlined">history</span>
                                                </button>
                                            </form>

                                                @if ($estudiante->semestre < 4)
                                                    <form action="{{ route('usuarios.promover', $estudiante) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            onclick="return confirm('¿Promover a {{ $estudiante->nombre }} al semestre {{ $estudiante->semestre + 1 }}?')"
                                                            class="btn-promote">
                                                            <span class="material-symbols-outlined">trending_up</span>
                                                            Promover
                                                        </button>
                                                    </form>
                                                @else
                                                    <span style="font-size:.7rem; color:#9ca3af; padding:.45rem 1rem; border-radius:10px; background:rgba(0,0,0,.03); font-weight:600; display:inline-flex; align-items:center; gap:5px;">
                                                        <span class="material-symbols-outlined" style="font-size:15px;">done_all</span>
                                                        Límite
                                                    </span>
                                                @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding:3rem;text-align:center;color:#9ca3af;">
                                        <span class="material-symbols-outlined" style="font-size:2.5rem;color:#e5e7eb;display:block;margin-bottom:.5rem;">group_off</span>
                                        No hay estudiantes registrados todavía.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDICIÓN --}}
    <div id="editModal" class="modal-overlay">
        <div class="modal-box">
            <!-- Header -->
            <div class="modal-top">
                <div class="modal-icon">
                    <span class="material-symbols-outlined">edit_note</span>
                </div>
                <div class="modal-top-text">
                    <h3>Editar Estudiante</h3>
                    <p>Actualiza la información del estudiante</p>
                </div>
                <button class="modal-close" onclick="closeModal()" title="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <!-- Sección: Datos personales -->
                    <div class="modal-section-title">
                        <span class="material-symbols-outlined">person</span>
                        Datos personales
                    </div>
                    <div class="modal-row">
                        <div class="field-group" style="grid-column: 1 / -1;">
                            <label class="field-label">
                                <span class="material-symbols-outlined">badge</span>
                                Nombre Completo
                            </label>
                            <input type="text" name="nombre" id="edit_nombre" class="field-input"
                                   placeholder="Nombre y apellido completo" required>
                        </div>
                        <div class="field-group">
                            <label class="field-label">
                                <span class="material-symbols-outlined">id_card</span>
                                Cédula
                            </label>
                            <input type="text" name="cedula" id="edit_cedula" class="field-input"
                                   placeholder="10 dígitos" maxlength="10" required>
                        </div>
                        <div class="field-group">
                            <label class="field-label">
                                <span class="material-symbols-outlined">school</span>
                                Semestre
                            </label>
                            <input type="number" name="semestre" id="edit_semestre" class="field-input"
                                   min="1" max="4" placeholder="Ej. 4" required>
                        </div>
                    </div>

                    <!-- Sección: Contacto -->
                    <div class="modal-section-title">
                        <span class="material-symbols-outlined">mail</span>
                        Contacto
                    </div>
                    <div class="field-group">
                        <label class="field-label">
                            <span class="material-symbols-outlined">alternate_email</span>
                            Correo Electrónico
                        </label>
                        <input type="email" name="email" id="edit_email" class="field-input"
                               placeholder="estudiante@ejemplo.com">
                        <span class="field-hint">Utilizado para restablecer la contraseña del estudiante.</span>
                    </div>

                    <!-- Sección: Seguridad -->
                    <div class="modal-section-title">
                        <span class="material-symbols-outlined">lock</span>
                        Seguridad
                    </div>
                    <div class="field-group">
                        <label class="field-label">
                            <span class="material-symbols-outlined">key</span>
                            Nueva Contraseña <span style="font-weight:500;color:#9ca3af;text-transform:none;letter-spacing:0;">(opcional)</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="password" name="password" id="edit_password" class="field-input"
                                   placeholder="Dejar en blanco para mantener la actual">
                            <button type="button" class="pass-toggle" onclick="togglePass('edit_password', this)" tabindex="-1">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </div>
                        <span class="field-hint warning">
                            <span style="font-size:12px;">⚠</span> Si dejas este campo vacío, se conservará la contraseña actual.
                        </span>
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
        function openEditModal(id, nombre, cedula, semestre, email) {
            document.getElementById('editForm').action = `/usuarios/${id}`;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_cedula').value = cedula;
            document.getElementById('edit_semestre').value = semestre;
            document.getElementById('edit_email').value = email || '';
            document.getElementById('edit_password').value = '';
            document.getElementById('editModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('edit_nombre').focus(), 150);
        }

        function closeModal() {
            document.getElementById('editModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function togglePass(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon  = btn.querySelector('.material-symbols-outlined');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });
    </script>
</x-app-layout>
