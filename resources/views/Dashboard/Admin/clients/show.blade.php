@extends('layouts.dashboard')
@section('page_title','Client Profile')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER CARD --}}
    <div class="bg-white rounded-xl shadow p-6 flex justify-between items-start">
        
        {{-- LEFT SIDE: CLIENT INFO --}}
        <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-1">
                {{ $client->firstname }} {{ $client->lastname }}
            </h2>

            <div class="space-y-1 text-gray-600">
                <p><strong>Pension:</strong> {{ $client->pension_number ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $client->user->email ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- RIGHT SIDE: STATUS + ACCOUNT --}}
        <div class="w-72 bg-gray-50 border rounded-xl p-4 shadow-sm">

            <h3 class="font-semibold text-gray-700 mb-2">Client Status</h3>

            {{-- STAGE DROPDOWN --}}
            <form method="POST" action="{{ route('admin.client.updateStage', $client) }}" id="stageForm">
                @csrf

                <label class="text-sm font-medium text-gray-600">Application Stage</label>
                <select name="stage" id="stageSelect"
                        class="w-full border rounded-md px-3 py-2 mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="new" {{ $client->stage=='new'?'selected':'' }}>New</option>
                    <option value="in_progress" {{ $client->stage=='in_progress'?'selected':'' }}>In Progress</option>
                    <option value="submitted_to_pfa" {{ $client->stage=='submitted_to_pfa'?'selected':'' }}>Submitted to PFA</option>
                    <option value="approval_pending" {{ $client->stage=='approval_pending'?'selected':'' }}>Approval Pending</option>
                    <option value="approved" {{ $client->stage=='approved'?'selected':'' }}>Approved</option>
                    <option value="rejected" {{ $client->stage=='rejected'?'selected':'' }}>Rejected</option>
                    <option value="disbursement" {{ $client->stage=='disbursement'?'selected':'' }}>Disbursement</option>
                </select>

                {{-- REJECTION REASON --}}
                <div id="rejectionBox"
                     class="mt-3 {{ $client->stage === 'rejected' ? '' : 'hidden' }}">
                    <label class="text-sm font-medium text-red-700">Rejection Reason</label>
                    <textarea name="rejection_reason"
                              rows="3"
                              class="w-full border rounded-md px-3 py-2 mt-1 focus:ring-red-500 focus:border-red-500"
                              placeholder="Explain rejection...">{{ old('rejection_reason', $client->rejection_reason) }}</textarea>

                    <button type="submit"
                            class="w-full bg-red-600 text-white py-2 rounded-md mt-3 hover:bg-red-700 shadow">
                        Save Rejection
                    </button>
                </div>

                <button type="submit" id="autoSubmit" class="hidden"></button>
            </form>

            {{-- ACCOUNT NUMBER --}}
            <form method="POST" action="{{ route('admin.client.updateAccount', $client) }}" class="mt-5">
                @csrf

                <label class="text-sm font-medium text-gray-600">Account Number</label>
                <input name="account_number"
                       value="{{ $client->account_number }}"
                       class="w-full border rounded-md px-3 py-2 mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                       placeholder="Account 000000">

                <button class="mt-3 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 shadow">
                    Save Account Number
                </button>
            </form>

        </div>
    </div>


{{-- DOCUMENT SECTION --}}
<div class="mt-10 bg-white rounded-xl shadow p-6">

    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center justify-between">
        Uploaded Documents

        {{-- DOWNLOAD SELECTED BUTTON --}}
        <form id="downloadForm" method="POST" action="{{ route('admin.client.downloadSelected') }}">
            @csrf
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 shadow">
                Download Selected
            </button>
        </form>
    </h3>

    @if($client->documents->count())

        {{-- SELECT ALL --}}
        <div class="mb-4 flex items-center">
            <input type="checkbox" id="selectAllDocs" class="mr-2">
            <label for="selectAllDocs" class="text-gray-700 font-medium text-sm">Select All</label>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            @foreach($client->documents as $doc)
            <div class="p-5 bg-gray-50 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">

                <div class="flex justify-between">
                    {{-- CHECKBOX --}}
                    <input type="checkbox" name="docs[]" form="downloadForm"
                           value="{{ $doc->id }}" class="doc-checkbox mt-1">

                    <div class="flex-1 ml-3">
                        {{-- TITLE --}}
                        <p class="font-semibold text-gray-800 text-lg">
                            {{ $doc->title ?? $doc->file_name }}
                        </p>

                        {{-- STATUS BADGE --}}
                        <span class="
                            inline-block mt-1 px-3 py-1 text-xs rounded-full font-semibold
                            @if($doc->status=='approved') bg-green-100 text-green-700
                            @elseif($doc->status=='rejected') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700
                            @endif
                        ">
                            {{ ucfirst($doc->status ?? 'pending') }}
                        </span>
                    </div>
                </div>

                {{-- VIEW BUTTON --}}
                <div class="flex justify-end mt-4">
                    <a href="{{ asset('storage/' . $doc->file_path) }}"
                       target="_blank"
                       class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 shadow">
                        View
                    </a>
                </div>
            </div>
            @endforeach

        </div>

    @else
        <p class="text-gray-500">No documents uploaded.</p>
    @endif
</div>





    {{-- MESSAGE PANEL --}}
    <div class="mt-10 bg-white rounded-xl shadow p-6">

        <h3 class="text-xl font-semibold text-gray-800 mb-3">Send Message</h3>

        <form method="POST" action="{{ route('messages.store') }}">
            @csrf

            <input type="hidden" name="receiver_id" value="{{ $client->user_id }}">

            <textarea name="content"
                      rows="4"
                      class="w-full border rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Write your message..."></textarea>

            <div class="text-right mt-3">
                <button class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 shadow">
                    Send Message
                </button>
            </div>
        </form>

    </div>

</div>



{{-- STAGE LOGIC --}}


<script>
document.getElementById('selectAllDocs').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.doc-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('stageSelect');
    const box = document.getElementById('rejectionBox');
    const autoSubmit = document.getElementById('autoSubmit');

    function toggle() {
        if (select.value === 'rejected') {
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
            autoSubmit.click();
        }
    }

    select.addEventListener('change', toggle);
});
</script>

@endsection
