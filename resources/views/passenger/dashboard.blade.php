<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Penumpang | QuixoteBus</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f7ff] text-[#111827] font-sans antialiased">

  <!-- NAVBAR -->
  <header class="w-full bg-white shadow fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-xl font-bold text-indigo-700">QuixoteBus</h1>

      <div class="flex items-center gap-4">
        <a href="{{ route('passenger.dashboard') }}" class="text-gray-700 font-medium hover:text-indigo-600">Dashboard</a>
        <a href="{{ route('passenger.reservations') }}" class="text-gray-700 font-medium hover:text-indigo-600">Reservasi Saya</a>

        <!-- Profil Breeze -->
        <div class="relative">
          <button onclick="toggleDropdown()" class="flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-4 py-2 rounded-lg font-medium shadow hover:from-indigo-600 hover:to-purple-600 transition">
            <i data-lucide="user" class="w-4 h-4"></i> {{ Auth::user()->name }}
          </button>

          <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-44 bg-white shadow-lg rounded-lg border border-gray-100 z-50">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profil</a>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="pt-24 px-6 max-w-7xl mx-auto">

    <!-- FORM CARI BUS -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-indigo-100 mb-8">
      <h2 class="text-2xl font-semibold text-indigo-700 mb-4">Cari Bus</h2>
      <form action="{{ route('passenger.search') }}" method="GET" class="grid md:grid-cols-4 gap-4">
        <div>
          <label class="text-gray-600 text-sm mb-1 block">Asal</label>
          <select name="origin" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400">
            <option value="">-- Pilih Asal --</option>
            @foreach($routes as $route)
              <option value="{{ $route->origin }}">{{ $route->origin }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="text-gray-600 text-sm mb-1 block">Tujuan</label>
          <select name="destination" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400">
            <option value="">-- Pilih Tujuan --</option>
            @foreach($routes as $route)
              <option value="{{ $route->destination }}">{{ $route->destination }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="text-gray-600 text-sm mb-1 block">Tanggal</label>
          <input type="date" name="departure_date" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400">
        </div>

        <div class="flex items-end">
          <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-indigo-600 to-purple-500 text-white rounded-lg font-medium shadow hover:from-indigo-700 hover:to-purple-600 transition">
            Cari
          </button>
        </div>
      </form>
    </div>

    <!-- RUTE REKOMENDASI -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-indigo-100 mb-8">
      <h2 class="text-2xl font-semibold text-indigo-700 mb-4">Rute Rekomendasi</h2>
      <div class="grid md:grid-cols-3 gap-6">
        @forelse($recommendedRoutes as $route)
          @php $lowestPrice = $route->schedules->min('price'); @endphp
          <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 hover:shadow-md transition">
            <h3 class="font-semibold text-gray-800">{{ $route->origin }} → {{ $route->destination }}</h3>
            <p class="text-gray-500 text-sm mt-1">Jarak: {{ $route->distance_km }} km</p>
            <p class="text-indigo-700 font-semibold mt-1">Mulai Rp{{ number_format($lowestPrice, 0, ',', '.') }}</p>
          </div>
        @empty
          <p class="text-gray-500 text-center col-span-3">Belum ada rute rekomendasi.</p>
        @endforelse
      </div>
    </div>

    <!-- JADWAL BUS HARI INI -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-indigo-100 mb-8">
      <h2 class="text-2xl font-semibold text-indigo-700 mb-4">Jadwal Bus Hari Ini</h2>

      @if($schedules->isEmpty())
        <div class="text-center text-gray-500 py-8">Belum ada jadwal bus hari ini</div>
      @else
        <div class="grid md:grid-cols-2 gap-6">
          @foreach($schedules as $schedule)
            <div class="border border-indigo-100 bg-indigo-50 rounded-xl p-5 hover:shadow-md transition">
              <div class="flex justify-between mb-1">
                <h3 class="font-semibold text-indigo-700">{{ $schedule->bus->model }}</h3>
                <span class="text-sm text-gray-600">{{ $schedule->departure_time }}</span>
              </div>
              <p class="text-gray-700">{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</p>
              <p class="text-gray-500 text-sm mb-2">Rp{{ number_format($schedule->price, 0, ',', '.') }}</p>
              <p class="text-sm text-gray-600 mb-3">Kursi tersedia: {{ $schedule->available_seats }}</p>

              <a href="{{ route('passenger.reserve.form', $schedule->id) }}" class="block w-full text-center py-2 bg-gradient-to-r from-indigo-600 to-purple-500 text-white rounded-lg font-medium hover:from-indigo-700 hover:to-purple-600 transition">
                Pesan Sekarang
              </a>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </main>

  <script>
    lucide.createIcons();
    function toggleDropdown() {
      document.getElementById('dropdownMenu').classList.toggle('hidden');
    }
    window.addEventListener('click', (e) => {
      const menu = document.getElementById('dropdownMenu');
      if (!e.target.closest('.relative')) menu.classList.add('hidden');
    });
  </script>

</body>
</html>
