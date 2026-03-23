<?php

namespace App\Http\Controllers\Admin;
use App\Notifications\AnnouncementNotification;
use App\Models\ActivityLog;


use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('dashboard.admin.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'body'=>'required|string',
        ]);
        $data['admin_id'] = Auth::id();
        Announcement::create($data);
        return back()->with('success','Announcement posted!');

        $announcement = Announcement::create([
    'admin_id'=>Auth::id(),
    'title'=>$request->title,
    'body'=>$request->body
]);

// notify all clients (optional)
$clients = \App\Models\User::where('role','client')->get();
foreach($clients as $client){
    $client->notify(new AnnouncementNotification($announcement));
}

ActivityLog::create([
    'user_id'=>Auth::id(),
    'action'=>'announcement_posted',
    'description'=>"Posted announcement #{$announcement->id}",
    'ip'=>request()->ip(),
    'user_agent'=>request()->header('User-Agent'),
]);
event(new \App\Events\NotificationPushed($notification));



    }

    public static function latest()
    {
        return Announcement::latest()->limit(5)->pluck('body')->toArray();
    }
}
