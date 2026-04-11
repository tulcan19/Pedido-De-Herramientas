<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ Auth::user()->esAdmin() ? __('Panel General del Taller') : __('Panel del Estudiante') }}
            </h2>
            @if(!Auth::user()->esAdmin())
                <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg" style="color:#cca75b;">school</span>
                    <span class="font-bold truncate max-w-[200px]" style="color:#23325b;">{{ Auth::user()->nombre }}</span>
                </div>
            @endif
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

        .dashboard-root {
            font-family: 'Outfit', sans-serif;
            background: #f0f3f8;
            min-height: 100vh;
        }

        /* ── HERO ── */
        .hero-section {
            background: linear-gradient(135deg, #16213e 0%, #23325b 60%, #2a3d6e 100%);
            position: relative;
            overflow: hidden;
            padding: 2.5rem 1.5rem 5rem;
        }
        @media (max-width: 640px) {
            .hero-section { padding: 1.5rem 1rem 4rem; }
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(204,167,91,.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 25%;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(204,167,91,.10) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(204,167,91,.15);
            border: 1px solid rgba(204,167,91,.35);
            color: #cca75b;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 999px;
            margin-bottom: 0.8rem;
            letter-spacing: .06em;
            text-transform: uppercase;
        }
        .hero-title {
            font-size: clamp(1.4rem, 5vw, 2.2rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: .5rem;
        }
        .hero-title span { color: #cca75b; }
        .hero-sub { 
            color: #a0b0cc; 
            font-size: clamp(0.8rem, 2.5vw, 0.92rem); 
            margin-top: .25rem;
            max-width: 600px;
        }
        .hero-time {
            color: #8899bb;
            font-size: .75rem;
            margin-top: 0.6rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1rem;
            position: relative;
            z-index: 10;
            margin-top: -2.5rem;
            padding: 0 1rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        @media (min-width: 640px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); margin-top: -3rem; padding: 0 1.5rem; }
        }
        @media (min-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(3, 1fr); }
        }

        .stat-card {
            border-radius: 20px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,.15);
            transition: transform .2s ease, box-shadow .2s ease;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0,0,0,.2);
        }
        .stat-card.gold   { background: linear-gradient(135deg, #c9a24a, #a07a2a); }
        .stat-card.navy   { background: linear-gradient(135deg, #23325b, #16213e); }
        .stat-card.accent { background: linear-gradient(135deg, #2a4a8a, #1a3060); }
        
        .stat-card .stat-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,.15);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 0.6rem;
        }
        .stat-card .stat-icon .material-symbols-outlined { color: #fff; font-size: 20px; }
        
        .stat-card .stat-label {
            color: rgba(255,255,255,.75);
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: .2rem;
        }
        .stat-card .stat-number { 
            font-size: clamp(2rem, 6vw, 2.5rem); 
            font-weight: 800; 
            color: #fff; 
            line-height: 1; 
        }
        .stat-card .stat-desc { 
            font-size: .75rem; 
            color: rgba(255,255,255,.65); 
            margin-top: .2rem; 
        }
        .stat-card .stat-shine {
            position: absolute;
            top: -20px; right: -15px;
            width: 100px; height: 100px;
            background: rgba(255,255,255,.05);
            border-radius: 50%;
        }

        /* ── MAIN CONTENT ── */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 1rem;
        }
        @media (min-width: 640px) {
            .main-content { padding: 2rem 1.5rem; }
        }

        /* ── CTA CARD ── */
        .cta-card {
            background: linear-gradient(135deg, #23325b, #16213e);
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 1.25rem;
            box-shadow: 0 12px 30px rgba(22,33,62,.3);
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
            border: 1px solid rgba(204,167,91,.2);
        }
        @media (min-width: 768px) {
            .cta-card { padding: 2rem 2.5rem; flex-direction: row; text-align: left; }
        }
        .cta-card::after {
            content: '';
            position: absolute;
            right: -30px; top: -30px;
            width: 180px; height: 180px;
            background: rgba(204,167,91,.07);
            border-radius: 50%;
        }
        .cta-card-icon {
            width: 54px; height: 54px;
            background: rgba(204,167,91,.15);
            border-radius: 14px;
            flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .cta-card-icon .material-symbols-outlined { color: #cca75b; font-size: 26px; }
        .cta-info h3 { color: #fff; font-size: 1.1rem; font-weight: 700; margin-bottom: .2rem; }
        .cta-info p  { color: #a0b0cc; font-size: .85rem; }
        .cta-btn {
            background: linear-gradient(135deg, #cca75b, #a07a2a);
            color: #16213e;
            font-weight: 800;
            font-size: .85rem;
            padding: .7rem 1.75rem;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            transition: all .2s;
            box-shadow: 0 4px 12px rgba(204,167,91,.3);
            width: 100%;
            justify-content: center;
        }
        @media (min-width: 768px) {
            .cta-btn { width: auto; }
        }
        .cta-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(204,167,91,.4); }

        /* ── SECTION HEADER ── */
        .section-header { 
            display: flex; 
            flex-direction: column; 
            gap: 0.5rem; 
            margin-bottom: 1.25rem; 
        }
        @media (min-width: 640px) {
            .section-header { flex-direction: row; align-items: center; justify-content: space-between; }
        }
        .section-title { font-size: 1rem; font-weight: 700; color: #16213e; display: flex; align-items: center; gap: 8px; }
        .section-title .material-symbols-outlined { color: #cca75b; font-size: 20px; }
        .section-link { font-size: .8rem; font-weight: 600; color: #23325b; text-decoration: none; }

        /* ── TOOL CARDS ── */
        .tools-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1rem;
        }
        @media (max-width: 400px) {
            .tools-grid { grid-template-columns: 1fr; }
        }
        .tool-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            border: 1px solid #e5e7eb;
            transition: transform .2s ease;
            display: flex;
            flex-direction: column;
        }
        .tool-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,.08); }
        .tool-card.alert { border-color: #fecaca; }
        .tool-card-img {
            height: 140px;
            background: #f8fafc;
            display: flex; align-items: center; justify-content: center;
            position: relative;
            padding: 1rem;
        }
        .tool-card-img img { max-height: 100%; max-width: 100%; object-fit: contain; }
        .tool-card-img .qr-badge {
            position: absolute;
            top: 10px; right: 10px;
            background: rgba(255,255,255,0.9);
            border: 1px solid #e5e7eb;
            font-size: 9px; font-weight: 700; color: #374151;
            padding: 3px 8px; border-radius: 6px; backdrop-filter: blur(4px);
        }
        .tool-card-body { padding: 1.2rem; flex: 1; display: flex; flex-direction: column; }
        .tool-card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: .4rem; gap: .5rem; }
        .tool-name { font-size: .92rem; font-weight: 700; color: #16213e; overflow: hidden; text-overflow: ellipsis; }
        .tool-status {
            font-size: 9px; font-weight: 700; text-transform: uppercase;
            padding: 2px 8px; border-radius: 999px; white-space: nowrap;
        }
        .tool-status.reservado { background: #ede9fe; color: #6d28d9; }
        .tool-status.prestado  { background: #dbeafe; color: #1d4ed8; }
        .tool-status.atrasado  { background: #fee2e2; color: #b91c1c; }
        .tool-desc { font-size: .75rem; color: #6b7280; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        
        .tool-timer-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: .6rem; }
        .tool-timer-label { font-size: .75rem; color: #9ca3af; font-weight: 500; }
        .tool-timer-pill { font-size: .75rem; font-weight: 700; border-radius: 999px; padding: 2px 10px; }
        .tool-timer-pill.ok  { background: #d1fae5; color: #065f46; }
        .tool-timer-pill.bad { background: #fee2e2; color: #991b1b; }
        .progress-bar-track { background: #f1f5f9; border-radius: 999px; height: 5px; overflow: hidden; }
        .progress-bar-fill { height: 5px; border-radius: 999px; transition: width .6s ease; }
        .progress-bar-fill.ok  { background: #10b981; }
        .progress-bar-fill.bad { background: #ef4444; }

        .empty-state { background: #fff; border-radius: 20px; border: 2px dashed #e5e7eb; padding: 3.5rem 1.5rem; text-align: center; }
        .empty-state .material-symbols-outlined { font-size: 2.5rem; color: #d1d5db; margin-bottom: 1rem; }
        .empty-state h4 { font-size: 1rem; font-weight: 600; color: #6b7280; }
        .empty-state p  { font-size: .85rem; color: #9ca3af; margin-top: .5rem; }
    </style>

    <div class="dashboard-root">

        {{-- HERO --}}
        <div class="hero-section">
            <div style="max-width:1200px;margin:0 auto;position:relative;z-index:1;">
                <div class="hero-badge">
                    <span class="material-symbols-outlined" style="font-size:13px;">verified</span>
                    ISTPET Traversari · Taller Mecánico
                </div>
                <h1 class="hero-title">
                    Bienvenido, <span>{{ Str::words(Auth::user()->nombre, 1, '') }}</span> 
                </h1>
                <p class="hero-sub">
                    {{ Auth::user()->esAdmin()
                        ? 'Vista general de todas las herramientas del taller'
                        : 'Revisa el estado de tus préstamos y accede al catálogo' }}
                </p>
                <p class="hero-time">
                    <span class="material-symbols-outlined" style="font-size:14px;">schedule</span>
                    {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </p>
            </div>
        </div>

        {{-- STAT CARDS --}}
        <div class="stats-grid">
            <div class="stat-card gold">
                <div class="stat-shine"></div>
                <div class="stat-icon"><span class="material-symbols-outlined">build</span></div>
                <div class="stat-label">Herramientas en uso</div>
                <div class="stat-number">{{ $prestamos->count() }}</div>
                <div class="stat-desc">prestadas actualmente</div>
            </div>
            <div class="stat-card navy">
                <div class="stat-shine"></div>
                <div class="stat-icon"><span class="material-symbols-outlined">warning</span></div>
                <div class="stat-label">Próximas a vencer</div>
                <div class="stat-number">{{ $alertas }}</div>
                <div class="stat-desc">requieren atención</div>
            </div>
            <div class="stat-card accent">
                <div class="stat-shine"></div>
                <div class="stat-icon"><span class="material-symbols-outlined">history</span></div>
                <div class="stat-label">Total préstamos</div>
                <div class="stat-number">{{ $prestamosTotales }}</div>
                <div class="stat-desc">registrados en total</div>
            </div>
        </div>

        {{-- MAIN --}}
        <div class="main-content">

            {{-- CTA --}}
            <div class="cta-card">
                <div class="cta-card-icon">
                    <span class="material-symbols-outlined">qr_code_scanner</span>
                </div>
                <div class="cta-info" style="flex:1;">
                    <h3>¿Necesitas una herramienta?</h3>
                    <p>Explora el catálogo completo o escanea el código QR para reservar al instante.</p>
                </div>
                <a href="{{ route('herramientas.index') }}" class="cta-btn">
                    <span class="material-symbols-outlined">storefront</span>
                    Ver catálogo
                </a>
            </div>

            {{-- Peticiones Pendientes --}}
            @if($peticiones->count() > 0)
            <div style="margin-bottom: 2.5rem;">
                <div class="section-header">
                    <div class="section-title">
                        <span class="material-symbols-outlined">assignment_ind</span>
                        {{ Auth::user()->esAdmin() ? 'Peticiones en Ventanilla' : 'Tus Solicitudes en Espera' }}
                    </div>
                </div>

                <div class="tools-grid">
                    @foreach($peticiones as $peticion)
                        <div class="tool-card" style="border: 2px solid #cca75b;">
                            <div class="tool-card-body" style="background:#fdf8ee;">
                                <div class="tool-card-top mb-1">
                                    <div class="tool-name">Doc. Petición #{{ str_pad($peticion->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    <span class="tool-status" style="background:#fef08a; color:#854d0e;">En Ventanilla</span>
                                </div>
                                <div class="text-xs mb-1"><span class="font-bold text-[#16213e]">Estudiante:</span> {{ $peticion->usuario->nombre }}</div>
                                <div class="text-xs mb-1"><span class="font-bold text-[#16213e]">Práctica:</span> {{ Str::limit($peticion->practica, 30) }}</div>
                                <div class="text-[11px] mb-3 text-gray-500 font-bold flex items-center justify-between border-t border-gray-200 pt-2 mt-2">
                                    <span>{{ $peticion->prestamos->count() }} herramientas solicitadas</span>
                                </div>
                                
                                @if(Auth::user()->esAdmin() && $peticion->estado == 'enviado')
                                    <div class="flex gap-2">
                                        <a href="{{ route('reportes.peticion', $peticion) }}" class="flex-shrink-0 p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors shadow-sm flex items-center justify-center" title="Descargar Formato PDF">
                                            <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                        </a>
                                        <a href="{{ route('peticiones.entrega', $peticion) }}" class="w-full text-[11px] uppercase tracking-wider font-bold py-2 bg-[#23325b] text-white rounded-lg hover:bg-[#16213e] transition-colors shadow-md flex justify-center items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">touch_app</span> Entregar a Estudiante
                                        </a>
                                    </div>
                                @endif
                                @if(!Auth::user()->esAdmin())
                                    <div class="mt-auto w-full text-center text-[11px] text-gray-500 italic py-2">Acércate a ventanilla para recibirlas.</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Herramientas activas --}}
            <div>
                <div class="section-header">
                    <div class="section-title">
                        <span class="material-symbols-outlined">inventory_2</span>
                        {{ Auth::user()->esAdmin() ? 'Herramientas Prestadas (General)' : 'Mis Herramientas Activas' }}
                    </div>
                    <a href="#" class="section-link">Ver historial completo →</a>
                </div>

                <div class="tools-grid">
                    @forelse($prestamos as $prestamo)
                        @php
                            $diff = now()->diff($prestamo->fecha_devolucion_esperada, false);
                            $minsTotales = $diff->invert ? 0 : ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
                            $labelTiempo = '';
                            
                            if ($diff->invert) {
                                $labelTiempo = 'Expirado';
                            } elseif ($diff->h > 0 || $diff->days > 0) {
                                $horas = ($diff->days * 24) + $diff->h;
                                $labelTiempo = $horas . 'h ' . $diff->i . 'm';
                            } else {
                                $labelTiempo = $diff->i . ' min';
                            }

                            $porcentaje = max(0, min(100, ($minsTotales / 60) * 100));
                            $isAlert = $minsTotales <= 15 || $prestamo->estado == 'atrasado' || $diff->invert;
                        @endphp
                        <div class="tool-card {{ $isAlert ? 'alert' : '' }}">
                            <div class="tool-card-img">
                                <img src="{{ $prestamo->herramienta->imagen_url }}" alt="{{ $prestamo->herramienta->nombre }}">
                                <span class="qr-badge">{{ $prestamo->herramienta->codigo_qr }}</span>
                            </div>
                            <div class="tool-card-body">
                                <div class="tool-card-top">
                                    <div class="tool-name">{{ $prestamo->herramienta->nombre }}</div>
                                    <span class="tool-status {{ $prestamo->estado }}">{{ $prestamo->estado }}</span>
                                </div>
                                <div class="tool-desc" title="{{ $prestamo->herramienta->descripcion }}">
                                    {{ $prestamo->herramienta->descripcion ?? 'Herramienta de taller' }}
                                </div>
                                
                                @if(Auth::user()->esAdmin())
                                    <div class="text-xs mb-2 py-1 px-2 bg-gray-50 rounded-lg border border-gray-100">
                                        <span class="font-bold text-[#16213e]">Ocupado por:</span> 
                                        <span class="text-indigo-600 font-semibold">{{ $prestamo->usuario->nombre }}</span>
                                    </div>
                                @endif
                                <div class="mt-auto">
                                    <div class="tool-timer-row">
                                        <span class="tool-timer-label">Vence en</span>
                                        <span class="tool-timer-pill {{ $isAlert ? 'bad' : 'ok' }}">
                                            {{ $labelTiempo }}
                                        </span>
                                    </div>
                                    <div class="progress-bar-track">
                                        <div class="progress-bar-fill {{ $isAlert ? 'bad' : 'ok' }}" style="width:{{ $porcentaje }}%"></div>
                                    </div>
                                    @if($prestamo->estado !== 'devuelto')
                                        <div class="mt-3 pt-3 border-t border-gray-100">
                                            @if($prestamo->herramienta->es_alto_valor && !Auth::user()->esAdmin())
                                                <a href="{{ route('prestamos.devolver', $prestamo) }}" class="block w-full text-center text-[11px] uppercase tracking-wider font-bold py-2 bg-[#fdf8ee] text-[#a07a2a] border border-[#cca75b] rounded-lg hover:bg-[#fdf0d0] transition-colors shadow-sm">
                                                    Check-list de Recepción
                                                </a>
                                            @else
                                                <form action="{{ route('prestamos.devolucion-rapida', $prestamo) }}" method="POST" class="w-full" onsubmit="return confirm('¿Confirmar que recibiste esta herramienta en buen estado?');">
                                                    @csrf
                                                    <button type="submit" class="w-full text-[11px] uppercase tracking-wider font-bold py-2 bg-white text-[#23325b] border border-[#23325b]/20 rounded-lg hover:bg-[#f0f3f8] transition-colors shadow-sm">
                                                        Recibir Herramienta
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" style="grid-column:1/-1;">
                            <span class="material-symbols-outlined">sentiment_calm</span>
                            <h4>Todo despejado por aquí</h4>
                            <p>No tienes herramientas prestadas o reservadas en este momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
