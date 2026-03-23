<?php
namespace App\Http\Controllers\Admin;

use App\Notifications\StaffAssignedNotification;
use App\Models\ActivityLog;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    public function index()
    {
        // Clients not yet assigned to any staff
        $newClients = Client::whereNull('staff_id')->with('user')->get();

        // Active staff
        $staff = User::where('role', 'staff')
                    ->where('is_active', true)
                    ->get();

        // Existing assignments
        $assigned = Assignment::with(['client.user', 'staff'])->get();

        return view('dashboard.admin.assignment.index', compact(
            'newClients', 'staff', 'assigned'
        ));
    }

    public function assign(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'staff_id'  => 'required|exists:users,id',
        ]);
Mail::to($staff->email)->queue(new StaffClientAssignedMail($staff, $client));

        // Create assignment and update client
        Assignment::create($data);
        Client::where('id', $data['client_id'])
            ->update(['staff_id' => $data['staff_id']]);

        return back()->with('success', 'Client assigned successfully!');
    }
}
