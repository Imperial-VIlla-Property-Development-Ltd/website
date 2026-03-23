@extends('layouts.dashboard')

@section('title', 'Edit Staff')
@section('page_title', 'Edit Staff Details')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Staff Account</h2>

    <form method="POST" action="{{ route('admin.staff.update', $staff->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div>
            <label class="block text-gray-700 mb-2 font-medium">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $staff->name) }}"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-gray-700 mb-2 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $staff->email) }}"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-gray-700 mb-2 font-medium">Password (Leave blank to keep current)</label>
            <input type="password" name="password"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label class="block text-gray-700 mb-2 font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        {{-- Active Status --}}
        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $staff->is_active ? 'checked' : '' }}
                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-400">
            <label for="is_active" class="ml-2 text-gray-700">Active Account</label>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.staff.index') }}" 
               class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow">Cancel</a>
            <button type="submit" 
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">Save Changes</button>
        </div>
    </form>
</div>
@endsection
