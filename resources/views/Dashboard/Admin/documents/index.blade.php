@extends('layouts.dashboard')
@section('page_title', 'All Uploaded Documents')

@section('content')

<div class="bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">Client Uploaded Documents</h2>

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="p-3 text-left">Client</th>
                <th class="p-3 text-left">Document</th>
                <th class="p-3 text-left">Type</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-right">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($documents as $doc)
            <tr class="border-b">
                <td class="p-3">
                    {{ $doc->client->firstname }} {{ $doc->client->lastname }}
                </td>

                <td class="p-3">
                    <a href="{{ asset('storage/'.$doc->file_path) }}"
                       target="_blank"
                       class="text-blue-600 underline">
                        View File
                    </a>
                </td>

                <td class="p-3 text-gray-600">{{ $doc->title }}</td>

                <td class="p-3">
                    @if($doc->status == 'approved')
                        <span class="text-green-600 font-semibold">Approved</span>
                    @elseif($doc->status == 'rejected')
                        <span class="text-red-600 font-semibold">Rejected</span>
                    @else
                        <span class="text-yellow-600 font-semibold">Pending</span>
                    @endif
                </td>

                <td class="p-3 text-right">
                    <a href="{{ route('admin.documents.review', $doc->id) }}"
                       class="text-blue-600 font-semibold hover:underline">
                       Review
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    <div class="mt-4">
        {{ $documents->links() }}
    </div>

</div>

@endsection
