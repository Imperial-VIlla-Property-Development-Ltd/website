@extends('layouts.auth')

@section('content')
<style>
    body {
        background: url('/images/bg.png') no-repeat center center fixed !important;
        background-size: cover !important;
    }
    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.55);
        z-index: 0;
    }

    .relative, .content, form, .min-h-screen, .container {
        position: relative;
        z-index: 10;
    }
</style>
<div class="max-w-lg mx-auto mt-10 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
  <h2 class="text-2xl font-semibold text-blue-700 mb-4 text-center">Select Your PFA</h2>

  <form id="pfaForm" method="POST" action="{{ route('register.client.pfa.post') }}">
    @csrf

    {{-- PFA dropdown --}}
    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2">Select Pension Fund Administrator (PFA)</label>
      <select id="pfaSelect" name="pfa" required class="border rounded-md w-full p-2">
        <option value="">-- Choose PFA --</option>
        <option value="Stanbic IBTC">Stanbic IBTC</option>
        <option value="AccessARM">AccessARM</option>
        <option value="Leadway">Leadway</option>
        <option value="Trustfund">Trustfund</option>
        <option value="Fidelity">Fidelity</option>
        <option value="Premium">Premium</option>
        <option value="Norenbeger">Norenbeger</option>
        <option value="TangerineAPT">TangerineAPT</option>
        <option value="NPF">NPF</option>
        <option value="NLPC">NLPC</option>
        <option value="PAL">PAL</option>
        <option value="FCMB">FCMB</option>
        <option value="Nupenco">Nupenco</option>
        <option value="Crusader">Crusader</option>
      </select>
    </div>

    {{-- Download & confirmation --}}
    <div id="downloadSection" class="hidden mb-4">
      <a id="downloadBtn" href="#" target="_blank"
         class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
        📄 Download Form
      </a>
      <div class="mt-3 flex items-center">
        <input type="checkbox" id="downloaded" class="mr-2">
        <label for="downloaded" class="text-sm text-gray-700">I have downloaded the form</label>
      </div>
    </div>

    {{-- Next button --}}
    <button type="submit"
            id="nextBtn"
            disabled
            class="w-full bg-blue-600 text-white py-2 rounded-md opacity-50 cursor-not-allowed transition">
      Next →
    </button>
  </form>
</div>

<script>
const pfaSelect = document.getElementById('pfaSelect');
const downloadSection = document.getElementById('downloadSection');
const downloadBtn = document.getElementById('downloadBtn');
const downloaded = document.getElementById('downloaded');
const nextBtn = document.getElementById('nextBtn');

// When user selects PFA
pfaSelect.addEventListener('change', () => {
  const selected = pfaSelect.value;
  if (selected) {
    // Dynamically link correct PDF
    downloadBtn.href = `/register/client/download/${encodeURIComponent(selected)}`;
    downloadSection.classList.remove('hidden');
    nextBtn.disabled = true;
    nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
  } else {
    downloadSection.classList.add('hidden');
    nextBtn.disabled = true;
  }
});

// Enable Next only after checkbox
downloaded.addEventListener('change', () => {
  if (downloaded.checked) {
    nextBtn.disabled = false;
    nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
  } else {
    nextBtn.disabled = true;
    nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
  }
});
</script>
@endsection
