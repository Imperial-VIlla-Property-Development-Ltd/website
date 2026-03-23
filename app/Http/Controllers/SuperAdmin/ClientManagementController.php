<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientManagementController extends Controller
{
    public function index()
    {
        $clients = Client::with('user')->get();
        return view('dashboard.super_admin.clients.index', compact('clients'));
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return back()->with('success', 'Client record deleted!');
    }
}
