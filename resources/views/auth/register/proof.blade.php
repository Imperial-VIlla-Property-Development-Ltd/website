@extends('layouts.app')
@section('title','Registration Proof')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4">Registration Proof</h2>

  <div class="p-4 border">
    <div class="flex items-center gap-4">
      <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://via.placeholder.com/80' }}" class="w-20 h-20 object-cover rounded">
      <div>
        <div class="font-bold text-lg">{{ $client->firstname }} {{ $client->middlename }} {{ $client->lastname }}</div>
        <div>Pension Number: {{ $user->pension_number }}</div>
        <div>Registration ID: {{ $client->registration_id }}</div>
        <div>Address: {{ $client->address }}</div>
      </div>
    </div>
  </div>

  <div class="mt-4">
    <button onclick="window.print()" class="bg-gray-700 text-white px-4 py-2 rounded">Print Proof</button>
    <a href="{{ route('dashboard.client') }}" class="ml-2 bg-green-600 text-white px-4 py-2 rounded">Go to Dashboard</a>
  </div>
</div>
@endsection
