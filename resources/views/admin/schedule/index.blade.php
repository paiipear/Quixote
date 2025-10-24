<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Jadwal | Admin QuixoteBus</title>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f5f7ff] text-[#111827] font-sans antialiased">
  <!-- SIDEBAR -->
  <aside class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-indigo-50 to-white flex flex-col shadow-md border-r border-indigo-100">
    <div class="px-6 py-6 border-b border-indigo-100">
      <h1 class="text-xl font-bold tracking-tight text-indigo-700">QuixoteBus</h1>
    </div>

    <nav class="flex-1 mt-6 space-y-1 px-4">
      <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Dashboard</a>
      <a href="{{ route('bus.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Data Bus</a>
      <a href="{{ route('busroute.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Rute</a>
      <a href="{{ route('schedule.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-indigo-700 bg-gradient-to-r from-indigo-600 to-purple-500 text-white shadow-md transition-all hover:shadow-lg">Jadwal</a>
      <a href="{{ route('admin.reservations') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Pemesanan</a>
    </nav>

    <form action="{{ route('logout') }}" method="POST" class="mt-auto mb-6 px-4">
      @csrf
      <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-indigo-600 to-purple-500 text-white rounded-lg font-medium text-sm shadow-md hover:from-indigo-700 hover:to-purple-600 transition-all">
        Logout
      </button>
    </form>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="ml-64 min-h-screen p-10 transition-all duration-300">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-2xl font-semibold text-indigo-700">Data Jadwal</h2>
      <a href="{{ route('schedule.create') }}" class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg font-medium shadow-sm hover:from-indigo-600 hover:to-purple-600 transition-all">
        + Tambah Jadwal
      </a>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-indigo-100 hover:shadow-md transition">
      <div class="overflow-x-auto">
        <table class="min-w-full border border-indigo-100 rounded-lg overflow-hidden">
          <thead class="bg-gradient-to-r from-indigo-400 to-purple-500 text-white text-sm">
            <tr>
              <th class="py-3 px-4 text-left">No</th>
              <th class="py-3 px-4 text-left">Bus</th>
              <th class="py-3 px-4 text-left">Rute</th>
              <th class="py-3 px-4 text-left">Tanggal</th>
              <th class="py-3 px-4 text-left">Waktu</th>
              <th class="py-3 px-4 text-left">Harga</th>
              <th class="py-3 px-4 text-left">Kursi Tersedia</th>
              <th class="py-3 px-4 text-left">Status</th>
              <th class="py-3 px-4 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-indigo-100">
            @forelse($schedules as $s)
              <tr class="{{ $loop->odd ? 'bg-indigo-50' : 'bg-white' }}">
                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                <td class="py-3 px-4">{{ $s->bus->model ?? '-' }}</td>
                <td class="py-3 px-4">
                  {{ $s->route->origin ?? '-' }} → {{ $s->route->destination ?? '-' }}
                </td>
                <td class="py-3 px-4">{{ $s->departure_date }}</td>
                <td class="py-3 px-4">{{ $s->departure_time }}</td>
                <td class="py-3 px-4">Rp{{ number_format($s->price, 0, ',', '.') }}</td>
                <td class="py-3 px-4">{{ $s->available_seats }}</td>
                <td class="py-3 px-4">
                  <span class="px-3 py-1 text-xs rounded-full 
                    {{ $s->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($s->status) }}
                  </span>
                </td>
                <td class="py-3 px-4 flex items-center gap-3">
                  <a href="{{ route('schedule.edit', $s->id) }}" class="p-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-500">
                    <i data-lucide="edit-3"></i>
                  </a>
                  <form action="{{ route('schedule.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                      <i data-lucide="trash-2"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="py-6 text-center text-gray-500 text-sm">Belum ada data jadwal</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
