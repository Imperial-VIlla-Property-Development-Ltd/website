@extends('layouts.dashboard')
@section('page_title','Review Document')

@section('content')

<div class="bg-white p-8 rounded shadow max-w-3xl mx-auto">

    <h2 class="text-2xl font-bold mb-4">Review Document</h2>

    <p class="mb-2 text-gray-700">
        <strong>Client:</strong>
        {{ $document->client->firstname }} {{ $document->client->lastname }}
    </p>

    <p class="mb-2 text-gray-700">
        <strong>Document Type:</strong> {{ $document->title }}
    </p>

    <div class="my-4">
        <iframe src="{{ asset('storage/'.$document->file_path) }}"
                class="w-full h-96 border rounded">
        </iframe>
    </div>

    <form method="POST" action="{{ route('documents.update', $document->id) }}">
        @csrf

        <label>Status</label>
        <select name="status" class="border p-2 w-full rounded mb-3" required>
            <option value="approved">Approve</option>
            <option value="rejected">Reject</option>
        </select>

        <textarea name="review_note" placeholder="Enter review note (optional)"
                  class="border p-2 w-full rounded h-28 mb-3"></textarea>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Submit Review
        </button>

    </form>

</div>

@endsection
