<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian | QuixoteBus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f6ff;
            font-family: 'Inter', sans-serif;
            color: #1f2937;
        }

        .search-header {
            background-color: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.1);
            padding: 15px 25px;
        }

        h4 {
            color: #4f46e5;
        }

        .bus-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.08);
            transition: 0.25s;
        }

        .bus-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.15);
        }

        .bus-name {
            font-weight: 700;
            color: #4f46e5;
        }

        .bus-type {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .route-line {
            border-left: 2px solid #c7d2fe;
            padding-left: 10px;
            margin-left: 5px;
        }

        .price {
            color: #e11d48;
            font-size: 1.25rem;
            font-weight: 700;
            text-align: right;
        }

        .rating {
            color: #fbbf24;
            font-weight: 600;
            font-size: 0.9rem;
            align-self: flex-end;
        }

        .btn-indigo {
            background: linear-gradient(to right, #6366f1, #8b5cf6);
            border: none;
            color: white;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-indigo:hover {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
        }

        .bus-info {
            min-width: 200px;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <!-- Header Section -->
    <div class="search-header mb-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div><strong>Asal:</strong> {{ request('origin') }}</div>
                <div>→</div>
                <div><strong>Tujuan:</strong> {{ request('destination') }}</div>
                <div><strong>Tanggal:</strong> {{ request('departure_date') }}</div>
            </div>
           @auth
            @if(Auth::user()->role === 'passenger')
                <a href="{{ route('passenger.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill">← Kembali</a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill">← Kembali</a>
            @else
                <a href="{{ url('/') }}" class="btn btn-sm btn-outline-secondary rounded-pill">← Kembali</a>
            @endif
            @else
            <a href="{{ url('/') }}" class="btn btn-sm btn-outline-secondary rounded-pill">← Kembali</a>
        @endauth

        </div>
    </div>

    <h4 class="fw-bold mb-4">Pilih Bus Keberangkatan</h4>

    @if($schedules->isEmpty())
        <div class="alert alert-warning text-center shadow-sm">
            Tidak ada bus ditemukan untuk rute dan tanggal tersebut.
        </div>
    @else
        <div class="d-flex flex-column gap-4">
            @foreach($schedules as $schedule)
                <div class="bus-card d-flex justify-content-between align-items-start flex-wrap">
                    
                    <!-- Kiri: Info Bus -->
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap">
                            <div>
                                <h5 class="bus-name mb-0">{{ $schedule->bus->model }}</h5>
                                <div class="bus-type">{{ $schedule->bus->type ?? 'Sleeper' }}</div>
                            </div>
                        </div>

                        <div class="route-line mt-2">
                            <div class="mb-2">
                                <strong>{{ $schedule->departure_time }}</strong> — {{ $schedule->route->origin }}
                            </div>
                            <div>— {{ $schedule->route->destination }}</div>
                        </div>

                        <div class="mt-3 text-muted small">
                            Fasilitas: {{ $schedule->bus->facilities ?? '-' }}
                        </div>
                    </div>

                    <!-- Kanan: Rating + Harga -->
                    <!-- Kanan: Rating + Harga -->
                    <div class="bus-info text-end mt-4 mt-md-0 d-flex flex-column align-items-end">
                        <div class="rating mb-1">{{ $schedule->bus->rating ?? '4.6' }}/5</div>
                        <div class="text-muted small">Mulai Dari</div>
                        <div class="price mb-1">
                            Rp{{ number_format($schedule->price, 0, ',', '.') }}/kursi
                        </div>
                        <div class="text-muted small mb-3">
                            {{ $schedule->available_seats }} kursi tersisa
                        </div>

                        {{-- Guest: diarahkan ke login --}}
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-indigo w-100">Pesan</a>
                        @endguest

                        {{-- Passenger: bisa langsung pesan --}}
                        @auth
                            @if(Auth::user()->role === 'passenger')
                                <form action="{{ route('passenger.reserve.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                    <input type="number" name="passenger_count" min="1" class="form-control mb-2"
                                        placeholder="Jumlah tiket" required>
                                    <button class="btn btn-indigo w-100">Pesan Sekarang</button>
                                </form>
                            @elseif(Auth::user()->role === 'admin')
                                {{-- Admin tidak bisa pesan --}}
                                <button class="btn btn-secondary w-100" disabled>Admin tidak dapat memesan</button>
                            @endif
                        @endauth
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>
