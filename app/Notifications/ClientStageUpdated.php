<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Client;

class ClientStageUpdated extends Notification
{
    use Queueable;

    protected $client;

    /**
     * Create a new notification instance.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail']; // You can also add 'database' if you want in-app alerts
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Client Stage Updated')
            ->greeting('Hello Admin,')
            ->line('A client’s stage has been updated.')
            ->line('Client: ' . $this->client->full_name)
            ->line('Pension ID: ' . $this->client->pension_id)
            ->line('New Stage: ' . $this->client->stage)
            ->action('View Dashboard', url('/admin/dashboard'))
            ->line('Thank you for using ImperialVilla Admin.');
    }
}
