<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'peticion_id',
        'usuario_id',
        'herramienta_id',
        'fecha_reserva',
        'fecha_devolucion_esperada',
        'fecha_devolucion_real',
        'estado',
        'foto_devolucion',
        'firma_devolucion',
        'checklist_accesorios',
        'observaciones',
        'auditoria_estado',
        'auditoria_notas',
    ];

    protected $casts = [
        'fecha_reserva' => 'datetime',
        'fecha_devolucion_esperada' => 'datetime',
        'fecha_devolucion_real' => 'datetime',
        'checklist_accesorios' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function herramienta()
    {
        return $this->belongsTo(Herramienta::class);
    }

    public function peticion()
    {
        return $this->belongsTo(Peticion::class);
    }
}
