<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class PassengerController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['schedule.bus', 'schedule.route', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('passenger.index', compact('reservations'));
    }
}
