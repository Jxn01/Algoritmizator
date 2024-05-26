<?php

namespace Tests\Unit\Notifications;

use App\Notifications\CustomReset;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

/**
 * Class CustomResetTest
 *
 * This class contains unit tests for the CustomReset notification.
 */
class CustomResetTest extends TestCase
{
    /**
     * Test that the CustomReset notification can be created with a valid token.
     *
     * This test verifies that the notification is correctly instantiated with the given token.
     */
    public function test_custom_reset_notification_can_be_created_with_valid_token(): void
    {
        $token = 'testToken';
        $customReset = new CustomReset($token);

        $this->assertEquals($token, $customReset->token);
    }

    /**
     * Test that the CustomReset notification returns the correct via channels.
     *
     * This test verifies that the notification will be sent via the 'mail' channel.
     */
    public function test_custom_reset_notification_returns_correct_via_channels(): void
    {
        $token = 'testToken';
        $customReset = new CustomReset($token);

        $this->assertEquals(['mail'], $customReset->via(null));
    }

    /**
     * Test that the CustomReset notification generates the correct verification URL.
     *
     * This test verifies that the notification generates a valid temporary signed URL for password reset.
     */
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

    /**
     * Test that the CustomReset notification returns the correct mail message.
     *
     * This test verifies that the notification generates the correct mail message content.
     */
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
