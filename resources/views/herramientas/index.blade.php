<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->esAdmin() ? __('Gestión de Herramientas') : __('Catálogo de Herramientas') }}
            </h2>
            @if(Auth::user()->esAdmin())
                <a href="{{ route('herramientas.create') }}"
                   style="background:linear-gradient(135deg,#cca75b,#a07a2a);color:#16213e;"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold rounded-xl shadow-lg transition-all hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-base">add_circle</span>
                    Nueva Herramienta
                </a>
            @endif
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

        .tool-root { font-family: 'Outfit', sans-serif; background: #f0f3f8; min-height: 100vh; }

        /* ── HERO ── */
        .tool-hero {
            background: linear-gradient(135deg, #16213e 0%, #23325b 60%, #2a3d6e 100%);
            padding: 2.5rem 1.5rem 5rem;
            position: relative; overflow: hidden;
        }
        .tool-hero::before {
            content: ''; position: absolute; top: -50px; right: -50px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(204,167,91,.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .tool-hero::after {
            content: ''; position: absolute; bottom: -30px; left: 20%;
            width: 180px; height: 180px;
            background: radial-gradient(circle, rgba(204,167,91,.10) 0%, transparent 70%);
            border-radius: 50%;
        }
        .tool-hero-inner { max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; }
        .tool-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(204,167,91,.15); border: 1px solid rgba(204,167,91,.35);
            color: #cca75b; font-size: 11px; font-weight: 700; padding: 4px 14px;
            border-radius: 999px; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 1rem;
        }
        .tool-hero-title { font-size: clamp(1.5rem, 3.5vw, 2rem); font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: .4rem; }
        .tool-hero-title span { color: #cca75b; }
        .tool-hero-sub { color: #a0b0cc; font-size: .9rem; }

        /* ── HERO CHIPS ── */
        .hero-chips { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1.5rem; }
        .hero-chip {
            background: rgba(255,255,255,.08); border: 1px solid rgba(204,167,91,.2);
            border-radius: 14px; padding: .7rem 1.1rem;
            display: flex; align-items: center; gap: .6rem;
        }
        .hero-chip-icon {
            width: 34px; height: 34px; background: rgba(204,167,91,.18);
            border-radius: 9px; display: flex; align-items: center; justify-content: center;
        }
        .hero-chip-icon .material-symbols-outlined { color: #cca75b; font-size: 17px; }
        .hero-chip-val { font-size: 1.3rem; font-weight: 800; color: #fff; line-height: 1; }
        .hero-chip-lbl { font-size: .7rem; color: #a0b0cc; font-weight: 500; margin-top: 2px; }

        /* ── SEARCH BAR ── */
        .search-bar-wrap {
            max-width: 1200px; margin: -3rem auto 0; padding: 0 1.5rem;
            position: sticky; top: 1rem; z-index: 50;
        }
        .search-card {
            background: #fff; border-radius: 18px; padding: 1.25rem 1.5rem;
            box-shadow: 0 8px 32px rgba(0,0,0,.10);
            display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        }
        .search-input-wrap { flex: 1; min-width: 200px; position: relative; }
        .search-input-wrap .material-symbols-outlined {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; font-size: 20px;
        }
        .search-input {
            width: 100%; border: 1.5px solid #e5e7eb; border-radius: 12px;
            padding: .65rem 1rem .65rem 2.5rem; font-size: .9rem; outline: none;
            transition: border-color .2s; font-family: 'Outfit', sans-serif;
        }
        .search-input:focus { border-color: #cca75b; }
        .filter-btn {
            display: inline-flex; align-items: center; gap: 5px; padding: .6rem 1.1rem;
            border-radius: 10px; font-size: .78rem; font-weight: 700;
            border: 1.5px solid #e5e7eb; background: #fff; cursor: pointer;
            transition: background .15s, border-color .15s;
            font-family: 'Outfit', sans-serif; color: #6b7280;
        }
        .filter-btn:hover { background: #fdf8ee; border-color: #cca75b; color: #a07a2a; }
        .filter-btn.active { background: #fdf8ee; border-color: #cca75b; color: #a07a2a; }
        .filter-btn .material-symbols-outlined { font-size: 16px; }

        /* ── MAIN ── */
        .tool-main { max-width: 1200px; margin: 1.5rem auto 0; padding: 0 1.5rem 3rem; }

        /* ── CATALOG GRID ── */
        .catalog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.25rem; }
        .catalog-card {
            background: #fff; border-radius: 20px; border: 1.5px solid #e5e7eb;
            overflow: hidden; display: flex; flex-direction: column;
            box-shadow: 0 2px 12px rgba(0,0,0,.05);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .catalog-card:hover { transform: translateY(-5px); box-shadow: 0 14px 40px rgba(0,0,0,.10); }
        .catalog-card.unavailable { opacity: .8; }
        .card-img-area {
            position: relative; height: 160px; background: #f5f7fb;
            border-bottom: 1.5px solid #f1f5f9;
            display: flex; align-items: center; justify-content: center; padding: 1rem;
        }
        .card-img-area img { max-height: 100%; max-width: 100%; object-fit: contain; mix-blend-mode: multiply; }
        .card-status-dot {
            position: absolute; top: 12px; left: 12px;
            display: flex; align-items: center; gap: 5px;
            background: #fff; border-radius: 999px; padding: 3px 10px 3px 6px;
            font-size: 10px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
            box-shadow: 0 1px 4px rgba(0,0,0,.1);
        }
        .status-dot-circle { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .status-dot-circle.disponible   { background: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,.2); }
        .status-dot-circle.prestado     { background: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.2); }
        .status-dot-circle.mantenimiento{ background: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.2); }
        .status-dot-circle.perdido      { background: #4b5563; box-shadow: 0 0 0 3px rgba(75,85,99,.2); }
        .card-qr-badge {
            position: absolute; top: 12px; right: 12px;
            background: rgba(255,255,255,.9); border: 1px solid #e5e7eb;
            font-size: 9px; font-weight: 700; color: #374151;
            padding: 2px 8px; border-radius: 6px; font-family: monospace;
        }
        .card-body { padding: 1rem 1.1rem; flex: 1; display: flex; flex-direction: column; }
        .card-name { font-size: .95rem; font-weight: 700; color: #16213e; margin-bottom: .25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .card-desc { font-size: .78rem; color: #9ca3af; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .btn-reserve {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            width: 100%; padding: .6rem 1rem; border-radius: 12px;
            font-size: .82rem; font-weight: 700; border: none; cursor: pointer;
            transition: transform .15s ease, box-shadow .15s ease;
            font-family: 'Outfit', sans-serif;
        }
        .btn-reserve.available {
            background: linear-gradient(135deg, #cca75b, #a07a2a);
            color: #16213e;
            box-shadow: 0 4px 14px rgba(204,167,91,.35);
        }
        .btn-reserve.available:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(204,167,91,.45); }
        .btn-reserve.disabled { background: #f3f4f6; color: #9ca3af; cursor: not-allowed; }
        .btn-reserve .material-symbols-outlined { font-size: 16px; }

        /* ── ADMIN TABLE ── */
        .admin-table-card { background: #fff; border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,.08); overflow: hidden; }
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table thead tr { background: #f5f7fb; border-bottom: 2px solid #e5e7eb; }
        .admin-table thead th { padding: 1rem 1.25rem; font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #6b7280; text-align: left; white-space: nowrap; }
        .admin-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
        .admin-table tbody tr:last-child { border-bottom: none; }
        .admin-table tbody tr:hover { background: #f8f9fd; }
        .admin-table td { padding: .9rem 1.25rem; vertical-align: middle; }

        .tool-thumb { width: 42px; height: 42px; border-radius: 12px; border: 1.5px solid #f1f5f9; object-fit: cover; background: #f8fafc; flex-shrink: 0; }
        .tool-name-cell { display: flex; align-items: center; gap: .75rem; }
        .tool-name-text { font-size: .9rem; font-weight: 600; color: #16213e; }

        .status-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 999px; font-size: .72rem; font-weight: 700; letter-spacing: .04em; }
        .status-pill.disponible    { background: #dcfce7; color: #15803d; }
        .status-pill.prestado      { background: #dbeafe; color: #1d4ed8; }
        .status-pill.mantenimiento { background: #fee2e2; color: #b91c1c; }
        .status-pill.perdido       { background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; }
        .status-pill .material-symbols-outlined { font-size: 13px; }

        .qr-mono { font-family: monospace; font-size: .8rem; color: #6b7280; background: #f3f4f6; padding: 3px 8px; border-radius: 6px; }

        .btn-edit {
            display: inline-flex; align-items: center; gap: 5px;
            padding: .4rem .9rem; border-radius: 9px; font-size: .78rem; font-weight: 700;
            color: #a07a2a; background: #fdf8ee; border: 1.5px solid #cca75b;
            text-decoration: none; transition: background .15s, transform .15s;
        }
        .btn-edit:hover { background: #fdf0d0; transform: translateY(-1px); }
        .btn-edit .material-symbols-outlined { font-size: 15px; }

        /* ── FLASH ── */
        .flash-ok { background: #d1fae5; border-left: 4px solid #10b981; color: #065f46; padding: .9rem 1.25rem; border-radius: 12px; margin-bottom: 1.25rem; font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: .5rem; }
        .flash-err { background: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: .9rem 1.25rem; border-radius: 12px; margin-bottom: 1.25rem; font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: .5rem; }

        /* ── EMPTY ── */
        .empty-box { background: #fff; border: 2px dashed #e5e7eb; border-radius: 18px; padding: 3.5rem; text-align: center; }
        .empty-box .material-symbols-outlined { font-size: 3rem; color: #d1d5db; display: block; margin-bottom: .75rem; }
        .empty-box h4 { font-size: 1rem; font-weight: 600; color: #6b7280; margin-bottom: .25rem; }
        .empty-box p  { font-size: .85rem; color: #9ca3af; }
    </style>

    <div class="tool-root">

        {{-- HERO --}}
        <div class="tool-hero">
            <div class="tool-hero-inner">
                <div class="tool-badge">
                    <span class="material-symbols-outlined" style="font-size:13px;">
                        {{ Auth::user()->esAdmin() ? 'admin_panel_settings' : 'storefront' }}
                    </span>
                    {{ Auth::user()->esAdmin() ? 'Panel de Coordinación' : 'Catálogo de Herramientas' }}
                </div>
                <h1 class="tool-hero-title">
                    {{ Auth::user()->esAdmin() ? 'Gestión de' : 'Nuestras' }}
                    <span>Herramientas</span>
                </h1>
                <p class="tool-hero-sub">
                    {{ Auth::user()->esAdmin()
                        ? 'Administra el inventario completo del taller mecánico.'
                        : 'Encuentra la herramienta que necesitas y resérvala al instante.' }}
                </p>
                <div class="hero-chips">
                    <div class="hero-chip">
                        <div class="hero-chip-icon"><span class="material-symbols-outlined">handyman</span></div>
                        <div>
                            <div class="hero-chip-val">{{ $herramientas->count() }}</div>
                            <div class="hero-chip-lbl">Total en inventario</div>
                        </div>
                    </div>
                    <div class="hero-chip">
                        <div class="hero-chip-icon"><span class="material-symbols-outlined">check_circle</span></div>
                        <div>
                            <div class="hero-chip-val">{{ $herramientas->where('estado','disponible')->count() }}</div>
                            <div class="hero-chip-lbl">Disponibles ahora</div>
                        </div>
                    </div>
                    <div class="hero-chip">
                        <div class="hero-chip-icon"><span class="material-symbols-outlined">published_with_changes</span></div>
                        <div>
                            <div class="hero-chip-val">{{ $herramientas->where('estado','prestado')->count() }}</div>
                            <div class="hero-chip-lbl">En préstamo</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEARCH BAR (solo estudiante) --}}
        @if(!Auth::user()->esAdmin())
        <div class="search-bar-wrap">
            <div class="search-card">
                <div class="search-input-wrap">
                    <span class="material-symbols-outlined">search</span>
                    <input type="text" id="searchInput" class="search-input" placeholder="Buscar herramienta por nombre…">
                </div>
                <button class="filter-btn active" data-filter="todos" onclick="filtrar(this,'todos')">
                    <span class="material-symbols-outlined">apps</span> Todos
                </button>
                <button class="filter-btn" data-filter="disponible" onclick="filtrar(this,'disponible')">
                    <span class="material-symbols-outlined">check_circle</span> Disponibles
                </button>
                <button class="filter-btn" data-filter="prestado" onclick="filtrar(this,'prestado')">
                    <span class="material-symbols-outlined">published_with_changes</span> En uso
                </button>
            </div>
        </div>
        @endif

        {{-- MAIN --}}
        <div class="tool-main" style="{{ Auth::user()->esAdmin() ? 'margin-top:-3rem;' : '' }}">

            @if (session('success'))
                <div class="flash-ok"><span class="material-symbols-outlined">check_circle</span>{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash-err"><span class="material-symbols-outlined">error</span>{{ session('error') }}</div>
            @endif

            @if(Auth::user()->esAdmin())
            {{-- VISTA ADMIN --}}
            <div class="admin-table-card">
                <div class="overflow-x-auto">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Herramienta</th>
                                <th>Estado</th>
                                <th>Código QR</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($herramientas as $herramienta)
                                @php $icons = ['disponible'=>'check_circle','prestado'=>'published_with_changes','mantenimiento'=>'build_circle']; @endphp
                                <tr>
                                    <td>
                                        <div class="tool-name-cell">
                                            <img src="{{ $herramienta->imagen_url }}" class="tool-thumb" alt="{{ $herramienta->nombre }}">
                                            <div class="flex flex-col">
                                                <span class="tool-name-text">{{ $herramienta->nombre }}</span>
                                                @if($herramienta->es_alto_valor)
                                                    <span class="text-[9px] font-bold uppercase tracking-tighter flex items-center gap-1 mt-0.5" style="color: #cca75b;">
                                                        <span class="material-symbols-outlined text-[11px]">stars</span> Alto Valor
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('herramientas.status-update', $herramienta) }}" method="POST" onchange="this.submit()">
                                            @csrf
                                            <select name="estado" class="text-[10px] font-bold uppercase tracking-wider py-1 px-3 pr-8 rounded-lg border-none {{ $herramienta->estado }} focus:ring-0 cursor-pointer" 
                                                style="
                                                    @if($herramienta->estado == 'disponible') background: #dcfce7; color: #15803d; 
                                                    @elseif($herramienta->estado == 'prestado') background: #dbeafe; color: #1d4ed8; 
                                                    @else background: #fee2e2; color: #b91c1c; @endif
                                                ">
                                                <option value="disponible" {{ $herramienta->estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                                <option value="prestado" {{ $herramienta->estado == 'prestado' ? 'selected' : '' }} {{ $herramienta->estado !== 'prestado' ? 'disabled' : '' }}>Prestado</option>
                                                <option value="mantenimiento" {{ $herramienta->estado == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                                <option value="perdido" {{ $herramienta->estado == 'perdido' ? 'selected' : '' }}>Perdido</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td><span class="qr-mono">{{ $herramienta->codigo_qr }}</span></td>
                                    <td>
                                        <a href="{{ route('herramientas.edit', $herramienta) }}" class="btn-edit">
                                            <span class="material-symbols-outlined">edit</span>
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="padding:3rem;text-align:center;color:#9ca3af;">No hay herramientas registradas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @else
            {{-- VISTA ESTUDIANTE --}}
            <div class="catalog-grid" id="catalogGrid">
                @forelse($herramientas->where('estado', '!=', 'perdido') as $herramienta)
                    <div class="catalog-card {{ $herramienta->estado !== 'disponible' ? 'unavailable' : '' }}"
                         data-name="{{ strtolower($herramienta->nombre) }}"
                         data-estado="{{ $herramienta->estado }}">
                        <div class="card-img-area">
                            <img src="{{ $herramienta->imagen_url }}" alt="{{ $herramienta->nombre }}">
                            <div class="card-status-dot">
                                <div class="status-dot-circle {{ $herramienta->estado }}"></div>
                                {{ ucfirst($herramienta->estado) }}
                            </div>
                            <span class="card-qr-badge">{{ $herramienta->codigo_qr }}</span>
                        </div>
                        <div class="card-body">
                            <div class="card-name">{{ $herramienta->nombre }}</div>
                            <div class="card-desc">{{ $herramienta->descripcion ?? 'Herramienta de taller mecánico.' }}</div>
                            @if($herramienta->estado == 'disponible')
                                <button type="button" class="btn-reserve available btn-add-cart" data-id="{{ $herramienta->id }}">
                                    <span class="material-symbols-outlined">add_task</span>
                                    Añadir a Petición
                                </button>
                            @else
                                <button class="btn-reserve disabled" disabled>
                                    <span class="material-symbols-outlined">block</span>
                                    No disponible
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-box" style="grid-column:1/-1;">
                        <span class="material-symbols-outlined">inventory_2</span>
                        <h4>Catálogo vacío</h4>
                        <p>Aún no hay herramientas registradas en el sistema.</p>
                    </div>
                @endforelse
            </div>
            @endif
        </div>
    </div>

    @if(!Auth::user()->esAdmin())
    <script>
        const searchInput = document.getElementById('searchInput');
        let currentFilter = 'todos';
        searchInput?.addEventListener('input', applyFilters);
        function filtrar(btn, estado) {
            currentFilter = estado;
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            applyFilters();
        }
        function applyFilters() {
            const query = searchInput.value.toLowerCase();
            document.querySelectorAll('.catalog-card').forEach(card => {
                const matchQ = (card.dataset.name ?? '').includes(query);
                const matchF = currentFilter === 'todos' || card.dataset.estado === currentFilter;
                card.style.display = (matchQ && matchF) ? '' : 'none';
            });
        }

        // Add to Cart Logic
        document.querySelectorAll('.btn-add-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;
                let _btn = this;
                _btn.innerHTML = '<span class="material-symbols-outlined">refresh</span> Añadiendo...';
                
                fetch(`/peticion/add/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(res => res.json())
                .then(data => {
                    if(data.success) {
                        _btn.innerHTML = '<span class="material-symbols-outlined">check</span> Añadido';
                        _btn.classList.add('disabled');
                        _btn.style.background = '#d1fae5';
                        _btn.style.color = '#065f46';
                        document.getElementById('cart-count').innerText = data.count;
                        document.getElementById('cart-fab').style.display = 'flex';
                    }
                }).catch(err => {
                    _btn.innerHTML = '<span class="material-symbols-outlined">error</span> Error';
                });
            });
        });
    </script>
    
    <div id="cart-fab" style="display: {{ Session::has('carrito_peticion') && count(Session::get('carrito_peticion')) > 0 ? 'flex' : 'none' }}; position: fixed; bottom: 2rem; right: 2rem; background: linear-gradient(135deg, #16213e, #23325b); padding: 1rem 1.5rem; border-radius: 999px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); z-index: 50; align-items: center; gap: 1rem; color: white; border: 1.5px solid #cca75b;">
        <div style="display:flex; align-items:center; gap: 8px;">
            <span class="material-symbols-outlined text-[#cca75b]">assignment</span>
            <span id="cart-count" class="font-bold text-lg">{{ Session::has('carrito_peticion') ? count(Session::get('carrito_peticion')) : 0 }}</span>
            <span class="text-xs text-gray-300">En la reserva</span>
        </div>
        <a href="{{ route('peticiones.create') }}" class="px-6 py-2 bg-[#cca75b] text-white font-black text-sm rounded-full hover:bg-[#a07a2a] transition-all shadow-lg transform hover:scale-105 active:scale-95">
            Llenar Formulario →
        </a>
    </div>
    @endif
</x-app-layout>
