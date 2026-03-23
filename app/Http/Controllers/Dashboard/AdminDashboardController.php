<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // === Basic counts ===
        $totalStaff = User::where('role', 'staff')->count();
        $totalClients = Client::count();
        $completed = Client::where('stage', 'completed')->count();
        $newClients = Client::whereNull('staff_id')->count();
        $assignedClients = Client::whereNotNull('staff_id')->count();

        // === Stage breakdown ===
        $stageData = [
            'new' => Client::where('stage', 'new')->count(),
            'in_progress' => Client::where('stage', 'in_progress')->count(),
            'submitted_to_pfa' => Client::where('stage', 'submitted_to_pfa')->count(),
            'approval_pending' => Client::where('stage', 'approval_pending')->count(),
            'approved' => Client::where('stage', 'approved')->count(),
            'rejected' => Client::where('stage', 'rejected')->count(),
            'Distbursement' => Client::where('stage', 'Disbursement')->count(),
        ];

        // === Clients over time for chart (last 10 days) ===
        $dates = collect();
        $counts = collect();
        for ($i = 9; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dates->push(now()->subDays($i)->format('d M'));
            $counts->push(Client::whereDate('created_at', $date)->count());
        }

        // === Top staff (by assigned clients) ===
        $topStaff = User::where('role', 'staff')
            ->leftJoin('clients', 'users.id', '=', 'clients.staff_id')
            ->select('users.id', 'users.name', DB::raw('COUNT(clients.id) as clients_count'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('clients_count')
            ->limit(5)
            ->get();

        // === Sidebar menu ===
        $menu = [
            ['label' => 'Overview', 'url' => route('dashboard.admin'), 'active' => 'dashboard/admin'],
            ['label' => 'Staff', 'url' => route('admin.staff.index'), 'active' => 'dashboard/admin/staff*'],
            ['label' => 'Clients', 'url' => route('admin.client.index'), 'active' => 'dashboard/admin/client*'],
            ['label' => 'Assignments', 'url' => route('admin.assignments.index'), 'active' => 'dashboard/admin/assignments*'],
            ['label' => 'Reports', 'url' => route('admin.reports.index'), 'active' => 'dashboard/admin/reports*'],
           // ['label' => 'Document Review', 'url' => route('admin.documents.index'), 'active' => 'dashboard/admin/documents*'],
            ['label' => 'Exceptions', 'url' => route('admin.exceptions'), 'active' => 'dashboard/admin/exceptions*'],
            ['label' => 'Announcements', 'url' => route('admin.announcements'), 'active' => 'dashboard/admin/announcements*'],
            ['label' => 'Map', 'url' => route('admin.map'), 'active' => 'dashboard/admin/map*'],
            ['label' => 'Activity Log', 'url' => route('admin.activity.index'), 'active' => 'dashboard/admin/activity*'],
        ];

        // === Render view ===
        return view('dashboard.admin.index', compact(
            'totalStaff',
            'totalClients',
            'completed',
            'newClients',
            'assignedClients',
            'stageData',
            'dates',
            'counts',
            'topStaff',
            'menu'
        ));
    }
}
