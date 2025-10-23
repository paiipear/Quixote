<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Reservation;
use App\Models\BusRoute;
use Illuminate\Support\Facades\Auth;

class PassengerController extends Controller
{
    /** DASHBOARD PENUMPANG */
    public function index()
    {
        $routes = BusRoute::all();

        $recommendedRoutes = BusRoute::with(['schedules' => function ($q) {
            $q->where('status', 'scheduled')->orderBy('price', 'asc');
        }])
            ->has('schedules')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $today = now()->format('Y-m-d');
        $schedules = Schedule::with(['bus', 'route'])
            ->whereDate('departure_date', $today)
            ->where('status', 'scheduled')
            ->orderBy('departure_time', 'asc')
            ->get();

        return view('passenger.dashboard', compact('routes', 'recommendedRoutes', 'schedules'));
    }

    /** FORM RESERVASI */
    public function showReservationForm($schedule_id)
    {
        $schedule = Schedule::with(['bus', 'route'])->findOrFail($schedule_id);
        return view('passenger.reserve', compact('schedule'));
    }

    /** SIMPAN RESERVASI → KE PEMBAYARAN */
    public function storeReservation(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'passenger_count' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);
        $total_price = $schedule->price * $request->passenger_count;

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'schedule_id' => $schedule->id,
            'booking_code' => 'QIX' . strtoupper(uniqid()),
            'status' => 'Menunggu Pembayaran',
            'total_price' => $total_price,
            'passenger_count' => $request->passenger_count,
            'note' => $request->note,
        ]);

        return redirect()->route('passenger.payment.form', $reservation->id);
    }

    /** FORM PEMBAYARAN */
    public function showPaymentForm($reservation_id)
    {
        $reservation = Reservation::with('schedule.route', 'schedule.bus')->findOrFail($reservation_id);
        return view('passenger.payment', compact('reservation'));
    }

    /** PROSES PEMBAYARAN */
    public function processPayment(Request $request, $reservation_id)
    {
        $reservation = Reservation::with('schedule')->where('user_id', Auth::id())->findOrFail($reservation_id);

        if ($reservation->status === 'Lunas') {
            return redirect()->route('passenger.reservations')->with('info', 'Reservasi ini sudah dibayar.');
        }

        $reservation->update(['status' => 'Lunas']);
        $reservation->schedule->decrement('available_seats', $reservation->passenger_count);

        $reservation->payment()->create([
            'amount' => $reservation->total_price,
            'payment_method' => $request->payment_method,
            'status' => 'Berhasil',
            'payment_date' => now(),
        ]);

        return redirect()->route('passenger.reservation.detail', $reservation->id)
            ->with('success', 'Pembayaran berhasil! Tiket kamu sudah aktif.');
    }

    /** BATALKAN RESERVASI */
    public function cancelReservation($id)
    {
        $reservation = Reservation::with('schedule')->where('user_id', Auth::id())->findOrFail($id);

        if (in_array($reservation->status, ['Lunas', 'Dibatalkan'])) {
            return redirect()->back()->with('error', 'Reservasi ini tidak dapat dibatalkan.');
        }

        $reservation->update(['status' => 'Dibatalkan']);
        $reservation->schedule->increment('available_seats', $reservation->passenger_count);

        return redirect()->route('passenger.reservations')->with('success', 'Reservasi berhasil dibatalkan.');
    }

    /** RIWAYAT & DETAIL */
    public function myReservations()
    {
        $reservations = Reservation::with(['schedule.bus', 'schedule.route', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('passenger.reservations', compact('reservations'));
    }

    public function showReservationDetail($id)
    {
        $reservation = Reservation::with(['schedule.bus', 'schedule.route', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('passenger.detail', compact('reservation'));
    } // pastikan sudah install barryvdh/laravel-dompdf

    public function downloadTicket($id)
    {
        $reservation = Reservation::with(['schedule.bus', 'schedule.route'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $pdf = Pdf::loadView('passenger.ticket-pdf', compact('reservation'));
        return $pdf->download('Tiket-' . $reservation->booking_code . '.pdf');
    }

}
