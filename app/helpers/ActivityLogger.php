<?php

namespace App\Helpers;

use App\Models\StaffActivity;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(string $description)
    {
        if (Auth::guard('staff')->check()) {
            StaffActivity::create([
                'staff_id' => Auth::guard('staff')->id(),
                'description' => $description,
            ]);
        }
    }
}
