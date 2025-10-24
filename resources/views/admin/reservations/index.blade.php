
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <aside class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-indigo-50 to-white flex flex-col shadow-md border-r border-indigo-100">
    <div class="px-6 py-6 border-b border-indigo-100">
      <h1 class="text-xl font-bold tracking-tight text-indigo-700">QuixoteBus</h1>
    </div>

    <nav class="flex-1 mt-6 space-y-1 px-4">
      <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Dashboard</a>
      <a href="{{ route('bus.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Data Bus</a>
      <a href="{{ route('busroute.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Rute</a>
      <a href="{{ route('schedule.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Jadwal</a>
      <a href="{{ route('admin.reservations') }}" class="block px-4 py-2.5 rounded-lg font-medium text-indigo-700 bg-gradient-to-r from-indigo-600 to-purple-500 text-white shadow-md transition-all hover:shadow-lg">Transaksi</a>
    </nav>

    <form action="{{ route('logout') }}" method="POST" class="mt-auto mb-6 px-4">
      @csrf
      <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-indigo-600 to-purple-500 text-white rounded-lg font-medium text-sm shadow-md hover:from-indigo-700 hover:to-purple-600 transition-all">
        Logout
      </button>
    </form>
  </aside>

  
  <main class="ml-64 min-h-screen p-10">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-2xl font-semibold text-indigo-700">Data Pemesanan</h2>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-indigo-100 hover:shadow-md transition">
      <div class="overflow-x-auto">
        <table class="min-w-full border border-indigo-100 rounded-lg overflow-hidden text-sm">
          <thead class="bg-gradient-to-r from-indigo-400 to-purple-500 text-white">
            <tr>
              <th class="py-3 px-4 text-left">Kode Booking</th>
              <th class="py-3 px-4 text-left">Nama Penumpang</th>
              <th class="py-3 px-4 text-left">Rute</th>
              <th class="py-3 px-4 text-left">Tanggal</th>
              <th class="py-3 px-4 text-left">Status Pembayaran</th>
              <th class="py-3 px-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-indigo-100">
            @forelse($reservations as $reservation)
              <tr class="{{ $loop->odd ? 'bg-indigo-50' : 'bg-white' }} hover:bg-indigo-100 transition">
                <td class="py-3 px-4 font-medium">{{ $reservation->booking_code }}</td>
                <td class="py-3 px-4">{{ $reservation->user->name ?? '-' }}</td>
                <td class="py-3 px-4">
                  {{ $reservation->schedule->route->origin ?? '-' }} → {{ $reservation->schedule->route->destination ?? '-' }}
                </td>
                <td class="py-3 px-4">{{ $reservation->schedule->departure_date ?? '-' }}</td>
                <td class="py-3 px-4">
                  <span class="px-2 py-1 text-xs font-medium rounded-full 
                    {{ $reservation->payment?->status == 'Lunas' ? 'bg-green-100 text-green-700' :
                       ($reservation->payment?->status == 'Menunggu' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                    {{ $reservation->payment->status ?? 'Belum Bayar' }}
                  </span>
                </td>
                <td class="py-3 px-4 text-center">
                  <a href="{{ route('admin.reservations.show', $reservation->id) }}" 
                     class="inline-flex items-center justify-center p-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition" 
                     title="Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="py-6 text-center text-gray-500 text-sm">Belum ada data pemesanan</td>
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