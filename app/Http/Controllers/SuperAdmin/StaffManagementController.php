<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffManagementController extends Controller
{
    public function index(Request $request)
{
    $query = \App\Models\User::where('role', 'staff');

    if ($search = $request->get('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        });
    }

    $staff = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('dashboard.super_admin.staff.index', compact('staff'));
}


   public function create()
{
    return view('dashboard.super_admin.staff.create');
}

public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => 'staff',
        'is_active' => true,
    ]);

    return redirect()->route('super.staff.index')->with('success', 'Staff added successfully.');
}

    public function toggleActive(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return back()->with('success', 'Staff status updated!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Staff deleted successfully!');
    }

    public function toggle($id)
{
    $staff = \App\Models\User::findOrFail($id);
    $staff->is_active = !$staff->is_active;
    $staff->save();

    return back()->with('success', 'Staff status updated successfully.');
}

}
