<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AnnouncementNotification extends Notification
{
    use Queueable;

    protected $announcement;

    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('New Announcement')
            ->greeting("Hello {$notifiable->name}")
            ->line($this->announcement->title)
            ->line($this->announcement->body)
            ->action('View Dashboard', url('/dashboard/client'))
            ->line('Stay updated with the latest portal information.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'announcement',
            'announcement_id' => $this->announcement->id,
            'message' => "{$this->announcement->title}: {$this->announcement->body}",
        ];
    }
}
