<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ClientWelcomeNotification extends Notification
{
    public function __construct(public $user, public $rawPassword) {}

    public function via($notifiable)
    {
        return ['mail'];  
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to ImperialVilla Portal')
            ->greeting('Welcome, '.$this->user->name)
            ->line('Your registration is complete.')
            ->line('Below are your login details:')
            ->line('Email: '.$this->user->email)
            ->line('Password: '.$this->rawPassword)
            ->line('Pension Number: '.$this->user->pension_number)
            ->action('Login to Portal', url('/login'))
            ->line('Please keep this information secure.');
    }
}
