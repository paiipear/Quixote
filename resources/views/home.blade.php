<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuixoteBus</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#F9FAFB] text-[#111827] font-sans antialiased">

    <!-- Navbar -->
    <nav class="flex items-center justify-between px-8 py-4 bg-white/90 backdrop-blur-md shadow-md fixed w-full top-0 z-50">
        <h1 class="text-2xl font-bold text-indigo-600 tracking-tight">QuixoteBus</h1>
        <div class="space-x-5">
            <a href="#features" class="text-sm text-gray-600 hover:text-indigo-600 transition font-medium">Fitur</a>
            <a href="#about" class="text-sm text-gray-600 hover:text-indigo-600 transition font-medium">Tentang</a>
            <a href="#contact" class="text-sm text-gray-600 hover:text-indigo-600 transition font-medium">Kontak</a>
            <a href="{{ Route('login') }}" class="bg-gradient-to-r from-indigo-600 to-purple-500 hover:from-indigo-700 hover:to-purple-600 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-200 shadow-md active:scale-95 text-sm">Login</a>
            @auth
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="text-sm text-red-500 hover:text-red-600 font-medium">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-24 bg-gradient-to-b from-white to-indigo-50">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between px-6 gap-12">

            <!-- Left Content -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-5xl md:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500 leading-tight">
                    Pesan Tiket Bus<br>Lebih Cepat & Mudah
                </h1>
                <p class="mt-5 text-gray-500 text-lg max-w-md mx-auto md:mx-0">
                    Nikmati perjalanan nyaman dengan QuixoteBus — solusi modern untuk perjalanan antar kota Anda.
                </p>

                <!-- Form -->
                <div class="mt-8 bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.05)] border border-indigo-50 max-w-md mx-auto md:mx-0 hover:shadow-xl transition-transform hover:scale-[1.02] duration-300">
                    <form action="{{ route('search') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="text-xs text-gray-500">Asal</label>
                                <select name="origin" class="w-full rounded-lg border border-gray-200 p-2 focus:ring-2 focus:ring-indigo-300 text-sm">
                                    @foreach($origins as $o)
                                        <option value="{{ $o->origin }}">{{ $o->origin }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Tujuan</label>
                                <select name="destination" class="w-full rounded-lg border border-gray-200 p-2 focus:ring-2 focus:ring-indigo-300 text-sm">
                                    @foreach($destinations as $d)
                                        <option value="{{ $d->destination }}">{{ $d->destination }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Tanggal</label>
                                <input type="date" name="departure_date" class="w-full rounded-lg border border-gray-200 p-2 focus:ring-2 focus:ring-indigo-300 text-sm">
                            </div>
                        </div>

                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-500 hover:from-indigo-700 hover:to-purple-600 text-white w-full py-3 rounded-lg font-semibold transition-all duration-200 shadow-md active:scale-95 text-sm">
                            Cari Bus
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Image -->
            <div class="flex-1">
               <img src="{{ asset('storage/images/bus.png') }}" alt="Bus Modern" class="w-full rounded-3xl shadow-xl border border-indigo-100 hover:shadow-2xl transition duration-300">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-10 text-gray-800">Mengapa Pilih QuixoteBus?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-8 bg-indigo-50 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                    <h3 class="font-semibold text-lg mb-2 text-gray-800">Rute Terbaik</h3>
                    <p class="text-gray-500 text-sm">Temukan perjalanan tercepat dan termudah hanya dengan satu klik.</p>
                </div>
                <div class="p-8 bg-indigo-50 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                    <h3 class="font-semibold text-lg mb-2 text-gray-800">Kenyamanan Maksimal</h3>
                    <p class="text-gray-500 text-sm">Kami bekerja sama dengan operator terpercaya untuk kenyamanan Anda.</p>
                </div>
                <div class="p-8 bg-indigo-50 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                    <h3 class="font-semibold text-lg mb-2 text-gray-800">Cepat & Aman</h3>
                    <p class="text-gray-500 text-sm">Pesan tiket tanpa ribet dengan sistem otomatis dan aman.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gradient-to-b from-indigo-50 to-white">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Tentang QuixoteBus</h2>
            <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed">
                QuixoteBus hadir untuk memudahkan Anda dalam merencanakan perjalanan antar kota. 
                Kami menyediakan platform pemesanan tiket bus yang cepat, aman, dan nyaman. 
                Dengan kerja sama berbagai operator bus terbaik, kami memastikan pengalaman perjalanan Anda menyenangkan dari awal hingga akhir.
            </p>
            <div class="mt-8 flex justify-center gap-6 flex-wrap">
                <div class="flex items-center gap-2">
                    <span class="text-indigo-600 font-semibold">Pembayaran Aman</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-indigo-600 font-semibold">Layanan 24 Jam</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-indigo-600 font-semibold">Jangkauan Luas</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white border-t border-gray-100">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Hubungi Kami</h2>
            <p class="text-gray-500 mb-8 max-w-2xl mx-auto">
                Ada pertanyaan, saran, atau rekomendasi rute baru? Kami senang mendengarnya!
                Tim QuixoteBus siap membantu Anda kapan saja.
            </p>

            <div class="flex flex-col md:flex-row justify-center gap-6">
                <div class="bg-indigo-50 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all">
                    <h3 class="text-indigo-600 font-semibold mb-2">Telepon</h3>
                    <p class="text-gray-600 text-sm">+62 812 3456 7890</p>
                </div>
                <div class="bg-indigo-50 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all">
                    <h3 class="text-indigo-600 font-semibold mb-2">Email</h3>
                    <p class="text-gray-600 text-sm">support@quixotebus.com</p>
                </div>
               
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-10 bg-white text-center border-t border-gray-100">
        <p class="text-gray-400 text-sm">
            © {{ date('Y') }} <span class="text-indigo-600 font-semibold">QuixoteBus</span> — Elegan, Cerdas, Cepat.
        </p>
    </footer>

</body>
</html>
