@extends('layout.dashboard')
@section('title', 'Client Documents')

@section('content')
<div class="max-w-4xl mx-auto">
  <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
    Documents for {{ $client->firstname }} {{ $client->lastname }}
  </h2>

  @if($documents->count())
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @foreach($documents as $doc)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
          <p class="font-medium text-gray-700 dark:text-gray-200">{{ $doc->title ?? 'Uploaded File' }}</p>
          <p class="text-xs text-gray-500 mb-2">Uploaded: {{ $doc->created_at->format('d M Y') }}</p>

          <a href="{{ Storage::url($doc->path) }}" 
             target="_blank"
             class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1.5 rounded-md transition-all">
            View
          </a>
        </div>
      @endforeach
    </div>
  @else
    <p class="text-gray-500 dark:text-gray-400">No documents uploaded yet.</p>
  @endif
</div>
@endsection
