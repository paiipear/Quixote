<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservasi Saya | QuixoteBus</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#f5f7ff] text-gray-800 font-sans antialiased">

  <!-- 🔹 NAVBAR -->
<header class="w-full bg-white shadow fixed top-0 left-0 z-50">
  <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-indigo-700">QuixoteBus</h1>

    <nav class="flex items-center gap-6">
      <a href="{{ route('passenger.dashboard') }}" class="text-gray-700 font-medium hover:text-indigo-600 transition">Dashboard</a>
      <a href="{{ route('passenger.reservations') }}" class="text-gray-700 font-medium hover:text-indigo-600 transition">Reservasi Saya</a>
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

  <!-- 🔹 MAIN CONTENT -->
  <main class="pt-24 px-6 max-w-6xl mx-auto">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">Riwayat Reservasi</h2>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-indigo-100">
      <table class="w-full text-sm text-left">
        <thead class="bg-gradient-to-r from-indigo-400 to-purple-500 text-white text-sm">
          <tr>
            <th class="py-3 px-4 rounded-tl-lg">Kode</th>
            <th class="py-3 px-4">Bus</th>
            <th class="py-3 px-4">Rute</th>
            <th class="py-3 px-4">Tanggal</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4 rounded-tr-lg">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-indigo-100">
          @forelse($reservations as $r)
            <tr class="{{ $loop->odd ? 'bg-indigo-50' : 'bg-white' }} hover:bg-indigo-100 transition">
              <td class="py-3 px-4 font-medium text-gray-800">{{ $r->booking_code }}</td>
              <td class="py-3 px-4">{{ $r->schedule->bus->model ?? '-' }}</td>
              <td class="py-3 px-4">{{ $r->schedule->route->origin ?? '?' }} → {{ $r->schedule->route->destination ?? '?' }}</td>
              <td class="py-3 px-4">{{ $r->schedule->departure_date }}</td>
              <td class="py-3 px-4">
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                  @if($r->status === 'Lunas') bg-green-100 text-green-700
                  @elseif($r->status === 'Dibatalkan') bg-red-100 text-red-700
                  @else bg-yellow-100 text-yellow-700 @endif">
                  {{ ucfirst($r->status) }}
                </span>
              </td>
              <td class="py-3 px-4 flex gap-3">
                <a href="{{ route('passenger.reservation.detail', $r->id) }}" 
                   class="text-indigo-600 hover:text-purple-500 font-medium">Detail</a>

                @if($r->status !== 'Lunas' && $r->status !== 'Dibatalkan')
                <form action="{{ route('passenger.reservation.cancel', $r->id ?? '') }}" method="POST" onsubmit="return confirm('Batalkan reservasi ini?')">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Batalkan</button>
                </form>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-6 text-center text-gray-500 text-sm">Belum ada reservasi.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </main>

<script>
  function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('hidden');
  }

  window.addEventListener('click', (e) => {
    if (!e.target.closest('[onclick="toggleDropdown()"]')) {
      document.getElementById('dropdownMenu').classList.add('hidden');
    }
  });
</script>
</body>
</html>
