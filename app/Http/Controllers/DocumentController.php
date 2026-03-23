<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ZipArchive;



use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;






class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('client.user')->latest()->paginate(30);

        return view('staff.documents.index', compact('documents'));
    }

    public function review(Document $document)
    {
        return view('staff.documents.review', compact('document'));
    }

    public function updateStatus(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'review_note' => 'nullable|string'
        ]);

        $document->update([
            'status' => $request->status,
            'review_note' => $request->review_note,
            'reviewed_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Document updated successfully.');
    }

    


public function downloadSelected(Request $request)
{
    $request->validate([
        'docs' => 'required|array|min:1'
    ]);

    $ids = $request->input('docs', []);
    $documents = Document::whereIn('id', $ids)->get();

    if ($documents->isEmpty()) {
        return back()->with('error', 'No documents found for download.');
    }

    // If ZipArchive exists — create zip and download
    if (class_exists('ZipArchive')) {
        $zip = new ZipArchive();
        $fileName = 'documents-' . now()->timestamp . '.zip';
        $tmpDir = storage_path('app/public/temp');

        if (!is_dir($tmpDir)) {
            @mkdir($tmpDir, 0755, true);
        }
        $zipPath = $tmpDir . DIRECTORY_SEPARATOR . $fileName;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            Log::error("Unable to create zip at: $zipPath");
            return back()->with('error', 'Could not create archive. Check server permissions.');
        }

        foreach ($documents as $doc) {
            // your docs are stored in storage/app/public/... if you're using 'public' disk
            $filePath = storage_path('app/public/' . ltrim($doc->file_path, '/'));
            if (file_exists($filePath)) {
                // Add file to zip using a friendly name
                $localName = basename($filePath);
                $zip->addFile($filePath, $localName);
            } else {
                Log::warning("File not found for document id {$doc->id}: $filePath");
            }
        }

        $zip->close();

        if (!file_exists($zipPath)) {
            return back()->with('error', 'Zip creation failed.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    // FALLBACK: ZipArchive not available
    // If only one document selected, return it directly
    if ($documents->count() === 1) {
        $doc = $documents->first();
        $filePath = storage_path('app/public/' . ltrim($doc->file_path, '/'));
        if (!file_exists($filePath)) {
            return back()->with('error', 'File not found on server.');
        }
        return response()->download($filePath);
    }

    // If multiple and no ZipArchive — explain to admin/developer how to fix
    $msg = 'Server is missing the PHP zip extension required to download multiple files as a ZIP. '
         . 'Please enable the zip extension (php_zip).';
    Log::error('ZipArchive missing while attempting multi-download.');
    return back()->with('error', $msg);
}

}
