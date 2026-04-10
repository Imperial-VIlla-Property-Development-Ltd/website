<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class StaffActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $staff;
    protected $action;
    protected $details;

    public function __construct($staff, $action, $details = null)
    {
        $this->staff = $staff;
        $this->action = $action;
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['database']; // Store in database
    }

    public function toArray($notifiable)
    {
        return [
            'staff_name' => $this->staff->name,
            'action' => $this->action,
            'details' => $this->details,
        ];
    }
}
