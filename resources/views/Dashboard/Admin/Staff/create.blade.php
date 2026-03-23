@extends('layouts.dashboard')

@section('page_title', 'Create Staff')

@section('content')

<div class="max-w-2xl mx-auto mt-12">

    {{-- PAGE HEADER --}}
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-bold text-blue-500">Create Staff Account</h1>
        <p class="text-black-300 mt-1 text-sm">
            Enter the details below to register a new staff member.
        </p>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-xl shadow-lg px-8 py-10">

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li class="leading-5">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- FULL NAME --}}
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">
                    Full Name
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter full name" required>
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">
                    Email Address
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter email address" required>
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">
                    Password
                </label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter password" required>
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">
                    Confirm Password
                </label>
                <input type="password" name="password_confirmation"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-800
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Re-enter password" required>
            </div>

            {{-- SUBMIT --}}
            <div class="pt-2">
                <button type="submit"
                        class="w-full py-3 rounded-lg text-white font-semibold
                               bg-blue-600 hover:bg-blue-700 transition shadow-md">
                    Create Staff Account
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
