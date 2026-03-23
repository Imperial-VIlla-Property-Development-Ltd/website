<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\ClientException;

class ExceptionController extends Controller
{
    public function index()
    {
        $clients = Client::with('user')->get();
        $exceptions = ClientException::latest()->with('client')->get();

        return view('dashboard.admin.exceptions.index', compact('clients','exceptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'message' => 'required|string|max:500'
        ]);

        $data['admin_id'] = Auth::id();
        ClientException::create($data);

        return redirect()->back()->with('success', 'Exception sent successfully!');
    }
}
