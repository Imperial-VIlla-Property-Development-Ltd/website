<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','ImperialVilla Portal')</title>
  
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  @stack('scripts')
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    body {
        background: url('/images/bg.png') no-repeat center center fixed !important;
        background-size: cover !important;
        position: relative;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.55); /* dark overlay */
        z-index: 0;
        pointer-events: none;
    }

    /* Ensure real page content stays above background */
    main, nav, .container, .content, .wrapper, .dashboard-content {
        position: relative;
        z-index: 10 !important;
    }
</style>


</head>

<body class="bg-gray-100 min-h-screen">

  <nav class="bg-white/90 backdrop-blur-md shadow p-4">
    <div class="container mx-auto flex justify-between">
      <a href="{{ route('home') }}" class="font-bold">ImperialVilla</a>
      <div></div>
    </div>
  </nav>

  <main class="container mx-auto p-6">
    @if($errors->any())
      <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>

</body>

@auth
  @if(Auth::user()->role === 'staff' && !Auth::user()->is_active)
    <div class="bg-red-600 text-white text-center py-2 animate-pulse font-bold">
      Your account has been suspended. Contact Admin.
    </div>
  @endif
@endauth

</html>
