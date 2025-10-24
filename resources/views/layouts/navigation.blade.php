<header class="w-full bg-white shadow fixed top-0 left-0 z-50">
  <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
    <!-- Logo -->
    <h1 class="text-xl font-bold text-indigo-700">QuixoteBus</h1>

    <!-- Menu Navigasi -->
    <nav class="hidden md:flex items-center gap-6">
      <a href="{{ route('passenger.dashboard') }}" 
         class="text-gray-700 font-medium hover:text-indigo-600 transition {{ request()->routeIs('passenger.dashboard') ? 'text-indigo-600 font-semibold' : '' }}">
         Dashboard
      </a>
      <a href="{{ route('passenger.reservations') }}" 
         class="text-gray-700 font-medium hover:text-indigo-600 transition {{ request()->routeIs('passenger.reservations') ? 'text-indigo-600 font-semibold' : '' }}">
         Reservasi Saya
      </a>
    </nav>

    <!-- Profil -->
    <div class="relative">
      <button onclick="toggleDropdown()" class="flex items-center gap-3 focus:outline-none">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366F1&color=fff" 
             alt="Avatar" class="w-9 h-9 rounded-full shadow">
        <div class="hidden sm:flex flex-col text-left">
          <span class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</span>
          <span class="text-xs text-gray-500">Penumpang</span>
        </div>
        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500"></i>
      </button>

      <!-- Dropdown -->
      <div id="dropdownMenu" class="hidden absolute right-0 mt-3 w-56 bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden z-50">
        <div class="px-4 py-3 border-b bg-gray-50">
          <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
          <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-indigo-50 transition">
          <i data-lucide="user" class="w-4 h-4 text-indigo-500"></i> Profil
        </a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition">
            <i data-lucide="log-out" class="w-4 h-4 text-red-500"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</header>

<script>
  function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('hidden');
  }

  window.addEventListener('click', (e) => {
    const dropdown = document.getElementById('dropdownMenu');
    if (!e.target.closest('button') && !e.target.closest('#dropdownMenu')) {
      dropdown.classList.add('hidden');
    }
  });
</script>
