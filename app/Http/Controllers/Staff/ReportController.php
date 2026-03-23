<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\ActivityLog;
use App\Notifications\ReportSubmittedNotification;

use App\Models\Report; // ✅ add this if not already imported

class ReportController extends Controller
{
    public function index()
    {
        $staff = Auth::user();

        // get all reports submitted by the logged-in staff
        $reports = Report::where('staff_id', $staff->id)
            ->orderByDesc('created_at')
            ->get();

        // side menu for layout
        $menu = [
            ['label'=>'Overview','url'=>route('dashboard.staff'),'active'=>'dashboard/staff'],
            ['label'=>'My Clients','url'=>route('staff.clients'),'active'=>'dashboard/staff/clients*'],
            ['label'=>'Reports','url'=>route('staff.reports.index'),'active'=>'dashboard/staff/reports*'],
            ['label'=>'Messages','url'=>route('messages.index'),'active'=>'messages*'],
        ];

        return view('dashboard.staff.reports.index', compact('reports', 'staff', 'menu'));
    }

    public function create()
    {
        $staff = Auth::user();

        $menu = [
            ['label'=>'Overview','url'=>route('dashboard.staff'),'active'=>'dashboard/staff'],
            ['label'=>'My Clients','url'=>route('staff.clients'),'active'=>'dashboard/staff/clients*'],
            ['label'=>'Reports','url'=>route('staff.reports.index'),'active'=>'dashboard/staff/reports*'],
            ['label'=>'Messages','url'=>route('messages.index'),'active'=>'messages*'],
        ];

        return view('dashboard.staff.reports.create', compact('menu','staff'));
    }

    // your store() method remains the same as before



    

    public function store(Request $request)
{
    $staff = Auth::user();

    $request->validate([
        'content' => 'required|string',
    ]);

    // ✅ Create a real Report record in the database
    $report = \App\Models\Report::create([
        'staff_id' => $staff->id,
        'content'  => $request->content,
        'report_date' => now(),
    ]);

    // Optional: Handle export (PDF / Word)
    $format = $request->input('format');

    if ($format === 'pdf') {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.staff_pdf', ['report' => $report]);
        return $pdf->download('staff_report.pdf');
    } elseif ($format === 'word') {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addText("Staff Report - {$staff->name} (" . now()->format('d M, Y') . ")");
        $section->addText($request->content);
        $path = \Storage::path('staff_report.docx');
        $phpWord->save($path);
        return response()->download($path)->deleteFileAfterSend(true);
    }

    // ✅ Notify all admins
    $admins = \App\Models\User::where('role', 'admin')->get();
    foreach ($admins as $admin) {
        $admin->notify(new \App\Notifications\ReportSubmittedNotification($report));
    }

    // ✅ Log activity
    \App\Models\ActivityLog::create([
        'user_id'    => $staff->id,
        'action'     => 'report_submitted',
        'description'=> 'Staff submitted a report',
        'ip'         => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    return redirect()->route('staff.reports.index')->with('success', 'Report submitted successfully!');
}

        
}
