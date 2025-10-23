<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>E-Ticket | QuixoteBus</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; color: #333; }
    .header { text-align: center; margin-bottom: 20px; }
    .header h2 { color: #4f46e5; margin: 0; }
    .ticket { border: 2px solid #4f46e5; border-radius: 12px; padding: 20px; }
    .info { margin-bottom: 8px; }
    .label { font-weight: bold; color: #4f46e5; width: 160px; display: inline-block; }
    .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
  </style>
</head>
<body>

  <div class="header">
    <h2>🚌 QuixoteBus E-Ticket</h2>
  </div>

  <div class="ticket">
    <div class="info"><span class="label">Kode Booking:</span> {{ $reservation->booking_code }}</div>
    <div class="info"><span class="label">Nama Penumpang:</span> {{ Auth::user()->name }}</div>
    <div class="info"><span class="label">Bus:</span> {{ $reservation->schedule->bus->model }} ({{ $reservation->schedule->bus->license_plate }})</div>
    <div class="info"><span class="label">Rute:</span> {{ $reservation->schedule->route->origin }} → {{ $reservation->schedule->route->destination }}</div>
    <div class="info"><span class="label">Tanggal:</span> {{ $reservation->schedule->departure_date }} | {{ $reservation->schedule->departure_time }}</div>
    <div class="info"><span class="label">Jumlah Penumpang:</span> {{ $reservation->passenger_count }}</div>
    <div class="info"><span class="label">Total Harga:</span> Rp{{ number_format($reservation->total_price, 0, ',', '.') }}</div>
    <div class="info"><span class="label">Status:</span> {{ strtoupper($reservation->status) }}</div>
  </div>

  <div class="footer">
    <p>*Tunjukkan e-ticket ini kepada petugas saat naik bus.</p>
    <p>Terima kasih telah menggunakan QuixoteBus 💜</p>
  </div>

</body>
</html>
