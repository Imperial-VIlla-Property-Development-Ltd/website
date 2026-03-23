<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
   // ProfileController.php (add these methods or ensure they exist)
public function edit()
{
    $user = auth()->user();

    // Sidebar menu for clients (you can adapt for other roles)
    $menu = [
        ['label' => 'Overview', 'url' => route('dashboard.client'), 'active' => 'dashboard/client'],
        ['label' => 'Messages', 'url' => route('messages.index'), 'active' => 'messages*'],
        ['label' => 'Profile', 'url' => route('profile.edit'), 'active' => 'profile*'],
    ];

    return view('profile.edit', compact('user','menu'));
}


public function update(Request $request)
{
    $user = auth()->user();

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'phone_number' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:500',
        'profile_photo' => 'nullable|image|max:2048',
        'password' => 'nullable|confirmed|min:8',
    ]);

    if($request->hasFile('profile_photo')) {
        $data['profile_photo'] = $request->file('profile_photo')->store('profiles','public');
    }

    if(!empty($data['password'])) {
        $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
    } else {
        unset($data['password']);
    }

    $user->update($data);

    // update client biodata if present (firstname/lastname)
    if($user->client) {
        $user->client->update([
            'firstname' => $request->input('firstname', $user->client->firstname),
            'middlename' => $request->input('middlename', $user->client->middlename),
            'lastname' => $request->input('lastname', $user->client->lastname),
            'phone_number' => $request->input('phone_number', $user->client->phone_number),
            'address' => $request->input('address', $user->client->address),
        ]);
    }

    return back()->with('success','Profile updated.');
}
}