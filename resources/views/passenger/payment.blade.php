<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran | QuixoteBus</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f7ff] text-gray-800">

  <div class="max-w-xl mx-auto py-12 px-6">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">Pembayaran Tiket</h2>

    <div class="bg-white p-6 rounded-2xl shadow-md border border-indigo-100">
      <!-- Detail Reservasi -->
      <p class="text-gray-600 mb-2">Kode Booking: <strong>{{ $reservation->booking_code }}</strong></p>
      <p class="text-gray-600 mb-2">Rute: {{ $reservation->schedule->route->origin }} → {{ $reservation->schedule->route->destination }}</p>
      <p class="text-gray-600 mb-2">Bus: {{ $reservation->schedule->bus->model }}</p>
      <p class="text-gray-600 mb-2">Jumlah Kursi Dipesan: <strong>{{ $reservation->passenger_count }}</strong>
</p>

      <p class="text-gray-600 mb-4">
        Total Harga: 
        <span class="text-indigo-600 font-semibold">
          Rp{{ number_format($reservation->total_price, 0, ',', '.') }}
        </span>
      </p>

      <!-- Form Pembayaran -->
      <form action="{{ route('passenger.payment.process', $reservation->id) }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label class="block mb-3 text-gray-700">Pilih Metode Pembayaran:</label>
          <select name="payment_method" required
            class="w-full border border-gray-300 rounded-lg p-2 mb-4 focus:ring-2 focus:ring-indigo-400">
            <option value="Transfer Bank">Transfer Bank</option>
            <option value="Dana">Dana</option>
            <option value="OVO">OVO</option>
            <option value="ShopeePay">ShopeePay</option>
            <option value="Cash">Cash</option>
          </select>
        </div>

        <div class="flex flex-col gap-3">
          <!-- Tombol Bayar -->
          <button type="submit"
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-500 text-white py-2.5 rounded-lg font-medium shadow-md hover:from-indigo-700 hover:to-purple-600 transition">
            Bayar Sekarang
          </button>

          <!-- Tombol Kembali -->
          <button type="button" 
            onclick="history.back()"
            class="w-full bg-red-100 text-red-600 py-2.5 rounded-lg font-medium hover:bg-red-200 transition">
            Batalkan Pembayaran
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
