<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NuevaReservaNotification extends Notification
{
    use Queueable;

    protected $prestamo;

    /**
     * Create a new notification instance.
     */
    public function __construct($prestamo)
    {
        $this->prestamo = $prestamo;
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
    public function toDatabase(object $notifiable): array
    {
        return [
            'prestamo_id' => $this->prestamo->id,
            'mensaje' => 'El estudiante ' . $this->prestamo->usuario->nombre . ' ha separado la herramienta: ' . $this->prestamo->herramienta->nombre . '.',
            'estudiante' => $this->prestamo->usuario->nombre,
            'herramienta' => $this->prestamo->herramienta->nombre,
            'fecha' => $this->prestamo->fecha_reserva->toDateTimeString(),
        ];
    }
}
