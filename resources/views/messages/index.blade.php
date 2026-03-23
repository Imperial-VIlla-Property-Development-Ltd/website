@extends('layouts.dashboard')
@section('page_title', 'Messages')
@section('content')

<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Messages</h2>
        <a href="{{ route('messages.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            ✉️ New Message
        </a>
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: 'inbox' }" class="bg-white rounded-lg shadow overflow-hidden">
        <div class="flex border-b text-sm font-medium text-gray-600">
            <button @click="tab='inbox'"
                :class="tab==='inbox' ? 'border-b-2 border-blue-600 text-blue-600' : ''"
                class="flex-1 py-3 hover:bg-gray-50">
                Inbox ({{ $inbox->count() }})
            </button>
            <button @click="tab='sent'"
                :class="tab==='sent' ? 'border-b-2 border-blue-600 text-blue-600' : ''"
                class="flex-1 py-3 hover:bg-gray-50">
                Sent ({{ $sent->count() }})
            </button>
        </div>

        {{-- Inbox --}}
<div x-show="tab==='inbox'" class="divide-y divide-gray-200">
    @forelse($inbox as $msg)
        <div
            x-data
            @click="$el.classList.add('opacity-70'); fetch('{{ route('messages.markRead',$msg) }}',{method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}})"
            class="flex items-center p-4 hover:bg-gray-50 transition cursor-pointer {{ $msg->isRead() ? 'opacity-70' : 'bg-blue-50' }}"
        >
            {{-- Avatar --}}
            <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-700 rounded-full mr-4 font-semibold">
                {{ strtoupper(substr($msg->sender->name,0,1)) }}
            </div>

            {{-- Message content --}}
            <div class="flex-1">
                <div class="flex justify-between">
                    <h4 class="font-semibold text-gray-800">
                        {{ $msg->sender->name }}
                        @unless($msg->isRead())
                            <span class="ml-2 text-xs bg-green-500 text-white px-2 py-0.5 rounded-full">New</span>
                        @endunless
                    </h4>
                    <small class="text-gray-400">{{ $msg->created_at->diffForHumans() }}</small>
                </div>
                <p class="text-sm text-gray-600 mt-1">
                    <span class="font-medium">{{ $msg->subject ?? '(No subject)' }}</span> — 
                    {{ \Illuminate\Support\Str::limit($msg->body, 80) }}
                </p>
            </div>

            {{-- Quick reply button --}}
            <button
                @click.stop="document.getElementById('replyModal-{{ $msg->id }}').classList.remove('hidden')"
                class="ml-3 text-blue-600 text-sm hover:underline">
                Reply
            </button>
        </div>

        {{-- Reply Modal (same as before) --}}
        <div id="replyModal-{{ $msg->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-lg font-semibold mb-3">Reply to {{ $msg->sender->name }}</h3>
                <form method="POST" action="{{ route('messages.store') }}">@csrf
                    <input type="hidden" name="receiver_id" value="{{ $msg->sender->id }}">
                    <input name="subject" class="border p-2 w-full mb-3 rounded" placeholder="Subject (optional)">
                    <textarea name="body" rows="4" class="border p-2 w-full mb-3 rounded" placeholder="Your message..." required></textarea>
                    <div class="flex justify-end gap-2">
                        <button type="button"
                            onclick="document.getElementById('replyModal-{{ $msg->id }}').classList.add('hidden')"
                            class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">Cancel</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">Send</button>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <p class="p-6 text-center text-gray-500">No messages in your inbox.</p>
    @endforelse
</div>

        {{-- Sent --}}
        <div x-show="tab==='sent'" class="divide-y divide-gray-200">
            @forelse($sent as $msg)
                <div class="flex items-center p-4 hover:bg-gray-50 transition">
                    <div class="w-12 h-12 flex items-center justify-center bg-green-100 text-green-700 rounded-full mr-4">
                        {{ strtoupper(substr($msg->receiver->name,0,1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <h4 class="font-semibold text-gray-800">{{ $msg->receiver->name }}</h4>
                            <small class="text-gray-400">{{ $msg->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">{{ $msg->subject ?? '(No subject)' }}</span> — 
                            {{ \Illuminate\Support\Str::limit($msg->body, 80) }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="p-6 text-center text-gray-500">You haven’t sent any messages yet.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Include Alpine.js for tabs & modals --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

@endsection
