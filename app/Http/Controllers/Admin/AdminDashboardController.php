<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // === Summary Cards ===
        $totalStaff = User::where('role', 'staff')->count();
        $totalClients = Client::count();
        $newClients = Client::whereNull('staff_id')->count();
        $assignedClients = Client::whereNotNull('staff_id')->count();

        // === Stage Distribution ===
        $stages = ['new', 'in_progress', 'submitted_to_pfa', 'approval_pendind', 'approved', 'rejected','disbursement'];
        $stageData = [];
        foreach ($stages as $s) {
            $stageData[$s] = Client::where('stage', $s)->count();
        }

        // === Client Registrations (Last 14 Days) ===
        $dates = collect();
        $counts = collect();
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dates->push(now()->subDays($i)->format('d M'));
            $counts->push(Client::whereDate('created_at', $date)->count());
        }

        // === Top Performing Staff ===
        $topStaff = User::select('id', 'name')
            ->where('role', 'staff')
            ->withCount(['clients'])
            ->orderBy('clients_count', 'desc')
            ->limit(6)
            ->get();

        // === Client Tables (NEW + ASSIGNED) ===
        $newClientList = Client::whereNull('staff_id')
            ->latest()
            ->take(10)
            ->with('user')
            ->get();

        $assignedClientList = Client::whereNotNull('staff_id')
            ->latest()
            ->take(10)
            ->with(['user', 'staff'])
            ->get();

        // === Sidebar Menu Items ===
        $menu = [
            ['label' => 'Overview', 'url' => route('dashboard.admin'), 'active' => 'dashboard/admin'],
            ['label' => 'Clients', 'url' => route('admin.client.index'), 'active' => 'dashboard/admin/clients*'],
            ['label' => 'Assignments', 'url' => route('admin.assignments.index'), 'active' => 'dashboard/admin/assignments*'],
            ['label' => 'Staff', 'url' => route('admin.staff.index'), 'active' => 'dashboard/admin/staff*'],
            
            ['label' => 'Reports', 'url' => route('admin.reports.index'), 'active' => 'dashboard/admin/reports*'],
            ['label' => 'Exceptions', 'url' => route('admin.exceptions'), 'active' => 'dashboard/admin/exceptions*'],
            ['label' => 'Announcements', 'url' => route('admin.announcements'), 'active' => 'dashboard/admin/announcements*'],
            ['label' => 'Activity Log', 'url' => route('admin.activity.index'), 'active' => 'dashboard/admin/activity*'],
        ];

        return view('dashboard.admin.index', compact(
            'totalStaff', 'totalClients', 'newClients', 'assignedClients',
            'stageData', 'dates', 'counts', 'topStaff',
            'newClientList', 'assignedClientList', 'menu'
        ));
    }
}
