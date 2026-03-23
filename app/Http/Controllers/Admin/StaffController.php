<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::where('role','staff')->orderBy('created_at','desc')->paginate(15);
        return view('dashboard.admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('dashboard.admin.staff.create');
    }

    public function store(Request $r)
    {
        $r->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed'
        ]);

        User::create([
            'name'=>$r->name,
            'email'=>$r->email,
            'password'=>Hash::make($r->password),
            'role'=>'staff',
            'is_active'=>true
        ]);

        return redirect()->route('admin.staff.index')->with('success','Staff created.');
    }

    public function edit(User $staff)
    {
        abort_if($staff->role!=='staff', 404);
        return view('dashboard.admin.staff.edit', compact('staff'));
    }

    public function update(Request $r, User $staff)
    {
        $r->validate([
            'name'=>'required|string|max:255',
            'email'=>['required','email', Rule::unique('users','email')->ignore($staff->id)],
            'password'=>'nullable|min:6|confirmed'
        ]);

        $staff->name = $r->name;
        $staff->email = $r->email;
        if ($r->filled('password')) $staff->password = Hash::make($r->password);
        $staff->save();

        return redirect()->route('admin.staff.index')->with('success','Staff updated.');
    }

    public function destroy(User $staff)
    {
        abort_if($staff->role!=='staff', 404);
        $staff->delete();
        return back()->with('success','Staff removed.');
    }

    // toggle active/suspend
    public function toggleActive(Request $r, User $staff)
    {
        abort_if($staff->role!=='staff', 404);
        $staff->is_active = !$staff->is_active;
        $staff->save();
        return back()->with('success','Staff status updated.');
    }
}
