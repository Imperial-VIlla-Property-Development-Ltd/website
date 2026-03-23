<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Super Admin Dashboard')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-200">

  <div class="flex min-h-screen">

    {{-- ✅ YOUR SIDEBAR PARTIAL --}}
    @include('dashboard.super_admin.partials.sidebar')

    {{-- ✅ MAIN DASHBOARD CONTENT AREA --}}
    <main class="flex-1 p-8 overflow-y-auto">
      @yield('content')
    </main>

  </div>

</body>
</html>
