<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;

class AdminMapController extends Controller
{
    public function index()
    {
        $locations = Client::whereNotNull('latitude')->get();

        return view('dashboard.admin.map', compact('locations'));
    }
}
