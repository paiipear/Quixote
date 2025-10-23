<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Bus Route | QuixoteBus</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-white text-gray-800 min-h-screen">

  <div class="max-w-3xl mx-auto mt-12 bg-white shadow-md rounded-2xl p-8 border border-indigo-100">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">Tambah Data Bus</h2>

    <form action="{{ route('busroute.store') }}" method="POST" class="space-y-5">
      @csrf

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">Asal</label>
          <input type="text" name="origin" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" placeholder="Contoh: Bandung" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">Tujuan</label>
          <input type="text" name="destination" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" placeholder="Contoh: Depok" required>
        </div>
       <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">Jarak (Km)</label>
          <input type="text" name="distance_km" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" placeholder="Contoh: 400" required>
        </div>
      
      </div>



      <div class="flex justify-between mt-8">
        <a href="{{ route('bus.index') }}" class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-600 font-medium hover:bg-gray-300 transition">Kembali</a>
        <button type="submit" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-500 text-white font-medium hover:from-indigo-700 hover:to-purple-600 transition shadow-md">
          Simpan Bus
        </button>
      </div>
    </form>
  </div>

</body>
</html>
