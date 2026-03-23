@extends('layouts.dashboard')
@section('page_title', 'Super Admin Dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">

  {{-- ✅ SIDEBAR --}}
  @includeIf('dashboard.super_admin.partials.sidebar')

  {{-- ✅ MAIN CONTENT --}}
  <main class="flex-1 p-8 overflow-y-auto">

    {{-- 🔹 HEADER & PORTAL TOGGLE --}}
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-green-500">🛡️ Super Admin Control Center</h1>
      <form action="{{ route('superadmin.toggle.portal') }}" method="POST" onsubmit="return confirm('Are you sure?')">
        @csrf
        <button
          class="px-4 py-2 rounded-lg font-semibold shadow-md transition
            {{ $portalStatus === 'active' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
          {{ $portalStatus === 'active' ? '🔒 Shutdown Portal' : '🚀 Activate Portal' }}
        </button>
      </form>
    </div>

    {{-- 🔹 STATUS CARD --}}
    <div
      class="p-4 mb-8 rounded-md shadow-sm
        {{ $portalStatus === 'active'
            ? 'bg-green-50 border border-green-300 text-green-700'
            : 'bg-red-50 border border-red-300 text-red-700' }}">
      <strong>Portal Status:</strong>
      {{ $portalStatus === 'active' ? 'Online' : 'Offline / Maintenance Mode' }}
    </div>

    {{-- ✅ DASHBOARD STATS --}}
    <div class="grid md:grid-cols-3 gap-6 mb-8">
      <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-gray-400 text-sm">Total Admins</h3>
        <p class="text-3xl font-bold text-green-500">{{ $totalAdmins }}</p>
      </div>
      <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-gray-400 text-sm">Total Staff</h3>
        <p class="text-3xl font-bold text-blue-500">{{ $totalStaff }}</p>
      </div>
      <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-gray-400 text-sm">Total Clients</h3>
        <p class="text-3xl font-bold text-yellow-500">{{ $totalClients }}</p>
      </div>
    </div>

    {{-- ✅ GRAPHS SECTION --}}
    <div class="grid lg:grid-cols-2 gap-6 mb-10">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <h3 class="font-semibold mb-3 text-gray-700 dark:text-gray-200">📈 Client Registration (Last 14 Days)</h3>
        <canvas id="clientsLineChart"></canvas>
      </div>
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <h3 class="font-semibold mb-3 text-gray-700 dark:text-gray-200">📊 Client Stages Overview</h3>
        <canvas id="stagePieChart"></canvas>
      </div>
    </div>

    {{-- ✅ STAFF TABLE --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
      <h3 class="text-xl font-bold text-gray-700 dark:text-gray-100 mb-4">👨‍💼 Staff Overview</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
          <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
            <tr>
              <th class="px-4 py-3">#</th>
              <th class="px-4 py-3">Full Name</th>
              <th class="px-4 py-3">Email</th>
              <th class="px-4 py-3">Status</th>
              <th class="px-4 py-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($staff as $index => $s)
              <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                <td class="px-4 py-3">{{ $index + 1 }}</td>
                <td class="px-4 py-3 font-semibold">{{ $s->name }}</td>
                <td class="px-4 py-3">{{ $s->email }}</td>
                <td class="px-4 py-3">
                  @if($s->is_active)
                    <span class="text-green-600 font-semibold">Active</span>
                  @else
                    <span class="text-red-500 font-semibold">Suspended</span>
                  @endif
                </td>
                <td class="px-4 py-3 text-center">
                  <form action="{{ route('super.staff.toggle', $s->id) }}" method="POST" class="inline">@csrf
                    <button class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs">Toggle</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-400">No staff records found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($staff->hasPages())
        <div class="mt-4">
          {{ $staff->links('pagination::tailwind') }}
        </div>
      @endif
    </div>

  </main>
</div>

{{-- ✅ ChartJS Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Line Chart
  new Chart(document.getElementById('clientsLineChart'), {
    type: 'line',
    data: {
      labels: @json($dates),
      datasets: [{
        label: 'Clients Registered',
        data: @json($counts),
        borderColor: '#22c55e',
        backgroundColor: 'rgba(34,197,94,0.2)',
        fill: true,
        tension: 0.3
      }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
  });

  // Pie Chart
  new Chart(document.getElementById('stagePieChart'), {
    type: 'doughnut',
    data: {
      labels: Object.keys(@json($stageStats)),
      datasets: [{
        data: Object.values(@json($stageStats)),
        backgroundColor: ['#22c55e','#3b82f6','#f59e0b','#ef4444']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
</script>
@endsection
