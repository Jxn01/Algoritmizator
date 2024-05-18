<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class CustomVerifyEmail
 *
 * The CustomVerifyEmail notification class is used to handle email verification notifications.
 * It generates a verification URL and sends it to the user's email.
 */
class CustomVerifyEmail extends VerifyEmail
{
    /**
     * Get the verification URL.
     *
     * @param  mixed  $notifiable  The notifiable entity.
     * @return string The verification URL.
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
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
            ->subject('Erősítse meg e-mail címét')
            ->greeting('Üdvözlöm!')
            ->line('Kérjük, kattintson az alábbi gombra az e-mail címének megerősítéséhez.')
            ->action('E-mail cím megerősítése', $verificationUrl)
            ->line('Amennyiben Ön nem hozott létre fiókot, további teendő nem szükséges.');
    }
}
