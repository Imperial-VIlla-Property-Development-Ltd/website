<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    // 🔹 List all admins
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('dashboard.super_admin.admins.index', compact('admins'));
    }

    // 🔹 Show create form
    public function create()
    {
        return view('dashboard.super_admin.admins.create');
    }

    // 🔹 Store new admin
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'admin',
            'is_active' => true,
        ]);

        return redirect()->route('super.admins.index')->with('success', 'Admin created successfully!');
    }

    // 🔹 Toggle active/suspended
    public function toggleActive(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return back()->with('success', 'Admin status updated!');
    }

    // 🔹 Delete admin
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Admin deleted successfully!');
    }

    public function toggleStatus($id)
{
    $admin = \App\Models\User::where('role', 'admin')->findOrFail($id);
    $admin->is_active = !$admin->is_active;
    $admin->save();

    return redirect()->back()->with('success', 'Admin status updated successfully.');
}

}
