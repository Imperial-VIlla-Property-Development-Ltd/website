@extends('layouts.dashboard')
@section('page_title', 'My Clients')

@section('content')
<div class="max-w-6xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">👥 My Clients</h2>

    {{-- Filters --}}
    <form method="GET" class="flex flex-col md:flex-row md:items-center md:space-x-3 mb-6 space-y-3 md:space-y-0">
        
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search client..."
               class="border-gray-300 rounded-md px-3 py-2 flex-1 focus:ring focus:ring-blue-100 focus:border-blue-400">

        <select name="stage" class="border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-100 focus:border-blue-400">
            <option value="">All Stages</option>
            @foreach($stages as $key => $value)
                <option value="{{ $key }}" {{ request('stage') == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>

        {{-- Sorting --}}
        <input type="hidden" name="sort" value="{{ request('sort') }}">
        <input type="hidden" name="direction" value="{{ request('direction') }}">

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Filter</button>
    </form>

    {{-- Sort Helper --}}
    @php
        function sort_link_client($field) {
            $direction = (request('sort') === $field && request('direction') === 'asc') ? 'desc' : 'asc';
            return '?sort='.$field.'&direction='.$direction.'&q='.request('q').'&stage='.request('stage');
        }
    @endphp

    {{-- Clients Table --}}
    @if($clients->count())
        <div class="overflow-x-auto bg-white border rounded-xl shadow-sm">
            <table class="min-w-full text-left">
                <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3">
                            <a href="{{ sort_link_client('firstname') }}" class="hover:underline">
                                Name {{ request('sort')=='firstname' ? (request('direction')=='asc'?'↑':'↓') : '' }}
                            </a>
                        </th>

                        <th class="px-4 py-3">
                            <a href="{{ sort_link_client('pension_number') }}" class="hover:underline">
                                Pension Number {{ request('sort')=='pension_number' ? (request('direction')=='asc'?'↑':'↓') : '' }}
                            </a>
                        </th>

                        <th class="px-4 py-3">
                            <a href="{{ sort_link_client('email') }}" class="hover:underline">
                                Email {{ request('sort')=='email' ? (request('direction')=='asc'?'↑':'↓') : '' }}
                            </a>
                        </th>

                        <th class="px-4 py-3">Stage</th>

                        <th class="px-4 py-3">
                            <a href="{{ sort_link_client('updated_at') }}" class="hover:underline">
                                Updated {{ request('sort')=='updated_at' ? (request('direction')=='asc'?'↑':'↓') : '' }}
                            </a>
                        </th>

                        <th class="px-4 py-3">Docs</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>

                <tbody class="text-sm text-gray-700">
                    @foreach($clients as $client)
                        @php $docCount = $client->documents()->count(); @endphp

                        <tr class="border-b hover:bg-gray-50">

                            <td class="px-4 py-3 font-semibold">
                                {{ $client->firstname }} {{ $client->lastname }}
                            </td>

                            <td class="px-4 py-3">{{ $client->user->pension_number ?? 'N/A' }}</td>

                            <td class="px-4 py-3">{{ $client->user->email ?? '—' }}</td>

                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-1 rounded-full
                                    {{ $client->stage == 'new' ? 'bg-blue-100 text-blue-700' :
                                       ($client->stage == 'in_progress' ? 'bg-yellow-100 text-yellow-700' :
                                        'bg-green-100 text-green-700') }}">
                                    {{ ucfirst(str_replace('_',' ',$client->stage)) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-xs text-gray-500">
                                {{ $client->updated_at->diffForHumans() }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="bg-gray-800 text-white text-xs px-2 py-1 rounded-full">{{ $docCount }}</span>
                            </td>

                            <td class="px-4 py-3 flex items-center space-x-3">

                                <a href="{{ route('staff.clients.profile', $client) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View →
                                </a>

                                {{-- Stage Dropdown --}}
                                <form method="POST" class="stageForm" action="{{ route('staff.clients.updateStage', $client) }}">
                                    @csrf

                                    <select name="stage"
                                            class="stageSelect text-xs border-gray-300 rounded-md py-1 px-2 focus:ring focus:ring-blue-100"
                                            data-client="{{ $client->id }}">
                                        @foreach($stages as $key => $value)
                                            <option value="{{ $key }}" {{ $client->stage == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $clients->links() }}
        </div>

    @else
        <p class="text-gray-500 text-center mt-10">No clients assigned yet.</p>
    @endif

</div>

{{-- ==================== REJECTION MODAL ===================== --}}
<div id="rejectionModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 shadow-lg max-w-md w-full">

        <h2 class="text-xl font-bold mb-4 text-red-600">Reason for Rejection</h2>

        <form id="rejectionForm" method="POST" action="">
            @csrf

            <textarea name="rejection_reason"
                      class="w-full border rounded-md p-2 text-sm"
                      placeholder="Explain the reason for rejecting this client..."
                      required></textarea>

            <div class="flex justify-end mt-4 space-x-3">
                <button type="button" onclick="closeRejectionModal()"
                        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</button>

                <button type="submit"
                        class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white">
                    Submit Reason
                </button>
            </div>
        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.stageSelect').forEach(select => {
    select.addEventListener('change', function () {
        const selected = this.value;
        const clientId = this.dataset.client;

        if (selected === 'rejected') {
            // Prevent auto-submit
            event.preventDefault();

            // Open modal
            openRejectionModal(clientId);

        } else {
            this.closest('form').submit();
        }
    });
});

function openRejectionModal(clientId) {
    let modal = document.getElementById('rejectionModal');
    let form = document.getElementById('rejectionForm');

    form.action = "/dashboard/staff/clients/" + clientId + "/update-stage-with-reason";

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeRejectionModal() {
    let modal = document.getElementById('rejectionModal');
    modal.classList.add('hidden');
}
</script>
@endpush
