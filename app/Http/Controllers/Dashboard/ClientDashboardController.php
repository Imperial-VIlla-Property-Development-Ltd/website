<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\Client;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $client = $user->client;

        // 🧩 Get Assigned Staff (if any)
        $assignedStaff = null;
        if ($client && $client->assigned_staff_id) {
            $assignedStaff = \App\Models\User::find($client->assigned_staff_id)?->name ?? 'Not Assigned';
        } else {
            $assignedStaff = 'Not Assigned';
        }

        // ✅ Announcements from admin
        $news = Announcement::latest()->limit(5)->pluck('body')->toArray();

        // ✅ Internal stages (staff/admin see all)
        $stages = [
            ['key' => 'new', 'label' => 'Registration'],
            ['key' => 'in_progress', 'label' => 'Processing'],
            ['key' => 'submitted_to_pfa', 'label' => 'Submitted to PFA'],
            ['key' => 'approval_pending', 'label' => 'Pending Approval'],
            ['key' => 'approved', 'label' => 'Approved'],
            ['key' => 'rejected', 'label' => 'Rejected'],
            ['key' => 'disbursement', 'label' => 'Disbursement'],
        ];

        $stageKey = $client?->stage ?? 'new';

        // ===============================================
        // ⭐ CLIENT-FRIENDLY STAGE LABEL LOGIC (YOUR RULES)
        // ===============================================

        // Visible stages for client BEFORE final decision
        $clientStageMap = [
            'new' => 'Registration',
            'in_progress' => 'Processing',
            'submitted_to_pfa' => 'Submitted to PFA',
            'approval_pending' => 'Approval Pending',
            'disbursement' => 'Disbursement',
        ];

        // After admin/staff sets final stage:
        if ($stageKey === 'approved') {
            $clientStageLabel = 'Approved';
        } elseif ($stageKey === 'rejected') {
            $clientStageLabel = 'Rejected';
        } else {
            $clientStageLabel = $clientStageMap[$stageKey] ?? 'Unknown Stage';
        }

        // ===============================================

        // ✅ Pie chart progress (reflects updated stage)
        // (kept exactly as you had it)
        $progressMap = [
            'new' => 16,
            'in_progress' => 32,
            'submitted_to_pfa' => 48,
            'approval_pending' => 64,
            'approved' => 80,
            'rejected' => 64,
            'disbursement' => 100,
        ];
        $done = $progressMap[$stageKey] ?? 0;

        // ✅ Sidebar menu
        $menu = [
            ['label' => 'Overview', 'url' => route('dashboard.client'), 'active' => 'dashboard/client'],
            ['label' => 'Messages', 'url' => route('messages.index'), 'active' => 'messages*'],
            ['label' => 'Profile', 'url' => route('profile.edit'), 'active' => 'profile*'],
            ['label' => 'Documents', 'url' => route('client.documents.index'), 'active' => 'dashboard/client/documents*'],
        ];

        // ✅ Account & assigned staff
        $accountNumber = $client?->account_number ?? 'Pending';
        $assignedStaff = $client?->staff?->name ?? 'Not Assigned';

        return view('dashboard.client.index', compact(
            'user',
            'client',
            'news',
            'stages',
            'stageKey',
            'clientStageLabel',  // ⭐ NEW
            'done',
            'menu',
            'accountNumber',
            'assignedStaff'
        ));
    }


    public function downloadDisbursementForm($clientId)
    {
        $client = auth()->user()->client;

        // Protect access
        if (!$client || $client->id != $clientId) {
            abort(403, 'Unauthorized action.');
        }

        // Match your system's stage name
        if ($client->stage !== 'disburstment' && $client->stage !== 'disbursement') {
            return back()->with('error', 'Form is only available at the disbursement stage.');
        }

        // Point to actual file inside storage/app/pfa_forms
        $filePath = storage_path('app/pfa_forms/disbursement_form.pdf');

        if (!file_exists($filePath)) {
            return back()->with('error', 'Disbursement form file not found.');
        }

        return response()->download($filePath);
    }
}
