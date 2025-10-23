<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Pemesanan | QuixoteBus</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-white text-gray-800 min-h-screen">

  <div class="max-w-3xl mx-auto mt-12 bg-white shadow-md rounded-2xl p-8 border border-indigo-100">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">Tambah Data Pemesanan</h2>

    <form action="{{ route('reservation.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf

      <!-- Pilih User -->
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Pengguna</label>
        <select name="user_id" required
          class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
          <option value="">-- Pilih Pengguna --</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
          @endforeach
        </select>
      </div>

      <!-- Pilih Jadwal -->
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Jadwal Bus</label>
        <select name="schedule_id" required
          class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
          <option value="">-- Pilih Jadwal --</option>
          @foreach($schedules as $schedule)
            <option value="{{ $schedule->id }}">
              {{ $schedule->bus->model ?? 'Bus tidak diketahui' }} |
              {{ $schedule->route->origin }} → {{ $schedule->route->destination ?? 'Route tidak diketahui' }} 
              {{ $schedule->departure_date }} {{ $schedule->departure_time }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Metode Pembayaran -->
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Metode Pembayaran</label>
        <input type="text" name="method" placeholder="Contoh: Transfer Bank / Cash" required
          class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
      </div>

      <!-- Jumlah -->
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Jumlah Pembayaran (Rp)</label>
        <input type="number" name="amount" min="0" placeholder="Contoh: 100000" required
          class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
      </div>

      <!-- Status -->
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Status Pembayaran</label>
        <select name="status" required
          class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
          <option value="Menunggu">Menunggu</option>
          <option value="Lunas">Lunas</option>
          <option value="Dibatalkan">Dibatalkan</option>
        </select>
      </div>

      <!-- Bukti Pembayaran -->
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Upload Bukti Pembayaran</label>
        <input type="file" name="payment_proof" accept="image/*"
          class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
      </div>

      <!-- Tanggal Bayar -->
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Pembayaran</label>
        <input type="date" name="paid_at"
          class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
      </div>

      <!-- Tombol Aksi -->
      <div class="flex justify-between mt-8">
        <a href="{{ route('reservation.index') }}" class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-600 font-medium hover:bg-gray-300 transition">Kembali</a>
        <button type="submit" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-500 text-white font-medium hover:from-indigo-700 hover:to-purple-600 transition shadow-md">
          Simpan Pemesanan
        </button>
      </div>
    </form>
  </div>

</body>
</html>
