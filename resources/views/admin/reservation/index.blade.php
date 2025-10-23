<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pemesanan | Admin QuixoteBus</title>
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
      <a href="{{ route('schedule.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Jadwal</a>
      <a href="{{ route('reservation.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-indigo-700 bg-gradient-to-r from-indigo-600 to-purple-500 text-white shadow-md hover:shadow-lg transition-all">Pemesanan</a>
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
      <h2 class="text-2xl font-semibold text-indigo-700">Data Pemesanan</h2>
      <a href="{{ route('reservation.create') }}" class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg font-medium shadow-sm hover:from-indigo-600 hover:to-purple-600 transition-all">
        + Tambah Pemesanan
      </a>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-indigo-100 hover:shadow-md transition">
      <div class="overflow-x-auto">
        <table class="min-w-full border border-indigo-100 rounded-lg overflow-hidden">
          <thead class="bg-gradient-to-r from-indigo-400 to-purple-500 text-white text-sm">
            <tr>
              <th class="py-3 px-4 text-left rounded-tl-lg">No</th>
              <th class="py-3 px-4 text-left">Nama Pengguna</th>
              <th class="py-3 px-4 text-left">Jadwal</th>
              <th class="py-3 px-4 text-left">Metode</th>
              <th class="py-3 px-4 text-left">Jumlah</th>
              <th class="py-3 px-4 text-left">Status</th>
              <th class="py-3 px-4 text-left">Tanggal Bayar</th>
              <th class="py-3 px-4 text-left">Bukti Pembayaran</th>
              <th class="py-3 px-4 text-left rounded-tr-lg">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-indigo-100">
            @forelse($reservations as $reservation)
              <tr class="{{ $loop->odd ? 'bg-indigo-50' : 'bg-white' }} hover:bg-indigo-100 transition">
                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                <td class="py-3 px-4 text-gray-700 font-medium">{{ $reservation->user->name ?? '-' }}</td>
                <td class="py-3 px-4 text-gray-600">
                  {{ $reservation->schedule->bus->model ?? 'Tidak ada data bus' }} <br>
                  <span class="text-xs text-gray-500">
                  {{ $reservation->schedule->route->origin }} → {{ $reservation->schedule->route->destination ?? 'Tanpa rute' }}
                  </span>
                </td>
                <td class="py-3 px-4 text-gray-600">{{ ucfirst($reservation->method) }}</td>
                <td class="py-3 px-4 text-gray-600">Rp{{ number_format($reservation->amount, 0, ',', '.') }}</td>
                <td class="py-3 px-4">
                  <span class="px-2 py-1 text-xs rounded-lg font-medium 
                    {{ $reservation->status === 'Lunas' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $reservation->status }}
                  </span>
                </td>
                <td class="py-3 px-4 text-gray-600">{{ $reservation->paid_at ? date('d M Y', strtotime($reservation->paid_at)) : '-' }}</td>
                <td class="py-3 px-4">
                  @if($reservation->payment_proof)
                    <a href="{{ asset($reservation->payment_proof) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a>
                  @else
                    <span class="text-gray-400 text-sm">Belum ada</span>
                  @endif
                </td>
                <td class="py-3 px-4 flex items-center gap-3">
                  <!-- Tombol Edit -->
                  <a href="{{ route('reservation.edit', $reservation->id) }}"
                    class="p-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-500 transition"
                    title="Edit">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                  </a>

                  <!-- Tombol Hapus -->
                  <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition" title="Hapus">
                      <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="py-6 text-center text-gray-500 text-sm">Belum ada data pemesanan</td>
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
