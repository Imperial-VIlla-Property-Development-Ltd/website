<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StaffAssignedNotification extends Notification
{
    use Queueable;

    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // mail optional if configured
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('New Client Assigned')
            ->greeting("Hello {$notifiable->name}")
            ->line("You have been assigned a new client: {$this->client->firstname} {$this->client->lastname}")
            ->action('View Client', url("/dashboard/staff/clients/{$this->client->id}"))
            ->line('Please attend to this client as soon as possible.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'assignment',
            'client_id' => $this->client->id,
            'message' => "Assigned client {$this->client->firstname} {$this->client->lastname}",
        ];
    }
}
