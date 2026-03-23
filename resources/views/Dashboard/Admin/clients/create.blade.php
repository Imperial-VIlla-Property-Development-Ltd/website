@extends('layouts.dashboard')

@section('title', 'Add New Client')
@section('page_title', 'Add New Client')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Register New Client</h2>

  <form action="{{ route('admin.client.store') }}" method="POST" class="space-y-6">
    @csrf

    {{-- Firstname --}}
    <div>
      <label for="firstname" class="block text-gray-700 font-medium mb-2">First Name</label>
      <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}"
        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
        placeholder="Enter client's first name">
      @error('firstname') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Lastname --}}
    <div>
      <label for="lastname" class="block text-gray-700 font-medium mb-2">Last Name</label>
      <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}"
        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
        placeholder="Enter client's last name">
      @error('lastname') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Email --}}
    <div>
      <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
      <input type="email" name="email" id="email" value="{{ old('email') }}"
        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
        placeholder="Enter client's email address">
      @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Pension Number --}}
    <div>
      <label for="pension_number" class="block text-gray-700 font-medium mb-2">Pension Number</label>
      <input type="text" name="pension_number" id="pension_number" value="{{ old('pension_number') }}"
        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
        placeholder="Enter client's pension number">
      @error('pension_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Assigned Staff --}}
    <div>
      <label for="staff_id" class="block text-gray-700 font-medium mb-2">Assign Staff</label>
      <select name="staff_id" id="staff_id"
        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        <option value="">-- Select Staff --</option>
        @foreach($staff ?? [] as $s)
          <option value="{{ $s->id }}" {{ old('staff_id') == $s->id ? 'selected' : '' }}>
            {{ $s->name }}
          </option>
        @endforeach
      </select>
      @error('staff_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Account Number --}}
    <div>
      <label for="account_number" class="block text-gray-700 font-medium mb-2">Account Number</label>
      <input type="text" name="account_number" id="account_number" value="{{ old('account_number') }}"
        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
        placeholder="Enter account number if available">
    </div>

    {{-- Stage --}}
    <div>
      <label for="stage" class="block text-gray-700 font-medium mb-2">Processing Stage</label>
      <select name="stage" id="stage"
        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        <option value="new">New</option>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
      </select>
    </div>

    {{-- Submit Button --}}
    <div class="flex justify-between mt-6">
      <a href="{{ route('admin.client.index') }}" 
         class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow">
         Cancel
      </a>
      <button type="submit" 
              class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
              Create Client
      </button>
    </div>
  </form>
</div>
@endsection
