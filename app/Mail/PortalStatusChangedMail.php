<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PortalStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newStatus;    // shutdown | active

    public function __construct($newStatus)
    {
        $this->newStatus = $newStatus;
    }

    public function build()
    {
        return $this->subject(
            $this->newStatus === 'shutdown' 
                ? '🚨 Portal Maintenance Notice'
                : '✅ Portal is Now Active'
        )
        ->markdown('emails.portal.status');
    }
}
