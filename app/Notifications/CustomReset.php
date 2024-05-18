<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class CustomReset
 *
 * The CustomReset notification class is used to handle password reset notifications.
 * It generates a password reset link and sends it to the user's email.
 */
class CustomReset extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     */
    public string $token;

    /**
     * Create a new notification instance.
     *
     * @param  string  $token  The password reset token.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable  The notifiable entity.
     * @return array The delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the password reset URL.
     *
     * @param  mixed  $notifiable  The notifiable entity.
     * @return string The password reset URL.
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'password.reset',
            Carbon::now()->addMinutes(Config::get('auth.passwords.users.expire')),
            ['token' => $this->token]
        );
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable  The notifiable entity.
     * @return MailMessage The mail message.
     */
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
