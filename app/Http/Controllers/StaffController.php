<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function dashboard()
    {
        $staff = Auth::guard('staff')->user();
        return view('portal.staff.dashboard', compact('staff'));
    }

    public function messages()
    {
        $staff = Auth::guard('staff')->user();
        return view('portal.staff.messages', compact('staff'));
    }
}
