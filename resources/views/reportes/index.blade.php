<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generación de Reportes y Bitácoras') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

        .rpt-root {
            font-family: 'Outfit', sans-serif;
            background: #f0f3f8;
            min-height: 100vh;
            padding-bottom: 3rem;
        }

        /* ── HERO ── */
        .rpt-hero {
            background: linear-gradient(135deg, #16213e 0%, #23325b 60%, #2a3d6e 100%);
            position: relative;
            overflow: hidden;
            padding: 2.5rem 1.5rem 5rem;
        }
        .rpt-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(204,167,91,.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .rpt-hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 30%;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(204,167,91,.10) 0%, transparent 70%);
            border-radius: 50%;
        }
        .rpt-hero-inner {
            max-width: 1100px; margin: 0 auto;
            position: relative; z-index: 1;
        }
        .rpt-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(204,167,91,.15);
            border: 1px solid rgba(204,167,91,.35);
            color: #cca75b;
            font-size: 11px; font-weight: 700;
            padding: 5px 14px; border-radius: 999px;
            margin-bottom: 1rem; letter-spacing: .06em; text-transform: uppercase;
        }
        .rpt-hero-title {
            font-size: clamp(1.5rem, 3.5vw, 2.1rem);
            font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: .4rem;
        }
        .rpt-hero-title span { color: #cca75b; }
        .rpt-hero-sub { color: #a0b0cc; font-size: .9rem; margin-top: .25rem; }

        /* ── MAIN WRAP ── */
        .rpt-main {
            max-width: 1100px;
            margin: -3rem auto 0;
            padding: 0 1.5rem;
            position: relative; z-index: 10;
        }

        /* ── WHITE CARD ── */
        .rpt-card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 8px 40px rgba(0,0,0,.08);
            border: 1.5px solid #e5e7eb;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .rpt-card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex; align-items: center; gap: 1rem;
        }
        .rpt-card-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #cca75b, #a07a2a);
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(204,167,91,.35);
        }
        .rpt-card-icon .material-symbols-outlined { color: #fff; font-size: 22px; }
        .rpt-card-icon.blue { background: linear-gradient(135deg, #23325b, #16213e); box-shadow: 0 4px 14px rgba(22,33,62,.3); }
        .rpt-card-icon.navy { background: linear-gradient(135deg, #2a4a8a, #1a3060); box-shadow: 0 4px 14px rgba(26,48,96,.3); }
        .rpt-card-header h3 { font-size: 1.1rem; font-weight: 700; color: #16213e; }
        .rpt-card-header p  { font-size: .8rem; color: #6b7280; margin-top: .15rem; }
        .rpt-card-body { padding: 2rem; }

        /* ── DATE GRID ── */
        .rpt-date-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;
        }
        @media(max-width:540px){ .rpt-date-grid { grid-template-columns: 1fr; } }

        .rpt-field label {
            display: block; font-size: .72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            color: #374151; margin-bottom: .5rem;
        }
        .rpt-input-wrap { position: relative; }
        .rpt-input-wrap .ico {
            position: absolute; left: .8rem; top: 50%; transform: translateY(-50%);
            color: #cca75b; font-size: 1.15rem; pointer-events: none;
        }
        .rpt-input-wrap input[type="date"],
        .rpt-input-wrap input[type="text"],
        .rpt-input-wrap select {
            width: 100%; padding: .75rem 1rem .75rem 2.7rem; box-sizing: border-box;
            border: 1.5px solid #e5e7eb; border-radius: 10px;
            font-size: .9rem; color: #16213e; background: #fff;
            transition: border-color .2s, box-shadow .2s;
            font-family: 'Outfit', sans-serif;
        }
        .rpt-input-wrap input:focus,
        .rpt-input-wrap select:focus {
            outline: none; border-color: #cca75b;
            box-shadow: 0 0 0 3px rgba(204,167,91,.15);
        }

        /* ── INFO BOX ── */
        .rpt-info {
            background: #eff6ff; border-left: 4px solid #3b82f6;
            border-radius: 0 10px 10px 0;
            padding: 1rem 1.2rem; margin-bottom: 1.5rem;
            display: flex; gap: .8rem;
        }
        .rpt-info .material-symbols-outlined { color: #3b82f6; font-size: 1.2rem; flex-shrink: 0; margin-top: .05rem; }
        .rpt-info p  { font-size: .82rem; color: #1d4ed8; font-weight: 600; margin: 0 0 .35rem; }
        .rpt-info ul { margin: 0; padding-left: 1.1rem; font-size: .78rem; color: #1e40af; line-height: 1.7; }
        .rpt-info ul li strong { color: #1d4ed8; }

        /* ── BUTTONS ── */
        .rpt-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: .8rem 2rem; border-radius: 12px; border: none; cursor: pointer;
            font-size: .9rem; font-weight: 800; font-family: 'Outfit', sans-serif;
            text-transform: uppercase; letter-spacing: .04em;
            transition: transform .15s, box-shadow .15s;
        }
        .rpt-btn-gold {
            background: linear-gradient(135deg, #cca75b, #a07a2a);
            color: #16213e;
            box-shadow: 0 4px 15px rgba(204,167,91,.4);
        }
        .rpt-btn-gold:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(204,167,91,.5); }
        .rpt-btn-navy {
            background: linear-gradient(135deg, #23325b, #16213e);
            color: #fff;
            box-shadow: 0 4px 15px rgba(22,33,62,.3);
        }
        .rpt-btn-navy:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(22,33,62,.4); }
        .rpt-btn .material-symbols-outlined { font-size: 20px; }

        /* ── TWO-COL GRID ── */
        .rpt-two-col {
            display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;
        }
        @media(max-width:700px){ .rpt-two-col { grid-template-columns: 1fr; } }

        /* ── SMALL FIELD GRID ── */
        .rpt-mini-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;
        }
        @media(max-width:440px){ .rpt-mini-grid { grid-template-columns: 1fr; } }
    </style>

    <div class="rpt-root">

        {{-- ── HERO ── --}}
        <div class="rpt-hero">
            <div class="rpt-hero-inner">
                <div class="rpt-badge">
                    <span class="material-symbols-outlined" style="font-size:13px;">insert_chart</span>
                    Centro de Reportes Oficiales
                </div>
                <h1 class="rpt-hero-title">Bitácoras &amp; <span>Reportes</span></h1>
                <p class="rpt-hero-sub">Genera documentos PDF oficiales con datos del taller mecánico, filtrados por periodo o estudiante.</p>
            </div>
        </div>

        {{-- ── MAIN CONTENT ── --}}
        <div class="rpt-main">

            {{-- REPORTE CONSOLIDADO --}}
            <div class="rpt-card">
                <div class="rpt-card-header">
                    <div class="rpt-card-icon">
                        <span class="material-symbols-outlined">analytics</span>
                    </div>
                    <div>
                        <h3>Reporte Consolidado por Periodo</h3>
                        <p>Seleccione el rango de fechas y descargue el Resumen Ejecutivo y la Bitácora de Actividad.</p>
                    </div>
                </div>
                <div class="rpt-card-body">
                    <form action="{{ route('reportes.consolidado') }}" method="POST">
                        @csrf
                        <div class="rpt-date-grid">
                            <div class="rpt-field">
                                <label for="fecha_inicio">Fecha de Inicio</label>
                                <div class="rpt-input-wrap">
                                    <span class="material-symbols-outlined ico">calendar_today</span>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio"
                                           value="{{ date('Y-04-01') }}" required>
                                </div>
                            </div>
                            <div class="rpt-field">
                                <label for="fecha_fin">Fecha de Fin</label>
                                <div class="rpt-input-wrap">
                                    <span class="material-symbols-outlined ico">event</span>
                                    <input type="date" name="fecha_fin" id="fecha_fin"
                                           value="{{ date('Y-09-30') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="rpt-info">
                            <span class="material-symbols-outlined">info</span>
                            <div>
                                <p>El reporte PDF incluirá automáticamente:</p>
                                <ul>
                                    <li><strong>Resumen Ejecutivo:</strong> Top 5 herramientas más solicitadas.</li>
                                    <li><strong>Reporte Cronológico:</strong> Detalle de cada petición registrada.</li>
                                    <li><strong>Filtro Dinámico:</strong> Solo peticiones entre las fechas seleccionadas.</li>
                                </ul>
                            </div>
                        </div>

                        <button type="submit" class="rpt-btn rpt-btn-gold" id="btn-consolidado">
                            <span class="material-symbols-outlined">picture_as_pdf</span>
                            Generar y Descargar PDF
                        </button>
                    </form>
                </div>
            </div>

            {{-- DOS COLUMNAS: INVENTARIO + HISTORIAL --}}
            <div class="rpt-two-col">

                {{-- REPORTE DE INVENTARIO --}}
                <div class="rpt-card" style="margin-bottom:0;">
                    <div class="rpt-card-header">
                        <div class="rpt-card-icon blue">
                            <span class="material-symbols-outlined">inventory</span>
                        </div>
                        <div>
                            <h3>Reporte de Inventario</h3>
                            <p>Estado técnico y ubicación actual de todas las herramientas.</p>
                        </div>
                    </div>
                    <div class="rpt-card-body">
                        <form action="{{ route('reportes.inventario') }}" method="POST">
                            @csrf
                            <p style="font-size:.85rem; color:#6b7280; margin-bottom:1.5rem; line-height:1.6;">
                                Descarga un listado completo con el estado actual de cada herramienta: disponible, prestada o en mantenimiento.
                            </p>
                            <button type="submit" class="rpt-btn rpt-btn-navy" id="btn-inventario">
                                <span class="material-symbols-outlined">download</span>
                                Descargar Estado Actual
                            </button>
                        </form>
                    </div>
                </div>

                {{-- HISTORIAL ESTUDIANTIL --}}
                <div class="rpt-card" style="margin-bottom:0;">
                    <div class="rpt-card-header">
                        <div class="rpt-card-icon navy">
                            <span class="material-symbols-outlined">history</span>
                        </div>
                        <div>
                            <h3>Historial de Préstamos</h3>
                            <p>Consulta por estudiante específico o por semestre.</p>
                        </div>
                    </div>
                    <div class="rpt-card-body">
                        <form action="{{ route('reportes.historial') }}" method="POST">
                            @csrf
                            <div class="rpt-mini-grid">
                                <div class="rpt-field">
                                    <label for="cedula">Cédula (Opcional)</label>
                                    <div class="rpt-input-wrap">
                                        <span class="material-symbols-outlined ico">fingerprint</span>
                                        <input type="text" name="cedula" id="cedula" placeholder="17...">
                                    </div>
                                </div>
                                <div class="rpt-field">
                                    <label for="semestre">Semestre</label>
                                    <div class="rpt-input-wrap">
                                        <span class="material-symbols-outlined ico">school</span>
                                        <select name="semestre" id="semestre">
                                            <option value="">Todos</option>
                                            <option value="1">Primero</option>
                                            <option value="2">Segundo</option>
                                            <option value="3">Tercero</option>
                                            <option value="4">Cuarto</option>
                                            <option value="5">Quinto</option>
                                            <option value="6">Sexto</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <p style="font-size:.78rem; color:#9ca3af; margin-bottom:1.2rem;">
                                Deja la cédula en blanco para obtener el historial de todos los estudiantes del semestre seleccionado.
                            </p>
                            <button type="submit" class="rpt-btn rpt-btn-navy" id="btn-historial">
                                <span class="material-symbols-outlined">search</span>
                                Generar Historial
                            </button>
                        </form>
                    </div>
                </div>

            </div>{{-- end two-col --}}

        </div>{{-- end rpt-main --}}
    </div>

    <script>
        // Loading feedback para cada botón
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('button[type="submit"]');
                if (btn) {
                    btn.style.opacity = '.7';
                    btn.style.pointerEvents = 'none';
                    const ico = btn.querySelector('.material-symbols-outlined');
                    if (ico) ico.textContent = 'autorenew';
                }
            });
        });
    </script>
</x-app-layout>
