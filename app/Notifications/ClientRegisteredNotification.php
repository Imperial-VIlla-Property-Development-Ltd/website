<?php

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Determine which channels to send on.
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // You can remove 'mail' if you only want in-app notifications
    }

    /**
     * Mail message (optional)
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Client Registration')
            ->greeting('Hello Admin,')
            ->line('A new client has just completed their registration.')
            ->line('Client Name: ' . $this->client->firstname . ' ' . $this->client->lastname)
            ->line('Pension Number: ' . $this->client->user->pension_number)
            ->action('View Client', url('/dashboard/admin/client/' . $this->client->id))
            ->line('Thank you for managing ImperialVilla registrations.');
    }

    /**
     * Database notification payload
     */
    public function toDatabase($notifiable)
    {
        return [
            'type'        => 'registration',
            'message'     => 'New client registered: ' . $this->client->firstname . ' ' . $this->client->lastname,
            'client_id'   => $this->client->id,
            'pension_no'  => $this->client->user->pension_number,
        ];
    }
}
