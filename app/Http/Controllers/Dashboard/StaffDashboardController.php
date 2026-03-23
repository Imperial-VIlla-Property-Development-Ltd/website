<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $staff = Auth::user();

        // Basic metrics
        $totalClients = Client::where('staff_id', $staff->id)->count();
        $completed = Client::where('staff_id', $staff->id)->where('stage', 'completed')->count();
        $todayAssigned = Client::where('staff_id', $staff->id)
            ->whereDate('created_at', now()->toDateString())->count();

        // Chart data
        $stages = ['new', 'in_progress', 'submitted_to_pfa','approval_pending','approved', 'rejected','disbursement'];
        $stageData = [];
        foreach ($stages as $stage) {
            $stageData[$stage] = Client::where('staff_id', $staff->id)->where('stage', $stage)->count();
        }

        $menu = [
            ['label'=>'Overview','url'=>route('dashboard.staff'),'active'=>'dashboard/staff'],
            ['label'=>'My Clients','url'=>route('staff.clients'),'active'=>'dashboard/staff/clients*'],
            
            ['label'=>'Reports','url'=>route('staff.reports.index'),'active'=>'dashboard/staff/reports*'],
            ['label'=>'Messages','url'=>route('messages.index'),'active'=>'messages*'],
        ];

        return view('dashboard.staff.index', compact(
            'staff','menu','totalClients','completed','todayAssigned','stageData'
        ));
    }
}
