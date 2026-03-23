@extends('layouts.dashboard')
@section('page_title', 'Notifications')
@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Recent Notifications</h2>

    @forelse($notifications as $note)
        <div class="border-b py-3">
            <div class="text-gray-800 font-medium">{{ $note->data['title'] }}</div>
            <p class="text-sm text-gray-600">{{ $note->data['message'] }}</p>
            <small class="text-gray-400">{{ $note->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p class="text-gray-500">No notifications yet.</p>
    @endforelse
</div>

@endsection
