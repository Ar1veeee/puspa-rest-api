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
        $resetUrl = url(
            config('app.frontend_url') .
                '/auth/reset-password?token=' . $this->token .
                '&email=' . urlencode($notifiable->email)
        );

        return (new MailMessage())
            ->subject('Reset Password - ' . config('app.name'))
            ->view('emails.reset-password', [
                'user' => $notifiable,
                'url' => $resetUrl,
            ]);
    }
}
