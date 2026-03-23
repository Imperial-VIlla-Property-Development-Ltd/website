<aside class="w-64 bg-gray-900 text-gray-200 flex flex-col shadow-lg">
  {{-- HEADER --}}
  <div class="p-6 border-b border-gray-800 text-center">
    <h1 class="text-xl font-bold text-green-400">🛡️ Super Admin</h1>
    <p class="text-xs text-gray-400">Master Control</p>
  </div>

  {{-- NAVIGATION --}}
  <nav class="flex-1 p-4 space-y-3">
    <a href="{{ route('dashboard.superadmin') }}" 
       class="block py-2 px-4 rounded hover:bg-green-600/20 {{ request()->routeIs('dashboard.superadmin') ? 'bg-green-700/20' : '' }}">
      🏠 Overview
    </a>

    <a href="{{ route('super.clients.index') }}" 
       class="block py-2 px-4 rounded hover:bg-green-600/20 {{ request()->routeIs('super.clients.*') ? 'bg-green-700/20' : '' }}">
      👥 Client Management
    </a>

    <a href="{{ route('super.staff.index') }}" 
       class="block py-2 px-4 rounded hover:bg-green-600/20 {{ request()->routeIs('super.staff.*') ? 'bg-green-700/20' : '' }}">
      🧑‍💼 Staff Management
    </a>

    <a href="{{ route('super.admins.index') }}" 
       class="block py-2 px-4 rounded hover:bg-green-600/20 {{ request()->routeIs('super.admins.*') ? 'bg-green-700/20' : '' }}">
      🧰 Admin Management
    </a>

    <form action="{{ route('superadmin.toggle.portal') }}" method="POST" class="mt-6">
      @csrf
      <button 
        class="w-full py-2 px-4 rounded text-white font-semibold transition
          {{ $portalStatus === 'active' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
        {{ $portalStatus === 'active' ? '🔒 Shutdown Portal' : '🚀 Activate Portal' }}
      </button>
    </form>

    <a href="{{ route('logout') }}" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="block mt-4 py-2 px-4 rounded bg-gray-800 hover:bg-red-700 text-center text-white text-sm">
      🚪 Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
  </nav>

  {{-- FOOTER --}}
  <div class="p-4 text-xs text-gray-500 border-t border-gray-800">
    © {{ now()->year }} ImperialVilla
  </div>
</aside>
