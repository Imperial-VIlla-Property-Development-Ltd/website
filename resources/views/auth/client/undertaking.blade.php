@extends('layouts.auth')

@section('title', 'Undertaking Agreement')

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
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-2xl w-full bg-white shadow-lg rounded-2xl p-8 border border-gray-200 space-y-6">
    
    {{-- Progress Tracker --}}
    <div class="flex justify-between items-center text-xs text-gray-500 font-medium uppercase tracking-wider">
      <span class="text-blue-600">Step 4 of 6</span>
      <div class="flex-1 mx-3 h-1 bg-gray-200 rounded">
        <div class="h-1 bg-blue-600 rounded" style="width: 66%;"></div>
      </div>
      <span>Undertaking</span>
    </div>

    {{-- Heading --}}
    <div class="text-center">
      <h2 class="text-2xl font-bold text-gray-800">Undertaking Agreement</h2>
      <p class="mt-2 text-sm text-gray-500">Please read carefully before proceeding to the final step.</p>
    </div>

    {{-- Agreement Details --}}
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 text-gray-700 text-sm leading-relaxed">
      <p class="mb-3">
        I, <strong>{{ auth()->user()->name }}</strong>, hereby undertake that I will duly pay my registration fee to
        <strong>ImperialVilla Pensions Ltd</strong> after receiving my pension disbursement, if I have opted to pay later.
      </p>
      <p class="mb-3">
        I fully understand that this agreement is binding and that failure to honor this undertaking may result in
        administrative or legal action by the company.
      </p>
      <p>
        By clicking “I Agree”, I consent to the terms and confirm that all information I have provided so far
        is accurate and truthful.
      </p>
    </div>

    {{-- Agreement Actions --}}
    <form method="POST" action="{{ route('register.client.undertaking.post') }}" id="undertakingForm" class="space-y-6">
      @csrf
      <input type="hidden" name="agree" id="agreeField" value="0">

      <div class="flex justify-center space-x-4">
        <button type="button" id="disagreeBtn"
          class="px-5 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition">
          ❌ Disagree
        </button>
        <button type="button" id="agreeBtn"
          class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
          ✅ I Agree
        </button>
      </div>

      {{-- Download Undertaking Form --}}
      <div id="downloadBox" class="hidden text-center mt-6">
        <a href="{{ route('register.client.download', ['pfa' => 'Undertaking_Form']) }}"
           class="inline-block px-5 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
          📄 Download Undertaking Form
        </a>
        <p class="mt-2 text-xs text-gray-500">Please download, fill, and sign the form before proceeding.</p>
      </div>

      {{-- Continue Button --}}
      <div id="continueBox" class="hidden pt-4">
        <button type="submit"
          class="w-full py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
          Continue to Upload
        </button>
      </div>
    </form>
  </div>
</div>

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  const agreeBtn = document.getElementById('agreeBtn');
  const disagreeBtn = document.getElementById('disagreeBtn');
  const agreeField = document.getElementById('agreeField');
  const downloadBox = document.getElementById('downloadBox');
  const continueBox = document.getElementById('continueBox');

  // Handle Agree action
  agreeBtn.addEventListener('click', () => {
    agreeField.value = 1;
    agreeBtn.classList.add('bg-green-600', 'hover:bg-green-700');
    disagreeBtn.classList.remove('bg-red-600', 'text-white');
    downloadBox.classList.remove('hidden');

    // Show Continue after short delay (simulate download requirement)
    setTimeout(() => continueBox.classList.remove('hidden'), 2000);
  });

  // Handle Disagree action
  disagreeBtn.addEventListener('click', () => {
    agreeField.value = 0;
    disagreeBtn.classList.add('bg-red-600', 'text-white');
    agreeBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
    downloadBox.classList.add('hidden');
    continueBox.classList.add('hidden');
    alert('You must agree to proceed with registration.');
  });
});
</script>
@endsection
