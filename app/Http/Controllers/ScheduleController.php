<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\BusRoute;
use App\Models\Route;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['bus', 'route'])->get();
        return view('admin.schedule.index', compact('schedules'));
    }

    public function create()
    {
        $buses = Bus::all();
        $routes = BusRoute::all();
        return view('admin.schedule.create', compact('buses', 'routes'));
    }

    public function store(Request $request)
    {

        Schedule::create([
            'bus_id' => $request->bus_id,
            'route_id' => $request->route_id,
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time,
            'price' => $request->price,
            'available_seats' => $request->available_seats ?? 0,
            'status' => $request->status ?? 'Tersedia',
        ]);

        return redirect()->route('schedule.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Schedule $schedule)
    {
        $buses = Bus::all();
        $routes = BusRoute::all();
        return view('admin.schedule.edit', compact('schedule', 'buses', 'routes'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->only(['bus_id', 'route_id', 'departure_date', 'departure_time', 'price', 'available_seats', 'status']);
        $schedule->update($data);
        return redirect()->route('schedule.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedule.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}
