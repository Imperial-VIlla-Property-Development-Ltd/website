<?php
namespace App\Listeners;

use App\Models\StaffWorkSession;
use Illuminate\Auth\Events\Logout;
use Carbon\Carbon;

class LogStaffLogout
{
    public function handle(Logout $event)
    {
        $user = $event->user;

        if ($user->role !== 'staff') {
            return;
        }

        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        $session = StaffWorkSession::where('staff_id', $user->id)
            ->where('work_date', $today)
            ->first();

        if ($session && !$session->end_time) {

            $start = Carbon::parse($session->start_time);
            $hours = $start->diffInMinutes($now) / 60;

            $session->update([
                'end_time' => $now->format('H:i:s'),
                'hours_spent' => round($hours, 2),
            ]);
        }
    }
}
