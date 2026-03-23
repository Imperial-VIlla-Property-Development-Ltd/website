<?php

namespace App\Http\Controllers\Client;
use App\Notifications\ClientDocumentUploaded;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;

class DocumentController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        $documents = Document::where('client_id', $client->id)->latest()->get();

        $menu = [
            ['label' => 'Overview', 'url' => route('dashboard.client'), 'active' => 'dashboard/client'],
            ['label' => 'Messages', 'url' => route('messages.index'), 'active' => 'messages*'],
            ['label' => 'Documents', 'url' => route('client.documents.index'), 'active' => 'dashboard/client/documents*'],
            ['label' => 'Profile', 'url' => route('profile.edit'), 'active' => 'profile*'],
        ];

        return view('dashboard.client.documents.index', compact('documents', 'client', 'menu'));
    }

    public function store(Request $request)
    {
        $client = Auth::user()->client;

        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $path = $request->file('file')->store('client_documents', 'public');

        Document::create([
            'client_id' => $client->id,
            'staff_id' => $client->staff_id ?? null, // if assigned
            'title' => $request->title,
            'file_path' => $path,
        ]);
        $doc = Document::create([
    'client_id' => $client->id,
    'staff_id' => $client->staff_id ?? null,
    'title' => $request->title,
    'file_path' => $path,
]);

// 🔔 Notify assigned staff
if ($client->staff_id) {
    $staff = \App\Models\User::find($client->staff_id);
    if ($staff) {
        $staff->notify(new ClientDocumentUploaded($doc));
    }
}


        return back()->with('success', 'Document uploaded successfully!');
    }

    public function destroy(Document $document)
    {
        $client = Auth::user()->client;

        if ($document->client_id !== $client->id) {
            abort(403);
        }

        \Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted.');
    }
}
