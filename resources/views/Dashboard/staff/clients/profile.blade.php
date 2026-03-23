@extends('layouts.dashboard')
@section('page_title', 'Client Profile')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">

  {{-- HEADER --}}
  <div class="flex items-center justify-between mb-8">
    <h2 class="text-3xl font-bold text-green-600 tracking-tight">
      👤 Client Profile
    </h2>
    <a href="{{ route('staff.clients') }}"
       class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md text-sm font-medium transition">
      ← Back to Clients
    </a>
  </div>

  {{-- PROFILE CARD --}}
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="md:flex items-center">
      
      {{-- LEFT: PROFILE PHOTO --}}
      <div class="md:w-1/3 p-6 flex justify-center bg-gradient-to-br from-green-100 to-green-50 dark:from-gray-900 dark:to-gray-800">
        <img src="{{ $client->user->profile_photo ? asset('storage/'.$client->user->profile_photo) : 'https://via.placeholder.com/200x200?text=Profile+Photo' }}"
             alt="Client Photo"
             class="w-40 h-40 rounded-full object-cover shadow-lg border-4 border-green-400 hover:scale-105 transition-transform duration-300">
      </div>

      {{-- RIGHT: CLIENT DETAILS --}}
      <div class="md:w-2/3 p-6">
        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-1">
          {{ $client->firstname }} {{ $client->middlename }} {{ $client->lastname }}
        </h3>
        <p class="text-gray-500 mb-3">📞 {{ $client->phone_number }}</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
          <div><strong>📧 Email:</strong> {{ $client->user->email ?? 'N/A' }}</div>
          <div><strong>🏠 Address:</strong> {{ $client->address ?? 'Not provided' }}</div>
          <div><strong>🪪 Pension Number:</strong> {{ $client->user->pension_number ?? '—' }}</div>
          <div><strong>🏦 Account Number:</strong> {{ $client->account_number ?? 'Pending' }}</div>
          <div><strong>🏢 PFA:</strong> {{ $client->pfa_selected ?? 'Not selected' }}</div>
          <div><strong>📊 Stage:</strong> 
            <span class="inline-block px-2 py-1 rounded text-white text-xs
                  {{ $client->stage === 'completed' ? 'bg-green-600' : ($client->stage === 'in_progress' ? 'bg-blue-500' : 'bg-gray-400') }}">
              {{ ucfirst($client->stage) }}
            </span>
          </div>
          <div><strong>🧾 Registration ID:</strong> {{ $client->registration_id }}</div>
          <div><strong>👨‍💼 Account Manager:</strong> 
            <span class="font-semibold text-green-600 dark:text-green-400">
              {{ $client->staff?->name ?? 'Not Assigned' }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- DOCUMENTS SECTION --}}
  <div class="mt-10 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-200 mb-4">📁 Uploaded Documents</h3>
    @if($documents->count())
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($documents as $doc)
          <div class="border border-gray-300 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
            <p class="font-medium text-gray-800 dark:text-gray-100 mb-2 truncate">{{ $doc->title }}</p>
            <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank"
               class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
              🔗 View Document
            </a>
          </div>
        @endforeach
      </div>
    @else
      <p class="text-gray-500">No documents uploaded yet.</p>
    @endif
  </div>

  {{-- MESSAGE SECTION --}}
  <div class="mt-10 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-200 mb-4">💬 Conversation</h3>
    <div class="max-h-80 overflow-y-auto space-y-3">
      @forelse($messages as $msg)
        <div class="p-3 rounded-md {{ $msg->sender_id === auth()->id() ? 'bg-green-100 dark:bg-green-900/40 text-right' : 'bg-gray-100 dark:bg-gray-700 text-left' }}">
          <p class="text-sm text-gray-800 dark:text-gray-100">{{ $msg->body }}</p>
          <small class="text-xs text-gray-500">{{ $msg->created_at->diffForHumans() }}</small>
        </div>
      @empty
        <p class="text-gray-500 text-sm">No messages yet with this client.</p>
      @endforelse
    </div>

    {{-- SEND MESSAGE BOX --}}
    <form method="POST" action="{{ route('messages.store') }}" class="mt-5">
      @csrf
      <input type="hidden" name="receiver_id" value="{{ $client->user_id }}">
      <textarea name="body" rows="3" placeholder="Type your message..." 
                class="w-full border rounded-md p-3 text-sm dark:bg-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-green-500 outline-none"></textarea>
      <div class="text-right mt-2">
        <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md font-medium shadow">
          ✉️ Send Message
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
