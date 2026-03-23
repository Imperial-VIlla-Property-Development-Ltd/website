<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use App\Models\Client;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $inbox = Message::where('receiver_id', $user->id)->latest()->get();
        $sent = Message::where('sender_id', $user->id)->latest()->get();

        // Sidebar Menu (for dashboard)
        $menu = [
            ['label' => 'Overview', 'url' => route('dashboard.client'), 'active' => 'dashboard/client'],
            ['label' => 'Messages', 'url' => route('messages.index'), 'active' => 'messages*'],
            ['label' => 'Profile',  'url' => route('profile.edit'), 'active' => 'profile*'],
        ];

        return view('messages.index', compact('inbox', 'sent', 'user', 'menu'));
    }

    /**
     * Show new message form
     */
    public function create()
    {
        $user = auth()->user();

        // 🔹 Filter user list based on role
        if ($user->role === 'client') {
            // Client → only assigned staff
            $client = $user->client;
            $users = collect();
            if ($client && $client->assigned_staff_id) {
                $users = User::where('id', $client->assigned_staff_id)->get();
            }
        } elseif ($user->role === 'staff') {
            // Staff → only their assigned clients
            $users = Client::where('assigned_staff_id', $user->id)
                ->with('user')
                ->get()
                ->pluck('user'); // convert to user collection
        } elseif (in_array($user->role, ['admin', 'super_admin'])) {
            // Admin / Super Admin → can message anyone
            $users = User::where('id', '!=', $user->id)->get();
        } else {
            // Default fallback
            $users = collect();
        }

        // Sidebar menu
        $menu = [
            ['label' => 'Overview', 'url' => route('dashboard.client'), 'active' => 'dashboard/client'],
            ['label' => 'Messages', 'url' => route('messages.index'), 'active' => 'messages*'],
            ['label' => 'Profile',  'url' => route('profile.edit'),  'active' => 'profile*'],
        ];

        return view('messages.create', compact('users', 'menu'));
    }

    /**
     * Store a new message
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
        ]);

        $data['sender_id'] = Auth::id();
        Message::create($data);

        return redirect()->route('messages.index')->with('success', 'Message sent successfully!');
    }

    /**
     * Mark message as read
     */
    public function markAsRead(Message $message)
    {
        if ($message->receiver_id === auth()->id()) {
            $message->update(['is_read' => true]);
        }

        return response()->json(['status' => 'ok']);
    }
}
