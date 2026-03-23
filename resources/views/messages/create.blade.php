@extends('layouts.dashboard')
@section('page_title','Compose Message')
@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">New Message</h2>

    <form method="POST" action="{{ route('messages.store') }}">@csrf
        <label class="block text-sm mb-1">Send to:</label>
        <select name="receiver_id" class="border p-2 rounded w-full mb-3" required>
            @foreach($users as $u)
                <option value="{{ $u->id }}">{{ $u->name }} ({{ ucfirst($u->role) }})</option>
            @endforeach
        </select>

        <input type="text" name="subject" class="border p-2 rounded w-full mb-3" placeholder="Subject (optional)">
        <textarea name="body" rows="6" class="border p-2 rounded w-full mb-3" placeholder="Write your message..." required></textarea>

        <div class="flex justify-end">
            <a href="{{ route('messages.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 mr-2">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Send</button>
        </div>
    </form>
</div>

@endsection
