<?php

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

/**
 * Class CustomVerifyEmailTest
 *
 * This class contains unit tests for the CustomVerifyEmail notification.
 */
class CustomVerifyEmailTest extends TestCase
{
    /**
     * Test that the CustomVerifyEmail notification can be created.
     *
     * This test verifies that the notification is correctly instantiated.
     */
    public function test_custom_verify_email_can_be_created(): void
    {
        try {
            $customVerifyEmail = new CustomVerifyEmail();
            $this->assertInstanceOf(CustomVerifyEmail::class, $customVerifyEmail);
        } catch (Exception $e) {
            Log::error('Failed to create CustomVerifyEmail notification: '.$e->getMessage());
            $this->fail('Exception thrown while creating CustomVerifyEmail: '.$e->getMessage());
        }
    }

    /**
     * Test that the CustomVerifyEmail notification returns the correct via channels.
     *
     * This test verifies that the notification will be sent via the 'mail' channel.
     */
    public function test_custom_verify_email_returns_correct_via_channels(): void
    {
        try {
            $customVerifyEmail = new CustomVerifyEmail();
            $this->assertEquals(['mail'], $customVerifyEmail->via(null));
        } catch (Exception $e) {
            Log::error('Failed to get via channels for CustomVerifyEmail notification: '.$e->getMessage());
            $this->fail('Exception thrown while getting via channels for CustomVerifyEmail: '.$e->getMessage());
        }
    }

    /**
     * Test that the CustomVerifyEmail notification generates the correct verification URL.
     *
     * This test verifies that the notification generates a valid temporary signed URL for email verification.
     *
     * @throws Exception
     */
    public function test_custom_verify_email_generates_correct_verification_url(): void
    {
        try {
            $notifiable = $this->createMock(User::class);
            $notifiable->method('getKey')->willReturn(1);
            $notifiable->method('getEmailForVerification')->willReturn('test@example.com');

            $customVerifyEmail = new CustomVerifyEmail();
            $expectedUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(config('auth.verification.expire', 60)),
                ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
            );

            $this->assertEquals($expectedUrl, $customVerifyEmail->verificationUrl($notifiable));
        } catch (Exception $e) {
            Log::error('Failed to generate verification URL for CustomVerifyEmail notification: '.$e->getMessage());
            $this->fail('Exception thrown while generating verification URL for CustomVerifyEmail: '.$e->getMessage());
        }
    }

    /**
     * Test that the CustomVerifyEmail notification returns the correct mail message.
     *
     * This test verifies that the notification generates the correct mail message content.
     *
     * @throws Exception
     */
    public function test_custom_verify_email_returns_correct_mail_message(): void
    {
        try {
            $notifiable = $this->createMock(User::class);
            $notifiable->method('getKey')->willReturn(1);
            $notifiable->method('getEmailForVerification')->willReturn('test@example.com');

            $customVerifyEmail = new CustomVerifyEmail();
            $verificationUrl = $customVerifyEmail->verificationUrl($notifiable);

            $mailMessage = (new MailMessage)
                ->subject('Erősítsd meg e-mail címed')
                ->greeting('Helló!')
                ->line('Kérlek, kattints az alábbi gombra az e-mail címed megerősítéséhez.')
                ->action('E-mail cím megerősítése', $verificationUrl)
                ->line('Amennyiben Te nem hoztál létre fiókot, további teendő nem szükséges.');

            $this->assertEquals($mailMessage, $customVerifyEmail->toMail($notifiable));
        } catch (Exception $e) {
            Log::error('Failed to generate mail message for CustomVerifyEmail notification: '.$e->getMessage());
            $this->fail('Exception thrown while generating mail message for CustomVerifyEmail: '.$e->getMessage());
        }
    }
}
