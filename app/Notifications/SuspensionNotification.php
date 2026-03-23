<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SuspensionNotification extends Notification
{
    use Queueable;

    protected $active;

    public function __construct($active)
    {
        $this->active = $active;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $status = $this->active ? 'reinstated' : 'suspended';

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject("Account {$status}")
            ->greeting("Hello {$notifiable->name}")
            ->line("Your staff account has been {$status} by the admin.")
            ->line('Contact your administrator for further details.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'suspension',
            'message' => $this->active
                ? 'Your account has been reactivated.'
                : 'Your account has been suspended by admin.',
        ];
    }
}
