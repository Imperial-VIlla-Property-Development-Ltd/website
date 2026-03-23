@extends('layouts.dashboard')
@section('page_title','Staff Dashboard')

@section('content')

<style>
    /* Compact Gradient Clock */
    .clock-box {
        background: linear-gradient(135deg, #0847f3ff, #0918ecff, #60a5fa);
        background-size: 300% 300%;
        animation: gradientShift 6s ease infinite, pulse 3s ease-in-out infinite;
        color: white;
        padding: 10px 16px;
        border-radius: 10px;
        display: inline-block;
        text-align: center;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        position: relative;
        margin-left: 10px; /* slight offset for positioning */
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    .christmas-hat {
        position: absolute;
        top: -18px;
        right: -4px;
        width: 35px; /* smaller hat */
        transform: rotate(15deg);
    }

    #staffClockTime {
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        line-height: 1.2;
    }

    #staffClockDate {
        margin-top: 2px;
        font-size: 0.75rem;
        opacity: 0.9;
    }
</style>

<!-- Position LEFT -->
<div style="text-align: right; margin-top: 5px;">
    <div class="clock-box">
        

        <div id="staffClockTime">00:00</div>
        <div id="staffClockDate">Loading date...</div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();

        let hours = now.getHours();
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');

        // Convert to 12-hour time
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // 12-hour fix

        const time = `${hours}:${minutes}:${seconds} ${ampm}`;

        const date = now.toLocaleDateString([], {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });

        document.getElementById("staffClockTime").innerText = time;
        document.getElementById("staffClockDate").innerText = date;
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>




<div class="w-full h-full flex flex-col items-center justify-start overflow-hidden space-y-6">

    {{-- Profile Section --}}
    <div class="flex flex-col items-center text-center mt-4">
        <img src="{{ $staff->profile_photo_url ?? asset('images/default-avatar.png') }}"
             class="w-24 h-24 rounded-full shadow-md border-4 border-blue-500 object-cover"
             alt="Profile">
        <h2 class="text-2xl font-bold mt-3 text-gray-800">{{ $staff->name }}</h2>
        <p class="text-gray-500 text-sm">{{ ucfirst($staff->role) }} | {{ $staff->email }}</p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-5xl w-full px-4">
        <div class="bg-blue-300 border rounded-lg shadow-sm p-4 text-center">
            <h4 class="text-gray-600 text-sm mb-2">Total Clients</h4>
            <div class="text-3xl font-bold text-blue-700">{{ $totalClients }}</div>
        </div>
        <div class="bg-green-300 border rounded-lg shadow-sm p-4 text-center">
            <h4 class="text-gray-600 text-sm mb-2">Completed</h4>
            <div class="text-3xl font-bold text-green-700">{{ $completed }}</div>
        </div>
        <div class="bg-yellow-100 border rounded-lg shadow-sm p-4 text-center">
            <h4 class="text-gray-600 text-sm mb-2">Assigned Today</h4>
            <div class="text-3xl font-bold text-yellow-700">{{ $todayAssigned }}</div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8 w-full px-4">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Client Stages</h3>
            <canvas id="stagePieChart" height="200"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Progress Over Time</h3>
            <canvas id="progressLineChart" height="200"></canvas>
        </div>
    </div>

    <!--{{-- Quick Report (Replaces Recent Activities) --}}
    <div class="max-w-5xl w-full bg-white rounded-xl shadow p-6 mt-4">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">📝 Quick Report</h3>
        <p class="text-gray-500 text-sm mb-3">
            Write a quick update or summary of your work today. This report goes directly to the admin dashboard.
        </p>

        <form id="quickReportForm" method="POST" action="{{ route('staff.reports.store') }}">
            @csrf
            <textarea id="quickReportContent" name="content" rows="4"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400 p-3"
                      placeholder="Type your daily report here..."></textarea>

            <div class="flex justify-end mt-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow transition-all duration-200">
                    Submit Report
                </button>
            </div>
        </form>

        <div id="reportStatus" class="hidden mt-3 text-green-600 font-medium"></div>
    </div>

</div> -->

{{-- Floating Sticky Toolbar --}}
<div id="staffToolbar"
     class="fixed bottom-6 right-6 bg-white shadow-xl rounded-full flex flex-col space-y-3 p-3 border border-gray-200 z-50 backdrop-blur-sm">

  {{-- New Report --}}
  <a href="{{ route('staff.reports.create') }}"
     title="Add Report"
     class="bg-blue-600 hover:bg-blue-700 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-md transition-all duration-300 transform hover:scale-110">
    📝
  </a>

  {{-- View Clients --}}
  <a href="{{ route('staff.clients') }}"
     title="View Clients"
     class="bg-green-600 hover:bg-green-700 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-md transition-all duration-300 transform hover:scale-110">
    👥
  </a>

  {{-- Messages --}}
  <a href="{{ route('messages.index') }}"
     title="Messages"
     class="bg-yellow-500 hover:bg-yellow-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-md transition-all duration-300 transform hover:scale-110 relative">
    💬
    @php
      $unreadCount = \App\Models\Message::where('receiver_id', auth()->id())->whereNull('read_at')->count();
    @endphp
    @if($unreadCount > 0)
      <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs px-1 rounded-full">{{ $unreadCount }}</span>
    @endif
  </a>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@push('scripts')
<style>
#staffToolbar {
  animation: fadeInUp 0.5s ease-in-out;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Floating toolbar tooltips
    const toolbarIcons = document.querySelectorAll('#staffToolbar a');
    toolbarIcons.forEach(el => {
        el.addEventListener('mouseenter', () => {
            const tip = document.createElement('div');
            tip.textContent = el.getAttribute('title');
            tip.className = 'fixed px-2 py-1 text-xs text-white bg-black bg-opacity-70 rounded-md shadow-sm transition-opacity duration-200';
            const rect = el.getBoundingClientRect();
            tip.style.top = `${rect.top + window.scrollY + 8}px`;
            tip.style.left = `${rect.left - 80}px`;
            tip.id = 'tooltip';
            document.body.appendChild(tip);
        });
        el.addEventListener('mouseleave', () => document.getElementById('tooltip')?.remove());
    });
});
</script>
@endpush

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Pie chart for client stages
    new Chart(document.getElementById('stagePieChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['New', 'In Progress', 'Completed'],
            datasets: [{
                data: [{{ $stageData['new'] ?? 0 }}, {{ $stageData['in_progress'] ?? 0 }}, {{ $stageData['completed'] ?? 0 }}],
                backgroundColor: ['#0307faff', '#fab60cff', '#09f128ff'],
                borderWidth: 1
            }]
        }
    });

    // Line chart (mock data for now)
    new Chart(document.getElementById('progressLineChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            datasets: [{
                label: 'Clients Processed',
                data: [2,4,3,5,6,8,7],
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59,130,246,0.1)',
                fill: true,
                tension: 0.3,
                borderWidth: 2,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Quick Report AJAX
    const form = document.getElementById('quickReportForm');
    const statusBox = document.getElementById('reportStatus');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        statusBox.classList.add('hidden');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            });

            if (response.ok) {
                form.reset();
                statusBox.textContent = '✅ Report submitted successfully!';
                statusBox.classList.remove('hidden');
                statusBox.classList.add('text-green-600');
            } else {
                statusBox.textContent = '❌ Failed to submit report.';
                statusBox.classList.remove('hidden');
                statusBox.classList.add('text-red-600');
            }
        } catch (err) {
            statusBox.textContent = '⚠️ Network error. Please check your connection.';
            statusBox.classList.remove('hidden');
            statusBox.classList.add('text-red-600');
        }
    });
});
</script>
@endpush
