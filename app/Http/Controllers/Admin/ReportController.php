<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('staff')->latest()->get();
        return view('dashboard.admin.reports.index', compact('reports'));
    }
}
