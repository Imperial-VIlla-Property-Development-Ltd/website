@extends('layouts.dashboard')
@section('page_title','Manage Clients')

@section('content')
<div class="max-w-7xl mx-auto">

  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
    <div>
      <h2 class="text-2xl font-bold">All Clients</h2>
      <p class="text-sm text-gray-500 mt-1">Showing <strong>{{ $clients->total() }}</strong> clients</p>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('admin.client.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow-sm hover:bg-blue-700 transition">
        ➕ New Client
      </a>
    </div>
  </div>

  {{-- FILTERS --}}
  <form method="GET" class="flex flex-col md:flex-row items-stretch md:items-center gap-3 mb-4">
    <input name="q" value="{{ request('q') }}" placeholder="Search by name, email or pension no..." 
           class="flex-1 border p-2 rounded focus:ring-2 focus:ring-green-400 outline-none">
    <select name="stage" class="border p-2 rounded">
      <option value="">All stages</option>
      <option value="new" {{ request('stage')=='new'?'selected':'' }}>New</option>
      <option value="in_progress" {{ request('stage')=='in_progress'?'selected':'' }}>In Progress</option>
      <option value="submitted_to_pfa" {{ request('stage')=='submitted_to_pfa'?'selected':'' }}>Submitted to Pfa</option>
      <option value="approval_pending" {{ request('stage')=='approval_pending'?'selected':'' }}>Approval Pending</option>
      <option value="approved" {{ request('stage')=='approved'?'selected':'' }}>Approved</option>
      <option value="approved" {{ request('stage')=='rejected'?'selected':'' }}>Rejected</option>
      <option value="disbursement" {{ request('stage')=='disbursement'?'selected':'' }}>Disbursement</option>
    </select>
    <select name="assigned" class="border p-2 rounded">
      <option value="">All</option>
      <option value="new" {{ request('assigned')=='new'?'selected':'' }}>Unassigned</option>
      <option value="assigned" {{ request('assigned')=='assigned'?'selected':'' }}>Assigned</option>
    </select>

    <button type="submit" class="bg-gray-800 text-white px-3 py-2 rounded hover:bg-gray-900 transition">
      Filter
    </button>

    {{-- Reset --}}
    <a href="{{ route('admin.client.index') }}" class="text-sm text-gray-500 underline ml-auto md:ml-0">Reset</a>
  </form>

  {{-- Bulk assign form --}}
  <form method="POST" id="bulkActionsForm">
    @csrf

    {{-- TABLE VIEW --}}
    <div class="bg-white rounded shadow overflow-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="p-3"><input type="checkbox" id="selectAll"></th>
                    <th class="p-3">Client Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Pension Number</th>
                    <th class="p-3">Stage</th>
                    <th class="p-3">Assigned Staff</th>
                    <th class="p-3">Created</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody class="text-sm">
                @forelse($clients as $client)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">
                            <input type="checkbox" name="client_ids[]" value="{{ $client->id }}" class="client-checkbox">
                        </td>

                        <td class="p-3 font-medium">
                            {{ $client->firstname }} {{ $client->lastname }}
                        </td>

                        <td class="p-3 text-gray-600">
                            {{ $client->user->email ?? '—' }}
                        </td>

                        <td class="p-3 font-mono text-gray-700">
                            {{ $client->user->pension_number ?? 'N/A' }}
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs
                                {{ $client->stage == 'completed' ? 'bg-green-100 text-green-700' : 
                                   ($client->stage == 'in_progress' ? 'bg-yellow-100 text-yellow-700' : 
                                    'bg-blue-100 text-blue-700') }}">
                                {{ ucfirst(str_replace('_', ' ', $client->stage)) }}
                            </span>
                        </td>

                        <td class="p-3">
                            {{ $client->staff?->name ?? '—' }}
                        </td>

                        <td class="p-3 text-gray-600">
                            {{ $client->created_at->format('d M, Y') }}
                        </td>

                        <td class="p-3">
                            <a href="{{ route('admin.client.show', $client) }}"
                               class="text-blue-600 hover:underline text-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center text-gray-500">
                            No clients found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- BULK ACTIONS --}}
    <div class="flex items-center mt-4 space-x-3">

        {{-- Assign Staff --}}
        <select name="staff_id" class="border p-2 rounded">
            <option value="">Assign to staff</option>
            @foreach($staff as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select>

        <button formaction="{{ route('admin.client.bulkAssign') }}"
                class="bg-green-600 text-white px-4 py-2 rounded">
            Assign Selected
        </button>

        {{-- DELETE SELECTED --}}
      <button formaction="{{ route('admin.client.bulkDelete') }}"
        formmethod="POST"
        onclick="return confirm('Are you sure you want to delete selected clients? This cannot be undone!')"
        class="bg-red-600 text-white px-4 py-2 rounded">
    Delete Selected
</button>



    </div>
</form>

<form id="bulkDeleteForm" action="{{ route('admin.client.bulkDelete') }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>


{{-- JS: SELECT ALL --}}
<script>
    document.getElementById('selectAll')?.addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.client-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>


  {{-- PAGINATION --}}
  <div class="mt-6 flex items-center justify-between">
    <div class="text-sm text-gray-600">
      Showing {{ $clients->firstItem() ?? 0 }} - {{ $clients->lastItem() ?? 0 }} of {{ $clients->total() }} clients
    </div>
    <div>
      {{ $clients->withQueryString()->links('pagination::tailwind') }}
    </div>
  </div>
</div>

{{-- Small JS for select all behavior --}}
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.client-checkbox');

    selectAll?.addEventListener('change', function () {
      checkboxes.forEach(cb => cb.checked = selectAll.checked);
    });

    // prevent assigning without selecting staff
    document.getElementById('bulkAssignForm')?.addEventListener('submit', function (e) {
      const staffVal = document.getElementById('bulkStaffSelect')?.value;
      const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
      if (!anyChecked) {
        e.preventDefault();
        alert('Please select at least one client to assign.');
        return;
      }
      if (!staffVal) {
        e.preventDefault();
        alert('Please choose a staff to assign to.');
      }
    });
  });
</script>
@endpush

@endsection
