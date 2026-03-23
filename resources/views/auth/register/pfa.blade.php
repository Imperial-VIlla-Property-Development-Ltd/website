@extends('layouts.app')
@section('title','PFA Form Upload')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4">PFA Forms</h2>
  <form action="{{ route('register.client.pfa.post') }}" method="POST" enctype="multipart/form-data">@csrf
    <label class="block mb-2">Select PFA</label>
    <select name="pfa_selected" class="w-full border p-2 mb-4">
      @foreach($pfas as $pfa)
        <option value="{{ $pfa['code'] }}">{{ $pfa['name'] }}</option>
      @endforeach
    </select>
    <label class="block mb-2">Upload filled PFA form (PDF)</label>
    <input type="file" name="pfa_form" accept="application/pdf" class="mb-4">
    <div>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
    </div>
  </form>
</div>
@endsection
