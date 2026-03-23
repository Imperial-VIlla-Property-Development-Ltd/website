@extends('layouts.dashboard')
@section('page_title','Super Admin - Staff')
@section('content')
<h2 class="text-xl font-semibold mb-4">Manage Staff</h2>

<a href="{{ route('super.staff.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded mb-3 inline-block">Add New Staff</a>

@if(session('success'))
  <div class="bg-green-100 text-green-700 p-2 mb-3 rounded">{{ session('success') }}</div>
@endif

<table class="table-auto w-full border">
  <thead class="bg-gray-200"><tr>
    <th>Name</th><th>Email</th><th>Staff ID</th><th>Status</th><th>Actions</th>
  </tr></thead>
  <tbody>
  @foreach($staff as $s)
    <tr class="border-b">
      <td>{{ $s->name }}</td>
      <td>{{ $s->email }}</td>
      <td>{{ $s->staff_id }}</td>
      <td>{{ $s->is_active ? 'Active' : 'Suspended' }}</td>
      <td class="space-x-1">
        <form action="{{ route('super.staff.toggle',$s) }}" method="POST">@csrf
          <button class="px-2 py-1 bg-yellow-500 text-white rounded">Toggle</button>
        </form>
        <form action="{{ route('super.staff.destroy',$s) }}" method="POST" onsubmit="return confirm('Delete staff?')">
          @csrf @method('DELETE')
          <button class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection
