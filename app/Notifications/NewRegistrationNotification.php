<?php

namespace App\Notifications;

use App\Models\Child;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewRegistrationNotification extends Notification
{
    use Queueable;

    private $child;

    /**
     * Create a new notification instance.
     */
    public function __construct(Child $child)
    {
        $this->child = $child;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'child_id' => $this->child->id,
            'child_name' => $this->child->child_name,
            'guardian_name' => $this->child->family->guardians->first()->guardian_name,
            'message' => 'Pendaftaran baru: ' . $this->child->child_name . ' (' . $this->child->family->guardians->first()->guardian_name . ')',
            'type' => 'registration',
        ];
    }
}
