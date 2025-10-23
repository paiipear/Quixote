<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Bus | QuixoteBus</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-white text-gray-800 min-h-screen">

  <div class="max-w-3xl mx-auto mt-12 bg-white shadow-md rounded-2xl p-8 border border-indigo-100">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">Edit Data Bus</h2>

    <form action="{{ route('bus.update', $bus->id) }}" method="POST" class="space-y-5">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Model</label>
        <input type="text" name="model" value="{{ $bus->model }}" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" required>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">Kapasitas</label>
          <input type="number" name="capacity" value="{{ $bus->capacity }}" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">Nomor Polisi</label>
          <input type="text" name="license_plate" value="{{ $bus->license_plate }}" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" required>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Fasilitas</label>
        <textarea name="facilities" rows="3" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">{{ $bus->facilities }}</textarea>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Destripsi</label>
        <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">{{ $bus->description }}</textarea>
      </div>

      <div class="flex justify-between mt-8">
        <a href="{{ route('bus.index') }}" class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-600 font-medium hover:bg-gray-300 transition">Kembali</a>
        <button type="submit" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-500 text-white font-medium hover:from-indigo-700 hover:to-purple-600 transition shadow-md">
          Update Bus
        </button>
      </div>
    </form>
  </div>

</body>
</html>
