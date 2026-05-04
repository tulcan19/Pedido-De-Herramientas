<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bitácora Interactiva de Préstamos') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');
        .bit-root { font-family: 'Outfit', sans-serif; background: #f0f3f8; min-height: 100vh; padding-bottom: 3rem; }
        .bit-container { max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem; }
        
        .bit-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,.05); border: 1.5px solid #e5e7eb; overflow: hidden; }
        .bit-header { padding: 1.5rem 2rem; background: #fff; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
        .bit-title { font-size: 1.25rem; font-weight: 800; color: #16213e; display: flex; align-items: center; gap: .75rem; }
        
        .bit-table { width: 100%; border-collapse: collapse; }
        .bit-table th { background: #f8fafc; padding: 1rem 1.5rem; text-align: left; font-size: .7rem; font-weight: 800; color: #6b7280; text-transform: uppercase; letter-spacing: .05em; border-bottom: 2px solid #f1f5f9; }
        .bit-table td { padding: 1.2rem 1.5rem; border-bottom: 1px solid #f1f5f9; font-size: .85rem; vertical-align: middle; }
        .bit-table tr:hover { background: #fdf8ee; }

        .status-pill { padding: .25rem .75rem; border-radius: 999px; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        .status-devuelto { background: #dcfce7; color: #166534; }
        .status-activo { background: #dbeafe; color: #1e40af; }
        .status-atrasado { background: #fee2e2; color: #991b1b; }
        .status-reservado { background: #fef9c3; color: #854d0e; }

        .btn-view { display: inline-flex; align-items: center; gap: .5rem; padding: .5rem 1rem; background: #fff; border: 1.5px solid #cca75b; color: #a07a2a; border-radius: 10px; font-weight: 700; font-size: .75rem; transition: all .2s; }
        .btn-view:hover { background: #cca75b; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(204,167,91,.3); }

        .pagination-wrap { padding: 1.5rem 2rem; border-top: 1px solid #f1f5f9; background: #fcfcfc; }

        .search-box { display: flex; gap: .5rem; background: #f8fafc; padding: .5rem; border-radius: 12px; border: 1.5px solid #e5e7eb; width: 300px; }
        .search-box input { background: transparent; border: none; outline: none; flex: 1; font-size: .85rem; color: #16213e; }
        .search-box .material-symbols-outlined { color: #9ca3af; }
    </style>

    <div class="bit-root">
        <div class="bit-container">
            
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h1 class="text-3xl font-black text-[#16213e] mb-1">Bitácora de <span>Préstamos</span></h1>
                    <p class="text-gray-500 text-sm">Registro histórico interactivo de todas las herramientas del taller.</p>
                </div>
                <div class="flex gap-3 no-print">
                    <a href="{{ route('reportes.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-50 transition flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                        Reportes PDF
                    </a>
                </div>
            </div>

            <div class="bit-card">
                <div class="bit-header flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                    <div class="bit-title">
                        <span class="material-symbols-outlined text-[#cca75b]">history_edu</span>
                        Listado General de Movimientos
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <form action="{{ route('reportes.bitacora') }}" method="GET" class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-2 py-1 shadow-sm">
                            <span class="material-symbols-outlined text-gray-400 text-sm">calendar_month</span>
                            <input type="date" name="fecha" value="{{ request('fecha') }}" class="bg-transparent border-none text-sm text-gray-700 focus:ring-0 p-1 cursor-pointer" onchange="this.form.submit()">
                            @if(request('fecha'))
                                <a href="{{ route('reportes.bitacora') }}" class="text-gray-400 hover:text-red-500 transition ml-1" title="Limpiar filtro">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </a>
                            @endif
                        </form>

                        <form action="{{ route('prestamos.auditar-todos') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas aprobar TODAS las devoluciones pendientes sin novedades de una sola vez?');">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg font-bold text-xs hover:bg-green-100 hover:text-green-800 transition flex items-center gap-2 shadow-sm uppercase tracking-wider h-[38px]">
                                <span class="material-symbols-outlined text-sm">done_all</span>
                                Aprobar Todo OK
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Modal de Auditoría -->
                <div id="auditModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                    <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl transform transition-all">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                            <h3 class="text-xl font-black text-[#16213e] flex items-center gap-2">
                                <span class="material-symbols-outlined text-red-600">report_problem</span>
                                Reportar Incidencia
                            </h3>
                            <button onclick="closeAuditModal()" class="text-gray-400 hover:text-gray-600">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <form id="auditForm" method="POST">
                            @csrf
                            <input type="hidden" name="estado" value="incidencia">
                            <div class="p-8">
                                <div class="mb-6">
                                    <p class="text-sm text-gray-500 mb-2">Está reportando una novedad para:</p>
                                    <div id="modalToolName" class="font-bold text-[#16213e] bg-blue-50 p-3 rounded-xl border border-blue-100"></div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Notas / Observaciones</label>
                                    <textarea name="notas" required class="w-full rounded-2xl border-gray-200 focus:border-[#cca75b] focus:ring focus:ring-[#cca75b]/20 min-h-[120px] text-sm" placeholder="Describa el problema (Ej: Herramienta perdida, cable roto, falta un accesorio...)"></textarea>
                                </div>

                                <div class="p-4 bg-red-50 rounded-2xl border border-red-100 flex gap-3">
                                    <span class="material-symbols-outlined text-red-600 text-lg">info</span>
                                    <p class="text-[11px] text-red-700 leading-relaxed">
                                        Al reportar una incidencia, la herramienta pasará automáticamente a estado de <strong>Mantenimiento</strong> y no podrá ser reservada hasta que se corrija.
                                    </p>
                                </div>
                            </div>
                            <div class="p-6 bg-gray-50 border-t border-gray-100 flex gap-3">
                                <button type="button" onclick="closeAuditModal()" class="flex-1 py-3 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-100 transition">Cancelar</button>
                                <button type="submit" class="flex-1 py-3 bg-red-600 text-white rounded-xl font-bold text-sm hover:bg-red-700 transition shadow-lg shadow-red-200">Confirmar Reporte</button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    function openAuditModal(id, name) {
                        const modal = document.getElementById('auditModal');
                        const form = document.getElementById('auditForm');
                        const toolName = document.getElementById('modalToolName');
                        
                        form.action = `/prestamos/${id}/auditar`;
                        toolName.innerText = name;
                        
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            modal.querySelector('.bg-white').classList.add('scale-100');
                            modal.querySelector('.bg-white').classList.remove('scale-95');
                        }, 10);
                    }

                    function closeAuditModal() {
                        const modal = document.getElementById('auditModal');
                        modal.querySelector('.bg-white').classList.add('scale-95');
                        modal.querySelector('.bg-white').classList.remove('scale-100');
                        setTimeout(() => {
                            modal.classList.add('hidden');
                        }, 200);
                    }
                </script>
                
                <div class="overflow-x-auto">
                    <table class="bit-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estudiante / Responsable</th>
                                <th>Herramienta</th>
                                <th>Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prestamos as $p)
                                <tr>
                                    <td class="font-bold text-[#16213e]">
                                        <div>{{ $p->created_at->format('d/m/Y') }}</div>
                                        <div class="text-[10px] text-gray-400 font-normal">{{ $p->created_at->format('H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                                {{ substr($p->usuario->nombre, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-[#16213e]">{{ $p->usuario->nombre }}</div>
                                                <div class="text-[10px] text-gray-400">{{ $p->usuario->cedula }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-medium text-[#23325b]">{{ $p->herramienta->nombre }}</div>
                                        <div class="text-[10px] text-gray-400">Cód: {{ $p->herramienta->codigo_qr }}</div>
                                    </td>
                                    <td>
                                        <span class="status-pill status-{{ $p->estado }}">
                                            {{ $p->estado }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($p->estado == 'devuelto')
                                                <a href="{{ route('prestamos.comprobante', $p) }}" class="btn-view" title="Ver Formato">
                                                    <span class="material-symbols-outlined text-sm">description</span>
                                                </a>
                                                
                                                @if($p->auditoria_estado == 'pendiente')
                                                    <div class="flex gap-1">
                                                        <form action="{{ route('prestamos.auditar', $p) }}" method="POST" onsubmit="return confirm('¿Aprobar esta devolución sin novedades?')">
                                                            @csrf
                                                            <input type="hidden" name="estado" value="aprobado">
                                                            <button type="submit" class="p-2 bg-green-50 text-green-600 rounded-lg border border-green-100 hover:bg-green-600 hover:text-white transition shadow-sm" title="Aprobar Todo OK">
                                                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                                            </button>
                                                        </form>
                                                        
                                                        <button type="button" onclick="openAuditModal({{ $p->id }}, '{{ $p->herramienta->nombre }}')" class="p-2 bg-red-50 text-red-600 rounded-lg border border-red-100 hover:bg-red-600 hover:text-white transition shadow-sm" title="Reportar Perdido / Falla">
                                                            <span class="material-symbols-outlined text-sm">report_problem</span>
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-[9px] font-bold uppercase flex items-center gap-1">
                                                        <span class="material-symbols-outlined text-[12px]">{{ $p->auditoria_estado == 'aprobado' ? 'verified' : 'warning' }}</span>
                                                        {{ $p->auditoria_estado }}
                                                    </span>
                                                @endif
                                            @else
                                                <div class="flex items-center justify-end gap-1 text-[10px] text-gray-400 italic">
                                                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                                                    En proceso
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-20 text-center">
                                        <span class="material-symbols-outlined text-gray-200" style="font-size:4rem;">folder_open</span>
                                        <p class="text-gray-400 mt-2">No se encontraron registros de préstamos.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrap">
                    {{ $prestamos->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
