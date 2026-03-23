@extends('layouts.dashboard')
@section('page_title', 'Add New Staff')
@section('content')
<div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Add New Staff</h2>
  <form method="POST" action="{{ route('super.staff.store') }}">
    @csrf
    <div class="mb-3">
      <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Full Name</label>
      <input type="text" name="name" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-gray-200" required>
    </div>
    <div class="mb-3">
      <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Email</label>
      <input type="email" name="email" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-gray-200" required>
    </div>
    <div class="mb-3">
      <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Password</label>
      <input type="password" name="password" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-gray-200" required>
    </div>
    <div class="mb-4">
      <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Confirm Password</label>
      <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-gray-200" required>
    </div>
    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">
      ➕ Create Staff
    </button>
  </form>
</div>
@endsection
