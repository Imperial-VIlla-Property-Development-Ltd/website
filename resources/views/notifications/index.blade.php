@extends('layouts.app')
@section('title','Notifications')

@section('content')

<div class="min-h-screen flex justify-center items-start py-10 bg-gray-50">

    <div class="w-full max-w-4xl">

        {{-- Page Title --}}
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">
            🔔 Notifications
        </h2>

        {{-- Mark All as Read --}}
        <form method="POST" action="{{ route('notifications.markRead') }}" class="text-center mb-6">
            @csrf
            <button type="submit"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition">
                Mark All as Read
            </button>
        </form>

        {{-- Notification List --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">

            <div class="bg-gray-100 px-6 py-3 border-b font-semibold text-gray-700 uppercase text-sm grid grid-cols-12">
                <div class="col-span-1"></div>
                <div class="col-span-2">Type</div>
                <div class="col-span-6">Message</div>
                <div class="col-span-3">Received</div>
            </div>

            <form method="POST" action="{{ route('notifications.markRead') }}">
                @csrf

                @foreach($notifications as $n)
                    <div class="grid grid-cols-12 px-6 py-4 border-b hover:bg-gray-50 transition
                        {{ $n->read_at ? '' : 'bg-yellow-50' }}">

                        {{-- Checkbox --}}
                        <div class="col-span-1 flex justify-center items-center">
                            <input type="checkbox" name="ids[]" value="{{ $n->id }}"
                                class="rounded border-gray-400">
                        </div>

                        {{-- Type --}}
                        <div class="col-span-2 font-medium text-gray-700 capitalize">
                            {{ $n->data['type'] ?? 'Notification' }}
                        </div>

                        {{-- Message --}}
                        <div class="col-span-6 text-gray-600">
                            {{ $n->data['message'] ?? ($n->data['exception'] ?? json_encode($n->data)) }}
                        </div>

                        {{-- Time --}}
                        <div class="col-span-3 text-gray-500 text-sm">
                            {{ $n->created_at->diffForHumans() }}
                        </div>

                    </div>
                @endforeach

                {{-- Bulk Mark Selected --}}
                <div class="p-4 bg-gray-100 flex justify-end">
                    <button
                        class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg shadow transition">
                        Mark Selected as Read
                    </button>
                </div>

            </form>

        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $notifications->links('pagination::tailwind') }}
        </div>

    </div>

</div>

@endsection
