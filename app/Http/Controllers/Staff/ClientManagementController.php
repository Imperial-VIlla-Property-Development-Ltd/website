<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Message;
use App\Models\Document;

class ClientManagementController extends Controller
{
    // ✅ List assigned clients (with search/filter)
    public function index(Request $request)
{
    $staff = Auth::user();

    $query = \App\Models\Client::where('staff_id', $staff->id)->with('user');

    if ($request->filled('stage')) {
        $query->where('stage', $request->stage);
    }

    if ($request->filled('q')) {
        $query->where(function($q) use ($request) {
            $q->where('firstname', 'like', "%{$request->q}%")
              ->orWhere('lastname', 'like', "%{$request->q}%")
              ->orWhere('pension_number', 'like', "%{$request->q}%");
        });
    }

    $clients = $query->orderBy('updated_at', 'desc')->paginate(9);

    // ✅ Add this array
    $stages = [
        'new' => 'New',
        'in_progress' => 'In Progress',
        'submitted_to_pfa' => 'Submitted to pfa',
        'approval_pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'rejected',
        'disbursement ' => 'Disbursement',
    ];

    $menu = [
        ['label'=>'Overview','url'=>route('dashboard.staff'),'active'=>'dashboard/staff'],
        ['label'=>'My Clients','url'=>route('staff.clients'),'active'=>'dashboard/staff/clients*'],
        ['label'=>'Reports','url'=>route('staff.reports.index'),'active'=>'dashboard/staff/reports*'],
        //['label'=>'Document Review','url'=>route('staff.documents.index'),'active'=>'dashboard/staff/documents*'],
        ['label'=>'Messages','url'=>route('messages.index'),'active'=>'messages*'],
        ['label'=>'Messages','url'=>route('messages.index'),'active'=>'messages*'],
    ];

    // ✅ Add $stages to compact()
    return view('dashboard.staff.clients.index', compact('staff', 'clients', 'menu', 'stages'));
}


    // ✅ Full client profile view
    public function profile(Client $client)
    {
        $staff = Auth::user();
        abort_unless($client->staff_id === $staff->id, 403);

        $documents = Document::where('client_id', $client->id)->get();

        $messages = Message::where(function ($q) use ($staff, $client) {
                $q->where('sender_id', $staff->id)
                  ->where('receiver_id', $client->user_id);
            })
            ->orWhere(function ($q) use ($staff, $client) {
                $q->where('sender_id', $client->user_id)
                  ->where('receiver_id', $staff->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $menu = [
            ['label'=>'Overview','url'=>route('dashboard.staff'),'active'=>'dashboard/staff'],
            ['label'=>'My Clients','url'=>route('staff.clients'),'active'=>'dashboard/staff/clients*'],
            ['label'=>'Reports','url'=>route('staff.reports.index'),'active'=>'dashboard/staff/reports*'],
            
            ['label'=>'Messages','url'=>route('messages.index'),'active'=>'messages*'],
        ];

        return view('dashboard.staff.clients.profile', compact('client', 'documents', 'messages', 'staff', 'menu'));
    }


    // ✅ Update client stage (supports both AJAX and normal form)
    public function updateStage(Request $request, Client $client)
    {
        $staff = Auth::user();
        abort_unless($client->staff_id === $staff->id, 403);

        $request->validate([
            'stage' => 'required|in:new,in_progress,submitted_to_pfa,approval_pending,approved,rejected,disbursement',
        ]);

        $client->update(['stage' => $request->stage]);

        // Return JSON if AJAX, else redirect
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Stage updated successfully!',
                'stage' => ucfirst($client->stage),
            ]);
        }

        return back()->with('success', 'Client stage updated successfully!');
    }


    // ✅ Send message from staff to client
    public function sendMessage(Request $request, Client $client)
    {
        $staff = Auth::user();
        abort_unless($client->staff_id === $staff->id, 403);

        $request->validate(['body' => 'required|string|max:2000']);

        Message::create([
            'sender_id' => $staff->id,
            'receiver_id' => $client->user_id,
            'subject' => 'Message from your Account Manager',
            'body' => $request->body,
        ]);

        return $request->ajax()
            ? response()->json(['status' => 'success', 'message' => 'Message sent!'])
            : back()->with('success', 'Message sent to client.');
    }

    public function updateStageWithReason(Request $request, Client $client)
{
    $request->validate([
        'rejection_reason' => 'required|string|max:500',
    ]);

    $client->stage = 'rejected';
    $client->rejection_reason = $request->rejection_reason;
    $client->save();

    return back()->with('success', 'Client rejected with reason saved.');
}

}
