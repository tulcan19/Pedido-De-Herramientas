<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncidenciaRegistrada extends Notification
{
    use Queueable;

    protected $prestamo;
    protected $notas;

    /**
     * Create a new notification instance.
     */
    public function __construct($prestamo, $notas)
    {
        $this->prestamo = $prestamo;
        $this->notas = $notas;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'mensaje' => "⚠️ INCIDENCIA: Se ha reportado una novedad en la herramienta '{$this->prestamo->herramienta->nombre}'. Detalle: {$this->notas}",
            'prestamo_id' => $this->prestamo->id,
            'fecha' => now()->toDateTimeString(),
            'tipo' => 'incidencia'
        ];
    }
}
