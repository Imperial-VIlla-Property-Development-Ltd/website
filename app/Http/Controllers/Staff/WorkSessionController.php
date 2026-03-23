<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\StaffWorkSession;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorkSessionController extends Controller
{
    public function start()
    {
        $staffId = auth()->id();
        $today   = Carbon::today()->toDateString();

        // Check if already exists
        $session = StaffWorkSession::where('staff_id', $staffId)
            ->where('work_date', $today)
            ->first();

        if (!$session) {
            StaffWorkSession::create([
                'staff_id' => $staffId,
                'work_date' => $today,
                'start_time' => Carbon::now(),
            ]);
        }

        return response()->json(['status' => 'started']);
    }

    public function end()
    {
        $staffId = auth()->id();
        $today   = Carbon::today()->toDateString();

        $session = StaffWorkSession::where('staff_id', $staffId)
            ->where('work_date', $today)
            ->first();

        if ($session && !$session->end_time) {
            $session->end_time = Carbon::now();

            $session->hours_spent = Carbon::parse($session->start_time)
                ->diffInMinutes($session->end_time) / 60;

            $session->save();
        }

        return response()->json(['status' => 'ended']);
    }
}
