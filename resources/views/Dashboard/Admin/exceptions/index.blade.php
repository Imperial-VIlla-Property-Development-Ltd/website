@extends('layouts.app')
@section('title','Exceptions')

@section('content')

<style>
    .bg-blur {
        background: url('/images/bg.png') no-repeat center center fixed;
        background-size: cover;
        filter: blur(6px);
        position: fixed;
        top:0; left:0;
        width:100%; height:100%;
        z-index:-2;
    }
</style>

{{-- Background Blur Layer --}}
<div class="bg-blur"></div>

{{-- White container centered --}}
<div class="flex justify-center items-center min-h-screen px-4">

    <div class="w-full max-w-2xl bg-white p-8 rounded-2xl shadow-2xl border border-gray-200 relative"
         style="z-index:5;">

        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center opacity-90">
            Send Exception to Client
        </h2>

        {{-- Success --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 opacity-90">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.exceptions.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-bold text-gray-700 mb-1 opacity-80">Select Client</label>
                <select name="client_id"
                        class="w-full p-3 rounded-md border border-gray-300 opacity-80 focus:ring-2 focus:ring-blue-400">
                    @foreach($clients as $c)
                        <option value="{{ $c->id }}">
                            {{ $c->firstname }} {{ $c->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1 opacity-80">Exception Message</label>
                <textarea name="message" required
                          placeholder="Type the exception message..."
                          class="w-full p-3 rounded-md border border-gray-300 h-32 resize-none opacity-80 focus:ring-2 focus:ring-blue-400"></textarea>
            </div>

            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg shadow transition">
                Send Exception
            </button>
        </form>

        <hr class="my-8 opacity-40">

        {{-- Sent Exceptions --}}
        <h3 class="text-xl font-semibold mb-3 text-center text-gray-700 opacity-80">
            Sent Exceptions
        </h3>

        <ul class="space-y-3">
            @foreach($exceptions as $e)
                <li class="bg-white p-3 rounded shadow border opacity-90">
                    <strong class="text-blue-700">{{ $e->client->firstname }}</strong>:
                    <span class="text-gray-700">{{ $e->message }}</span>
                </li>
            @endforeach
        </ul>

    </div>

</div>
@endsection
