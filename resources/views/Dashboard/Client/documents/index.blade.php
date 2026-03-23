@extends('layouts.dashboard')
@section('page_title','My Documents')
@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Staff Card --}}
    @if($client && $client->staff)
    <div class="flex justify-end mb-4">
        <div class="flex items-center bg-white rounded-full shadow px-3 py-2 border border-gray-200">
            <img src="{{ $client->staff->profile_photo ? asset('storage/'.$client->staff->profile_photo) : 'https://via.placeholder.com/50' }}"
                 class="w-10 h-10 rounded-full mr-2" alt="Staff Photo">
            <div>
                <div class="font-semibold text-gray-800">{{ $client->staff->name }}</div>
                <div class="text-xs text-gray-500">Account Manager</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Upload Form --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-3">Upload Document</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-3">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('client.documents.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="title" class="border p-2 rounded" placeholder="Document title" required>
                <input type="file" name="file" class="border p-2 rounded" required>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Upload
                </button>
            </div>
        </form>
    </div>

    {{-- Document List --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Uploaded Files</h3>

        @if($documents->isEmpty())
            <p class="text-gray-500 text-sm">No documents uploaded yet.</p>
        @else
            <table class="w-full text-sm border">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-2 text-left">Title</th>
                        <th class="p-2 text-left">File</th>
                        <th class="p-2 text-left">Uploaded</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                        <tr class="border-b">
                            <td class="p-2">{{ $doc->title }}</td>
                            <td class="p-2">
                                <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                    View File
                                </a>
                            </td>
                            <td class="p-2">{{ $doc->created_at->format('d M, Y') }}</td>
                            <td class="p-2 text-center">
                                <form method="POST" action="{{ route('client.documents.destroy', $doc) }}" onsubmit="return confirm('Delete this file?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>

@endsection
