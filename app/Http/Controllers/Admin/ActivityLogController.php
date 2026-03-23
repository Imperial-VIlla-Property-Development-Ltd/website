<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\StaffWorkSession;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(15);

            $workSessions = StaffWorkSession::with('staff')
        ->latest()
        ->paginate(20);

        return view('dashboard.admin.activity.index', compact('logs', 'workSessions'));
    }

    

}