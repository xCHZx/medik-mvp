<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Routing\Route;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Solicitud de cambio de contraseña')
                    ->line('Has recibido este correo porque solicitaste cambiar tu contraseña.')
                    ->line('Si no has sido tu el que realizo esta accion ignora este correo')
                    ->line('Si deseas modificarla da clic al boton de abajo.')
                    ->action('Cambiar contraseña', url(config('app.url').route('password.reset', ['token' => $this->token, 'email' => $notifiable->email], false)))
                    ->line('Gracias por usar Medik!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
