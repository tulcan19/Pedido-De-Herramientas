<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo_qr',
        'estado',
        'ubicacion',
        'imagen',
    ];

    /**
     * Get the tool's image URL.
     */
    public function getImagenUrlAttribute()
    {
        if ($this->imagen && \Storage::disk('public')->exists($this->imagen)) {
            return \Storage::url($this->imagen);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nombre) . '&color=23325b&background=ebf1ff';
    }

    /**
     * Get the tool's QR history.
     */
    public function historialQr()
    {
        return $this->hasMany(HistorialQr::class, 'herramienta_id')->latest();
    }

    /**
     * Get the tool's loans.
     */
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'herramienta_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::updating(function ($herramienta) {
            // Si el codigo_qr ha cambiado y no está vacío, guardamos el original en el historial
            if ($herramienta->isDirty('codigo_qr')) {
                $oldCode = $herramienta->getOriginal('codigo_qr');
                if (!empty($oldCode)) {
                    $herramienta->historialQr()->create([
                        'codigo_qr' => $oldCode
                    ]);
                }
            }
        });

        static::saving(function ($herramienta) {
            if (empty($herramienta->codigo_qr)) {
                $lastTool = self::where('codigo_qr', 'like', 'HTA-%')->latest('id')->first();
                $nextNum = 1;
                if ($lastTool) {
                    $lastNum = (int) str_replace('HTA-', '', $lastTool->codigo_qr);
                    $nextNum = $lastNum + 1;
                }
                $herramienta->codigo_qr = 'HTA-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
