<?php

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class CustomVerifyEmailTest extends TestCase
{
    public function test_custom_verify_email_can_be_created(): void
    {
        $customVerifyEmail = new CustomVerifyEmail();

        $this->assertInstanceOf(CustomVerifyEmail::class, $customVerifyEmail);
    }

    public function test_custom_verify_email_returns_correct_via_channels(): void
    {
        $customVerifyEmail = new CustomVerifyEmail();

        $this->assertEquals(['mail'], $customVerifyEmail->via(null));
    }

    /**
     * @throws Exception
     */
    public function test_custom_verify_email_generates_correct_verification_url(): void
    {
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
    }

    /**
     * @throws Exception
     */
    public function test_custom_verify_email_returns_correct_mail_message(): void
    {
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
    }
}
