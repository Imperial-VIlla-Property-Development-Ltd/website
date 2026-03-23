@extends('layouts.app')
@section('title','New Report')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10 px-4">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-2xl">

        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">
            📝 Submit Daily Report
        </h2>

        {{-- Decorative Divider --}}
        <div class="w-16 h-1 bg-green-500 mx-auto mb-8 rounded-full"></div>

        {{-- Form --}}
        <form method="POST" action="{{ route('staff.reports.store') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Today's Progress</label>
                <textarea name="content" rows="6"
                          class="border border-gray-300 rounded-lg p-3 w-full focus:ring focus:ring-green-200 focus:border-green-500 transition"
                          placeholder="Write your detailed report for today..." required></textarea>
            </div>

            <button
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg w-full transition">
                Submit Report
            </button>
        </form>

    </div>
</div>
@endsection
