<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Pemesanan | Admin QuixoteBus</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
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
      <a href="{{ route('admin.reservations') }}" class="block px-4 py-2.5 rounded-lg font-medium text-indigo-700 bg-gradient-to-r from-indigo-600 to-purple-500 text-white shadow-md transition-all hover:shadow-lg">Pemesanan</a>
    </nav>

    <form action="{{ route('logout') }}" method="POST" class="mt-auto mb-6 px-4">
      @csrf
      <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-indigo-600 to-purple-500 text-white rounded-lg font-medium text-sm shadow-md hover:from-indigo-700 hover:to-purple-600 transition-all">
        Logout
      </button>
    </form>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="ml-64 min-h-screen p-10">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-2xl font-semibold text-indigo-700">Detail Pemesanan</h2>
      <a href="{{ route('admin.reservations') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </div>

    <!-- CARD DETAIL -->
    <div class="bg-white rounded-2xl shadow-sm border border-indigo-100 p-8 space-y-6">
      <div>
        <h3 class="text-lg font-semibold text-indigo-600 mb-3">Informasi Pemesanan</h3>
        <div class="grid grid-cols-2 gap-y-2 text-gray-700">
          <p><strong>Kode Booking:</strong> {{ $reservation->booking_code }}</p>
          <p><strong>Status:</strong> 
            <span class="px-3 py-1 rounded-full text-sm 
              @if($reservation->status === 'Lunas') bg-green-100 text-green-700
              @elseif($reservation->status === 'Dibatalkan') bg-red-100 text-red-700
              @else bg-yellow-100 text-yellow-700 @endif">
              {{ $reservation->status }}
            </span>
          </p>
          <p><strong>Tanggal Pesan:</strong> {{ $reservation->created_at->format('d M Y, H:i') }}</p>
          <p><strong>Total Harga:</strong> Rp{{ number_format($reservation->total_price, 0, ',', '.') }}</p>
          <p><strong>Jumlah Penumpang:</strong> {{ $reservation->passenger_count }}</p>
          <p><strong>Catatan:</strong> {{ $reservation->note ?? '-' }}</p>
        </div>
      </div>

      <div>
        <h3 class="text-lg font-semibold text-indigo-600 mb-3">Informasi Jadwal & Rute</h3>
        <div class="grid grid-cols-2 gap-y-2 text-gray-700">
          <p><strong>Rute:</strong> {{ $reservation->schedule->route->origin }} → {{ $reservation->schedule->route->destination }}</p>
          <p><strong>Bus:</strong> {{ $reservation->schedule->bus->model ?? '-' }}</p>
          <p><strong>Keberangkatan:</strong> {{ \Carbon\Carbon::parse($reservation->schedule->departure_time)->format('d M Y, H:i') }}</p>
          <p><strong>Harga per Kursi:</strong> Rp{{ number_format($reservation->schedule->price, 0, ',', '.') }}</p>
        </div>
      </div>

      <div>
        <h3 class="text-lg font-semibold text-indigo-600 mb-3">Informasi Penumpang</h3>
        <p><strong>Nama:</strong> {{ $reservation->user->name }}</p>
        <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
      </div>

      <div>
        <h3 class="text-lg font-semibold text-indigo-600 mb-3">Informasi Pembayaran</h3>
        @if($reservation->payment)
          <div class="grid grid-cols-2 gap-y-2 text-gray-700">
            <p><strong>Metode:</strong> {{ $reservation->payment->method }}</p>
            <p><strong>Status Pembayaran:</strong> {{ $reservation->payment->status }}</p>
            <p><strong>Tanggal Bayar:</strong> {{ $reservation->payment->paid_at ? $reservation->payment->paid_at->format('d M Y, H:i') : '-' }}</p>
            <p><strong>Total Dibayar:</strong> Rp{{ number_format($reservation->payment->amount, 0, ',', '.') }}</p>
          </div>
          @if($reservation->payment->payment_proof)
            <div class="mt-4">
              <p class="font-medium text-gray-700 mb-2">Bukti Pembayaran:</p>
              <img src="{{ asset('storage/' . $reservation->payment->payment_proof) }}" alt="Bukti Pembayaran" class="w-64 rounded-lg border shadow">
            </div>
          @endif
        @else
          <p class="text-gray-500 italic">Belum ada data pembayaran.</p>
        @endif
      </div>
    </div>
  </main>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
