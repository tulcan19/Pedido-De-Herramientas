<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('reportes.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold hover:opacity-70 transition" style="color:#23325b;">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Historial
            </a>
            <span class="text-gray-300">/</span>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Comprobante de Devolución #{{ $prestamo->id }}
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

        .sheet-header { border-bottom: 2px solid #23325b; padding-bottom: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-end; }
        .sheet-title-area h1 { font-size: 1.3rem; font-weight: 800; color: #16213e; text-transform: uppercase; letter-spacing: .05em; line-height: 1.3; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem 3rem; margin-bottom: 2.5rem; }
        .input-group { display: flex; align-items: flex-end; gap: .5rem; }
        .input-label { font-weight: 700; color: #4b5563; font-size: .95rem; white-space: nowrap; }
        .input-line { flex: 1; border-bottom: 1.5px solid #e5e7eb; padding: .25rem 0; font-size: .95rem; color: #1f2937; }

        .tools-table-wrapper { border: 1.5px solid #16213e; border-radius: 8px; overflow: hidden; margin-bottom: 2rem; }
        .tools-table { width: 100%; border-collapse: collapse; }
        .tools-table th { background: #f8fafc; border-bottom: 1.5px solid #16213e; border-right: 1.5px solid #16213e; padding: .8rem; font-size: .75rem; font-weight: 800; text-align: center; color: #16213e; text-transform: uppercase; }
        .tools-table td { border-bottom: 1px solid #cbd5e1; border-right: 1px solid #cbd5e1; padding: .8rem; font-size: .85rem; color: #374151; }
        
        .section-header { background: #f1f5f9; padding: 0.5rem 1rem; font-weight: 800; font-size: 0.8rem; color: #23325b; text-transform: uppercase; margin: 2rem 0 1rem; border-radius: 4px; }
        
        .evidence-img { width: 100%; border-radius: 12px; border: 2px solid #e5e7eb; max-height: 400px; object-fit: contain; background: #f8fafc; }

        .signatures-new { display: flex; flex-direction: column; gap: 1.5rem; margin-top: 2rem; border-top: 1.5px solid #16213e; padding-top: 2rem; }
        
        .status-badge {
            display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 11px; font-weight: 800; text-transform: uppercase;
        }
        .status-disponible { background: #dcfce7; color: #166534; }
        .status-mantenimiento { background: #fee2e2; color: #991b1b; }
        .status-perdido { background: #f3f4f6; color: #111827; }

        @media print {
            .sheet-root { background: white; padding: 0; }
            .sheet-wrap { margin: 0; max-width: 100%; }
            .paper-sheet { box-shadow: none; border: none; padding: 0; }
            button, .no-print { display: none; }
        }
    </style>

    <div class="sheet-root">
        <div class="sheet-wrap">
            <div class="paper-sheet">
                
                <div class="sheet-header">
                    <div class="sheet-title-area">
                        <h1>Comprobante de Recepción<br><span style="color:#cca75b; font-size:1rem;">Taller de Mecánica Automotriz</span></h1>
                    </div>
                    <div class="text-right no-print">
                        <button onclick="window.print()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">print</span> Imprimir
                        </button>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="input-group">
                        <span class="input-label">Docente:</span>
                        <div class="input-line">{{ $prestamo->peticion->docente ?? 'N/A' }}</div>
                    </div>
                    <div class="input-group">
                        <span class="input-label">Asignatura:</span>
                        <div class="input-line">{{ $prestamo->peticion->asignatura ?? 'N/A' }}</div>
                    </div>
                    <div class="input-group">
                        <span class="input-label">Estudiante:</span>
                        <div class="input-line">{{ $prestamo->usuario->nombre }}</div>
                    </div>
                    <div class="input-group">
                        <span class="input-label">Fecha Devolución:</span>
                        <div class="input-line">{{ $prestamo->fecha_devolucion_real ? $prestamo->fecha_devolucion_real->format('d/m/Y H:i') : 'N/A' }}</div>
                    </div>
                    
                    <div class="input-group">
                        <span class="input-label">Hora Salida:</span>
                        <div class="input-line">{{ $prestamo->peticion ? $prestamo->peticion->updated_at->format('H:i') : $prestamo->created_at->format('H:i') }}</div>
                    </div>
                    <div class="input-group">
                        <span class="input-label">Hora Entrada:</span>
                        <div class="input-line">{{ $prestamo->fecha_devolucion_real ? $prestamo->fecha_devolucion_real->format('H:i') : 'N/A' }}</div>
                    </div>
                </div>

                <div class="section-header">Herramienta Recibida</div>
                <div class="tools-table-wrapper">
                    <table class="tools-table">
                        <thead>
                            <tr>
                                <th style="width:10%;">Código</th>
                                <th style="text-align:left;">Descripción</th>
                                <th style="width:40%;">Accesorios Recibidos</th>
                                <th style="width:15%;">Estado Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align:center; font-weight:700;">{{ $prestamo->herramienta->codigo_qr }}</td>
                                <td>{{ $prestamo->herramienta->nombre }}</td>
                                <td>
                                    @php $checklist = is_array($prestamo->checklist_accesorios) ? $prestamo->checklist_accesorios : json_decode($prestamo->checklist_accesorios ?? '[]', true); @endphp
                                    @if(count($checklist) > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($checklist as $accIndex)
                                                @php $acc = $prestamo->herramienta->accesorios_formateados[$accIndex] ?? null; @endphp
                                                @if($acc)
                                                    <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md text-[10px] font-bold border border-blue-100">
                                                        ✓ {{ $acc['nombre'] }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs italic text-gray-400">Ninguno o sin accesorios</span>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    <span class="status-badge status-{{ $prestamo->herramienta->estado }}">
                                        {{ $prestamo->herramienta->estado }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <div class="section-header">Evidencia de Devolución</div>
                        @if($prestamo->foto_devolucion)
                            <img src="{{ asset('storage/' . $prestamo->foto_devolucion) }}" class="evidence-img" alt="Evidencia">
                        @else
                            <div class="p-8 border-2 border-dashed border-gray-200 rounded-xl text-center text-gray-400">
                                Sin evidencia fotográfica registrada
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="section-header">Observaciones de Recepción</div>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-sm italic text-gray-600 min-height-[100px]">
                            {{ $prestamo->observaciones ?? 'Sin observaciones registradas.' }}
                        </div>

                        @if($prestamo->firma_devolucion)
                            <div class="section-header">Firma Digital (Registro)</div>
                            <img src="{{ asset('storage/' . $prestamo->firma_devolucion) }}" style="height:80px; width:auto; border-bottom:1px solid #16213e;" alt="Firma">
                        @endif
                    </div>
                </div>

                <div class="signatures-new">
                    <div style="display: flex; align-items: flex-end; gap: 10px; font-size: 0.85rem;">
                        <span style="font-weight: 700;">Entregado por (Estudiante responsable):</span>
                        <div style="flex: 1; border-bottom: 1.5px solid #16213e; padding-bottom: 2px;">
                            <span style="font-weight: 800; color: #cca75b; font-style: italic;">{{ $prestamo->usuario->nombre }}</span>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-end; gap: 10px; font-size: 0.85rem;">
                        <span style="font-weight: 700;">Recibido por (Encargado de taller):</span>
                        <div style="flex: 1; border-bottom: 1.5px solid #16213e; padding-bottom: 2px;">
                            <span style="font-weight: 800; color: #16213e; font-style: italic;">{{ \App\Models\Usuario::where('rol', 'admin')->first()->nombre ?? 'Javier Tulcán' }}</span>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-end; gap: 10px; font-size: 0.85rem;">
                        <span style="font-weight: 700;">Autorizado por (Docente responsable):</span>
                        <div style="flex: 1; border-bottom: 1.5px solid #16213e; padding-bottom: 2px;">
                            <span style="font-weight: 800; color: #1e40af; font-style: italic;">{{ $prestamo->peticion->docente ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 text-center no-print">
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Documento Digital - Sistema de Inventario IST PET</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
