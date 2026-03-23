<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffClientAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $staff;
    public $clients;

public function __construct($staff, $clients)
{
    $this->staff = $staff;
    $this->clients = $clients; // Now supports array/collection
}


    public function build()
{
    return $this->subject('New Client Assignment Notification')
                ->markdown('emails.staff_clients_assigned');
}
}
