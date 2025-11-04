<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = $this->getResetUrl($notifiable);

        return (new MailMessage())
            ->subject('Reset Password - ' . config('app.name'))
            ->view('emails.reset-password', [
                'user' => $notifiable,
                'url' => $resetUrl,
            ]);
    }

    private function getResetUrl($notifiable): string
    {
        $token = $this->token;
        $email = urlencode($notifiable->email);

        // URL untuk web
        return url(
            config('app.frontend_url') .
            "/auth/reset-password?token={$token}&email={$email}"
        );
    }
}
