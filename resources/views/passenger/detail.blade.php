<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Reservasi | QuixoteBus</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-indigo-50 text-gray-800">
  <div class="max-w-3xl mx-auto mt-10 bg-white rounded-2xl p-8 shadow-sm border border-indigo-100">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">Detail Reservasi</h2>

    <div class="space-y-3 text-sm">
      <p><strong>Kode Reservasi:</strong> {{ $reservation->booking_code }}</p>
      <p><strong>Bus:</strong> {{ $reservation->schedule->bus->model ?? '-' }}</p>
      <p><strong>Rute:</strong> {{ $reservation->schedule->route->origin }} → {{ $reservation->schedule->route->destination }}</p>
      <p><strong>Tanggal Keberangkatan:</strong> {{ $reservation->schedule->departure_date }} ({{ $reservation->schedule->departure_time }})</p>
      <p><strong>Jumlah Penumpang:</strong> {{ $reservation->passenger_count }}</p>
      <p><strong>Total Harga:</strong> Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
      <p><strong>Status:</strong> {{ ucfirst($reservation->status) }}</p>
      @if($reservation->note)
        <p><strong>Catatan:</strong> {{ $reservation->note }}</p>
      @endif
    </div>

    <div class="mt-8 flex justify-between">
      <a href="{{ route('passenger.reservations') }}" class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-600 hover:bg-gray-300 transition">Kembali</a>
      <a href="#" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-500 text-white font-medium hover:from-indigo-700 hover:to-purple-600 transition shadow-md">Download Tiket</a>
    </div>
  </div>
</body>
</html>
