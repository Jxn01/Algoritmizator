<?php

namespace Tests\Unit\Notifications;

use App\Notifications\CustomReset;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class CustomResetTest extends TestCase
{
    public function test_custom_reset_notification_can_be_created_with_valid_token(): void
    {
        $token = 'testToken';
        $customReset = new CustomReset($token);

        $this->assertEquals($token, $customReset->token);
    }

    public function test_custom_reset_notification_returns_correct_via_channels(): void
    {
        $token = 'testToken';
        $customReset = new CustomReset($token);

        $this->assertEquals(['mail'], $customReset->via(null));
    }

    public function test_custom_reset_notification_generates_correct_verification_url(): void
    {
        $token = 'testToken';
        $customReset = new CustomReset($token);
        $expectedUrl = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(config('auth.passwords.users.expire')),
            ['token' => $token]
        );

        $this->assertEquals($expectedUrl, $customReset->verificationUrl(null));
    }

    public function test_custom_reset_notification_returns_correct_mail_message(): void
    {
        $token = 'testToken';
        $customReset = new CustomReset($token);
        $verificationUrl = $customReset->verificationUrl(null);

        $mailMessage = (new MailMessage)
            ->subject('Jelszó visszaállítás')
            ->greeting('Helló!')
            ->line('Kérlek, kattints az alábbi gombra a jelszó visszaállításához.')
            ->action('Jelszó visszaállítása', $verificationUrl)
            ->line('Amennyiben Te nem kérted a jelszó visszaállítását, további teendő nem szükséges.');

        $this->assertEquals($mailMessage, $customReset->toMail(null));
    }
}
