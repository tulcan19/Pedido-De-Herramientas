<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Inventario - ISTPET</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', sans-serif; font-size: 10pt; color: #1e293b; line-height: 1.4; margin: 0; background: #fff; }
        .sidebar { position: fixed; left: 0; top: 0; bottom: 0; width: 10px; background: #cca75b; }
        .header { background: #f8fafc; padding: 40px 50px; border-bottom: 2px solid #23325b; }
        .logo-container { float: left; width: 120px; }
        .title-container { float: left; margin-left: 20px; width: 450px; }
        .title-container h1 { margin: 0; font-size: 16pt; color: #16213e; text-transform: uppercase; }
        .title-container .subtitle { color: #23325b; font-weight: bold; font-size: 10pt; margin-top: 5px; }
        .meta-info { text-align: right; font-size: 8pt; color: #64748b; }
        .clear { clear: both; }

        .content { padding: 40px 50px; }
        
        /* ── SUMMARY TILES ── */
        .summary-grid { width: 100%; margin-bottom: 30px; }
        .summary-tile { background: #f1f5f9; padding: 15px; border-radius: 8px; text-align: center; }
        .tile-val { font-size: 16pt; font-weight: 800; color: #23325b; display: block; }
        .tile-lbl { font-size: 7.5pt; color: #64748b; text-transform: uppercase; font-weight: bold; }

        /* ── TABLE ── */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #16213e; color: #fff; text-align: left; padding: 10px; font-size: 9pt; text-transform: uppercase; }
        td { padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 8.5pt; }
        tr:nth-child(even) { background: #f8fafc; }
        
        .status-badge {
            padding: 2px 8px; border-radius: 99px; font-size: 7pt; font-weight: bold; text-transform: uppercase;
        }
        .status-disponible { background: #dcfce7; color: #166534; }
        .status-prestado { background: #dbeafe; color: #1e40af; }
        .status-atrasado { background: #fee2e2; color: #991b1b; }

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
            <h1>Inventario Técnico</h1>
            <div class="subtitle">ESTADO ACTUAL DE HERRAMIENTAS Y EQUIPOS</div>
        </div>
        <div class="meta-info">Total Items: {{ $total }}<br>Fecha: {{ $fecha }}</div>
        <div class="clear"></div>
    </div>

    <div class="content">
        <table class="summary-grid">
            <tr>
                <td width="25%" style="border:none; padding:5px;">
                    <div class="summary-tile"><span class="tile-val">{{ $total }}</span><span class="tile-lbl">Totales</span></div>
                </td>
                <td width="25%" style="border:none; padding:5px;">
                    <div class="summary-tile"><span class="tile-val">{{ $porEstado['disponible'] ?? 0 }}</span><span class="tile-lbl">Disponibles</span></div>
                </td>
                <td width="25%" style="border:none; padding:5px;">
                    <div class="summary-tile"><span class="tile-val">{{ ($porEstado['prestado'] ?? 0) + ($porEstado['atrasado'] ?? 0) }}</span><span class="tile-lbl">En Uso</span></div>
                </td>
                <td width="25%" style="border:none; padding:5px;">
                    <div class="summary-tile" style="background:#fee2e2;"><span class="tile-val">{{ $porEstado['mantenimiento'] ?? 0 }}</span><span class="tile-lbl">Mantenimiento</span></div>
                </td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th width="15%">Código</th>
                    <th width="45%">Nombre de Herramienta</th>
                    <th width="20%">Ubicación</th>
                    <th width="20%">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($herramientas as $h)
                <tr>
                    <td><strong>{{ $h->codigo_qr }}</strong></td>
                    <td>
                        {{ $h->nombre }}
                        @if($h->es_alto_valor)
                            <div style="font-size:7pt; color:#cca75b; font-weight:bold;">[ALTO VALOR]</div>
                        @endif
                    </td>
                    <td>{{ $h->ubicacion ?? 'Taller General' }}</td>
                    <td>
                        <span class="status-badge status-{{ $h->estado }}">{{ $h->estado }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="footer">Sistema ISTPET - Reporte Generado por Javier Tulcán - Taller de Mecánica Automotriz</div>
</body>
</html>
