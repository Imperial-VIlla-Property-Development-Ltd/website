@extends('layouts.app')
@section('title','Staff Reports')

@section('content')

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.82);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        padding: 30px;
        max-width: 900px;
        margin: auto;
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    table tr:hover {
        background: rgba(0, 74, 239, 0.07);
        transition: 0.2s;
    }
</style>

<div class="glass-card">

    <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">
        📝 Staff Reports Overview
    </h2>

    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm">
        <thead class="bg-blue-600 text-white text-sm uppercase tracking-wide">
            <tr>
                <th class="py-3 px-4 text-left">Staff Name</th>
                <th class="py-3 px-4 text-left">Date</th>
                <th class="py-3 px-4 text-left">Report Details</th>
            </tr>
        </thead>

        <tbody>
            @forelse($reports as $r)
                <tr class="border-b text-sm">
                    <td class="py-3 px-4 font-semibold text-gray-800">
                        {{ $r->staff->name }}
                    </td>
                    <td class="py-3 px-4 text-gray-600">
                        {{ \Carbon\Carbon::parse($r->report_date)->format('d M, Y') }}
                    </td>
                    <td class="py-3 px-4 text-gray-700">
                        {{ $r->content }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-5 text-center text-gray-500">
                        No staff reports found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
