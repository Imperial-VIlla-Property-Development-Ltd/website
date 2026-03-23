@extends('layouts.auth')

@section('title', 'Registration Payment')

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
  <div class="max-w-2xl w-full bg-white shadow-lg rounded-2xl p-8 space-y-6 border border-gray-200">
    
    {{-- Heading --}}
    <div class="text-center">
      <h2 class="text-2xl font-bold text-gray-800">Registration Fee Payment</h2>
      <p class="mt-2 text-sm text-gray-500">Choose how you’d like to pay your registration fee to proceed.</p>
    </div>

    {{-- Payment Options --}}
    <form id="paymentForm" method="POST" action="{{ route('register.client.payment.post') }}" class="space-y-6">
      @csrf

      <div class="space-y-4">
        <label class="flex items-center p-4 border rounded-lg hover:bg-blue-50 cursor-pointer transition">
          <input type="radio" name="payment_option" value="pay_now" class="mr-3 text-blue-600" required>
          <div>
            <div class="font-semibold text-gray-800">Pay Now</div>
            <p class="text-sm text-gray-500">You’ll make your payment immediately to complete your registration.</p>
          </div>
        </label>

        <label class="flex items-center p-4 border rounded-lg hover:bg-blue-50 cursor-pointer transition">
          <input type="radio" name="payment_option" value="pay_later" class="mr-3 text-blue-600" required>
          <div>
            <div class="font-semibold text-gray-800">Pay After Disbursement</div>
            <p class="text-sm text-gray-500">You’ll pay after your pension disbursement is processed.</p>
          </div>
        </label>
      </div>

      {{-- Pay Now Section --}}
      <div id="payNowBox" class="hidden mt-6 border-t pt-4">
        <h3 class="font-semibold text-gray-800 mb-2">Company Account Details</h3>
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-sm space-y-1">
          <p><strong>Bank Name:</strong> Zenith Bank</p>
          <p><strong>Account Name:</strong> ImperialVilla Property Ltd</p>
          <p><strong>Account Number:</strong> 1234567890</p>
          <p><strong>Amount:</strong> ₦5,000</p>
        </div>
        <p class="text-xs text-gray-500 mt-2">Please ensure you pay the exact amount before proceeding.</p>
      </div>

      {{-- Pay Later Section --}}
      <div id="payLaterBox" class="hidden mt-6 border-t pt-4">
        <h3 class="font-semibold text-gray-800 mb-2">Undertaking Agreement</h3>
        <p class="text-sm text-gray-600 mb-3">
          You are required to fill and agree to our <strong>Undertaking Form</strong> confirming your intent to pay the registration fee after disbursement.
        </p>
        
        <div class="space-y-3">
          <div class="flex items-center">
            <input type="checkbox" id="agreeCheckbox" class="mr-2 rounded text-blue-600">
            <label for="agreeCheckbox" class="text-sm text-gray-700">I agree to the terms of the Undertaking Form.</label>
          </div>

          
        </div>
      </div>

      {{-- Submit Button --}}
      <div class="pt-4">
        <button type="submit"
                class="w-full py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
          Continue
        </button>
      </div>
    </form>

  </div>
</div>

{{-- JavaScript Section --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  const payNow = document.querySelector('input[value="pay_now"]');
  const payLater = document.querySelector('input[value="pay_later"]');
  const payNowBox = document.getElementById('payNowBox');
  const payLaterBox = document.getElementById('payLaterBox');
  const agreeCheckbox = document.getElementById('agreeCheckbox');
  const downloadBtn = document.getElementById('downloadFormBtn');
  const form = document.getElementById('paymentForm');

  // Show/Hide boxes based on selection
  document.querySelectorAll('input[name="payment_option"]').forEach(option => {
    option.addEventListener('change', () => {
      if (payNow.checked) {
        payNowBox.classList.remove('hidden');
        payLaterBox.classList.add('hidden');
      } else if (payLater.checked) {
        payLaterBox.classList.remove('hidden');
        payNowBox.classList.add('hidden');
      }
    });
  });

  // Handle undertaking agreement
  agreeCheckbox.addEventListener('change', () => {
    downloadBtn.classList.toggle('hidden', !agreeCheckbox.checked);
  });

  // Prevent submitting without required action
  form.addEventListener('submit', e => {
    if (payLater.checked && !agreeCheckbox.checked) {
      e.preventDefault();
      alert('You must agree to the Undertaking Form to proceed.');
    }
  });
});
</script>
@endsection
