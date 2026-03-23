<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientLoginAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ip;
    public $time;

    public function __construct($user)
    {
        $this->user = $user;
        $this->ip = request()->ip();
        $this->time = now()->format('d M Y, h:i A');
    }

    public function build()
    {
        return $this->subject('New Login to Your Account')
                    ->markdown('emails.client-login-alert')
                    ->with([
                        'user' => $this->user,
                        'ip' => $this->ip,
                        'time' => $this->time,
                    ]);
    }
}
