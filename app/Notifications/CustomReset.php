<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class CustomReset extends Notification
{
    use Queueable;

    public string $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'password.reset',
            Carbon::now()->addMinutes(Config::get('auth.passwords.users.expire')),
            ['token' => $this->token]
        );
    }

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Jelszó visszaállítás')
            ->greeting('Üdvözlöm!')
            ->line('Kérjük, kattintson az alábbi gombra a jelszó visszaállításához.')
            ->action('Jelszó visszaállítása', $verificationUrl)
            ->line('Amennyiben Ön nem kérte a jelszó visszaállítását, további teendő nem szükséges.');
    }
}
