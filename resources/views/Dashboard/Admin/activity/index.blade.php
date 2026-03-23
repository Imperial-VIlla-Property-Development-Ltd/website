@extends('layouts.dashboard')

@section('title', 'Activity Log')
@section('page_title', 'Activity Log')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">

    {{-- ================= HEADER WITH COUNTER ================= --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            Recent Activities
        </h2>

        {{-- Green Counter Badge --}}
        <span class="bg-green-600 text-white text-xs px-3 py-1 rounded-full shadow">
            {{ $logs->total() }} Logs
        </span>
    </div>

    {{-- ================= COLLAPSIBLE BUTTON ================= --}}
    <button 
        onclick="toggleRecentActivity()"
        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow mb-3 transition"
    >
        <span class="text-sm font-semibold">Show / Hide Recent Activity</span>

        {{-- Chevron Icon --}}
        <svg id="recentChevron" xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 011.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                  clip-rule="evenodd" />
        </svg>
    </button>

    {{-- ================= COLLAPSIBLE WRAPPER ================= --}}
    <div id="recentActivityPanel" class="hidden">

        @if($logs->count())
        <div class="overflow-x-auto mb-10 mt-3">
            <table class="w-full text-sm border-collapse border border-gray-200 dark:border-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="py-2 px-3 text-left">User</th>
                        <th class="py-2 px-3 text-left">Action</th>
                        <th class="py-2 px-3 text-left">IP</th>
                        <th class="py-2 px-3 text-left">Date</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($logs as $log)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="py-2 px-3">{{ $log->user->name ?? 'System' }}</td>
                        <td class="py-2 px-3">{{ ucfirst(str_replace('_',' ', $log->action)) }}</td>
                        <td class="py-2 px-3">{{ $log->ip }}</td>
                        <td class="py-2 px-3">{{ $log->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 mb-10">
            {{ $logs->links() }}
        </div>
        @else
            <p class="text-gray-500 italic">No activity logs yet.</p>
        @endif

    </div>


    {{-- ================= STAFF WORK SESSION TABLE ================= --}}
    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 mt-10">
        Staff Daily Work Hours
    </h2>

    @if($workSessions->count())
    <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <tr>
                    <th class="py-2 px-3 text-left">Staff</th>
                    <th class="py-2 px-3 text-left">Date</th>
                    <th class="py-2 px-3 text-left">Login Time</th>
                    <th class="py-2 px-3 text-left">Logout Time</th>
                    <th class="py-2 px-3 text-left">Hours Worked</th>
                </tr>
            </thead>

            <tbody>
                @foreach($workSessions as $ws)
                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="py-2 px-3">{{ $ws->staff->name }}</td>
                    <td class="py-2 px-3">{{ $ws->work_date }}</td>

                    <td class="py-2 px-3">
                        {{ $ws->start_time ? \Carbon\Carbon::parse($ws->start_time)->format('h:i A') : '—' }}
                    </td>

                    <td class="py-2 px-3">
                        {{ $ws->end_time ? \Carbon\Carbon::parse($ws->end_time)->format('h:i A') : '—' }}
                    </td>

                    <td class="py-2 px-3 font-semibold">
                        {{ $ws->hours_spent ? number_format($ws->hours_spent, 2) . ' hrs' : '—' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $workSessions->links() }}
        </div>
    </div>

    @else
        <p class="text-gray-500 italic">No staff work-hour logs recorded yet.</p>
    @endif

</div>

{{-- ================= JAVASCRIPT ================= --}}
<script>
function toggleRecentActivity() {
    const panel = document.getElementById('recentActivityPanel');
    const chevron = document.getElementById('recentChevron');

    panel.classList.toggle('hidden');
    chevron.classList.toggle('rotate-180');
}
</script>

@endsection
