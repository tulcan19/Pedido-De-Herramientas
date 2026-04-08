<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialQr extends Model
{
    use HasFactory;

    protected $table = 'historial_qr';

    protected $fillable = ['herramienta_id', 'codigo_qr'];

    /**
     * Get the tool associated with this history.
     */
    public function herramienta()
    {
        return $this->belongsTo(Herramienta::class);
    }
}
