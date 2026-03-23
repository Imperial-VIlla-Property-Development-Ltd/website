@extends('layouts.dashboard')
@section('page_title','Add Admin')
@section('content')
<h2 class="text-xl font-semibold mb-4">Create New Admin</h2>
<form method="POST" action="{{ route('super.admins.store') }}">@csrf
  <input name="name" placeholder="Name" class="border p-2 w-full mb-3" required>
  <input name="email" placeholder="Email" class="border p-2 w-full mb-3" required>
  <input name="password" type="password" placeholder="Password" class="border p-2 w-full mb-3" required>
  <input name="password_confirmation" type="password" placeholder="Confirm Password" class="border p-2 w-full mb-3" required>
  <button class="bg-green-600 text-white px-4 py-2 rounded">Create Admin</button>
</form>
@endsection
