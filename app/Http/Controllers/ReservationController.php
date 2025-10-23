<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('schedule')
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'passenger_count' => 'required|integer|min:1',
        ]);

        // transaksikan perubahan (jika kamu pakai available_seats)
        return DB::transaction(function () use ($request) {
            $schedule = Schedule::lockForUpdate()->findOrFail($request->schedule_id);

            // jika kamu menyimpan available_seats
            if (is_null($schedule->available_seats)) {
                $schedule->available_seats = $schedule->bus->capacity ?? $schedule->available_seats;
            }
            if ($schedule->available_seats < $request->passenger_count) {
                return back()->with('error', 'Kursi tidak cukup tersedia.');
            }

            $schedule->available_seats -= $request->passenger_count;
            $schedule->save();

            $totalPrice = $schedule->price * $request->passenger_count;

            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'schedule_id' => $schedule->id,
                'booking_code' => Str::upper(Str::random(8)),
                'status' => 'pending',
                'total_price' => $totalPrice,
                'passenger_count' => $request->passenger_count,
                'note' => $request->note ?? null,
            ]);

            return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dibuat! Kode: '.$reservation->booking_code);
        });
    }

    public function show($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->with('schedule.payments')->findOrFail($id);
        return view('reservations.show', compact('reservation'));
    }
}
