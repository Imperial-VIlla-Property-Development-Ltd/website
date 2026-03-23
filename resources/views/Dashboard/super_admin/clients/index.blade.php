@extends('layouts.dashboard')
@section('page_title','Super Admin - Clients')
@section('content')
<h2 class="text-xl font-semibold mb-4">All Clients</h2>

@if(session('success'))
  <div class="bg-green-100 text-green-700 p-2 mb-3 rounded">{{ session('success') }}</div>
@endif

<table class="table-auto w-full border">
  <thead class="bg-gray-200"><tr>
    <th>Name</th><th>Email</th><th>Pension Number</th><th>Stage</th><th>Action</th>
  </tr></thead>
  <tbody>
  @foreach($clients as $client)
    <tr class="border-b">
      <td>{{ $client->firstname }} {{ $client->lastname }}</td>
      <td>{{ $client->user->email ?? 'N/A' }}</td>
      <td>{{ $client->user->pension_number ?? 'N/A' }}</td>
      <td>{{ ucfirst($client->stage) }}</td>
      <td>
        <form action="{{ route('super.clients.destroy',$client) }}" method="POST" onsubmit="return confirm('Delete client?')">
          @csrf @method('DELETE')
          <button class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection
