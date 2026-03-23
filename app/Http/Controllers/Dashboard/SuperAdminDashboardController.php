<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\PortalStatusChangedMail;
use Illuminate\Support\Facades\Mail;


class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // Overview stats
        $totalAdmins = User::where('role', 'admin')->count();
        $totalStaff = User::where('role', 'staff')->count();
        $totalClients = Client::count();

        // Client stage stats (pie chart)
        $stageStats = Client::selectRaw('stage, COUNT(*) as total')
            ->groupBy('stage')
            ->pluck('total', 'stage')
            ->toArray();

        // Client registration trend (line chart for last 14 days)
        $dates = collect();
        $counts = collect();
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dates->push(now()->subDays($i)->format('d M'));
            $counts->push(Client::whereDate('created_at', $date)->count());
        }

        // Top 5 admins by client count (bar chart)
        $topAdmins = User::where('role', 'admin')
            ->withCount(['clients'])
            ->orderBy('clients_count', 'desc')
            ->limit(5)
            ->get();

        // ✅ Add staff and clients for tables with pagination
        $staff = User::where('role', 'staff')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $clients = Client::orderBy('created_at', 'desc')->paginate(10);

        // ✅ Portal status (active/shutdown)
        $portalStatus = SystemSetting::where('key', 'portal_status')->value('value') ?? 'active';

        // ✅ Return to view with all needed data
        return view('dashboard.super_admin.index', compact(
            'totalAdmins',
            'totalStaff',
            'totalClients',
            'stageStats',
            'dates',
            'counts',
            'topAdmins',
            'staff',
            'clients',
            'portalStatus'
        ));
    }

    /**
 * 🔄 Toggle portal status (active/shutdown)
 */
public function togglePortal()
{
    try {
        DB::beginTransaction();

        // Get current status
        $currentStatus = SystemSetting::where('key', 'portal_status')->value('value') ?? 'active';
        $newStatus = $currentStatus === 'active' ? 'shutdown' : 'active';

        // Update status
        SystemSetting::updateOrCreate(
            ['key' => 'portal_status'],
            ['value' => $newStatus]
        );

        DB::commit();

        /*
        |--------------------------------------------------------------------------
        | 📩 SEND MAINTENANCE ALERT EMAIL TO ALL USERS
        |--------------------------------------------------------------------------
        */

        // Get all users who should receive maintenance notice
        $recipients = User::whereIn('role', ['admin', 'staff', 'client'])
                          ->whereNotNull('email')
                          ->get();

        foreach ($recipients as $user) {
            Mail::to($user->email)->queue(new PortalStatusChangedMail($newStatus));
        }

        return back()->with('success', "✅ Portal has been {$newStatus} successfully! Maintenance email sent.");

    } catch (\Throwable $th) {
        DB::rollBack();
        report($th);
        return back()->with('error', '⚠️ Something went wrong while updating portal status.');
    }
}
}