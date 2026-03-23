@extends('layouts.dashboard')
@section('page_title','My Reports')
@section('content')

<div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Reports History</h2>
        <a href="{{ route('staff.reports.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">New Report</a>
    </div>

    @if($reports->isEmpty())
        <p class="text-gray-500 text-sm">No reports submitted yet.</p>
    @else
        <table class="w-full text-sm border">
            <thead class="bg-gray-100 text-gray-600">
                <tr><th class="p-2 text-left">Date</th><th class="p-2 text-left">Content</th><th class="p-2">Download</th></tr>
            </thead>
            <tbody>
                @foreach($reports as $r)
                    <tr class="border-b">
                        <td class="p-2">{{ $r->report_date }}</td>
                        <td class="p-2">{{ \Illuminate\Support\Str::limit($r->content, 100) }}</td>
                        <td class="p-2 text-center">
                            <a href="{{ route('pdf.report', $r->id) }}" class="text-blue-600 underline">PDF</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
