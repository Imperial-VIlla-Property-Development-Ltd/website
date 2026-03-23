@extends('layouts.dashboard')
@section('page_title','Admin Dashboard')

@section('content')

<style>

  /* Neon Clock */
    .neon-clock {
        background: linear-gradient(90deg, #0040ff, #007bff);
        box-shadow: 0 0 20px rgba(0,123,255,0.7);
    } 
  </style>

<div class="max-w-7xl mx-auto space-y-6">

<!-- DIGITAL CLOCK -->
        <div class="flex flex-col items-end">
            <div id="digitalClock"
                class="px-6 py-3 neon-clock text-white rounded-2xl text-lg font-bold">
            </div>

            <div id="digitalDate"
                class="mt-1 text-sm font-semibold text-gray-600 dark:text-gray-300">
            </div>
        </div>

  {{-- Summary cards --}}
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-gradient-to-r from-blue-600  to-blue-600 text-white p-4 rounded-lg shadow">
      <div class="text-sm">Total Staff</div>
      <div class="text-2xl font-bold">{{ $totalStaff }}</div>
    </div>
    <div class="bg-gradient-to-r from-indigo-400 to-indigo-400 text-white p-4 rounded-lg shadow">
      <div class="text-sm">Total Clients</div>
      <div class="text-2xl font-bold">{{ $totalClients }}</div>
    </div>
    <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white p-4 rounded-lg shadow">
      <div class="text-sm">New Clients</div>
      <div class="text-2xl font-bold">{{ $newClients }}</div>
    </div>
    <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-4 rounded-lg shadow">
      <div class="text-sm">Assigned Clients</div>
      <div class="text-2xl font-bold">{{ $assignedClients }}</div>
    </div>
  </div>

  {{-- Charts --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow p-4">
      <h4 class="font-semibold mb-3">Stage Distribution</h4>
      <canvas id="stagePie" height="200"></canvas>
    </div>

    <div class="bg-white rounded-lg shadow p-4 md:col-span-2">
      <h4 class="font-semibold mb-3">Clients Over Time</h4>
      <canvas id="clientsLine" height="200"></canvas>
    </div>

  </div>

  {{-- Top staff + quick actions --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow p-4">
      <h4 class="font-semibold mb-3">Top Staff (by assignments)</h4>
      <ul class="space-y-2">
        @foreach($topStaff as $s)
          <li class="flex justify-between items-center">
            <div>
              <div class="font-medium">{{ $s->name }}</div>
              <div class="text-xs text-gray-500">{{ $s->clients_count ?? 0 }} clients</div>
            </div>
            <a href="{{ route('admin.staff.edit', $s->id) }}" class="text-blue-600 text-sm">Manage</a>
          </li>
        @endforeach
      </ul>
    </div>

    <div class="bg-white rounded-lg shadow p-4 col-span-2">
      <h4 class="font-semibold mb-3">Quick Actions</h4>
      <div class="flex space-x-3">
        <a href="{{ route('admin.client.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">New Client</a>
        <a href="{{ route('admin.staff.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">New Staff</a>
        <a href="{{ route('admin.reports.index') }}" class="bg-yellow-500 text-white px-4 py-2 rounded">View Reports</a>
      </div>
    </div>
  </div>

</div>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // pie
  new Chart(document.getElementById('stagePie').getContext('2d'), {
    type: 'pie',
    data: {
      labels: ['New','In Progress','Submitted to PFA', 'Approval Pending', 'Approved', 'Rejected', 'Disbursement'],
      datasets: [{
        data: [{{ $stageData['new'] ?? 0 }}, {{ $stageData['in_progress'] ?? 0 }}, {{ $stageData['submitted_to_pfa'] ?? 0 }}, {{ $stageData['approval_pending'] ?? 0 }},{{ $stageData['approved'] ?? 0 }}, {{ $stageData['rejected'] ?? 0 }}, {{ $stageData['disbursement'] ?? 0 }}],
        backgroundColor: ['#0c08f0ff','#f8b408ff', '#08f0f8ff', '#ff0202ff', '#40f808f6', '#f80808ff','#020b5cff']
      }]
    }
  });

  // line
  new Chart(document.getElementById('clientsLine').getContext('2d'), {
    type: 'bar',
    data: {
      labels: {!! json_encode($dates) !!},
      datasets: [{
        label: 'Clients',
        data: {!! json_encode($counts) !!},
        backgroundColor: '#1d06e9ff'
      }]
    },
    options: {
      responsive: true,
      scales: { y: { beginAtZero:true } }
    }
  });
});
</script>
<script>
    // CLOCK + DATE
    function updateClock(){
        const now = new Date();
        digitalClock.innerText = now.toLocaleTimeString('en-GB');
        digitalDate.innerText = now.toDateString();
    }
    setInterval(updateClock, 1000);
    updateClock();

    // THEME SWITCH
    function toggleTheme() {
        document.documentElement.classList.toggle('dark');
    }
</script>
@endpush
