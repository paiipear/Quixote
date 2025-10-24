<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Bus;
use App\Models\BusRoute;
use App\Models\Schedule;
use App\Models\Reservation;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'user' => Auth::user(),
            'busCount' => Bus::count(),
            'routeCount' => BusRoute::count(),
            'scheduleCount' => Schedule::count(),
            'reservationCount' => Reservation::count(),
        ]);
    }
    public function reservations()
    {
        $reservations = Reservation::with(['user', 'schedule.route', 'payment'])->latest()->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function showReservation($id)
    {
        $reservation = Reservation::with(['user', 'schedule.route', 'payment'])->findOrFail($id);
        return view('admin.reservations.show', compact('reservation'));
    }

}
