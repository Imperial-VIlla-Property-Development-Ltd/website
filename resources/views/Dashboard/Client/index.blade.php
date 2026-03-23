@extends('layouts.dashboard')
@section('page_title','Client Dashboard')
@section('content')

<style>
    .client-dashboard-bg {
        background: url('/images/bg.png') no-repeat center center fixed;
        background-size: cover;
        position: relative;
        padding: 30px 0;
        min-height: 100vh;
    }

    .client-dashboard-bg::before {
        content: "";
        position: absolute;
        top: 0; 
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.55);
        z-index: 0;
    }

    .client-content-wrapper {
        position: relative;
        z-index: 10;
    }

    .stage-dot {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 13px;
        font-weight: bold;
    }

    /* ===================== PREMIUM TOOLTIP ANIMATION ===================== */

    .tooltip-animated {
        position: absolute;
        left: 0;
        top: 28px;
        width: 280px;

        background: #fff5f5;
        border: 1px solid #f5b5b5;
        color: #b40000;
        padding: 12px;
        border-radius: 8px;

        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        z-index: 50;

        opacity: 0;
        pointer-events: none;

        /* Forward-pop animation */
        transform: translateY(-12px) scale(0.92);
        transition:
            opacity .4s ease,
            transform .45s cubic-bezier(.22,1.28,.37,1.15);
    }

    /* On hover, show tooltip */
    .group:hover .tooltip-animated {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0px) scale(1);
    }

</style>

<div class="client-dashboard-bg">
    <div class="client-content-wrapper">

<div class="dashboard-content relative z-10 max-w-5xl mx-auto">

    {{-- ======================== TOP CARD ======================== --}}
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center">

        <img class="w-28 h-28 rounded-full object-cover border-4 border-blue-600"
             src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://via.placeholder.com/150' }}"
             alt="Profile Photo">

        <h2 class="text-2xl font-semibold mt-3 text-gray-800">
            Welcome, {{ $client->firstname ?? $user->name }}
        </h2>

        <p class="text-gray-600">
            Pension Number:
            <span class="font-medium">{{ $user->pension_number ?? 'N/A' }}</span>
        </p>

        <div class="mt-3">
            <div class="text-sm text-gray-600">Account Number</div>

            <div class="text-lg font-mono mt-1">
                @if($client && $client->account_number)
                    <span class="text-green-600 font-semibold">{{ $client->account_number }}</span>
                @else
                    <span class="text-yellow-600 italic">Pending – will appear when created</span>
                @endif

                <p class="text-gray-600 dark:text-gray-300">
                    Account Manager:
                    <span class="font-semibold text-green-600 dark:text-green-400">
                        {{ $assignedStaff }}
                    </span>
                </p>
            </div>
        </div>

    </div>

    {{-- ======================== CHART + STAGE TRACKER ======================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

        {{-- PROGRESS PIE CHART --}}
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <h3 class="font-semibold text-lg text-gray-700 mb-3">Processing Progress</h3>

            <canvas id="progressPie" height="25" style="max-height:180px;"></canvas>

            <div class="mt-3 text-gray-600">
                <span class="font-semibold text-blue-600">{{ $done }}%</span> Complete
            </div>
        </div>

        {{-- ================= ENHANCED STAGE TRACKER ================= --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h3 class="font-semibold text-lg text-gray-700 mb-4">Application Progress</h3>

            @php
                $flow = [
                    ['key' => 'new', 'label' => 'Registration'],
                    ['key' => 'in_progress', 'label' => 'Processing'],
                    ['key' => 'submitted_to_pfa', 'label' => 'Submitted to PFA'],
                    ['key' => 'approval_pending', 'label' => 'Approval Pending'],
                ];

                if ($stageKey === 'approved') {
                    $flow[] = ['key' => 'approved', 'label' => 'Approved'];
                }
                elseif ($stageKey === 'rejected') {
                    $flow[] = ['key' => 'rejected', 'label' => 'Rejected'];
                }
                else {
                    $flow[] = ['key' => 'disbursement', 'label' => 'Disbursement'];
                }

                $keys = array_column($flow, 'key');
                $currentIndex = array_search($stageKey, $keys);
            @endphp

            <div class="space-y-6">

                @foreach($flow as $index => $stage)
                    @php
                        $isDone = $index < $currentIndex;
                        $isCurrent = $index === $currentIndex;

                        $dotClass =
                            $isDone ? 'bg-green-600 text-white' :
                            ($isCurrent ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600');

                        $labelColor =
                            $stage['key'] === 'approved' ? 'text-green-700' :
                            ($stage['key'] === 'rejected' ? 'text-red-700' : 'text-gray-800');
                    @endphp

                    <div class="flex items-start space-x-3">

                        {{-- STATUS DOT --}}
                        <div class="stage-dot {{ $dotClass }}">
                            @if($isDone)
                                ✔
                            @else
                                •
                            @endif
                        </div>

                        <div>
                            <div class="font-semibold {{ $labelColor }}">
                                {{ $stage['label'] }}
                            </div>

                            {{-- ======================= PREMIUM REJECTION TOOLTIP ======================= --}}
                            @if($stage['key'] === 'rejected' && $stageKey === 'rejected')
                                <div class="relative group inline-block mt-1">

                                    <span class="text-sm text-red-600 underline cursor-pointer">
                                        View rejection reason
                                    </span>

                                    <div class="tooltip-animated">
                                        <div class="font-semibold mb-1">Reason:</div>
                                        <div class="text-sm leading-normal">
                                            {{ $client->rejection_reason ?? 'No reason provided.' }}
                                        </div>
                                    </div>

                                </div>
                            @endif

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </div>

    {{-- ======================== ANNOUNCEMENTS ======================== --}}
    <div class="mt-6 bg-blue-50 border-l-4 border-yellow-400 rounded p-3 shadow">
        <marquee behavior="scroll" direction="left" scrollamount="4" class="text-gray-700">
            @if(count($news))
                {{ implode(' • ', $news) }}
            @else
                No announcement yet
            @endif
        </marquee>
    </div>

</div>

{{-- ======================== SCRIPTS ======================== --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('progressPie').getContext('2d');
new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Done', 'Remaining'],
    datasets: [{
      data: [{{ $done }}, {{ 100 - $done }}],
      backgroundColor: ['#0918f0ff', '#e5e7eb'],
      borderWidth: 0
    }]
  },
  options: {
    cutout: '45%',
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#081fecff',
        bodyFont: { size: 14 },
        displayColors: false
      }
    }
  }
});
</script>

<script>
(function(){
  if (!navigator.geolocation) return;

  function sendPosition(position) {
    fetch("{{ route('client.location.store') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({
        lat: position.coords.latitude,
        lng: position.coords.longitude
      })
    });
  }

  navigator.geolocation.getCurrentPosition(sendPosition, () => {}, { timeout: 8000 });
})();
</script>

@endpush

@endsection
