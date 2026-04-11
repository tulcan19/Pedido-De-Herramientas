<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hoja de Petición - ISTPET</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Helvetica', sans-serif; 
            font-size: 10pt; 
            color: #1e293b; 
            line-height: 1.4; 
            margin: 0;
            background: #fff;
        }
        
        .sidebar { position: fixed; left: 0; top: 0; bottom: 0; width: 10px; background: #23325b; }
        .header { background: #f8fafc; padding: 40px 50px; border-bottom: 2px solid #cca75b; }
        .logo-container { float: left; width: 120px; }
        .title-container { float: left; margin-left: 20px; width: 450px; }
        .title-container h1 { margin: 0; font-size: 16pt; color: #16213e; text-transform: uppercase; }
        .title-container .subtitle { color: #cca75b; font-weight: bold; font-size: 10pt; margin-top: 5px; }
        .meta-info { text-align: right; font-size: 8pt; color: #64748b; }
        .clear { clear: both; }

        .content { padding: 40px 50px; }
        
        /* ── INFO BOX ── */
        .info-grid { 
            width: 100%; 
            margin-bottom: 30px; 
            background: #fdf8ee; 
            border: 1px solid #cca75b; 
            border-radius: 8px;
            padding: 15px;
        }
        .info-label { font-weight: bold; color: #23325b; font-size: 8.5pt; text-transform: uppercase; }
        .info-value { color: #1e293b; font-size: 10pt; padding-bottom: 8px; border-bottom: 1px dotted #e2e8f0; }

        /* ── TABLE ── */
        .tools-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tools-table th { background: #23325b; color: #fff; text-align: left; padding: 10px; font-size: 9pt; }
        .tools-table td { padding: 12px 10px; border-bottom: 1px solid #e2e8f0; font-size: 9pt; }
        
        .acc-list { font-size: 8pt; color: #64748b; font-style: italic; margin-top: 4px; }

        /* ── SIGNATURES ── */
        .signatures { margin-top: 60px; width: 100%; }
        .sig-box { width: 30%; float: left; text-align: center; margin: 0 1.5%; }
        .sig-line { border-top: 1px solid #23325b; padding-top: 8px; font-size: 8pt; font-weight: bold; color: #23325b; text-transform: uppercase; }
        .sig-name { font-weight: bold; font-style: italic; font-size: 10pt; margin-bottom: 30px; color: #1e293b; height: 40px; }

        .footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            padding: 20px 50px; text-align: center; font-size: 7.5pt; color: #94a3b8; border-top: 1px solid #e2e8f0;
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
            <h1>Hoja de Petición</h1>
            <div class="subtitle">SOLICITUD DE MATERIALES Y HERRAMIENTAS</div>
            <div style="font-size: 8pt; color: #64748b; margin-top: 5px;">TALLER DE MECÁNICA AUTOMOTRIZ</div>
        </div>
        <div class="meta-info">
            Petición #{{ str_pad($peticion->id, 5, '0', STR_PAD_LEFT) }}<br>
            Emisión: {{ $peticion->created_at->format('d/m/Y H:i') }}
        </div>
        <div class="clear"></div>
    </div>

    <div class="content">
        <table class="info-grid">
            <tr>
                <td width="50%">
                    <div class="info-label">Estudiante Responsable</div>
                    <div class="info-value">{{ $peticion->usuario->nombre }}</div>
                </td>
                <td width="50%">
                    <div class="info-label">Identificación (Cédula)</div>
                    <div class="info-value">{{ $peticion->usuario->cedula }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="info-label">Docente de Práctica</div>
                    <div class="info-value">{{ $peticion->docente->nombre ?? $peticion->docente }}</div>
                </td>
                <td>
                    <div class="info-label">Asignatura</div>
                    <div class="info-value">{{ $peticion->asignatura }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="info-label">Nombre de la Práctica</div>
                    <div class="info-value">{{ $peticion->practica }}</div>
                </td>
            </tr>
        </table>

        <div style="margin-bottom: 10px; font-weight: bold; font-size: 11pt; color: #23325b;">DETALLE DE HERRAMIENTAS</div>
        <table class="tools-table">
            <thead>
                <tr>
                    <th width="10%">Cant.</th>
                    <th width="65%">Descripción del Equipo</th>
                    <th width="25%">Código QR / ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peticion->prestamos as $prestamo)
                <tr>
                    <td style="text-align: center;">1</td>
                    <td>
                        <strong>{{ $prestamo->herramienta->nombre }}</strong>
                        @php
                            $accsDisponibles = array_filter($prestamo->herramienta->accesorios_formateados, fn($acc) => $acc['estado'] === 'disponible');
                        @endphp
                        @if(count($accsDisponibles) > 0)
                            <div class="acc-list">Incluye: {{ implode(', ', array_column($accsDisponibles, 'nombre')) }}</div>
                        @endif
                    </td>
                    <td style="text-align: center; color: #64748b;">{{ $prestamo->herramienta->codigo_qr }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 25px;">
            <div class="info-label">Observaciones Adicionales</div>
            <div style="font-size: 9pt; color: #475569; padding: 10px; background: #f8fafc; border-radius: 5px; margin-top: 5px; min-height: 40px;">
                {{ $peticion->observaciones ?? 'Ninguna observación registrada.' }}
            </div>
        </div>

        <div class="signatures">
            <div class="sig-box">
                <div class="sig-name">{{ $peticion->usuario->nombre }}</div>
                <div class="sig-line">ENTREGUÉ CONFORME (EST.)</div>
            </div>
            <div class="sig-box">
                <div class="sig-name">{{ $peticion->docente->nombre ?? $peticion->docente }}</div>
                <div class="sig-line">DOCENTE / AUTORIZADO</div>
            </div>
            <div class="sig-box">
                <div class="sig-name">Javier Tulcán</div>
                <div class="sig-line">ENCARGADO DE TALLER</div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="footer">
        Este documento es un comprobante digital de préstamo generado por el sistema ISTPET.<br>
        Firma digital ID: {{ sha1($peticion->id.$peticion->created_at) }}
    </div>
</body>
</html>
