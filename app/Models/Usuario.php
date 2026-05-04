<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UsuarioFactory> */
    use HasFactory, Notifiable;

    /**
     * Define the table associated with the model.
     */
    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'cedula',
        'email',
        'password',
        'rol',
        'asignatura',
        'semestre',
        'ultimo_cambio_semestre',
    ];

    /**
     * Comprobar si el usuario es coordinador.
     */
    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    /**
     * Comprobar si el usuario es docente.
     */
    public function esDocente(): bool
    {
        return $this->rol === 'docente';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'ultimo_cambio_semestre' => 'datetime',
        ];
    }

    /**
     * Obtener los préstamos de este usuario
     */
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'usuario_id');
    }

    public function peticiones()
    {
        return $this->hasMany(Peticion::class, 'usuario_id');
    }

    /**
     * Peticiones donde este usuario es el docente responsable
     */
    public function peticionesAsignadas()
    {
        return $this->hasMany(Peticion::class, 'docente_id');
    }
}
