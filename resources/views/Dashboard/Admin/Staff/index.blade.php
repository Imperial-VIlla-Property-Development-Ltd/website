@extends('layouts.dashboard')
@section('page_title','Manage Staff')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Manage Staff</h2>

        <a href="{{ route('admin.staff.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow-md transition-all duration-200">
            + Add Staff
        </a>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <table class="w-full text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm tracking-wide">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Active</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">
                @foreach($staff as $s)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3 font-medium">{{ $s->name }}</td>
                    <td class="p-3">{{ $s->email }}</td>

                    <td class="p-3">
                        @if($s->is_active)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">
                                Active
                            </span>
                        @else
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-semibold">
                                Suspended
                            </span>
                        @endif
                    </td>

                    <td class="p-3 text-right space-x-2">

                        {{-- EDIT BUTTON --}}
                        <a href="{{ route('admin.staff.edit', $s->id) }}"
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-sm shadow transition">
                            Edit
                        </a>

                        {{-- DELETE BUTTON --}}
                        <form action="{{ route('admin.staff.destroy', $s->id) }}"
                              method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button
                                onclick="return confirm('Are you sure you want to delete this staff member?')"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-sm shadow transition">
                                Delete
                            </button>
                        </form>

                        {{-- SUSPEND/ACTIVATE BUTTON --}}
                        <form action="{{ route('admin.staff.toggle', $s->id) }}"
                              method="POST" class="inline">
                            @csrf
                            <button class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded-md text-sm shadow transition">
                                {{ $s->is_active ? 'Suspend' : 'Activate' }}
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $staff->links() }}
    </div>

</div>
@endsection
