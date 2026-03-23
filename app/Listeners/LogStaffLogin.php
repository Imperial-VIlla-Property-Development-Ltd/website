<?php
namespace App\Listeners;

use App\Models\StaffWorkSession;
use Illuminate\Auth\Events\Login;
use Carbon\Carbon;

class LogStaffLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;

        if ($user->role !== 'staff') {
            return;
        }

        $today = Carbon::today()->toDateString();

        // If already has session today, do not recreate
        $session = StaffWorkSession::where('staff_id', $user->id)
            ->where('work_date', $today)
            ->first();

        if (!$session) {
            StaffWorkSession::create([
                'staff_id' => $user->id,
                'work_date' => $today,
                'start_time' => Carbon::now()->format('H:i:s'),
            ]);
        }
    }
}
