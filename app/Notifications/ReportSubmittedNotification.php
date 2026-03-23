<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportSubmittedNotification extends Notification
{
    use Queueable;

    protected $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('New Report Submitted')
            ->greeting("Hello {$notifiable->name}")
            ->line("A staff member has submitted a new report.")
            ->line("Report ID: {$this->report->id}")
            ->line("Date: {$this->report->report_date}")
            ->action('View Report', url('/dashboard/admin/reports'))
            ->line('Please review it at your earliest convenience.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'report',
            'report_id' => $this->report->id,
            'message' => "Staff report #{$this->report->id} submitted.",
        ];
    }
}
