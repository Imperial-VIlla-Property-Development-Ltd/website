<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StaffCreatedNotification extends Notification
{
    use Queueable;

    protected $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Staff Account - ImperialVilla')
                    ->greeting("Hello {$notifiable->full_name},")
                    ->line('An account has been created for you at ImperialVilla.')
                    ->line("Email: {$notifiable->email}")
                    ->line("Password: {$this->password}")
                    ->action('Login', url('/admin/login'))
                    ->line('Please change your password after first login.');
    }
}
