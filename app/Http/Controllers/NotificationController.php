<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('notifications.index', compact('notifications'));
    
        $menu = [
            ['label' => 'Dashboard', 'url' => route('dashboard.staff'), 'active' => 'dashboard/staff'],
            ['label' => 'Reports', 'url' => route('staff.reports.index'), 'active' => 'dashboard/staff/reports*'],
            ['label' => 'Notifications', 'url' => route('notifications.index'), 'active' => 'notifications*'],
        ];
        return view('dashboard.staff.notifications', compact('notifications', 'menu'));
    
    }

    public function markRead(Request $request)
    {
        $ids = $request->ids ?? [];
        if ($ids) {
            auth()->user()->unreadNotifications()->whereIn('id',$ids)->get()->each->markAsRead();
        } else {
            // mark all
            auth()->user()->unreadNotifications->markAsRead();
        }
        return back()->with('success','Marked as read.');
    }
}
