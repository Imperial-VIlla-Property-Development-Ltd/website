@extends('layouts.dashboard')

@section('title', 'Client Assignments')
@section('page_title', 'Client Assignments')

@section('content')
<div class="space-y-8">

  {{-- ======= Summary Cards ======= --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5 border dark:border-gray-700">
      <div class="text-sm text-gray-500 dark:text-gray-400">Total Clients</div>
      <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ \App\Models\Client::count() }}</div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5 border dark:border-gray-700">
      <div class="text-sm text-gray-500 dark:text-gray-400">Unassigned Clients</div>
      <div class="text-2xl font-bold text-yellow-500">{{ $newClients->count() }}</div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5 border dark:border-gray-700">
      <div class="text-sm text-gray-500 dark:text-gray-400">Active Assignments</div>
      <div class="text-2xl font-bold text-green-500">{{ $assigned->count() }}</div>
    </div>
  </div>

  {{-- ======= Unassigned Clients ======= --}}
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow border dark:border-gray-700 p-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex justify-between items-center">
      Unassigned Clients
      <span class="text-sm text-gray-400">Assign clients to staff below</span>
    </h2>

    @if($newClients->count() > 0)
      <table class="w-full text-sm border-collapse border border-gray-200 dark:border-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
          <tr>
            <th class="py-2 px-3 text-left">Client Name</th>
            <th class="py-2 px-3 text-left">Email</th>
            <th class="py-2 px-3 text-left">Assign To</th>
            <th class="py-2 px-3 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($newClients as $client)
            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
              <td class="py-2 px-3">{{ $client->firstname }} {{ $client->lastname }}</td>
              <td class="py-2 px-3">{{ $client->user->email ?? 'N/A' }}</td>
              <td class="py-2 px-3">
                <form method="POST" action="{{ route('admin.assignments.assign') }}" class="flex items-center space-x-2">
                  @csrf
                  <input type="hidden" name="client_id" value="{{ $client->id }}">
                  <select name="staff_id" class="border-gray-300 rounded-md text-sm p-1 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Select Staff</option>
                    @foreach($staff as $member)
                      <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                  </select>
              </td>
              <td class="py-2 px-3 text-center">
                  <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded-md">
                    Assign
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p class="text-sm text-gray-500 dark:text-gray-400 italic">✅ All clients are assigned.</p>
    @endif
  </div>

  {{-- ======= Existing Assignments ======= --}}
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow border dark:border-gray-700 p-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Assigned Clients</h2>

    @if($assigned->count() > 0)
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($assigned as $item)
          <div class="border rounded-lg p-4 dark:border-gray-700 dark:bg-gray-800 shadow hover:shadow-lg transition">
            <div class="font-semibold text-blue-600 dark:text-blue-400">
              {{ $item->client->firstname ?? 'N/A' }} {{ $item->client->lastname ?? '' }}
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400">
              Assigned to: {{ $item->staff->name ?? 'Unknown' }}
            </div>
            <div class="mt-2 text-sm">
              <span class="px-2 py-0.5 bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200 rounded text-xs">
                Active
              </span>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <p class="text-sm text-gray-500 dark:text-gray-400 italic">No assignments yet.</p>
    @endif
  </div>
</div>
@endsection
