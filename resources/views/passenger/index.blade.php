<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Penumpang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-4">
    <h2>Dashboard Penumpang</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('profile.edit') }}" class="btn btn-primary mb-3">Edit Profile</a>
    <a href="{{ route('logout') }}" class="btn btn-danger mb-3 float-end"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>

    <h4>Riwayat Reservasi</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Rute</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $r)
                <tr>
                    <td>{{ $r->booking_code }}</td>
                    <td>{{ $r->schedule->route->origin }} → {{ $r->schedule->route->destination }}</td>
                    <td>{{ $r->schedule->departure_date }}</td>
                    <td>Rp{{ number_format($r->total_price, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($r->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada reservasi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
