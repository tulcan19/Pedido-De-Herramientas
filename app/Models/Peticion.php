<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peticion extends Model
{
    protected $table = 'peticiones';

    protected $fillable = [
        'usuario_id',
        'docente_id',
        'docente', // Mantener por compatibilidad temporal si es necesario
        'asignatura',
        'practica',
        'minutos_estimados',
        'observaciones',
        'foto_entrega',
        'estado',
        'docente_aprueba',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function docente()
    {
        return $this->belongsTo(Usuario::class, 'docente_id');
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'peticion_id');
    }
}
