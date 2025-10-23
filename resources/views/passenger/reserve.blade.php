<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservasi | QuixoteBus</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-white text-gray-800">
  <div class="max-w-3xl mx-auto mt-12 bg-white shadow-md rounded-2xl p-8 border border-indigo-100">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">Reservasi Tiket Bus</h2>

    <div class="mb-5">
      <p class="text-gray-600"><span class="font-semibold">Bus:</span> {{ $schedule->bus->model }}</p>
      <p class="text-gray-600"><span class="font-semibold">Rute:</span> {{ $schedule->route->origin }} → {{ $schedule->route->destination }}</p>
      <p class="text-gray-600"><span class="font-semibold">Tanggal:</span> {{ $schedule->departure_date }} | {{ $schedule->departure_time }}</p>
      <p class="text-gray-600"><span class="font-semibold">Harga Tiket:</span> Rp {{ number_format($schedule->price,0,',','.') }}</p>
    </div>

    <form action="{{ route('passenger.reserve.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
      <div>
        <label class="block text-sm text-gray-600 mb-1 font-medium">Jumlah Penumpang</label>
        <input type="number" name="passenger_count" min="1" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400" required>
      </div>

      <div>
        <label class="block text-sm text-gray-600 mb-1 font-medium">Catatan (opsional)</label>
        <textarea name="note" rows="3" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400" placeholder="Contoh: kursi dekat jendela..."></textarea>
      </div>

      <div class="flex justify-between mt-8">
        <a href="{{ route('passenger.dashboard') }}" class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-600 font-medium hover:bg-gray-300 transition">Kembali</a>
        <button type="submit" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-500 text-white font-medium hover:from-indigo-700 hover:to-purple-600 transition shadow-md">Konfirmasi Pesanan</button>
      </div>
    </form>
  </div>
</body>
</html>
