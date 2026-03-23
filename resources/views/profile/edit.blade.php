@extends('layouts.dashboard')
@section('page_title','Edit Profile')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight flex items-center gap-3">
            <span class="text-blue-700 text-5xl">👤</span> Edit Profile
        </h2>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded-xl mb-6 shadow-lg text-lg font-semibold">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Form Container --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-10 border border-gray-200 dark:border-gray-700">

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- FULL NAME --}}
                <div>
                    <label class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2 block">Full Name</label>
                    <input
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="profile-input"
                        placeholder="Enter your full name"
                        required
                    >
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2 block">Email Address</label>
                    <input
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="profile-input"
                        placeholder="example@email.com"
                        required
                    >
                </div>

                {{-- FIRST NAME --}}
                <div>
                    <label class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2 block">First Name</label>
                    <input
                        name="firstname"
                        value="{{ old('firstname', optional($user->client)->firstname) }}"
                        class="profile-input"
                        placeholder="First name"
                    >
                </div>

                {{-- MIDDLE NAME --}}
                <div>
                    <label class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2 block">Middle Name</label>
                    <input
                        name="middlename"
                        value="{{ old('middlename', optional($user->client)->middlename) }}"
                        class="profile-input"
                        placeholder="Middle name (optional)"
                    >
                </div>

                {{-- LAST NAME --}}
                <div>
                    <label class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2 block">Last Name</label>
                    <input
                        name="lastname"
                        value="{{ old('lastname', optional($user->client)->lastname) }}"
                        class="profile-input"
                        placeholder="Last name"
                    >
                </div>

                {{-- PHONE NUMBER --}}
                <div>
                    <label class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2 block">Phone Number</label>
                    <input
                        name="phone_number"
                        value="{{ old('phone_number', optional($user->client)->phone_number ?? $user->phone_number) }}"
                        class="profile-input"
                        placeholder="Phone number"
                    >
                </div>

                {{-- ADDRESS --}}
                <div class="md:col-span-2">
                    <label class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2 block">Address</label>
                    <input
                        name="address"
                        value="{{ old('address', optional($user->client)->address) }}"
                        class="profile-input"
                        placeholder="Home address"
                    >
                </div>

                {{-- PROFILE PHOTO --}}
                <div class="md:col-span-2">
                    <label class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2 block">Profile Photo</label>

                    <div class="flex items-center gap-6">
                        <img
                            src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
                            class="w-28 h-28 rounded-full object-cover shadow-xl border-4 border-blue-600"
                        >
                        <input type="file" name="profile_photo" class="profile-input py-3">
                    </div>
                </div>

                {{-- CHANGE PASSWORD --}}
                <div class="md:col-span-2 mt-4">
                    <label class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2 block">
                        Change Password <span class="text-sm text-gray-500">(optional)</span>
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input
                            type="password"
                            name="password"
                            class="profile-input"
                            placeholder="Enter new password"
                        >

                        <input
                            type="password"
                            name="password_confirmation"
                            class="profile-input"
                            placeholder="Confirm new password"
                        >
                    </div>
                </div>

            </div>

            {{-- SAVE BUTTON --}}
            <div class="mt-10 text-right">
                <button class="bg-blue-700 hover:bg-blue-800 text-white text-lg font-bold px-8 py-3 rounded-xl shadow-xl transition-all transform hover:scale-[1.03]">
                    💾 Save Changes
                </button>
            </div>

        </form>

    </div>

</div>


{{-- Custom Bold Input Style --}}
<style>
    .profile-input {
        @apply w-full px-4 py-3 rounded-xl 
        border border-gray-300 dark:border-gray-700 
        bg-gray-50 dark:bg-gray-800 
        text-gray-900 dark:text-gray-100 
        text-lg font-semibold shadow-sm;
    }
    .profile-input:focus {
        @apply outline-none ring-2 ring-blue-600 shadow-lg;
    }
</style>

@endsection
