<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Mail\StaffClientAssignedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\ActivityLog;


class ClientController extends Controller
{
    public function index(Request $r)
    {
        $query = Client::with('user','staff');

        if ($r->filled('q')) {
            $query->where(function($q) use ($r){
                $q->where('firstname','like','%'.$r->q.'%')
                  ->orWhere('lastname','like','%'.$r->q.'%')
                  ->orWhereHas('user', function($q2) use ($r){
                      $q2->where('email','like','%'.$r->q.'%')
                         ->orWhere('pension_number','like','%'.$r->q.'%');
                  });
            });
        }

        if ($r->filled('stage')) {
            $query->where('stage',$r->stage);
        }

        // ✅ Fixed: Use assigned_staff_id, not staff_id
        if ($r->filled('assigned')) {
            if ($r->assigned === 'new') $query->whereNull('assigned_staff_id');
            if ($r->assigned === 'assigned') $query->whereNotNull('assigned_staff_id');
        }

        $clients = $query->orderBy('created_at','desc')->paginate(12);
        $staff = User::where('role','staff')->get();

        return view('dashboard.admin.clients.index', compact('clients','staff'));
    }

    public function create() { return view('dashboard.admin.clients.create'); }

    public function store(Request $r)
    {
        $r->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required|email|unique:users,email',
        ]);

        $user = \App\Models\User::create([
            'name' => $r->firstname.' '.$r->lastname,
            'email'=>$r->email,
            'password'=>bcrypt('password'),
            'role'=>'client',
            'is_active'=>true,
        ]);

        Client::create([
            'user_id'=>$user->id,
            'firstname'=>$r->firstname,
            'lastname'=>$r->lastname,
            'stage'=>'new'
        ]);

        return redirect()->route('admin.client.index')->with('success','Client created.');
    }

    public function show(Client $client)
    {
        $client->load('user','documents','staff');
        return view('dashboard.admin.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $staff = User::where('role','staff')->get();
        return view('dashboard.admin.clients.edit', compact('client','staff'));
    }

    public function update(Request $r, Client $client)
    {
        $r->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'pension_number' => ['nullable', Rule::unique('clients','pension_number')->ignore($client->id)]
        ]);

        // ✅ Fixed: assigned_staff_id instead of staff_id
        $client->update($r->only(['firstname','lastname','pension_number','stage','assigned_staff_id']));

        if ($r->filled('email')) {
            $client->user->update(['email'=>$r->email]);
        }

        return back()->with('success','Client updated.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return back()->with('success','Client removed.');
    }

   public function bulkAssign(Request $r)
{
    $r->validate([
        'client_ids' => 'required|array',
        'staff_id'   => 'required|exists:users,id',
    ]);

    $staff = User::findOrFail($r->staff_id);

    // 👉 Fetch all selected clients
    $clients = Client::whereIn('id', $r->client_ids)->get();

    // 👉 Store clients for a single email summary
    $clientsForEmail = [];

    foreach ($clients as $client) {

        // Assign to staff
        $client->assigned_staff_id = $staff->id;
        $client->save();

        // Add to email list
        $clientsForEmail[] = $client;

        // Activity log
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'client_assigned',
            'description' => "Assigned {$client->firstname} {$client->lastname} to staff {$staff->name}",
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    // =====================================
    //  📩 SEND ONE EMAIL FOR ALL CLIENTS
    // =====================================
    try {
        Mail::to($staff->email)->queue(new StaffClientAssignedMail($staff, $clientsForEmail));
    } catch (\Throwable $e) {
        \Log::error("Bulk Staff Assign Email Failed: " . $e->getMessage());
    }

    return back()->with('success', 'Clients assigned successfully and staff notified.');
}

    
public function updateStage(Request $request, Client $client)
{
    // Validate stage and optional rejection reason
    $validated = $request->validate([
        'stage' => 'required|string',
        'rejection_reason' => 'nullable|string|max:5000',
    ]);

    $newStage = $validated['stage'];


    /*
    |--------------------------------------------------------------------------
    | HANDLE REJECTION LOGIC
    |--------------------------------------------------------------------------
    | - If stage is "rejected", rejection_reason is required
    | - If stage is anything else, rejection_reason must be cleared
    */

    if ($newStage === 'rejected') {

        if (!$request->filled('rejection_reason')) {
            return response()->json([
                'status' => 'error',
                'message' => 'A rejection reason is required when rejecting an application.'
            ], 422);
        }

        // Save reason
        $client->rejection_reason = $request->rejection_reason;

    } else {
        // Clear reason when stage moves away from rejected
        $client->rejection_reason = null;
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE THE STAGE (NO BEHAVIOR CHANGED)
    |--------------------------------------------------------------------------
    */

    $client->stage = $newStage;
    $client->save();


    /*
    |--------------------------------------------------------------------------
    | ACTIVITY LOG (UNCHANGED)
    |--------------------------------------------------------------------------
    */

    \App\Models\ActivityLog::create([
        'user_id' => auth()->id(),
        'action' => 'client_stage_updated',
        'description' => "Updated stage for {$client->firstname} {$client->lastname} to {$validated['stage']}",
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);


    /*
    |--------------------------------------------------------------------------
    | RETURN JSON RESPONSE (UNCHANGED)
    |--------------------------------------------------------------------------
    */

    return response()->json([
        'status' => 'success',
        'message' => 'Client stage updated successfully.',
        'new_stage' => ucfirst($client->stage),
    ]);
}

public function updateAccount(Request $request, Client $client)
    {
        $validated = $request->validate([
            'account_number' => 'required|string|max:50',
        ]);

        $client->update(['account_number' => $validated['account_number']]);

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'client_account_updated',
            'description' => "Updated account number for {$client->firstname} {$client->lastname}",
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Account number updated successfully.',
            'account_number' => $client->account_number,
        ]);
    }

    public function viewDocuments(Client $client)
    {
        $documents = \App\Models\Document::where('client_id', $client->id)->get();
        return view('dashboard.admin.clients.documents', compact('client', 'documents'));
    }
   public function bulkDelete(Request $request)
{
    $request->validate([
        'client_ids' => 'required|array',
    ]);

    $clientIds = $request->client_ids;

    // Delete clients and their linked user accounts
    foreach ($clientIds as $id) {
        $client = Client::find($id);
        if ($client) {
            // delete user too
            $client->user()->delete();
            $client->delete();
        }
    }

    return redirect()->back()->with('success', 'Selected clients have been deleted successfully.');
}



}
