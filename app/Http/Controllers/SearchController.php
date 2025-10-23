<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date',
        ]);

        $schedules = Schedule::with(['bus', 'route'])
            ->whereHas('route', function ($q) use ($request) {
                $q->where('origin', $request->origin)
                  ->where('destination', $request->destination);
            })
            ->whereDate('departure_date', $request->departure_date)
            ->where('status', 'scheduled')
            ->get();

        return view('search.results', compact('schedules', 'request'));
    }
}
