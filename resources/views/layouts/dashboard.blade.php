<!doctype html>
<html lang="en" class="transition-colors duration-300">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Portal')</title>

  {{-- Tailwind CDN --}}
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  {{-- Optional Chart.js --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  {{-- Vite Check --}}
  @php
      $viteManifest = public_path('build/manifest.json');
  @endphp
  @if (file_exists($viteManifest))
      @vite(['resources/js/app.js'])
  @endif

  <style>
    html, body {
      height: 100%;
      overflow: hidden;
    }

    aside {
      background-color: #ccd0f3ff;
      color: #01070eff;
      font-size: 24px;
    }

    /* ==== DARK MODE OVERRIDES ==== */
    body.dark {
      background-color: #000207ff;
      color: #f8fafc;
    }

    body.dark aside {
      background-color: #000000ff;
      border-color: #0d09eeff;
      color: #f8fafc;
    }

    body.dark aside a {
      color: #e2e8f0;
      background-color: #0d09ee;
    }

    body.dark aside a:hover {
      background-color: #334155;
      color: #fcf6f6ff;
    }

    body.dark header {
      background-color: #0a20e9ff;
      border-bottom: 1px solid #0b22eeff;
      color: #f8fafc;
    }

    body.dark main {
      background-color: #000207ff;
      color: #f8fafc;
    }

    body.dark .card,
    body.dark .shadow,
    body.dark .rounded-lg {
      background-color: #010305ff;
      color: #f8fafcff;
      border-color: #0717f5ff;
    }

    body.dark input,
    body.dark textarea,
    body.dark select {
      background-color: #04060aff;
      color: #f1f5f9;
      border-color: #031cf7ff;
    }

    body.dark button {
      background-color: #ebebf1ff;
      color: #0a18d8ff;
    }

    body.dark button:hover {
      background-color: #231feeff;
    }

    body.dark #userMenuDropdown {
      background-color: #020336ff;
      color: #0d0d0eff;
    }
  </style>
</head>

<body class="flex min-h-screen bg-gray-100 text-gray-900 dark:bg-black-900 dark:text-white-100 transition-colors duration-300">
{{-- Sidebar --}}
<aside class="bg-dark w-64 p-4 border-r hidden md:flex flex-col justify-between">

    {{-- Sidebar Logo --}}
    <div class="flex flex-col items-center mb-8 mt-4">
        <img src="{{ asset('logo.png') }}" 
             alt="Imperial Villa Logo"
             class="w-28 h-28 object-contain mb-2 rounded-full shadow">
        <h1 class="text-xl font-bold text-blue-800 tracking-wide">IMPERIAL VILLA</h1> 
    </div>

    {{-- Navigation --}}
    <nav class="space-y-2 mb-6">
        @isset($menu)
            @foreach($menu as $item)
                <a href="{{ $item['url'] }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium 
                   {{ request()->is($item['active']) ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }}">
                   {{ $item['label'] }}
                </a>
            @endforeach
        @endisset

       {{-- CLIENT-ONLY: Disbursement Form Button --}}
@if(
    auth()->user()->role === 'client' &&
    auth()->user()->client &&
    auth()->user()->client->stage === 'disbursement'
)
    <a href="{{ route('client.form.download', auth()->user()->client->id) }}"
       class="mt-4 block w-full text-center bg-green-600 hover:bg-green-700 
              text-white font-semibold py-2 rounded-lg shadow transition-all duration-200">
        📄 Download Disbursement Form
    </a>
@endif

    </nav>

    {{-- Bottom Quick Report --}}
    <div id="quickReportBox" class="border-t pt-3 mt-auto">
        <h4 class="text-sm font-semibold text-gray-700 mb-2">📝 Quick Report</h4>

        <form id="sidebarQuickReport" method="POST" action="{{ route('staff.reports.store') }}" class="space-y-2">
            @csrf
            <textarea name="content"
                      rows="2"
                      placeholder="Type report..."
                      class="w-full text-sm border-gray-300 rounded-md focus:ring focus:ring-blue-100 p-2 resize-none"></textarea>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm py-1.5 rounded-md shadow transition-all duration-200">
                Submit
            </button>
        </form>

        <div id="sidebarReportStatus" class="hidden mt-1 text-xs"></div>
    </div>

</aside>



  {{-- Main Workspace --}}
  <div class="flex-1 flex flex-col h-full overflow-hidden">

    {{-- Header --}}
    <header class="bg-white dark:bg-gray-800 shadow px-4 py-3 flex justify-between items-center relative z-40">

        {{-- Sidebar Toggle --}}
        <div class="md:hidden">
          <button onclick="document.querySelector('aside').classList.toggle('hidden')" 
                  class="p-2 border rounded hover:bg-gray-100 dark:hover:bg-gray-700">
            ☰
          </button>
        </div>

        {{-- Page Title --}}
        <h1 class="font-semibold text-lg text-white-700 dark:text-white-100">@yield('page_title','Dashboard')</h1>

        {{-- Right Controls --}}
        <div class="flex items-center space-x-6 relative">

            {{-- Notifications --}}
            <a href="{{ route('notifications.index') }}" class="relative text-xl hover:text-blue-600 dark:hover:text-blue-400">
              🔔
              @if(auth()->user()->unreadNotifications->count())
                <span class="absolute -top-1 -right-2 bg-red-600 text-white text-xs rounded-full px-1">
                  {{ auth()->user()->unreadNotifications->count() }}
                </span>
              @endif
            </a>

            {{-- Messages --}}
            @php
              $unreadCount = \App\Models\Message::where('receiver_id',auth()->id())
                              ->whereNull('read_at')->count();
            @endphp
            <a href="{{ route('messages.index') }}" 
               class="relative text-lg hover:text-blue-600 dark:hover:text-blue-400">
              💬
              @if($unreadCount > 0)
                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1">
                  {{ $unreadCount }}
                </span>
              @endif
            </a>

            {{-- Profile Dropdown --}}
            <div class="relative">
              <button id="userMenuBtn" 
                      class="flex items-center space-x-2 border border-gray-200 dark:border-gray-700 px-2 py-1 rounded-full hover:bg-gray-50 dark:hover:bg-gray-700">

                <img src="{{ auth()->user()->profile_photo 
                            ? asset('storage/' . auth()->user()->profile_photo) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                    alt="Avatar"
                    class="w-9 h-9 rounded-full border-2 border-blue-500 object-cover">

                <span class="hidden md:inline font-medium text-gray-700 dark:text-gray-100">{{ auth()->user()->name }}</span>

                <svg class="w-4 h-4 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
              </button>

              {{-- Dropdown --}}
              <div id="userMenuDropdown"
                   class="hidden absolute right-0 mt-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg w-56 z-50 transition-all overflow-hidden">
                
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                  <div class="font-semibold text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</div>
                  <div class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ auth()->user()->role ?? 'user' }}</div>
                </div>

                <a href="{{ route('profile.edit') }}" 
                   class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">
                   👤 Profile
                </a>

                <button id="darkModeToggle" 
                        class="w-full text-left px-4 py-2 hover:bg-black-100 dark:hover:bg-black-700 text-white-700 dark:text-white-200 text-sm">
                  🌗 Toggle Dark Mode
                </button>

                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" 
                          class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 text-sm">
                    🔒 Logout
                  </button>
                </form>

              </div>
            </div>
        </div>
    </header>

    {{-- Content Area --}}
    <main class="flex-1 overflow-y-auto overflow-x-hidden p-6 bg-gray-50 relative">
        @yield('content')
        @stack('floating')
    </main>

  </div>

  {{-- Toast --}}
  @if(session('success'))
    <div id="toast" class="fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow-lg">
      {{ session('success') }}
    </div>
    <script>
      setTimeout(() => document.getElementById('toast')?.remove(), 4000);
    </script>
  @endif

  {{-- Scripts --}}
  @stack('scripts')

<script>
document.addEventListener('DOMContentLoaded', () => {
  const menuBtn = document.getElementById('userMenuBtn');
  const dropdown = document.getElementById('userMenuDropdown');
  const toggle = document.getElementById('darkModeToggle');
  const body = document.body;

  if (menuBtn && dropdown) {
    menuBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      dropdown.classList.toggle('hidden');
    });
    window.addEventListener('click', () => dropdown.classList.add('hidden'));
  }

  function applyTheme(mode) {
    if (mode === 'dark') {
      body.classList.add('dark');
      localStorage.setItem('theme', 'dark');
      toggle.textContent = '🌞 Light Mode';
    } else {
      body.classList.remove('dark');
      localStorage.setItem('theme', 'light');
      toggle.textContent = '🌗 Dark Mode';
    }
  }

  const saved = localStorage.getItem('theme');
  if (saved === 'dark') applyTheme('dark');
  else if (saved === 'light') applyTheme('light');
  else {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    applyTheme(prefersDark ? 'dark' : 'light');
  }

  if (toggle) {
    toggle.addEventListener('click', (e) => {
      e.stopPropagation();
      const isDark = body.classList.contains('dark');
      applyTheme(isDark ? 'light' : 'dark');
    });
  }
});
</script>

</body>
</html>
