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

        .graduated-tag { font-size: .75rem; color: #cca75b; font-weight: 700; display: flex; align-items: center; gap: 4px; justify-content: flex-end; }
        .graduated-tag .material-symbols-outlined { font-size: 15px; }
    </style>

    <div class="est-root">

        {{-- HERO --}}
        <div class="est-hero">
            <div class="est-hero-inner">
                <div class="est-badge">
                    <span class="material-symbols-outlined" style="font-size:13px;">manage_accounts</span>
                    Panel Administrativo
                </div>
                <h1 class="est-hero-title">Gestión de <span>Estudiantes</span></h1>
                <p class="est-hero-sub">Consulta el semestre actual de cada estudiante y promuévelo cuando corresponda.</p>

                <div class="stat-chips">
                    <div class="stat-chip">
                        <div class="chip-icon"><span class="material-symbols-outlined">groups</span></div>
                        <div>
                            <div class="chip-val">{{ $estudiantes->count() }}</div>
                            <div class="chip-lbl">Estudiantes totales</div>
                        </div>
                    </div>
                    <div class="stat-chip">
                        <div class="chip-icon"><span class="material-symbols-outlined">workspace_premium</span></div>
                        <div>
                            <div class="chip-val">{{ $estudiantes->where('semestre', 6)->count() }}</div>
                            <div class="chip-lbl">En último semestre</div>
                        </div>
                    </div>
                    <div class="stat-chip">
                        <div class="chip-icon"><span class="material-symbols-outlined">trending_up</span></div>
                        <div>
                            <div class="chip-val">{{ $estudiantes->whereNotNull('ultimo_cambio_semestre')->count() }}</div>
                            <div class="chip-lbl">Promovidos alguna vez</div>
                        </div>
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
                                    $semClass   = $semClasses[$estudiante->semestre] ?? 'sem-1';
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
                                        @if($estudiante->semestre < 6)
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
                                            <span class="graduated-tag">
                                                <span class="material-symbols-outlined">workspace_premium</span>
                                                Último semestre
                                            </span>
                                        @endif
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
</x-app-layout>
