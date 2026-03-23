<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewExceptionNotification extends Notification
{
    use Queueable;
    public $exception;

    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    public function via($notifiable) { return ['database','mail']; }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('New Exception')
            ->line("An exception was raised for your case: {$this->exception->message}")
            ->action('View', url('/dashboard/client'))
            ->line('Contact support if you have questions.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'=>'exception',
            'exception_id'=>$this->exception->id,
            'message'=>$this->exception->message,
        ];
    }
}
