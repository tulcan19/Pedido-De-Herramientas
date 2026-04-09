<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial de Préstamos - ISTPET</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', sans-serif; font-size: 10pt; color: #1e293b; line-height: 1.4; margin: 0; background: #fff; }
        .sidebar { position: fixed; left: 0; top: 0; bottom: 0; width: 10px; background: #23325b; }
        .header { background: #f8fafc; padding: 40px 50px; border-bottom: 2px solid #cca75b; }
        .logo-container { float: left; width: 120px; }
        .title-container { float: left; margin-left: 20px; width: 450px; }
        .title-container h1 { margin: 0; font-size: 16pt; color: #16213e; text-transform: uppercase; }
        .title-container .subtitle { color: #cca75b; font-weight: bold; font-size: 10pt; margin-top: 5px; }
        .clear { clear: both; }

        .content { padding: 40px 50px; }
        
        .filters-box { 
            background: #f1f5f9; padding: 10px 15px; border-radius: 5px; margin-bottom: 20px; font-size: 8pt; color: #475569;
        }

        .student-section { margin-bottom: 40px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; page-break-inside: avoid; }
        .student-header { background: #f8fafc; padding: 12px 15px; border-bottom: 1px solid #e2e8f0; }
        .student-name { font-size: 12pt; font-weight: bold; color: #23325b; }
        .student-meta { font-size: 8pt; color: #64748b; margin-top: 2px; }

        table { width: 100%; border-collapse: collapse; }
        th { background: #23325b; color: #fff; text-align: left; padding: 8px 12px; font-size: 8pt; text-transform: uppercase; }
        td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; font-size: 8.5pt; }
        tr:nth-child(even) { background: #fbfcfd; }

        .badge { padding: 2px 6px; border-radius: 4px; font-size: 7pt; font-weight: bold; text-transform: uppercase; background: #e2e8f0; color: #475569; }
        .badge-devuelto { background: #dcfce7; color: #166534; }

        .footer { 
            position: fixed; bottom: 0; left: 0; right: 0; padding: 20px 50px; 
            text-align: center; font-size: 8pt; color: #94a3b8; border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="sidebar"></div>
    <div class="header">
        <div class="logo-container"><img src="{{ public_path('img/ISTPET-ORIGINAL.png') }}" style="width: 100px;"></div>
        <div class="title-container">
            <h1>Historial de Préstamos</h1>
            <div class="subtitle">REGISTRO INDIVIDUAL Y POR NIVEL</div>
        </div>
        <div style="text-align: right; font-size: 8pt; color: #64748b;">Generado: {{ $fecha }}</div>
        <div class="clear"></div>
    </div>

    <div class="content">
        <div class="filters-box">
            Filtros aplicados: 
            <strong>Cédula:</strong> {{ $filtro_cedula ?: 'Todos' }} | 
            <strong>Semestre:</strong> {{ $filtro_semestre ?: 'Todos' }}
        </div>

        @forelse($estudiantes as $estudiante)
        <div class="student-section">
            <div class="student-header">
                <div class="student-name">{{ $estudiante->nombre }}</div>
                <div class="student-meta">
                    Cédula: {{ $estudiante->cedula }} | Semestre: {{ $estudiante->semestre }}° | Total Préstamos: {{ $estudiante->prestamos->count() }}
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th width="15%">Fecha</th>
                        <th width="45%">Herramienta</th>
                        <th width="25%">Devolución</th>
                        <th width="15%">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estudiante->prestamos as $p)
                    <tr>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $p->herramienta->nombre }}</strong><br>
                            <span style="font-size: 7pt; color: #94a3b8;">Ref: {{ $p->herramienta->codigo_qr }}</span>
                        </td>
                        <td>
                            {{ $p->fecha_devolucion_real ? $p->fecha_devolucion_real->format('d/m H:i') : 'No devuelto' }}
                        </td>
                        <td>
                            <span class="badge {{ $p->estado == 'devuelto' ? 'badge-devuelto' : '' }}">{{ $p->estado }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: #94a3b8;">Sin préstamos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @empty
        <div style="text-align: center; padding: 50px; color: #94a3b8;">
            No se encontraron estudiantes con los criterios seleccionados.
        </div>
        @endforelse
    </div>

    <div class="footer">Este documento es para fines informativos y de control interno del Taller de Mecánica ISTPET.</div>
</body>
</html>
