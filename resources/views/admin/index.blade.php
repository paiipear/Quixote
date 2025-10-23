<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | QuixoteBus</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gradient-to-b from-indigo-50 to-white text-[#111827] font-sans antialiased">

  <!-- SIDEBAR -->
  <aside class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-indigo-50 to-white flex flex-col shadow-md border-r border-indigo-100">
    <div class="px-6 py-6 border-b border-indigo-100">
      <h1 class="text-xl font-bold tracking-tight text-indigo-700">QuixoteBus</h1>
    </div>

    <nav class="flex-1 mt-6 space-y-1 px-4">
      <a href="{{ route('admin.dashboard') }} " class="block px-4 py-2.5 rounded-lg font-medium text-indigo-700 bg-gradient-to-r from-indigo-600 to-purple-500 text-white shadow-md transition-all hover:shadow-lg">Dashboard</a>
      <a href="{{ route('bus.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Data Bus</a>
      <a href="{{ route('busroute.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Rute</a>
      <a href="{{ route('schedule.index') }}" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Jadwal</a>
      <a href="#" class="block px-4 py-2.5 rounded-lg font-medium text-gray-600 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-500 transition-all">Pemesanan</a>
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
    <!-- Welcome Card -->
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-indigo-100 hover:shadow-md transition ">
      <h2 class="text-2xl font-semibold text-indigo-700 mb-2">Selamat Datang, {{ $user->name ?? 'Admin' }}</h2>
      <p class="text-gray-500">Anda login sebagai <span class="font-semibold text-gray-700">{{ $user->role ?? 'Admin' }}</span>.</p>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
      <div class="bg-white border border-indigo-100 rounded-xl shadow-sm p-6 hover:shadow-md hover:-translate-y-1 transition">
        <h5 class="text-sm font-medium text-gray-500 mb-1">Total Bus</h5>
        <h2 class="text-3xl font-bold text-indigo-700 mb-3">12</h2>
        <a href="{{ route('bus.index') }}" class="inline-block text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-500 px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-600 transition-all shadow-sm">Lihat Data</a>
      </div>

      <div class="bg-white border border-indigo-100 rounded-xl shadow-sm p-6 hover:shadow-md hover:-translate-y-1 transition">
        <h5 class="text-sm font-medium text-gray-500 mb-1">Rute Aktif</h5>
        <h2 class="text-3xl font-bold text-indigo-700 mb-3">8</h2>
        <a href="#" class="inline-block text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-500 px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-600 transition-all shadow-sm">Lihat Data</a>
      </div>

      <div class="bg-white border border-indigo-100 rounded-xl shadow-sm p-6 hover:shadow-md hover:-translate-y-1 transition">
        <h5 class="text-sm font-medium text-gray-500 mb-1">Jadwal</h5>
        <h2 class="text-3xl font-bold text-indigo-700 mb-3">15</h2>
        <a href="#" class="inline-block text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-500 px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-600 transition-all shadow-sm">Lihat Data</a>
      </div>

      <div class="bg-white border border-indigo-100 rounded-xl shadow-sm p-6 hover:shadow-md hover:-translate-y-1 transition">
        <h5 class="text-sm font-medium text-gray-500 mb-1">Pemesanan</h5>
        <h2 class="text-3xl font-bold text-indigo-700 mb-3">30</h2>
        <a href="#" class="inline-block text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-500 px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-600 transition-all shadow-sm">Lihat Data</a>
      </div>
    </div>
  </main>
   
</body>
</html>
