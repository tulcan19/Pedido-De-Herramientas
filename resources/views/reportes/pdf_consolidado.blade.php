<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Consolidado - ISTPET</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Helvetica', sans-serif; 
            font-size: 10pt; 
            color: #1e293b; 
            line-height: 1.5; 
            margin: 0;
            background: #fff;
        }
        
        /* ── HEADER DESIGN ── */
        .sidebar {
            position: fixed;
            left: 0; top: 0; bottom: 0;
            width: 8px;
            background: #23325b;
        }
        .header {
            background: #f8fafc;
            padding: 40px 50px;
            border-bottom: 2px solid #cca75b;
        }
        .logo-container { float: left; width: 120px; }
        .title-container { float: left; margin-left: 30px; width: 450px; }
        .title-container h1 { 
            margin: 0; 
            font-size: 18pt; 
            color: #16213e; 
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .title-container .subtitle {
            color: #cca75b;
            font-weight: bold;
            font-size: 11pt;
            margin-top: 5px;
        }
        .meta-info {
            text-align: right;
            font-size: 8pt;
            color: #64748b;
        }
        .clear { clear: both; }

        /* ── CONTENT ── */
        .content { padding: 40px 50px; }
        
        .section-header {
            border-left: 4px solid #cca75b;
            padding-left: 15px;
            margin-bottom: 20px;
            margin-top: 30px;
        }
        .section-header h2 {
            margin: 0;
            font-size: 13pt;
            color: #23325b;
            text-transform: uppercase;
        }

        /* ── STATS CARDS ── */
        .stats-grid {
            width: 100%;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        .stat-value {
            font-size: 18pt;
            font-weight: 800;
            color: #23325b;
            display: block;
        }
        .stat-label {
            font-size: 7.5pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 4px;
            display: block;
        }

        /* ── TABLE ── */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background: #23325b;
            color: #fff;
            text-align: left;
            padding: 10px 12px;
            font-size: 9pt;
            text-transform: uppercase;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9pt;
            vertical-align: top;
        }
        tr:nth-child(even) { background: #f8fafc; }
        
        .badge {
            background: #cca75b;
            color: #fff;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* ── FOOTER ── */
        .footer {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            padding: 20px 50px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 8pt;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="sidebar"></div>
    
    <div class="header">
        <div class="logo-container">
            <img src="{{ public_path('img/ISTPET-ORIGINAL.png') }}" style="width: 100px;">
        </div>
        <div class="title-container">
            <h1>Resumen Consolidado</h1>
            <div class="subtitle">BITÁCORA DE ACTIVIDAD DEL TALLER</div>
            <div style="font-size: 9pt; margin-top: 8px; color: #475569;">
                Rango de fechas: <strong>{{ $inicio }}</strong> al <strong>{{ $fin }}</strong>
            </div>
        </div>
        <div class="meta-info">
            Documento Oficial ISTPET<br>
            Generado: {{ now()->format('d/m/Y H:i') }}
        </div>
        <div class="clear"></div>
    </div>

    <div class="content">
        <div class="section-header">
            <h2>Resumen Ejecutivo</h2>
        </div>
        
        <table class="stats-grid">
            <tr>
                @forelse($estadisticas as $stat)
                <td width="20%" style="border-bottom: none; padding: 5px;">
                    <div class="stat-card">
                        <span class="stat-value">{{ $stat->total }}</span>
                        <span class="stat-label">{{ Str::limit($stat->nombre, 20) }}</span>
                    </div>
                </td>
                @empty
                <td style="border-bottom: none; text-align: center; color: #94a3b8;">No hay datos para el periodo.</td>
                @endforelse
            </tr>
        </table>

        <div class="section-header">
            <h2>Detalle Cronológico de Peticiones</h2>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th width="15%">Fecha/Hora</th>
                    <th width="25%">Estudiante</th>
                    <th width="35%">Herramientas</th>
                    <th width="15%">Docente</th>
                    <th width="10%">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peticiones as $p)
                <tr>
                    <td>
                        <strong>{{ $p->created_at->format('d/m/Y') }}</strong><br>
                        <span style="color: #64748b;">{{ $p->created_at->format('H:i') }}</span>
                    </td>
                    <td>
                        <strong>{{ $p->usuario->nombre }}</strong><br>
                        <span style="font-size: 8pt; color: #64748b;">CI: {{ $p->usuario->cedula }}</span>
                    </td>
                    <td>
                        @foreach($p->prestamos as $pre)
                            <div style="margin-bottom: 3px;">• {{ $pre->herramienta->nombre }} <span style="font-size: 7.5pt; color: #94a3b8;">[{{ $pre->herramienta->codigo_qr }}]</span></div>
                        @endforeach
                    </td>
                    <td>{{ $p->docente->nombre ?? $p->docente }}</td>
                    <td style="text-align: center;">
                        <span class="badge">{{ $p->estado }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                        Sin registros en el periodo seleccionado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Sistema de Gestión de Inventario ISTPET - Taller de Mecánica Automotriz - Página 1 de 1
    </div>
</body>
</html>
